@extends('frontend.daftar._index')

@section('content-block')
    <div class="block-header block-header-default">
        <h3 class="block-title">2. <small>Registrasi</small></h3>
    </div>
    <!-- Form -->
    <form action="{{ route('jadwal.daftar.step2')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="step" value="2">
        <div class="block-content block-content-full">
            <h2 class="content-heading pt-0">Data Peserta</h2>
            <div class="form-group mb-0">
                <label for="foto">Foto</label><br>
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new img-thumbnail" style="width: 200px; height: 150px;">
                        <img src="{{ asset('media/avatars/foto.png') }}" alt="Foto">
                    </div>
                    <div class="fileinput-preview fileinput-exists img-thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                    <div>
                        <span class="btn btn-sm btn-outline-secondary btn-file"><span class="fileinput-new">Pilih Foto</span><span class="fileinput-exists">Ganti</span><input type="file" accept="image/x-png,image/gif,image/jpeg" id="foto" name="foto"></span>
                        <a href="#" class="btn btn-sm btn-outline-secondary fileinput-exists" data-dismiss="fileinput">Hapus</a>
                    </div>
                    <small class="form-text text-muted">Hanya file (*.jpg, *.png, *.gif) dengan ukuran < 512 KB</small>
                </div>                                    
            </div>
            <div class="form-group form-row">
                <div class="col-6">
                    <label for="nip">NIP</label>
                    <input class="js-maxlength form-control" type="text" id="nip" name="nip" placeholder="NIP tanpa spasi..." minlength="18" maxlength="18" data-always-show="true" data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-primary" value="{{ $pegawai['nip'] }}" readonly required>
                </div>
                <div class="col-6">
                    <label for="nip">NIK (No. KTP)</label>
                    <input class="js-maxlength form-control" type="text" id="ktp" name="ktp" placeholder="NIK (No. KTP)..." minlength="16" maxlength="16" data-always-show="true" data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-primary" required>
                </div>                                    
            </div>
            <div class="form-group form-row">
                <div class="col-6">
                <label for="instansi">Nama Lengkap</label>
                    <input class="form-control" type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap..." required>
                </div>
                <div class="col-6">
                        <label for="instansi">Nama Panggilan</label>
                    <input class="form-control" type="text" id="nama_panggil" name="nama_panggil" placeholder="Nama Panggilan..." required>
                </div>
            </div>
            <div class="form-group">
                <label for="instansi">Alamat</label>
                <textarea class="form-control" name="alamat" placeholder="Alamat..." required></textarea>
            </div>                                
            <div class="form-group form-row">
                <div class="col-6">
                    <label for="instansi">Tempat Lahir</label>
                    <input class="form-control" type="text" id="tmp_lahir" name="tmp_lahir" placeholder="Tempat Lahir..." required>
                </div>
                <div class="col-6">
                    <label for="instansi">Tanggal Lahir</label>
                    <input class="js-datepicker form-control" type="text" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd" required>
                </div>
            </div>  
            <div class="form-group form-row">
                <div class="col-6">
                    <label for="instansi">Jenis Kelamin</label>
                    <select class="form-control" id="jk" name="jk" style="width: 100%;" required>
                        <option value="" selected>-- Pilih Jenis Kelamin --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="instansi">Agama</label>
                    <select class="form-control" id="agama" name="agama" style="width: 100%;" required>
                        <option value="" selected>-- Pilih Agama --</option>
                        @foreach ($agama as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>                                    
                        @endforeach
                    </select>
                </div>
            </div>                                
            <div class="form-group form-row">
                <div class="col-6">
                    <label for="instansi">No. Handphone</label>
                    <input class="form-control" type="text" id="hp" name="hp" placeholder="No. Handphone..." required>
                </div>
                <div class="col-6">
                    <label for="instansi">Email</label>
                    <input class="form-control" type="email" id="email" name="email" placeholder="Email..." required>
                </div>
            </div>              
            <div class="form-group form-row">
                <div class="col-6">
                    <label for="instansi">Status Perkawinan</label>
                    <select class="form-control" id="marital" name="marital" style="width: 100%;" required>
                        <option value="" selected>-- Pilih Status Perkawinan --</option>
                        <option value="1">Menikah</option>
                        <option value="2">Belum Menikah</option>
                        <option value="3">Duda</option>
                        <option value="4">Janda</option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="instansi">Pangkat</label>
                    <select class="form-control" id="pangkat" name="pangkat" style="width: 100%;" required>
                        <option value="" selected>-- Pilih Pangkat --</option>
                        @foreach ($pangkat as $p)
                        <option value="{{ $p->id }}">{{ $p->singkat }}</option>                                    
                        @endforeach
                    </select>
                </div>                                    
            </div>                                                                                                             
            <div class="form-group">
                <label for="instansi">Jabatan</label>
                <input class="form-control" type="text" id="jabatan" name="jabatan" placeholder="Jabatan..." required>
            </div>
            <h2 class="content-heading pt-3 mb-3">Data Instansi & Unit Kerja</h2>
            <div class="form-group">
                <label for="instansi">Instansi</label>
                <select class="form-control" id="instansi" name="instansi" style="width: 100%;" required>
                    <option value="" selected>-- Pilih Instansi --</option>
                    @foreach ($instansi as $i)
                    <option value="{{ $i->nama }}">{{ $i->nama }}</option>                                    
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="instansi">Satuan Kerja (SKPD/OPD)</label>
                <input class="form-control" type="text" id="satker_nama" name="satker_nama" placeholder="Satuan Kerja..." required>
            </div>
            <div class="form-group">
                <label for="instansi">Alamat</label>
                <textarea class="form-control" id="satker_alamat" name="satker_alamat" placeholder="Alamat Satuan Kerja..." required></textarea>
            </div>    
            <div class="form-group form-row">
                <div class="col-6">
                <label for="instansi">No. Telepon</label>
                <input class="form-control" type="text" id="satker_telp" name="satker_telp" placeholder="No. Telepon Satuan Kerja" required>
                </div>
            </div>                                                                                             
        </div>
        <div class="block-content block-content-sm block-content-full bg-body-light rounded-bottom">
            <div class="row">
                <div class="col-12">
                    <a href="{{URL::route('jadwal.daftar.step1')}}" class="btn btn-sm btn-primary"><i class="fa fa-angle-left"></i>
                        Kembali</a>
                    <button type="submit" class="btn btn-sm btn-primary">
                        Lanjut <i class="fa fa-angle-right ml-1"></i>
                    </button>                                        
                    <button type="reset" class="btn btn-sm btn-light">
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </form>
    <!-- END Form -->
@endsection    