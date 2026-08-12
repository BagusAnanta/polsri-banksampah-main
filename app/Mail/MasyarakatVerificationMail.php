<?php

namespace App\Mail;

use App\Models\Masyarakat;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MasyarakatVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $masyarakat;
    public $status;
    public $alasan;

    public function __construct(Masyarakat $masyarakat, $status, $alasan = null)
    {
        $this->masyarakat = $masyarakat;
        $this->status = $status;
        $this->alasan = $alasan;
    }

    public function build()
    {
        $isApproved = $this->status === 'Disetujui';

        return $this->subject($isApproved
                ? 'Akun Bank Sampah Telah Disetujui'
                : 'Akun Bank Sampah Ditolak')
            ->view('mail.masyarakat-verification', [
                'masyarakat' => $this->masyarakat,
                'status' => $this->status,
                'alasan' => $this->alasan,
                'isApproved' => $isApproved,
            ]);
    }
}