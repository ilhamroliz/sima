@extends('main')
@section('title', 'Daftar Project')
@section('extra_styles')
    <style type="text/css">
        .dark{
          background-color: #F2F2F2;
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
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project Progress</h4>
                        <button type="button" onclick="addProject()" class="btn btn-sm btn-custom pull-right w-md waves-effect waves-light"><i class="fa fa-plus"></i> Progress </button>
                        <div class="row col-12" style="margin-top: 50px; margin-left: 2px;">
                            <div class="col-3">
                                <div class="input-daterange input-group " id="date-range" style="">
                                    <input type="text" class="form-control" name="start" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                    <span class="input-group-addon bg-custom text-white b-0">to</span>
                                    <input type="text" class="form-control" name="end" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                </div>
                            </div>
                            <div class="col-4 form-group">
                                <select class="select2 form-control select2-multiple select2-hidden-accessible" multiple="" data-placeholder="Pilih Project" tabindex="-1" aria-hidden="true" id="select-project">
                                    @foreach($project as $select)
                                    <option value="{{ $select->p_code }}">{{ $select->p_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4 form-group">
                                <input type="text" placeholder="Masukkan Nama" class="form-control" name="team" id="cari-team">
                                <input type="hidden" class="form-control" name="teamHidden" id="teamHidden">
                            </div>
                            <div class="col-1 pull-right">
                                <button type="button" onclick="updateData()" class="btn btn-icon waves-effect waves-light btn-primary pull-right" style="margin-left: 10px;"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-12" style="margin-top: 10px;">
                            <div style="overflow: auto;" id="content-table1">
                                <table class="table table-hover table-bordered table-colored table-custom table-striped" cellspacing="0" width="100%" id="project-progress">
                                    <thead>
                                        <th style="width: 25%;">Nama Project</th>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th style="width: 17%;">Inisiator</th>
                                        <th style="width: 17%;">Team</th>
                                        <th style="width: 17%;">Fitur</th>
                                        <th style="width: 9%;">Aksi</th>
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
    </div>

    <div id="modal-project" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Pilih Project</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover table-colored table-custom">
                        <thead>
                            <th>Nama Project</th>
                        </thead>
                        <tbody>
                            @foreach($project as $row)
                            <tr onclick="addProgress('{{ $row->p_code }}')" style="cursor: pointer;">
                                <td>{{ $row->p_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
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
                        <div class="loading-circle">
                            <div class="sk-circle">
                                <div class="sk-circle1 sk-child"></div>
                                <div class="sk-circle2 sk-child"></div>
                                <div class="sk-circle3 sk-child"></div>
                                <div class="sk-circle4 sk-child"></div>
                                <div class="sk-circle5 sk-child"></div>
                                <div class="sk-circle6 sk-child"></div>
                                <div class="sk-circle7 sk-child"></div>
                                <div class="sk-circle8 sk-child"></div>
                                <div class="sk-circle9 sk-child"></div>
                                <div class="sk-circle10 sk-child"></div>
                                <div class="sk-circle11 sk-child"></div>
                                <div class="sk-circle12 sk-child"></div>
                            </div>
                        </div>
                        <div id="content-note" style="display: none;">
                            <form class="form-horizontal">
                                <input type="hidden" name="pp_id" class="pp_id">
                                <div class="form-group row">
                                    <label for="edit-executor" class="col-2 col-form-label">Eksekutor</label>
                                    <div class="select-executor col-6">
                                        <input type="text" class="form-control executor" name="eksekutor" id="edit-executor"  readonly>
                                    </div>
                                </div>
                                <div class="form-group no-margin">
                                    <label for="edit-target" class="control-label">Target</label>
                                    <textarea class="form-control" id="edit-target" placeholder="Tulis target untuk fitur ini" readonly></textarea>
                                </div>
                                <div class="form-group no-margin row">
                                    <label for="edit-execution" class="col-form-label col-2">Eksekusi</label>
                                    <div class="col-12">
                                        <textarea class="form-control" id="edit-execution" placeholder="Tulis hasil eksekusi untuk fitur ini" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-12 tombol-simpan" style="margin-top: 10px; display: none;">
                                    <input type="hidden" name="projectcode" class="projectcode" id="projectcode">
                                    <div class="pull-right">
                                        <button type="button"
                                                class="btn btn-info waves-effect waves-light btnUpdate"
                                                onclick="updateProgress()">Simpan
                                        </button>
                                    </div>
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
                                            
                                        </div>
                                        
                                    </div>
                                </div>
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
        var projectProgress;
        var dateProgress;
        var teamProgress;
        var start = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
        var end = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
        var id_team = '{{ Auth::user()->un_companyteam }}';
        var sekarang = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}';
        var statusGlobal = '';

        $('#cari-team').autocomplete({
            serviceUrl: baseUrl + '/manajemen-project/project-progress/getTeam',
            type: 'get',
            dataType: 'json',
            onSelect: function(event) {
                $('#teamHidden').val(event.data);
            }
        });
    
        $(document).ready(function(){
            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                projectProgress = $("#project-progress").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                        "type": "post",
                        "data": {awal: start, akhir: end, project: 'all'}
                    },
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'inisiator', name: 'inisiator'},
                        {data: 'eksekutor', name: 'eksekutor'},
                        {data: 'pf_detail', name: 'pf_detail'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 500);

            $(".select2").select2();

            $('#date-range').datepicker({
                toggleActive: true,
                autoclose: true,
                todayHighlight: true,
                format: "dd/mm/yyyy"
            });

        });

        function addProject() {
            $('#modal-project').modal('show');
        }

        function updateData(){
            var awal = document.getElementsByName('start')[0].value;
            var akhir = document.getElementsByName('end')[0].value;
            var project = $('#select-project').val();
            var team = $('#teamHidden').val();
            var data = null;

            if (team == null || team == '') {
                data = {awal: awal, akhir: akhir, project: project};
            } else {
                data = {awal: awal, akhir: akhir, project: project, team: team};
            }

            $("#project-progress").dataTable().fnDestroy();

            projectProgress = $("#project-progress").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                        "type": "post",
                        "data": data
                    },
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'inisiator', name: 'inisiator'},
                        {data: 'eksekutor', name: 'eksekutor'},
                        {data: 'pf_detail', name: 'pf_detail'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage
                });
        }

        function edit(id, kode) {
            $('#modal-progress').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-project/'+kode+'/getProgress',
                type: 'post',
                data: {pp_id: id},
                dataType: 'json',
                success: function (response) {
                    var data = response.data[0];
                    $('.edit-fitur').html(data.pp_date + ' - ' + data.pf_detail);
                    $('textarea#edit-target').val(data.pp_target);
                    $('textarea#edit-execution').val(data.pp_execution);
                    $('#edit-executor').val(data.team);
                    $('.pp_id').val(data.pp_id);
                    $('.loading-circle').hide();
                    $('#content-note').show();
                    statusGlobal = data.pp_state;
                    if (sekarang == data.pp_date && data.pp_state == 'ENTRY') {
                        $('#edit-execution').prop('readonly', false);
                        $('.tombol-simpan').show();
                        $('#projectcode').val(kode);
                    } else {
                        $('#projectcode').val('');
                        $('#edit-execution').prop('readonly', true);
                        $('.tombol-simpan').hide();
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

        function addProgress(kode){
            window.location = '{{ url('manajemen-project/project-progress/project') }}' + '/' + kode;
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
                type: 'post',
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
                        if (hasil != null) {
                            for(var i = 0, length1 = hasil.length; i < length1; i++){
                                if (hasil[i].team == id_team) {
                                    var chat = '<div class="outgoing_msg"><div class="sent_msg form-group"><label for="">'+hasil[i].name+'</label><p>'+hasil[i].note+'</p><span class="time_date"> '+hasil[i].time+'    |    '+hasil[i].date+'</span></div></div>';
                                    $('#konten-chat').append(chat);
                                } else {
                                    var chat = '<div class="incoming_msg"><div class="received_msg form-group"><label for="">'+hasil[i].name+'</label><div class="received_withd_msg"><p>'+hasil[i].note+'</p><span class="time_date"> '+hasil[i].time+'    |    '+hasil[i].date+'</span></div></div>';
                                    $('#konten-chat').append(chat);
                                }
                            }
                            $("#konten-chat").animate({ scrollTop: $('#konten-chat').prop("scrollHeight")}, 500);
                        }
                        $('#modal-catatan').modal('show');
                        $("#konten-chat").animate({ scrollTop: $('#konten-chat').prop("scrollHeight")}, 500);
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

        function updateProgress() {
            var fitur = $('.pp_id').val();
            var target = $('#edit-target').val();
            var eksekusi = $('#edit-execution').val();
            var note = $('#edit-note').val();
            var eksekutor = $('#edit-executor').val();
            var status = statusGlobal;
            var projectcode = $('#projectcode').val();
            $('#modal-progress').modal('hide');
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/get-project/'+projectcode+'/update-progress-init',
                type: 'post',
                data: {
                    pp_id: fitur,
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
                        projectProgress.ajax.reload();
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


    </script>
@endsection