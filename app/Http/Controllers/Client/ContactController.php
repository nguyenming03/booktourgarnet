<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.pages.contact');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'subject' => 'required|string|max:50',
            'message' => 'required|min:6'
        ], [
            'name.required' => 'Tên là bắt buộc.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 50 ký tự.',

            'subject.required' => 'Chủ đề là bắt buộc.',
            'subject.string' => 'Chủ đề phải là chuỗi ký tự.',
            'subject.max' => 'Chủ đề không được vượt quá 50 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email phải có định dạng hợp lệ.',

            'message.required' => 'Nội dung là bắt buộc.',
            'message.min' => 'Nội dung phải có ít nhất 6 ký tự.',
        ]);
        $contact = Contact::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => "Đang chờ xử lý",
        ]);


        // return redirect()->route('contact.index')->with('success', 'Cảm ơn bạn đã phản hồi. Chúng tôi sẽ sớm liên hệ với bạn trong thời gian ngắn nhất.');
        return response()->json([
            'status' => 'success',
            'message' => 'Cảm ơn bạn đã phản hồi. Chúng tôi sẽ sớm liên hệ với bạn trong thời gian ngắn nhất.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
