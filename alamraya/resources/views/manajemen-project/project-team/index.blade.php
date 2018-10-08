@extends('main')
@section('title', 'Project Team')
@section('extra_styles')
    <style type="text/css">

    </style>
@endsection
@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title float-left">Daftar Project</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                            <li class="breadcrumb-item active">Project Team</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <button type="button" onclick="projectPosition()" class="btn btn-sm btn-info waves-effect w-md waves-light pull-right"><i
                                class="fa fa-list-ul"></i> Project Position
                        </button>
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Daftar Project</h4>
                        <div class="col-12" style="margin-top: 50px;">
                            <div class="form-group row">
                                <label class="col-1 col-form-label" style="margin-left: 15px;">Status</label>
                                <div class="col-3" style="margin-left: 12px;">
                                    <select class="form-control" id="filter" name="filtercolumn" onchange="getData()">
                                        <option value="all">All</option>
                                        <option value="RUNNING" selected>Running</option>
                                        <option value="DONE">Done</option>
                                        <option value="FAULT">Fault</option>
                                    </select>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="daftar-project">
                                <thead>
                                    <th>Nama Project</th>
                                    <th>Tipe</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Status</th>
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
@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        $(document).ready(function () {
            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                table = $("#daftar-project").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-team/get-data/RUNNING',
                        "type": "post"
                    },
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pt_detail', name: 'pt_detail'},
                        {data: 'p_kickoff', name: 'p_kickoff'},
                        {data: 'p_deadline', name: 'p_deadline'},
                        {data: 'p_state', name: 'p_state'}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    //"scrollY": '50vh',
                    //"scrollCollapse": true,
                    "language": dataTableLanguage,
                });
                $('#daftar-project').css('width', '100%').dataTable().fnAdjustColumnSizing();
            }, 500);
        });

        $('#daftar-project').on('click', '.list-project', function (e) {
            location.href = baseUrl + '/manajemen-project/project-team/project/' + this.id;
        });

        function getData(){
            var status = $('#filter').val();
            table.destroy();
            table = $("#daftar-project").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": baseUrl + '/manajemen-project/project-team/get-data/'+status,
                    "type": "post"
                },
                columns: [
                    {data: 'p_name', name: 'p_name'},
                    {data: 'pt_detail', name: 'pt_detail'},
                    {data: 'p_kickoff', name: 'p_kickoff'},
                    {data: 'p_deadline', name: 'p_deadline'},
                    {data: 'p_state', name: 'p_state'}
                ],
                responsive: true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "aaSorting": [],
                //"scrollY": '50vh',
                //"scrollCollapse": true,
                "language": dataTableLanguage,
            });
        }

        function projectPosition(){
            location.href = baseUrl + '/manajemen-project/project-team/project-position';
        }
    </script>
@endsection
