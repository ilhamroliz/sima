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
                        <h4 class="page-title float-left">Daftar Fitur</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('manajemen-project/daftar-project') }}">Daftar Project</a></li>
                            <li class="breadcrumb-item active">Daftar Fitur</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Daftar Fitur {{ $project[0]->pt_detail }} {{ $project[0]->p_name }}</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="daftar-fitur">
                                <thead>
                                    <th style="width: 50%;">Nama Fitur</th>
                                    <th style="width: 20%;">Progress</th>
                                    <th style="width: 20%;">Deadline</th>
                                    <th style="width: 10%;">Aksi</th>
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
                table = $("#daftar-fitur").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/daftar-project/get-fitur/'+'{{ $project[0]->p_code }}',
                        "type": "POST"
                    },
                    columns: [
                        {data: 'pf_detail', name: 'pf_detail'},
                        {data: 'pf_progress', name: 'pf_progress'},
                        {data: 'pf_deadline', name: 'pf_deadline'},
                        {data: 'aksi', name: 'aksi'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    //"scrollY": '50vh',
                    //"scrollCollapse": true,
                    "language": dataTableLanguage,
                });
            }, 500);
        });
    </script>
@endsection
