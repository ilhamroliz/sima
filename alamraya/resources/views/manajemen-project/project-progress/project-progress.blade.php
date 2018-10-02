@extends('main')
@section('title', 'Project Progress')
@section('extra_styles')
    <style type="text/css">
        .checkbox.checkbox-single {

            label {
                width: 0;
                height: 16px;
                visibility: hidden;

                &
                :before,

                &
                :after {
                    visibility: visible;
                }

            }
        }
        .table-project {
            max-height: calc(100vh - 210px);
            overflow-y: auto;
        }

        #list-fitur_filter {
            float: left !important;
            margin-left: -150px;
        }

        .container {
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }

        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
            padding:
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 5px 0 5px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
        }

        .msg_history {
            overflow: auto;
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
                        <h4 class="header-title m-b-15 m-t-0 pull-left">
                            Project {{ $project[0]->pt_detail }} {{ $project[0]->p_name }}</h4>
                        <h4 class="header-title m-b-15 m-t-0 pull-right">{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</h4>
                        <div class="col-sm-12 table-project" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="project">
                                <thead>
                                <th style="width: 23%;">Nama Fitur</th>
                                <th style="width: 15%;">Tanggal</th>
                                <th style="width: 20%;">Initiator</th>
                                <th style="width: 20%;">Executor</th>
                                <th style="width: 8%;">Status</th>
                                <th style="width: 15%;" class="text-center">
                                    @if($posisi == 'PRJSPV')
                                        <button type="button" onclick="tambah()" title="Tambah"
                                                class="btn btn-icon waves-effect btn-primary btn-sm"><i
                                                class="fa fa-plus"></i></button>
                                    @else
                                        Aksi
                                    @endif
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
        <div id="modal-fitur" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel">Tambah
                            Progress {{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="row">
                                <div class="col-4" style="overflow: auto;" id="content-table">
                                    <table
                                        class="table table-colored table-pink table-striped table-hover table-bordered"
                                        id="list-fitur" cellspacing="0" style="width: 100%;">
                                        <thead>
                                        <th>Code</th>
                                        <th>Nama Fitur</th>
                                        <th></th>
                                        </thead>
                                        <tbody>
                                        @if(count($projectFitur) > 0)
                                            @foreach($projectFitur as $index=>$modal)
                                                <tr style="cursor: pointer;" onclick="check({{ $modal->pf_id }}, this)">
                                                    <td>{{ $modal->pf_code }}</td>
                                                    <td>{{ $modal->pf_detail }}</td>
                                                    <td>
                                                        <div class="text-center">
                                                            <div
                                                                class="checkbox checkbox-pink checkbox-single checkbox-inline">
                                                                <input type="checkbox" class="checkfitur pilih"
                                                                       id="fitur-{{ $modal->pf_id }}"
                                                                       value="{{ $modal->pf_id }}" name="fitur"
                                                                       aria-label="Single radio One">
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
                                        <textarea class="form-control" id="text-target"
                                                  placeholder="Tulis target untuk fitur ini"
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
                                                        <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }}
                                                            - {{ $tim->pp_detail }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" id="text-execution"
                                                      placeholder="Tulis hasil eksekusi untuk fitur ini"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group no-margin">
                                        <label for="text-note" class="control-label">Catatan</label>
                                        <textarea class="form-control" id="text-note"
                                                  placeholder="Tulis catatan untuk fitur ini"></textarea>
                                    </div>
                                    <div class="form-group no-margin">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-info waves-effect waves-light"
                                                    onclick="addProgress()">Simpan
                                            </button>
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
        <div id="modal-progress" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title edit-fitur" id="myLargeModalLabel">Edit Progress</h4>
                    </div>
                    <div class="modal-body">
                        <div id="content-note">
                            <form class="form-horizontal">
                                <input type="hidden" name="pf_id" class="pf_id">
                                <div class="form-group row">
                                    <label for="edit-executor" class="col-2 col-form-label">Eksekutor</label>
                                    <div class="select-executor col-6">
                                        <select class="form-control executor" name="eksekutor" id="edit-executor"
                                                @if ($posisi != 'PRJSPV')
                                                disabled
                                            @endif
                                        >
                                            <option selected disabled>Pilih Eksekutor</option>
                                            @foreach($team as $tim)
                                                <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }}
                                                    - {{ $tim->pp_detail }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group no-margin">
                                    <label for="edit-target" class="control-label">Target</label>
                                    <textarea class="form-control" id="edit-target"
                                              placeholder="Tulis target untuk fitur ini"
                                              @if ($posisi != 'PRJSPV')
                                              readonly
                                        @endif
                                    ></textarea>
                                </div>
                                <div class="form-group no-margin row">
                                    <label for="edit-execution" class="col-form-label col-2">Eksekusi</label>
                                    <div class="col-12">
                                        <textarea class="form-control" id="edit-execution"
                                                  placeholder="Tulis hasil eksekusi untuk fitur ini" readonly></textarea>
                                    </div>
                                    @if($posisi == 'PRJSPV')
                                        <div class="col-12">
                                            <div class="pull-right">
                                                <button type="button"
                                                        class="btn btn-warning waves-effect waves-light btn-xs">Hold
                                                </button>
                                                <button type="button" class="btn btn-info waves-effect waves-light btn-xs">
                                                    Revision
                                                </button>
                                                <button type="button"
                                                        class="btn btn-success waves-effect waves-light btn-xs">Closed
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12" style="margin-top: 10px;">
                                            <div class="pull-right">
                                                <button type="button"
                                                        class="btn btn-info waves-effect waves-light btnUpdate"
                                                        onclick="updateProgress()">Simpan
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->

    <!--  Modal content for the above example -->
    <div class="custombox-modal custombox-modal-fadein" style="transition-duration: 500ms; z-index: 10003;">
        <div id="modal-catatan" class="modal bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title edit-fitur" id="modal-title">Catatan Fitur</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="messaging">
                                <div class="inbox_msg">
                                    <div class="mesgs" style="width: 100%">
                                        <input type="hidden" name="id_pp" id="id_pp">
                                        <input type="hidden" name="id_project" id="id_project">
                                        <div class="msg_history" id="konten-chat" style="width: 100%">
                                            {{-- <div class="incoming_msg">
                                                <div class="received_msg form-group">
                                                    <label for="">Nama</label>
                                                    <div class="received_withd_msg">
                                                        <p>Test, which is a new approach to have</p>
                                                        <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
                                                </div>
                                            </div>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p>Test which is a new approach to have all
                                                        solutions</p>
                                                    <span class="time_date"> 11:01 AM    |    June 9</span></div>
                                            </div>
                                            <div class="incoming_msg">
                                                <div class="received_msg">
                                                    <div class="received_withd_msg">
                                                        <p>Test, which is a new approach to have</p>
                                                        <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
                                                </div>
                                            </div>
                                            <div class="outgoing_msg">
                                                <div class="sent_msg">
                                                    <p>Apollo University, Delhi, India Test</p>
                                                    <span class="time_date"> 11:01 AM    |    Today</span></div>
                                            </div> --}}
                                            
                                        </div>
                                        <div class="type_msg">
                                            <div class="input_msg_write">
                                                <input type="text" id="write_msg" class="write_msg" placeholder="Type a message"/>
                                                <button class="msg_send_btn" id="msg_send_btn" type="button" onclick="writeNote()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group no-margin">
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        var id_team = '{{ Auth::user()->un_companyteam }}';
        var posisi = '{{ $posisi }}';
        $(document).ready(function () {
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
                        "url": baseUrl + '/manajemen-project/project-progress/get-progress/' + '{{ $project[0]->p_code }}',
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

            $("#list-fitur").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                fixedColumns: true,
                responsive: true,
                "paging": false,
                "ordering": false,
                "aaSorting": [],
                "info": false,
                "language": dataTableLanguage,
            });

        });

        function tambah() {
            document.getElementById("content-table").style.height = (screen.height - (screen.height / 3)) + 'px';
            $('#modal-fitur').modal('show');
        }

        function check(id, field) {
            $(".checkfitur").prop("checked", false);
            document.getElementById("fitur-" + id).checked = true;
        }

        function addProgress() {
            var target = $('#text-target').val();
            var eksekusi = $('#text-execution').val();
            var note = $('#text-note').val();
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
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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

        function edit(id) {
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
                    console.log(data);
                    if (posisi == 'PRJPRG' && (data.pp_state == 'ENTRY' || data.pp_state == 'REVISION')) {
                        $('#edit-target').prop('readonly', true);
                        $('#edit-execution').prop('readonly', false);
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

        function updateProgress() {
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
                type: 'get',
                data: {
                    fitur: fitur,
                    target: target,
                    eksekusi: eksekusi,
                    note: note,
                    eksekutor: eksekutor,
                    status: status
                },
                dataType: 'json',
                success: function (response) {
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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

        function note(id, project) {
            document.getElementById('konten-chat').style.height = (screen.height / 2) + 'px';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-chat',
                type: 'get',
                data: {
                    id: id,
                    project: project
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        var hasil = response.data;
                        $('#id_pp').val(id);
                        $('#id_project').val(project);
                        $('#modal-title').html('Catatan fitur ' + response.fitur + ' - ' + response.tanggal);
                        $('#konten-chat').empty();
                        for(var i = 0, length1 = hasil.length; i < length1; i++){
                            if (hasil[i].team == id_team) {
                                var chat = '<div class="outgoing_msg"><div class="sent_msg form-group"><label for="">'+hasil[i].name+'</label><p>'+hasil[i].note+'</p><span class="time_date"> '+hasil[i].time+'    |    '+hasil[i].date+'</span></div></div>';
                                $('#konten-chat').append(chat);
                            } else {
                                var chat = '<div class="incoming_msg"><div class="received_msg form-group"><label for="">'+hasil[i].name+'</label><div class="received_withd_msg"><p>'+hasil[i].note+'</p><span class="time_date"> '+hasil[i].time+'    |    '+hasil[i].date+'</span></div></div>';
                                $('#konten-chat').append(chat);
                            }
                        }
                        $('#modal-catatan').modal('show');
                    } else if (response.status == 'failed') {
                        
                    }
                },
                error: function (xhr, status) {
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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

        function writeNote(){
            var msg = $('#write_msg').val();
            var id = $('#id_pp').val();
            project = $('#id_project').val();
            $('#write_msg').val('');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            waitingDialog.show();
            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/save-note',
                type: 'get',
                data: {
                    note: msg,
                    project: project,
                    id: id
                },
                dataType: 'json',
                success: function (response) {
                    note(id, project);
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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

        document.getElementById("write_msg").addEventListener("keyup", function(event) {
          // Cancel the default action, if needed
            event.preventDefault();
          // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
            // Trigger the button element with a click
                document.getElementById("msg_send_btn").click();
            }
        });
    </script>
@endsection
