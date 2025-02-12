<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationUserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:view_notificationUser'])->only(['index']);
        $this->middleware(['permission:create_notificationUser'])->only(['create']);
        $this->middleware(['permission:store_notificationUser'])->only(['store']);
        $this->middleware(['permission:update_notificationUser'])->only(['update']);
        $this->middleware(['permission:destroy_notificationUser'])->only(['destroy']);
    }
    public function index()
    {
        if (request()->ajax()) {
            $notificationUsers = NotificationUser::with('notification', 'user')->get();

            return datatables()->of($notificationUsers)
                ->addColumn('name', function ($user) {
                    return $user->name;
                })
                ->addColumn('is_read', function ($notification) {
                    if ($notification->is_read == 1) {
                        return '<span class="text-success">Đã đọc</span>';
                    } else {
                        return '<span class="text-danger">Chưa đọc</span>';
                    }
                })
                ->addColumn('action', function ($notificationUser) {
                    return '<button id="deleteItem" class="btn btn-danger btn-sm" data-id="' . $notificationUser->id . '">Xóa</button>';
                })

                ->rawColumns(['name', 'is_read', 'action'])
                ->make(true);
        }
        return view('admin.notification.list_notify_user');
    }
    public function create()
    {
        $notifications = Notification::query()->where('all_user', '=', 0)->get();
        $users = User::all();

        return view('admin.notification.add_notify_user', compact('notifications', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'notification_id' => 'required|exists:notifications,id',
            'user_id' => 'required|array|min:1', // Kiểm tra mảng người dùng
            'user_id.*' => 'exists:users,id', // Kiểm tra từng ID người dùng
        ]);

        // Lưu thông báo cho nhiều người dùng
        foreach ($validatedData['user_id'] as $userId) {
            NotificationUser::create([
                'notification_id' => $validatedData['notification_id'],
                'user_id' => $userId
            ]);
        }

        session()->flash('success', 'Gán thông báo cho người dùng thành công.');
        return back();
    }

    // Sửa thông báo của người dùng
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'is_read' => 'required|boolean',
        ]);

        $notificationUser = NotificationUser::findOrFail($id);
        $notificationUser->update([
            'is_read' => $validatedData['is_read'],
        ]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thông báo thành công.');
    }

    // Xóa thông báo của người dùng
    public function destroy($id)
    {
        $notificationUser = NotificationUser::findOrFail($id);
        $notificationUser->delete();

        return redirect()->back()->with('success', 'Đã xóa thông báo của người dùng.');
    }

    public function searchUsers(Request $request)
    {
        $search = $request->get('q');
        $users = User::where('name', 'like', "%{$search}%")->get();

        return response()->json($users);
    }
}
