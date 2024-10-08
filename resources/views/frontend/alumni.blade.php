@extends('layouts.frontend')

@section('css_before')
    <!-- Page JS Plugins CSS -->  
    <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection


@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        jQuery(function() { 
            Dashmix.helpers(['datepicker']); 
                // Override a few default classes
                jQuery.extend(jQuery.fn.dataTable.ext.classes, {
                sWrapper: "dataTables_wrapper dt-bootstrap4",
                sFilterInput:  "form-control",
                sLengthSelect: "form-control"
            });

            // Override a few defaults
            jQuery.extend(true, jQuery.fn.dataTable.defaults, {
                language: {
                    emptyTable: "Tidak ada data tersedia",
                    infoEmpty: "Halaman 0 dari 0",
                    lengthMenu: "_MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "Cari...",
                    info: "Halaman <strong>_PAGE_</strong> dari <strong>_PAGES_</strong>",
                    paginate: {
                        first: '<i class="fa fa-angle-double-left"></i>',
                        previous: '<i class="fa fa-angle-left"></i>',
                        next: '<i class="fa fa-angle-right"></i>',
                        last: '<i class="fa fa-angle-double-right"></i>'
                    }
                }
            });

            jQuery('.js-dataTable-full').dataTable({
                pageLength: 25,
                lengthMenu: [[10, 25, 50], [10, 25, 50]],
                autoWidth: false,
                scrollX: true,
            });

            $('#form-cari').submit(function (e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), 
                    success: function(data)
                    {
                        $('#div-data').html(data);
                    }
                });
            });
        });
    </script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light border-top border-bottom">
        <div class="content content-full py-1">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-sm text-uppercase font-w700 mt-2 mb-0 mb-sm-2">
                    <i class="fa fa-angle-right fa-fw text-primary"></i> Alumni
                </h1>
                <nav class="flex-sm-00-auto ml-sm-3 font-size-sm" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><i class="fa fa-home"></i></li>
                        <li class="breadcrumb-item active" aria-current="page">Alumni</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <div class="bg-image" style="background-image: url('{{ asset('media/various/bg_dashboard.jpg') }}');">
        <div class="bg-white-90">
            <div class="content invisible" data-toggle="appear">
                <div class="text-center py-3">
                    <h1 class="h3 font-w700 mb-2">Data Alumni Pelatihan</h1>
                    <h2 class="h5 font-w400 text-muted">Silahkan isi form dibawah untuk melakukan pencarian!</h2>
                </div>
                <form id="form-cari" action="{{ route('alumni.cari') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-group row items-push mb-0">
                        <div class="col-md-4">
                            <input type="text" class="form-control text-center" id="nip" name="nip" placeholder="NIP...">
                        </div>
                        <div class="col-md-2">
                            <select class="custom-select" id="tahun" name="tahun">
                                <option value="">Tahun...</option>
                                @foreach ($tahun as $t)
                                <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>    
                                @endforeach          
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="custom-select" id="jenis" name="jenis">
                                <option value="">Jenis...</option>
                                <option value="0">Semua</option>
                                @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>                                                                   
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-search mr-1"></i> Cari</button>
                        </div>
                        <div class="col-md-2">
                            <button type="reset" class="btn btn-block btn-dark">Reset</button>
                        </div>                    
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <div class="content">
            <div class="row invisible" data-toggle="appear">
                <div class="block block-rounded block-bordered" style="width: 100%">
                    <div class="block-content block-content-full">
                        <div class="table-responsive" id="div-data">
                            @include('frontend.alumni_cari')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection    