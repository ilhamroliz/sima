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
                                   cellspacing="0" width="100%" id="project">
                                <thead>
                                <th>Nama Project</th>
                                <th>Tipe</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Progress</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $project[0]->p_name }}</td>
                                    <td>{{ $project[0]->pt_detail }}</td>
                                    <td class="text-center">{{ $project[0]->deadline }}</td>
                                    <td class="text-center">{{ $project[0]->p_state }}</td>
                                    <td class="text-center">
                                        <button type="button" onclick="progress('{{ $project[0]->p_code }}')" title="Project Progress" class="btn btn-icon waves-effect btn-custom btn-xs"> <i class="fa fa-line-chart"></i> </button>
                                    </td>
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
                            <table class="table table-xs table-hover" cellspacing="0" width="100%" id="our-team">
                                <thead>
                                <th>Nama</th>
                                <th></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="card-box">
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Project Team {{ $project[0]->p_name }}</h4>
                        <div class="col-sm-12" style="margin-top: 50px;">
                            <table class="table table-xs table-hover" cellspacing="0" width="100%" id="project-team">
                                <thead>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th class="text-center">Aksi</th>
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

    <div id="masukan-team" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Masukkan ke team</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" id="form-modal">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <label class="namapilihan-modal col-form-label"></label>
                                <input type="hidden" name="ct_id" class="idteam-modal">
                                <input type="hidden" name="p_code" class="idproject-modal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Posisi</label>
                            <div class="col-10">
                                <select class="form-control" name="position">
                                    @foreach($posisi as $posisi)
                                        <option value="{{ $posisi->pp_code }}"> {{ $posisi->pp_detail }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-info waves-effect waves-light" onclick="tambah()">Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        var table;
        var ourteam;
        var projectteam;
        var project = '{{ $project[0]->p_code }}';
        $(document).ready(function () {
            setTimeout(function () {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                ourteam = $("#our-team").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-team/getData',
                        "type": "post",
                        "data": {kode: 'ourteam', project: project}
                    },
                    columns: [
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "searching": false,
                    "paging": false,
                    "info": false,
                    "pageLength": 10,
                    "ordering": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 500);

            setTimeout(function () {
                projectteam = $("#project-team").DataTable({
                    "search": {
                        "caseInsensitive": true
                    },
                    processing: true,
                    serverSide: true,
                    "ajax": {
                        "url": baseUrl + '/manajemen-project/project-team/getData',
                        "type": "post",
                        "data": {kode: 'projectteam', project: project}
                    },
                    columns: [
                        {data: 'ct_name', name: 'ct_name'},
                        {data: 'pp_detail', name: 'pp_detail'},
                        {data: 'aksi', name: 'aksi'}
                    ],
                    responsive: true,
                    "searching": false,
                    "paging": false,
                    "info": false,
                    "pageLength": 10,
                    "ordering": false,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });

            }, 1000);
        })

        $('#our-team').on('click', '.row-team', function (e) {
            var nama = $('#' + this.id).text();
            var id = this.id;
            $('.namapilihan-modal').html(nama);
            $('.idteam-modal').val(id);
            $('.idproject-modal').val(project);
            $('#masukan-team').modal('show');
        });

        function tambah() {
            $('#masukan-team').modal('hide');
            waitingDialog.show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-team/addTeam',
                type: 'post',
                data: $('#form-modal').serialize(),
                dataType: 'json',
                success: function (response) {
                    setTimeout(function () {waitingDialog.hide();}, 500);
                    if (response.status == 'success') {
                        ourteam.ajax.reload();
                        projectteam.ajax.reload();
                        $.toast({
                            heading: 'Sukses!',
                            text: 'Data berhasil disimpan.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 1
                        });
                    } else if (response.status == 'already') {
                        $.toast({
                            heading: 'Perhatian!',
                            text: 'Nama sudah di dalam list project team.',
                            position: 'top-right',
                            loaderBg: '#da8609',
                            icon: 'warning',
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


        function hapus(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-team/deleteTeam',
                type: 'post',
                data: {ct_id: id, p_code: project},
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'success') {
                        ourteam.ajax.reload();
                        projectteam.ajax.reload();
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

        function progress(kode){
            location.href = baseUrl + '/manajemen-project/project-progress/project/' + kode;
        }
    </script>
@endsection
