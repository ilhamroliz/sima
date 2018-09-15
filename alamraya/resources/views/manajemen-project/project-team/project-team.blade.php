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
                        <h4 class="page-title float-left">Project Team</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                            <li class="breadcrumb-item active">Tim Pelaksana</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped"
                                   cellspacing="0" width="100%" id="project-team">
                                <thead>
                                    <th>Nama Project</th>
                                    <th>Tipe</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $data[0]->p_name }}</td>
                                        <td>{{ $data[0]->pt_detail }}</td>
                                        <td class="text-center">{{ $data[0]->deadline }}</td>
                                        <td class="text-center">{{ $data[0]->p_state }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-4">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Our Team</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-xs table-hover"
                                   cellspacing="0" width="100%" id="project-team">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                </thead>
                                <tbody>
                                    @foreach($team as $index=>$row)
                                    <tr style="cursor: pointer;" onclick="add('{{ $row->ct_id }}')">
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row->ct_name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project Team {{ $data[0]->p_name }}</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-xs table-hover"
                                   cellspacing="0" width="100%" id="project-team">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Posisi</th>
                                    <th class="text-center">Aksi</th>
                                </thead>
                                <tbody>
                                    @foreach($data as $no=>$team)
                                    <tr>
                                        <td>{{ $no + 1 }}</td>
                                        <td>{{ $team->ct_name }}</td>
                                        <td>{{ $team->pp_detail }}</td>
                                        <td class="text-center">
                                            <button type="button" title="Ganti Posisi" class="btn btn-icon waves-effect btn-primary btn-xs"> <i class="fa fa-exchange"></i> </button>
                                            <button type="button" title="Delete" class="btn btn-icon waves-effect btn-danger btn-xs"> <i class="fa fa-times"></i> </button>
                                        </td>
                                    </tr>
                                    @endforeach
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
        $(document).ready(function(){
            $("#project-team").DataTable({
                "searching": false,
                "paging": false,
                "info": false,
                "language": dataTableLanguage
            });
        })

        function add(id){
            alert(id);
        }
    </script>
@endsection
