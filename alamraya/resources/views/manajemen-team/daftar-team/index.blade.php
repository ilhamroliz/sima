@extends('main')
@section('title', 'Daftar Project')
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
                        <h4 class="page-title float-left">Daftar Team</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Team</a></li>
                            <li class="breadcrumb-item active">Daftar Team</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <button type="button" onclick="addProject()"
                                class="btn btn-sm btn-custom pull-right w-md waves-effect waves-light"><i
                                class="fa fa-plus"></i> Tambah Team
                        </button>
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Daftar Team</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <div class="form-group row">
                                <label class="col-1 col-form-label" style="margin-left: 15px;">Status</label>
                                <div class="col-3" style="margin-left: 12px;">
                                    <select class="form-control" id="filter" name="filtercolumn" onchange="getData()">
                                        <option value="all">All</option>
                                        <option value="ACTIVE" selected>Active</option>
                                        <option value="CUTI">Cuti</option>
                                        <option value="OUT">Out</option>
                                    </select>
                                </div>
                            </div>
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="daftar-team">
                                <thead>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Aksi</th>
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
                table = $("#daftar-team").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-team/get-team/ACTIVE',
                        "type": "get"
                    },
                    columns: [
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'ct_state', name: 'ct_state'},
                        {data: 'ct_in', name: 'ct_in'},
                        {data: 'ct_out', name: 'ct_out'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    //"scrollY": '50vh',
                    //"scrollCollapse": true,
                    "language": dataTableLanguage,
                });
                $('#daftar-team').css('width', '100%').dataTable().fnAdjustColumnSizing();
            }, 500);
        });

        function getData(){
            var status = $('#filter').val();
            table.destroy();
            table = $("#daftar-team").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": baseUrl + '/manajemen-team/get-team/'+status,
                    "type": "POST"
                },
                columns: [
                    {data: 'ct_name', name: 'ct_name'},
                    {data: 'ct_state', name: 'ct_state'},
                    {data: 'ct_in', name: 'ct_in'},
                    {data: 'ct_out', name: 'ct_out'},
                    {data: 'aksi', name: 'aksi'}
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
    </script>
@endsection
