@extends('main')
@section('title', 'Project Progress')
@section('extra_styles')
    <style type="text/css">
        .checkbox.checkbox-single {

            label {
                width: 0;
                height: 16px;
                visibility: hidden;

                &:before, &:after {
                    visibility: visible;
                }

            }
        }
        .table-project {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }
    </style>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Project Progress</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                            <li class="breadcrumb-item active">Project Progress</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project {{ $project[0]->pt_detail }} {{ $project[0]->p_name }}</h4>
                        <h4 class="header-title m-b-15 m-t-0 pull-right">{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</h4>
                        <div class="col-sm-12 table-project" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped" cellspacing="0" width="100%" id="project">
                                <thead>
                                    <th style="width: 25%;">Nama Fitur</th>
                                    <th style="width: 15%;">Tanggal</th>
                                    <th style="width: 20%;">Initiator</th>
                                    <th style="width: 20%;">Executor</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;" class="text-center">
                                        <button type="button" onclick="tambah()" title="Tambah" class="btn btn-icon waves-effect btn-primary btn-sm"> <i class="fa fa-plus"></i> </button>
                                    </th>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Modal content for the above example -->
    <div class="custombox-modal custombox-modal-fadein" style="transition-duration: 500ms; z-index: 10003;">
        <div id="modal-fitur" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Tambah Progress {{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-4" style="overflow: auto;" id="content-table">
                                    <table class="table table-colored table-pink table-striped table-hover table-bordered" id="list-fitur">
                                        <thead>
                                            <th>No</th>
                                            <th>Nama Fitur</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @if(count($projectFitur) > 0)
                                            @foreach($projectFitur as $index=>$modal)
                                                <tr style="cursor: pointer;" onclick="check({{ $modal->pf_id }}, this)">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $modal->pf_detail }}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <div class="checkbox checkbox-pink checkbox-single checkbox-inline">
                                                                <input type="checkbox" class="checkfitur pilih" id="fitur-{{ $modal->pf_id }}" value="{{ $modal->pf_id }}" name="fitur" aria-label="Single radio One">
                                                                <label></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-8">
                                    <div class="form-group no-margin">
                                        <label for="text-target" class="control-label">Target</label>
                                        <textarea class="form-control" id="text-target" placeholder="Tulis target untuk fitur ini" 
                                        @if ($posisi != 'PRJSPV')
                                            readonly 
                                        @endif
                                        ></textarea>
                                    </div>
                                    <div class="form-group no-margin row">
                                        <div class="col-8 form-group row">
                                            <label for="text-execution" class="col-form-label col-2">Eksekusi</label>
                                            <div class="col-10">
                                                <select class="form-control executor" name="eksekutor">
                                                    <option selected disabled>Pilih Eksekutor</option>
                                                    @foreach($team as $tim)
                                                        <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }} - {{ $tim->pp_detail }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" id="text-execution" placeholder="Tulis hasil eksekusi untuk fitur ini"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group no-margin">
                                        <label for="text-note" class="control-label">Catatan</label>
                                        <textarea class="form-control" id="text-note" placeholder="Tulis catatan untuk fitur ini"></textarea>
                                    </div>
                                    <div class="form-group no-margin">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-info waves-effect waves-light" onclick="addProgress()">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->


<!--  Modal content for the above example -->
    <div class="custombox-modal custombox-modal-fadein" style="transition-duration: 500ms; z-index: 10003;">
        <div id="modal-progress" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title edit-fitur" id="myLargeModalLabel">Edit Progress</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <input type="hidden" name="pf_id" class="pf_id">
                            <div class="form-group row">
                                <label for="edit-executor" class="col-2 col-form-label">Eksekutor</label>
                                <div class="select-executor col-5">
                                    <select class="form-control executor" name="eksekutor" id="edit-executor"
                                    @if ($posisi != 'PRJSPV')
                                        disabled 
                                    @endif
                                    >
                                        <option selected disabled>Pilih Eksekutor</option>
                                        @foreach($team as $tim)
                                            <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }} - {{ $tim->pp_detail }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label for="edit-target" class="control-label">Target</label>
                                <textarea class="form-control" id="edit-target" placeholder="Tulis target untuk fitur ini" 
                                @if ($posisi != 'PRJSPV')
                                    readonly 
                                @endif
                                ></textarea>
                            </div>
                            <div class="form-group no-margin row">
                                <label for="edit-execution" class="col-form-label col-2">Eksekusi</label>
                                <div class="col-12">
                                    <textarea class="form-control" id="edit-execution" placeholder="Tulis hasil eksekusi untuk fitur ini" readonly></textarea>
                                </div>
                                <div class="col-12">
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-warning waves-effect waves-light btn-xs">Hold</button>
                                        <button type="button" class="btn btn-info waves-effect waves-light btn-xs">Revision</button>
                                        <button type="button" class="btn btn-success waves-effect waves-light btn-xs">Closed</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                <label for="edit-note" class="control-label">Catatan</label>
                                <textarea class="form-control" readonly>Shitta | 22 Sep 2018 09:35 | "Fitur Absensi Seperti fitur absensi projek lain"
Mahmud | 23 Sep 2018 15:45 | "Beda beda mbak"
                                </textarea>
                                {{-- <input type="text" class="form-control" name="lastNote" readonly value='Shitta | 22 Sep 2018 | "Fitur Absensi Seperti fitur absensi projek lain"'>
                                <input type="text" class="form-control" name="lastNote" readonly value='Mahmud | 23 Sep 2018 | "Beda beda mbak"' style="margin-top: 10px;">
                                <input type="text" class="form-control" name="note" style="margin-top: 10px;" placeholder="Masukan Catatan"> --}}
                                {{-- <input type="text" class="form-control form-control-success" id="inputSuccess1" style="margin-top: 10px;" placeholder="Masukan Catatan"> --}}
                                <div class="input-group" style="margin-top: 10px">
                                    <input type="email" id="example-input2-group2" name="example-input2-group2" class="form-control" placeholder="Catatan">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn waves-effect waves-light btn-primary"><i class="dripicons-checkmark"></i></button>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group no-margin">
                                {{-- <div class="pull-right">
                                    <button type="button" class="btn btn-info waves-effect waves-light btnUpdate" onclick="updateProgress()">Simpan</button>
                                </div> --}}
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        var posisi = '{{ $posisi }}';
        $(document).ready(function(){
            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                table = $("#project").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/get-progress/'+'{{ $project[0]->p_code }}',
                        "type": "post",
                    },
                    columns: [
                        {data: 'pf_detail', name: 'pf_detail'},
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'init', name: 'init'},
                        {data: 'team', name: 'team'},
                        {data: 'pp_state', name: 'pp_state'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "ordering": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 500);
        });

        function tambah(){
            document.getElementById("content-table").style.height = (screen.height - (screen.height/3))+'px';
            $('#modal-fitur').modal('show');
        }

        function check(id, field){
            $(".checkfitur").prop("checked", false);
            document.getElementById("fitur-"+id).checked = true;
        }

        function addProgress(){
            var target = $('#text-target').val();
            var eksekusi = $('#text-execution').val();
            var note = $('#text-execution').val();
            var eksekutor = $('.executor').val();
            var fitur = $('input.pilih:checked').val();

            if (fitur == null || fitur == '') {
                $.toast({
                    heading: 'Peringatan!',
                    text: 'Pilih fitur yang ingin ditambahkan.',
                    position: 'top-right',
                    loaderBg: '#5ba035',
                    icon: 'warning',
                    hideAfter: 3000,
                    stack: 1
                });
                return false;
            }
            if (eksekutor == null || eksekutor == '') {
                $.toast({
                    heading: 'Peringatan!',
                    text: 'Pilih eksekutor yang ingin ditambahkan.',
                    position: 'top-right',
                    loaderBg: '#5ba035',
                    icon: 'warning',
                    hideAfter: 3000,
                    stack: 1
                });
                return false;
            }
            
            $('#modal-fitur').modal('hide');
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-project/{{ $kode }}/save-progress-init',
                type: 'post',
                data: {fitur: fitur, target: target, eksekusi: eksekusi, note: note, eksekutor: eksekutor},
                dataType: 'json',
                success: function (response) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (response.status == 'success') {
                        table.ajax.reload();
                        $.toast({
                            heading: 'Sukses!',
                            text: 'Data berhasil disimpan.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 1
                        });
                    } else if (response.status == 'failed') {
                        $.toast({
                            heading: 'Gagal!',
                            text: 'Data gagal disimpan, hubungi admin.',
                            position: 'top-right',
                            loaderBg: '#bf441d',
                            icon: 'error',
                            hideAfter: 3000,
                            stack: 1
                        });
                    }
                },
                error: function (xhr, status) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (status == 'timeout') {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 0) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 500) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                    }
                }
            });
        }

        function edit(id){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-project/{{ $kode }}/getProgress',
                type: 'post',
                data: {pp_id: id},
                dataType: 'json',
                success: function (response) {
                    $('#modal-progress').modal('show');
                    var data = response.data[0];
                    if (posisi == 'PRJPRG' && (data.pp_state == 'Hold' || data.pp_state == 'Closed')) {
                        $('#edit-target').prop('readonly', true);
                        $('#edit-execution').prop('readonly', true);
                        $('#edit-note').prop('readonly', true);
                        $('.btnUpdate').prop('disabled', true);
                    }
                    $('.edit-fitur').html('{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }} - ' + data.pf_detail);
                    $('textarea#edit-target').val(data.pp_target);
                    $('textarea#edit-execution').val(data.pp_execution);
                    $('textarea#edit-note').val(data.pp_note);
                    $('div .select-executor select').val(data.pp_team);
                    $('div .select-status select').val(data.pp_state);
                    $('.pf_id').val(data.pf_id);
                },
                error: function (xhr, status) {
                    if (status == 'timeout') {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 0) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 500) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                    }
                }
            });
        }

        function updateProgress(){
            var fitur = $('.pf_id').val();
            var target = $('#edit-target').val();
            var eksekusi = $('#edit-execution').val();
            var note = $('#edit-note').val();
            var eksekutor = $('#edit-executor').val();
            var status = $('.modal-status').val();

            $('#modal-progress').modal('hide');
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-project/{{ $kode }}/update-progress-init',
                type: 'post',
                data: {fitur: fitur, target: target, eksekusi: eksekusi, note: note, eksekutor: eksekutor, status: status},
                dataType: 'json',
                success: function (response) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (response.status == 'success') {
                        table.ajax.reload();
                        $.toast({
                            heading: 'Sukses!',
                            text: 'Data berhasil disimpan.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 1
                        });
                    } else if (response.status == 'failed') {
                        $.toast({
                            heading: 'Gagal!',
                            text: 'Data gagal disimpan, hubungi admin.',
                            position: 'top-right',
                            loaderBg: '#bf441d',
                            icon: 'error',
                            hideAfter: 3000,
                            stack: 1
                        });
                    }
                },
                error: function (xhr, status) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (status == 'timeout') {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Terjadi Kesalahan, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 0) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Koneksi Internet Bemasalah, Coba Lagi Nanti');
                    }
                    else if (xhr.status == 500) {
                        $('.error-load').css('visibility', 'visible');
                        $('.error-load small').text('Ups. Server Bemasalah, Coba Lagi Nanti');
                    }
                }
            });
        }
    </script>
@endsection
