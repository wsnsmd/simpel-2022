@extends('layouts.backend')

@section('sidebar')
    @include('layouts.sidebar_jadwal')
@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">    
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('js/plugins/es6-promise/es6-promise.auto.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/additional-methods.js') }}"></script>
    <script>        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        jQuery(function(){
            Dashmix.helpers(['datepicker', 'validation']); 
        });

        @if (session('success'))
        $.notify({
            icon: "fa fa-check mr-1",
            message: "{{ session('success') }}"
        }, {
            allow_dismiss: false,
            type: 'success',
            placement: {
                from: "top",
                align: "center"
            }
        });
        @elseif (session('error'))
        $.notify({
            icon: "fa fa-times mr-1",
            message: "{{ session('error') }}"
        }, {
            allow_dismiss: false,
            type: 'danger',
            placement: {
                from: "top",
                align: "center"
            }
        });
        @endif

        jQuery(document).ready(function () { 
            jQuery.extend(jQuery.validator.messages, {
                required: "Wajib diisi.",
            });

            var form_buat = $('#mdl-buat-form').validate({
                errorElement: "em",
				errorPlacement: function ( error, element ) {
					// Add the `help-block` class to the error element
					error.addClass( "help-block" );

					if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent( "label" ) );
					} else {
						error.insertAfter( element );
					}
				},
                highlight: function ( element, errorClass, validClass ) {
					$( element ).addClass( "is-invalid" ).removeClass( "valid" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).addClass( "valid" ).removeClass( "is-invalid" );
				}
            });

            $('#mdl-buat').on('hidden.bs.modal', function() {        
                form_buat.resetForm();
                $('#mdl-buat-form').trigger('reset');
                // $('textarea[name=keterangan]').val('');
                $('.is-invalid').removeClass('is-invalid');
            });
        })        
        
        function showBuat() {
            action = 'add';
            $('#mdl-buat').modal('show');
        }
    </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_dashboard.jpg') }}');">
        <div class="bg-white-90">
            <div class="content content-full">
                <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                    <h1 class="flex-sm-fill font-size-h3 font-w400 mt-2 mb-0 mb-sm-2">Sertifikat</h1>
                    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">Jadwal</li>
                            <li class="breadcrumb-item">Detail</li>
                            <li class="breadcrumb-item active" aria-current="page">{{$jadwal->nama}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Quick Menu -->
    @if(Gate::check('isUser'))
    <div class="pt-4 px-4 bg-body-dark rounded push">
        <div class="row row-deck">
            @if(!$sertifikat)
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-rounded block-link-pop text-center d-flex align-items-center" href="javascript:;" onclick="showBuat()">
                    <div class="block-content">
                        <p class="mb-2 d-sm-block">
                            <i class="fa fa-plus-circle text-success fa-2x"></i>
                        </p>
                        <p class="font-w600 font-size-sm text-uppercase">Buat Sertifikat</p>
                    </div>
                </a>
            </div>
            @else
            @if($sertifikat->import)
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-rounded block-link-pop text-center d-flex align-items-center" href="javascript:;">
                    <div class="block-content">
                        <p class="mb-2 d-sm-block">
                            <i class="fa fa-download text-warning fa-2x"></i>
                        </p>
                        <p class="font-w600 font-size-sm text-uppercase">Impor Peserta</p>
                    </div>
                </a>
            </div>            
            @else            
            <div class="col-6 col-md-4 col-xl-2">
                <a class="block block-rounded block-link-pop text-center d-flex align-items-center" href="javascript:;" onclick="event.preventDefault(); document.getElementById('buat-peserta-form').submit();">
                    <div class="block-content">
                        <p class="mb-2 d-sm-block">
                            <i class="fa fa-plus-circle text-success fa-2x"></i>
                        </p>
                        <p class="font-w600 font-size-sm text-uppercase">Buat Sertifikat Peserta</p>
                    </div>
                </a>
                <form id="buat-peserta-form" action="{{ route('backend.diklat.sertifikat.buat.peserta', ['jadwal' => $jadwal->id]) }}" method="post" style="display: none;">
                    @csrf                
                </form>
            </div>
            @endif
            @endif   
        </div>
    </div>
    @endif
    <!-- END Quick Menu --> 

    <!-- Page Content -->
    <div class="content">
        @if($sertifikat)
        <!-- Sertifikat Peserta -->        
        <div class="block block-bordered block-themed">
            <div class="block-header">
                <h3 class="block-title">Daftar Sertifikat</h3>
            </div>
            <div class="block-content block-content-full">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="font-w700 text-center" style="width: 30px;">#</th>
                                <th class="font-w700 text-center" style="width: 60px;">Nomor</th>
                                <th class="font-w700 text-center" style="width: 12%;">NIP</th>   
                                <th class="font-w700 text-center">Nama</th>                         
                                <th class="font-w700 text-center">Satuan Kerja</th>
                                <th class="font-w700 text-center">Instansi</th>
                                <th class="font-w700 text-center" style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sertPeserta as $sp)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{-- <img src="{{ is_null($sp->foto) ? asset('media/avatars/avatar8.jpg') :  asset(\Storage::url($sp->foto)) }}" class="img-avatar img-avatar-thumb img-avatar-rounded" style="height: auto;"> --}}
                                    {{ $sp->nomor }}
                                </td>
                                <td class="font-w600">
                                    {{ $sp->nip }}
                                </td>
                                <td class="font-w600">
                                    {{ $sp->nama_lengkap }}
                                </td>             
                                <td class="font-w600">
                                    {{ $sp->satker_nama }}
                                </td>          
                                <td class="font-w600">
                                    {{ $sp->instansi }}
                                </td>               
                                <td class="text-center">
                                    <form action="{{ route('backend.diklat.sertifikat.cetak', $sp->spid) }}" method="POST" target="_cetak">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-print mr-1"></i> Cetak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END Peserta Sertifikat -->
        @endif

        <!-- Modal Buat -->
        <div class="modal fade" id="mdl-buat" tabindex="-1" role="dialog" aria-labelledby="mdl-buat" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-popin" role="document">
                <form id="mdl-buat-form" method="POST" action="{{ route('backend.diklat.sertifikat.store') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                    <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title" id="mdl-form-title">Buat Sertifikat</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content" id="mdl-form-content">
                                    <div class="form-group form-row">
                                        <div class="col-6">
                                            <label for="barcode" class="control-label">Barcode <span class="text-danger">*</span></label>
                                            <select class="form-control" id="barcode" name="barcode" style="width: 100%;" required>
                                                <option value="" selected>-- Pilih Barcode --</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label for="kualifikasi" class="control-label">Kualifikasi <span class="text-danger">*</span></label>
                                            <select class="form-control" id="kualifikasi" name="kualifikasi" style="width: 100%;" required>
                                                <option value="" selected>-- Pilih Kualifikasi --</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>                         
                                    <div class="form-group form-row">
                                        <div class="col-6">
                                            <label for="import" class="control-label">Import <span class="text-danger">*</span></label>
                                            <select class="form-control" id="import" name="import" style="width: 100%;" required>
                                                <option value="" selected>-- Pilih Import --</option>
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="form-group form-row">
                                        <div class="col-6">
                                            <label for="tempat" class="control-label">Tempat Sertifikat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="tempat" name="tempat" placeholder="Cth. Samarinda..." required>
                                        </div>
                                        <div class="col-6">
                                            <label for="tanggal" class="control-label">Tanggal Sertifikat<span class="text-danger">*</span></label>
                                            <input type="text" class="js-datepicker form-control" id="tanggal" name="tanggal" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required>
                                        </div>
                                    </div>
                                    <h2 class="content-heading pt-0 mb-3">Pejabat Penandatangan</h2>
                                    <div class="form-group form-row">
                                        <div class="col-6">
                                            <label for="jabatan" class="control-label">Jabatan <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Cth. Kepala, Plt. Kepala..." required>
                                        </div>
                                        <div class="col-6">
                                            <label for="nip" class="control-label">NIP <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP..." min="18" maxlength="18" required>
                                        </div>
                                    </div>
                                    <div class="form-group form-row">
                                        <div class="col-6">
                                            <label for="nama" class="control-label">Nama <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama..." required>
                                        </div>
                                        <div class="col-6">
                                            <label for="pangkat" class="control-label">Pangkat <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pangkat" name="pangkat" placeholder="Pangkat..." required>
                                        </div>
                                    </div>                                
                                </div>
                                <div class="block-content block-content-full text-right bg-light">
                                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-sm btn-primary btn-submit"></i> Simpan</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        <!-- END Modal Buat -->
    </div>
    <!-- END Page Content -->     
@endsection
