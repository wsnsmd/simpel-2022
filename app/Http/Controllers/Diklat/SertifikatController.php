<?php

namespace App\Http\Controllers\Diklat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;

class SertifikatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request) 
    {   
        $validator = $request->validate([            
            'jadwal_id' => 'required',
            'barcode' => 'required',
            'kualifikasi' => 'required',
            'import' => 'required',
            'tempat' => 'required',
            'tanggal' => 'required|date',
            'jabatan' => 'required',
            'nip' => 'required|min:18|max:18',
            'nama' => 'required',
            'pangkat' => 'required',
        ]);

        $input = $request->all();

        DB::beginTransaction();

        try 
        {
            $created_at = date('Y-m-d H:i:s');

            DB::table('sertifikat')->insert([
                'diklat_jadwal_id' => $input['jadwal_id'],
                'barcode' => $input['barcode'],
                'kualifikasi' => $input['kualifikasi'],
                'import' => $input['import'],
                'tempat' => $input['tempat'],
                'tanggal' => $input['tanggal'],
                'jabatan' => $input['jabatan'],
                'nip' => $input['nip'],
                'nama' => $input['nama'],
                'pangkat' => $input['pangkat'],
                'created_at' => $created_at
            ]);
        }
        catch (\Exception $e) 
        {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        $notifikasi = 'Data sertifikat berhasil dibuat!';

        $jadwal = DB::table('v_jadwal_detail')->where('id', $input['jadwal_id'])->first();

        return redirect()->route('backend.diklat.jadwal.detail', ['id' => $jadwal->id, 'slug' => str_slug($jadwal->nama), 'page' => 'sertifikat'])
                    ->with([
                        'success' => $notifikasi,
                    ]);
    }

    public function buatPeserta(Request $request, $id)
    {
        $peserta = DB::table('v_sertifikat_peserta')
                    ->where('diklat_jadwal_id', $id)
                    ->get();

        $jadwal = DB::table('v_jadwal_detail')->find($id);
        
        $sertifikat = DB::table('sertifikat')->where('diklat_jadwal_id', $id)->first();

        return view('backend.diklat.sertifikat.buat_peserta', compact('jadwal', 'peserta', 'sertifikat'));
    }

    public function buatPesertaSimpan(Request $request, $id)
    {
        // dd($request->all());
        $pid = $request->pid;

        $created_at = date('Y-m-d H:i:s');
        $jadwal = DB::table('v_jadwal_detail')->find($id);
        $sertifikat = DB::table('sertifikat')->where('diklat_jadwal_id', $id)->first();

        $bulan = date('m', strtotime($sertifikat->tanggal));
        $tahun = date('Y', strtotime($sertifikat->tanggal));

        $result = DB::table('sertifikat_peserta')
                    ->where('tahun', $tahun)
                    ->where('bidang', $jadwal->usergroup)
                    ->max('no');      

        DB::beginTransaction();

        try
        {
            foreach($pid as $p) 
            {   
                $peserta = DB::table('v_peserta')
                            ->where('id', $p)
                            ->where('diklat_jadwal_id', $id)
                            ->exists();
                
                if($peserta)
                {
                    $no = ++$result;
                    $nomor = sprintf("%04s%02s%s", $no, $bulan, $tahun);

                    DB::table('sertifikat_peserta')->insert([
                        'no' => $no,
                        'peserta_id' => $p,
                        'sertifikat_id' => $sertifikat->id,
                        'nomor' => $nomor,
                        'tahun' => $tahun,
                        'bidang' => $jadwal->usergroup,
                        'created_at' => $created_at,
                    ]);
                }
                else 
                {
                    throw new \Exception('Simpan data sertifikat gagal, data peserta tidak sesuai!');
                }
            }
        }
        catch (\Exception $e) 
        {
            DB::rollback();
            throw $e;
        }

        DB::commit();

        $notifikasi = 'Data sertifikat peserta berhasil dibuat!';
        
        return redirect()->route('backend.diklat.jadwal.detail', ['id' => $jadwal->id, 'slug' => str_slug($jadwal->nama), 'page' => 'sertifikat'])
                    ->with([
                        'success' => $notifikasi,
                    ]);
    }

    public function cetak(Request $request, $id)
    {
        $sertPeserta = DB::table('v_sertifikat')
                        ->select('nip', 'nama_lengkap', 'tmp_lahir', 'tgl_lahir', 'jabatan', 'foto', 'instansi', 'satker_nama', 'diklat_jadwal_id', 'pangkat', 'golongan', 'nomor', 'sertifikat_id') 
                        ->where('spid', $id)
                        ->first();

        $sertifikat = DB::table('sertifikat')
                        ->select('tempat', 'tanggal', 'jabatan', 'nama', 'pangkat', 'nip', 'diklat_jadwal_id')
                        ->where('id', $sertPeserta->sertifikat_id)
                        ->first();

        $jadwal = DB::table('v_jadwal_detail')
                        ->select('nama', 'tipe', 'tgl_awal', 'tgl_akhir', 'kelas', 'total_jp', 'lokasi', 'lokasi_kota')
                        ->where('id', $sertifikat->diklat_jadwal_id)
                        ->first();

        if(!is_null($sertPeserta->foto))
        {
            $sertPeserta->foto = asset(\Storage::url($sertPeserta->foto));
        }
        else 
        {
            $sertPeserta->foto = asset('media/avatars/avatar8.jpg');
        }

        $temp = [];
        $data = [];
        $temp['sertifikat'] = $sertifikat;
        $temp['peserta'] = $sertPeserta;
        $temp['jadwal'] = $jadwal;
        $data['json'] = json_encode($temp);

        return view('report.sertifikat.template1', $data);
    }
}
