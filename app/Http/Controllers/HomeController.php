<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DaftarMailable;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function mail()
    {
        // $name = 'Wawan Setiawan';
        // Mail::to('wsnsmd@gmail.com')->send(new DaftarMailable($name));
   
        // return 'Email was sent';
        $jadwal = DB::table('v_jadwal_detail')->find(1);
        $url = route('jadwal.detail', ['jadwal' => $jadwal->id, 'slug' => str_slug($jadwal->nama)]);
        
        return view('emails.verifikasi_wait', ['name' => 'Wawan Setiawan'], compact('jadwal'));
    }
}
