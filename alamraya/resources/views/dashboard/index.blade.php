@extends('main')
@section('title', 'Dashboard')
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
        .noti-icon-badge{
            top: -8px !important;
            right: -10px !important;
            position: absolute !important;
        }
        .badge{
            padding: 3px !important;
        }
        .noti-icon-badge-left{
            top: -8px !important;
            left: -10px !important;
            position: absolute !important;
            cursor: pointer;
        }
        .btn {
            cursor: pointer;
        }
    </style>
@endsection
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Dashboard</h4>

                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Project Progress</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-progress" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Fitur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Daftar Project</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-list" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Supervisor</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Catatan</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-note" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Dari</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

    </div> <!-- container -->
</div> <!-- content -->

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
                                        <div class="type_msg">
                                            <div class="input_msg_write">
                                                <input type="text" id="write_msg" class="write_msg" placeholder="Type a message"/>
                                                <button class="msg_send_btn" id="msg_send_btn" type="button" onclick="writeNote()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                            </div>
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

    <!--  Modal content for the above example -->
    <div class="custombox-modal custombox-modal-fadein" style="transition-duration: 500ms; z-index: 10003;">
        <div id="modal-controll" class="modal bs-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title edit-fitur" id="modal-title">Controll Progress Team {{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-bordered table-colored table-pink table-striped" id="table-controll" cellspacing="0" width="100%">
                            <thead>
                                <th>Nama Team</th>
                                <th>Supervisor</th>
                                <th>Project</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </div><!-- /.modal -->
@endsection

@section('extra_scripts')
<script type="text/javascript">
    var projectprogress;
    var projectlist;
    var projectnote;
    var start = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
    var end = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
    $(document).ready(function(){
        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            projectprogress = $("#project-progress").DataTable({
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
                    {data: 'pf_detail', name: 'pf_detail'},
                    {data: 'aksi', name: 'aksi'}
                ],
                responsive: true,
                scrollY:'50vh',
                scrollCollapse: true,
                paging:false,
                searching: false,
                "pageLength": 10,
                "aaSorting": [],
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "language": dataTableLanguage,
            });
        }, 500);
    });

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
                        if (response.tanggal == '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}') {
                            $('.type_msg').show();
                        } else {
                            $('.type_msg').hide();
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

</script>
@endsection
