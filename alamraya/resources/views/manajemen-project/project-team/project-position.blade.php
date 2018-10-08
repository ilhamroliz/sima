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
                        <div class="col-12 row" style="margin-top: 50px;">
                            @if(Auth::user()->un_companyteam == 'AR000000')
                            <div class="col-7 form-group">
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
                            @endif
                            <div class="col-12">
                                @if(Auth::user()->un_companyteam == 'AR000000')
                                <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                       cellspacing="0" width="100%" id="table-position">
                                    <thead>
                                        <th>Nama Project</th>
                                        <th>Nama Team</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                @else
                                <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                       cellspacing="0" width="100%" id="table-position">
                                    <thead>
                                        <th>Nama Project</th>
                                        <th>Posisi</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                @endif
                            </div>
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
                    @if(Auth::user()->un_companyteam == 'AR000000')
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'pp_detail', name: 'pp_detail'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    @else
                    columns: [
                        {data: 'p_name', name: 'p_name'},
                        {data: 'pp_detail', name: 'pp_detail'}
                    ],
                    @endif
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    //"scrollY": '50vh',
                    //"scrollCollapse": true,
                    "language": dataTableLanguage,
                });
                $('#table-position').css('width', '100%').dataTable().fnAdjustColumnSizing();
            }, 500);

            $('#cari-team').autocomplete({
                serviceUrl: baseUrl + '/manajemen-project/project-progress/getTeam',
                type: 'get',
                dataType: 'json',
                onSelect: function(event) {
                    $('#teamHidden').val(event.data);
                }
            });

            $(".select2").select2();
        });
    </script>
@endsection
