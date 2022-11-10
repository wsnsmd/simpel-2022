@extends('frontend.daftar._index')

@section('content-block')
    <div class="block-header block-header-default">
        <h3 class="block-title">1. <small>Instansi</small></h3>
    </div>
    <!-- Form -->
    <form action="{{ route('jadwal.daftar.step1')}}" method="POST" autocomplete="off">
        @csrf
        <input type="hidden" name="step" value="1">
        <div class="block-content block-content-full">
            <div class="form-group">
                <label for="instansi">Instansi</label>
                <select class="custom-select" id="instansi" name="instansi" required>
                    <option value="">-- Pilih Instansi --</option>
                    <option value="1">Pemerintah Provinsi Kalimantan Timur</option>
                    <option value="2">Pemerintah Kab/Kota Kalimantan Timur</option>
                    <option value="3">Pemerintah Provinsi/Kementerian/Lembaga Lain</option>
                </select>
            </div>
            <div class="form-group">
                <label for="status">Status ASN</label>
                <select class="custom-select" id="status" name="status" required>
                    <option value="">-- Pilih Status ASN --</option>
                    <option value="1">PNS</option>
                    <option value="2">PPPK</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nip">NIP tanpa spasi</label>
                <input class="js-maxlength form-control" type="text" id="nip" name="nip" placeholder="NIP tanpa spasi" minlength="18" maxlength="18" data-always-show="true" data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-primary" required>
            </div>
        </div>
        <div class="block-content block-content-sm block-content-full bg-body-light rounded-bottom">
            <div class="row">
                <div class="col-12">
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