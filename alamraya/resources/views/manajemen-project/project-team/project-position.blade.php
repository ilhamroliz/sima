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
                        <h4 class="page-title float-left">Project Position</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                            <li class="breadcrumb-item"><a href="#">Project Team</a></li>
                            <li class="breadcrumb-item active">Project Position</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project Position</h4>
                        <div class="col-12" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="table-position">
                                <thead>
                                    <th>Nama Project</th>
                                    <th>Status</th>
                                    <th>Posisi</th>
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
                table = $("#table-position").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-team/get-position',
                        "type": "get"
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
    </script>
@endsection
