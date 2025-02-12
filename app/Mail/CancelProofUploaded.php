<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelProofUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public $confirmationCode;
    public $cancelProofImage;
    public $sotien; // Biến chứa số tiền hoàn

    /**
     * Create a new message instance.
     *
     * @param string $confirmationCode
     * @param string|null $cancelProofImage
     * @param float $refundAmount
     */
    public function __construct($confirmationCode, $cancelProofImage, $refundAmount)
    {
        $this->confirmationCode = $confirmationCode;
        $this->cancelProofImage = $cancelProofImage;
        $this->sotien = $refundAmount; // Gán giá trị số tiền hoàn vào thuộc tính
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject('Yêu cầu hoàn tiền của bạn đã được tiếp nhận')
                      ->view('admin.mail.cancel_proof_uploaded')
                      ->with([
                          'confirmationCode' => $this->confirmationCode,
                          'refundAmount' => $this->sotien, // Gửi số tiền hoàn qua view
                      ]);

        if ($this->cancelProofImage) {
            $email->attachFromStorageDisk('public', $this->cancelProofImage, 'cancel-proof-image.jpg');
        }

        return $email;
    }
}
