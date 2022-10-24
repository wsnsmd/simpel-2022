<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifikasiStatusMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $jadwal;
    public $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $jadwal, $status)
    {
        //
        $this->name = $name;
        $this->jadwal = $jadwal; 
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(setting()->get('from_email'), setting()->get('from_name'))
                    ->subject('Status Verifikasi Pendaftaran')
                    ->view('emails.verifikasi_status');
    }
}
