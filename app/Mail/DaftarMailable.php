<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DaftarMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $url)
    {
        //        
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(setting()->get('from_email'), setting()->get('from_name'))
                    ->subject('Verifikasi Pendaftaran')
                    ->view('emails.daftar');
    }
}
