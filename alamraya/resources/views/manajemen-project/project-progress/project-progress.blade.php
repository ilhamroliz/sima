@extends('main')
@section('title', 'Project Progress')
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
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project {{ $info[0]->pt_detail }} {{ $info[0]->p_name }}</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-hover table-bordered table-colored table-custom table-striped" cellspacing="0" width="100%" id="project">
                                <thead>
                                    <th style="width: 20%;">Nama Fitur</th>
                                    <th style="width: 15%;">Tanggal</th>
                                    <th style="width: 55%;">Progress</th>
                                    <th style="width: 10%;" class="text-center">
                                        <button type="button" onclick="tambah()" title="Tambah" class="btn btn-icon waves-effect btn-primary btn-sm"> <i class="fa fa-plus"></i> </button>
                                    </th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Master Item</td>
                                        <td class="text-center">{{ Carbon\Carbon::now('Asia/Jakarta')->format('d M Y') }}</td>
                                        <td class="text-center"><textarea class="form-control"></textarea></td>
                                        <td class="text-center">
                                            <button type="button" onclick="tambah()" title="Tambah" class="btn btn-icon waves-effect btn-primary btn-sm"> <i class="fa fa-plus"></i> </button>
                                            <button type="button" onclick="hapus()" title="Hapus" class="btn btn-icon waves-effect btn-danger btn-sm"> <i class="fa fa-times"></i> </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="row">
                @foreach($info as $row)
                <div class="col-12">
                    <div class="portlet">
                        <div class="portlet-heading portlet-default">
                            <h3 class="portlet-title text-dark">
                                Fitur {{ $row->pf_detail }}
                            </h3>
                            <div class="portlet-widgets">
                                <a href="javascript:;" data-toggle="reload"><i class="fa fa-save" onclick="save({{ $row->pf_id }})"></i></a>
                                <a data-toggle="collapse" data-parent="#accordion1" href="#portlet-{{ $row->pf_id }}"><i class="mdi mdi-minus"></i></a>
                                <a href="#" data-toggle="remove"><i class="mdi mdi-close"></i></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div id="portlet-{{ $row->pf_id }}" class="panel-collapse collapse in show">
                            <div class="portlet-body">
                                <form class="form-horizontal row form-{{ $row->pf_id }}">
                                    @if($row->pp_init == null)
                                    <div class="col-3" style="margin-top: 10px">
                                        <select class="form-control init-{{ $row->pf_id }}" name="team">
                                            <option selected disabled>Pilih Inisiator</option>
                                            @foreach($team as $tim)
                                                <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }} - {{ $tim->pp_detail }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-9">
                                        <textarea class="target-{{ $row->pf_id }} form-control" name="target[]"></textarea>
                                    </div>
                                    @else
                                    <label class="col-3 col-form-label">{{ $row->init_name }}</label>
                                    <div class="col-9">
                                        <textarea class="target-{{ $row->pf_id }} form-control" name="target[]">{{ $row->pp_target }}</textarea>
                                    </div>
                                    @endif

                                    @if($row->pp_team == null)
                                    <div class="col-3" style="margin-top: 10px">
                                        <select class="form-control team-{{ $row->pf_id }}" name="team">
                                            <option selected disabled>Pilih Eksekutor</option>
                                            @foreach($team as $tim)
                                                <option value="{{ $tim->ct_id }}">{{ $tim->ct_name }} - {{ $tim->pp_detail }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <label class="col-3 col-form-label" style="margin-top: 10px">{{ $row->team_name }}</label>
                                    @endif
                                    <div class="col-9" style="margin-top: 10px">
                                        <textarea class="eksekusi-{{ $row->pf_id }} form-control" name="eksekusi[]"></textarea>
                                    </div>
                                </form>                                
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div> --}}

        </div>
    </div>

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var counter = 1;
        var table;
        var project = '{{ $info[0]->p_code }}';
        $(document).ready(function(){
            table = document.getElementById("project");
            $('.mdi-minus').click();
        });

        function tambah(){
            $('#masukan-fitur').modal('show');
        }

        function addFitur(kode){
            
        }

        function save(id){
            var eksekusi = $('.eksekusi-'+id).val();
            var target = $('.target-'+id).val();
            var team = $('.team-'+id).val();
            var init = $('.init-'+id).val();
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-progress/save',
                type: 'get',
                data: {target: target, eksekusi: eksekusi, id: id, project: project, team: team, init: init},
                dataType: 'json',
                success: function (response) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (response.status == 'success') {
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
                    setTimeout(function () {waitingDialog.hide();}, 500);
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
