<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectCancelTourMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tourName;

    /**
     * Tạo instance mới cho RejectCancelTourMail.
     *
     * @param string $tourName
     */
    public function __construct(string $tourName)
    {
        $this->tourName = $tourName;
    }

    /**
     * Build email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông báo: Không chấp nhận hủy tour')
                    ->view('admin.mail.reject_cancel_tour');
    }
}
