@extends('main')
@section('title', 'Daftar Project')
@section('extra_styles')
    <style type="text/css">
        .dark{
          background-color: #F2F2F2;
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
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <div style="overflow: auto;" id="content-table1">
                                <table class="table table-hover table-bordered table-colored table-custom table-striped" cellspacing="0" width="100%" id="project-progress">
                                    <thead>
                                        <th style="width: 40%;">Nama Project</th>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th style="width: 20%;">Team</th>
                                        <th style="width: 25%;">Fitur</th>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Tanggal Progress</h4>

                        <div class="col-12 form-group">
                            <div class="input-daterange input-group col-5" id="date-range" style="margin-top: 40px;">
                                <input type="text" class="form-control" name="start" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                <span class="input-group-addon bg-custom text-white b-0">to</span>
                                <input type="text" class="form-control" name="end" value="{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}">
                                <button type="button" onclick="updateDate()" class="btn btn-icon waves-effect waves-light btn-primary" style="margin-left: 10px;"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-12" style="margin-top: 10px;">
                            <div style="overflow: auto;" id="content-table2">
                                <table class="table table-hover table-bordered table-colored table-pink table-striped" cellspacing="0" width="100%" id="date-progress">
                                    <thead>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th style="width: 40%;">Nama Project</th>
                                        <th style="width: 20%;">Team</th>
                                        <th style="width: 25%;">Fitur</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Update Progress</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <div style="overflow: auto;" id="content-table3">
                                <table class="table table-hover table-bordered table-colored table-warning table-striped" cellspacing="0" width="100%" id="team-progress">
                                    <thead>
                                        <th style="width: 20%;">Team</th>
                                        <th style="width: 40%;">Nama Project</th>
                                        <th style="width: 15%;">Tanggal</th>
                                        <th style="width: 25%;">Fitur</th>
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

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var projectProgress;
        var dateProgress;
        var teamProgress;
        var start = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
        var end = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
    
        $(document).ready(function(){
            document.getElementById("content-table1").style.height = (screen.height/2)+'px';
            document.getElementById("content-table2").style.height = (screen.height/2)+'px';
            document.getElementById("content-table3").style.height = (screen.height/2)+'px';

            $('#pencarian').autocomplete({
                source: baseUrl + '/manajemen-pekerja/phk/carino',
                select: function(event, ui) {
                    getdata(ui.item.id);
                }
            });

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
                        "data": {tipe: 'project'}
                    },
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'pf_detail', name: 'pf_detail'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "ordering": false,
                    "paging": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 500);

            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                dateProgress = $("#date-progress").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                        "type": "post",
                        "data": {tipe: 'date', start: start, end: end}
                    },
                    columns: [
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'p_name', name: 'p_name'},
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'pf_detail', name: 'pf_detail'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "ordering": false,
                    "paging": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 750);

            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                teamProgress = $("#team-progress").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                        "type": "post",
                        "data": {tipe: 'team'}
                    },
                    columns: [
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'pf_detail', name: 'pf_detail'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "ordering": false,
                    "paging": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 1000);

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

        function updateDate(){
            var awal = document.getElementsByName('start')[0].value;
            var akhir = document.getElementsByName('end')[0].value;

            $("#date-progress").dataTable().fnDestroy();

            dateProgress = $("#date-progress").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                        "type": "post",
                        "data": {tipe: 'date', start: awal, end: akhir}
                    },
                    columns: [
                        {data: 'pp_date', name: 'pp_date'},
                        {data: 'p_name', name: 'p_name'},
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'pf_detail', name: 'pf_detail'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "ordering": false,
                    "paging": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
        }
    </script>
@endsection
