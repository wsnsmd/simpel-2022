<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use GuzzleHttp\Client;

use DB;

class UploadSimpegJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public $timeout = 180;

    public $peserta;
    public $jadwal;
    public $sertifikat;
    public $struktural;
    public $jenis;
    public $url_sertifikat;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($peserta, $jadwal, $sertifikat, $struktural, $jenis, $url_sertifikat)
    {
        $this->peserta = $peserta;
        $this->jadwal = $jadwal;
        $this->sertifikat = $sertifikat;
        $this->struktural = $struktural;
        $this->jenis = $jenis;
        $this->url_sertifikat = $url_sertifikat;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url = null;
        switch($this->jenis)
        {
            case 1:
                $url = 'https://api-simpeg.kaltimbkd.info/pns/tambah-riwayat-diklat/diklat-struktural/?api_token=d7c91613809ddc815a262a2fdfa54415';
                break;
            case 2:
                $url = 'https://api-simpeg.kaltimbkd.info/pns/tambah-riwayat-diklat/diklat-fungsional/?api_token=d7c91613809ddc815a262a2fdfa54415';
                break;
            case 3:
                $url = 'https://api-simpeg.kaltimbkd.info/pns/tambah-riwayat-diklat/diklat-teknis/?api_token=d7c91613809ddc815a262a2fdfa54415';
                break;
            case 4:
                $url = 'https://api-simpeg.kaltimbkd.info/pns/tambah-riwayat-seminar/?api_token=d7c91613809ddc815a262a2fdfa54415';
                break;
        }

        $client = new \GuzzleHttp\Client();
        $res = $client->get($this->url_sertifikat);
        $content = (string) $res->getBody();

        $client = new Client(['verify' => false]);
        $options = [
            'multipart' => [
                [
                    'name' => 'nip',
                    'contents' => $this->peserta->nip
                ],
                [
                    'name' => ($this->jenis != 4 ? 'nama_diklat' : 'nama_seminar'),
                    'contents' => $this->jadwal->nama
                ],
                [
                    'name' => ($this->jenis != 4 ? 'tempat_diklat' : 'tempat_seminar'),
                    'contents' => $this->jadwal->lokasi_kota
                ],
                [
                    'name' => 'penyelenggara',
                    'contents' => $this->jadwal->lokasi
                ],
                [
                    'name' => 'angkatan',
                    'contents' => ''
                ],
                [
                    'name' => 'tgl_mulai',
                    'contents' => $this->jadwal->tgl_awal
                ],
                [
                    'name' => 'tgl_selesai',
                    'contents' => $this->jadwal->tgl_akhir
                ],
                [
                    'name' => 'jumlah_jam',
                    'contents' => $this->jadwal->total_jp
                ],
                [
                    'name' => 'no_sertifikat',
                    'contents' => $this->peserta->nomor
                ],
                [
                    'name' => 'tgl_sertifikat',
                    'contents' => $this->sertifikat->tanggal
                ],
                [
                    'name' => 'id_jenis_diklat_struktural',
                    'contents' => $this->struktural
                ],
                [
                    'name' => 'file',
                    'contents' => $content,
                    'filename' => '/sertifikat.pdf',
                    'headers'  => [
                      'Content-Type' => '<Content-type header>'
                    ]
                ],
            ]
        ];
        $request = new \GuzzleHttp\Psr7\Request('POST', $url);
        $res = $client->sendAsync($request, $options)->wait();

        $body = json_decode($res->getBody());

        if($body->kode == 200 && $body->valid)
        {
            $at = date('Y-m-d H:i:s');
            DB::table('sertifikat_peserta')->where('id', $this->peserta->spid)->update([
                'simpeg_at' => $at
            ]);
        }
    }
}
