<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingSuccess extends Mailable
{
    use Queueable, SerializesModels;

    protected $emailData;
    protected $pdfData;

    /**
     * Create a new message instance.
     *
     * @param  mixed  $emailData  Dữ liệu email.
     * @param  mixed  $pdfData    Dữ liệu PDF.
     */
    public function __construct($emailData, $pdfData)
    {
        $this->emailData = $emailData;
        $this->pdfData = $pdfData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Tạo file PDF từ dữ liệu PDF
        $pdf = Pdf::loadView('client.pdf.tour-details', $this->pdfData);
        $pdfContent = $pdf->output(); // Lấy nội dung PDF dạng binary

        // Gắn PDF vào email
        $this->attachData($pdfContent, 'Thong-tin-chi-tiet-tour.pdf', [
            'mime' => 'application/pdf',
        ]);

        // Danh sách các ảnh bạn muốn đính kèm
        $images = [
            'top-header.png' => public_path('storage/images/top-header.png'),
            'logo6d1d.png' => public_path('storage/images/logo6d1d.png'),
            'top.png' => public_path('storage/images/top.png'),
            'FLIGHT.png' => public_path('storage/images/FLIGHT.png'),
            'instagram2x.png' => public_path('storage/images/instagram2x.png'),
            'facebook2x.png' => public_path('storage/images/facebook2x.png'),
        ];

        // Đính kèm các ảnh và gán CID
        foreach ($images as $cid => $imagePath) {
            if (file_exists($imagePath)) {
                $this->attach($imagePath, [
                    'as' => $cid,
                    'mime' => 'image/png',
                    'encoding' => 'base64',
                    'cid' => $cid
                ]);
            }
        }

        return $this->subject('Booking Confirmation')
            ->view('client.email.emailviet.new-email') // View của email
            ->with(['data' => $this->emailData]);     // Truyền dữ liệu vào view
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Booking Success',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
