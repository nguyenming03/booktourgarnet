<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_permission'])->only(['index']);
        $this->middleware(['permission:create_permission'])->only(['create']);
        $this->middleware(['permission:store_permission'])->only(['store']);
        $this->middleware(['permission:edit_permission'])->only(['edit']);
        $this->middleware(['permission:update_permission'])->only(['update']);
        $this->middleware(['permission:destroy_permission'])->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $permissions = Permission::query()->get();
            return DataTables()->of($permissions)
                ->addColumn('action', function ($permission) {
                    $editUrl = route('permissions.edit', $permission->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-subtle-secondary btn-icon btn-sm edit-item-btn" data-id="' . $permission->id . '"><i class="ph-pencil"></i></a>
                        <a href="#deleteRecordModal" id="deleteItem" data-bs-toggle="modal" data-id="' . $permission->id . '" class="btn btn-subtle-danger btn-icon btn-sm remove-item-btn"><i class="ph-trash"></i></a>
                    ';
                })
                ->rawColumns(['action']) // Cho phép HTML hiển thị trong các cột này
                ->make(true);
        }

        return view('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'description' => 'nullable|string',
        ]);
        // dd($request);
        if ($validatedData) {
            Permission::create($validatedData);
            session()->flash('success', 'Thêm mới thành công.');
            return back();
        } else {
            session()->flash('error', 'Thêm mới thất bại.');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        // dd($request);
        if ($validatedData) {
            $permission->update($validatedData);
            session()->flash('success', 'Sửa quyền thành công.');
            return back();
        } else {
            session()->flash('error', 'Sửa quyền thất bại.');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $check = $permission->delete();
        if ($check) {

            return response()->json([
                'status' => true,
                'message' => 'xóa thành công.'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Xóa thất bại.'
            ]);
        }
    }
}
