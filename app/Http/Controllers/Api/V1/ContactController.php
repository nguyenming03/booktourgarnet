<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\Contact\StoreContactRequest;
use App\Http\Requests\Api\Contact\UpdateContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Danh sách liên hệ. Chỉ user đã xác thực mới được đọc dữ liệu quản trị.
     */
    public function index(Request $request)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $contacts = Contact::with('user:id,name,email')
            ->orderByDesc('id')
            ->paginate(min(max((int) $request->input('per_page', 20), 1), 100));

        return $this->success($contacts, 'Danh sách liên hệ.');
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create([
            'user_id' => auth('sanctum')->id(),
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 0,
        ]);

        return $this->created($contact, 'Gửi liên hệ thành công! Chúng tôi sẽ phản hồi sớm nhất.');
    }

    public function show(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $contact = Contact::with('user:id,name,email')->find($id);

        if (!$contact) {
            return $this->notFound('Không tìm thấy liên hệ.');
        }

        return $this->success($contact, 'Chi tiết liên hệ.');
    }

    public function update(UpdateContactRequest $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $contact = Contact::find($id);

        if (!$contact) {
            return $this->notFound('Không tìm thấy liên hệ.');
        }

        $contact->update($request->validated());

        return $this->success($contact->fresh(), 'Cập nhật liên hệ thành công.');
    }

    public function destroy(Request $request, string $id)
    {
        if ($response = $this->ensureAdmin($request)) return $response;
        $contact = Contact::find($id);

        if (!$contact) {
            return $this->notFound('Không tìm thấy liên hệ.');
        }

        $contact->delete();

        return $this->success(null, 'Xóa liên hệ thành công.');
    }
}
