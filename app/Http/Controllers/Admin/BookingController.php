<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;

class BookingController extends Controller
{
    //
    public function generateTourPDF($booking)
    {
        // Dữ liệu cần thiết cho PDF
        $data = [
            'customer_name' => $booking->customer_name,
            'tour_name' => $booking->tour_name,
            'departure_date' => $booking->departure_date,
            'location' => $booking->location,
            'money' => $booking->money,
        ];

        // Tạo file PDF từ view
        $pdf = Pdf::loadView('client.pdf.tour-details', $data);

        // Lưu file PDF vào storage
        $path = storage_path('app/public/tour-details-' . $booking->id . '.pdf');
        $pdf->save($path);

        return $path; // Trả về đường dẫn file PDF
    }
}
