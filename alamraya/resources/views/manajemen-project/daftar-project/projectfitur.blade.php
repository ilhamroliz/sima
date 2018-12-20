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
                                    <th style="width: 30%;">Nama Fitur</th>
                                    <th style="width: 10%;">Progress</th>
                                    <th style="width: 15%;">Deadline</th>
                                    <th style="width: 15%;">Estimasi</th>
                                    <th style="width: 20%;">Status</th>
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
    <!--  Modal content for the above example -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="labelEdit">Edit Progress Fitur</h4>
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
                    <form class="form-horizontal" id="form-edit" style="display: none;">
                        <input type="hidden" name="project" class="projectcode">
                        <input type="hidden" name="fitur" class="fitur">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Point</label>
                            <div class="col-3">
                                <select class="form-control point" name="point" id="point">
                                    <option value="" selected>Pilih</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <label class="col-2 col-form-label">Status</label>
                            <div class="col-5">
                                <select class="form-control status" name="status" id="status">
                                    <option value="" selected>Pilih</option>
                                    <option value="OBSERVASI">Observasi</option>
                                    <option value="FRONT">Front End</option>
                                    <option value="CODE">Code</option>
                                    <option value="PENDING">Pending</option>
                                    <option value="REVISION">Revision</option>
                                    <option value="DONE">Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Persentase</label>
                            <div class="col-10">
                                <input type="text" name="persentase" id="persentase" class="persentase form-control" placeholder="Persentase Pengerjaan" maxlength="5" onkeyup="cekPersentase()">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Deadline</label>
                            <div class="col-10">
                                <input type="text" name="deadline" id="deadline" class="deadline form-control" placeholder="Deadline Fitur">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Durasi</label>
                            <div class="col-10">
                                <input type="text" name="durasi" id="durasi" class="durasi form-control" placeholder="Durasi Pengerjaan (Hari)">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Selesai</label>
                            <div class="col-10">
                                <input type="text" name="donest" id="donest" class="donest form-control" placeholder="Estimasi Selesai">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Tutup</button>
                    <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
                        {data: 'pf_doneest', name: 'pf_doneest'},
                        {data: 'pf_state', name: 'pf_state'},
                        {data: 'aksi', name: 'aksi'},
                    ],
                    responsive: true,
                    "pageLength": 10,
                    "aaSorting": [],
                    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                    "language": dataTableLanguage,
                });
            }, 500);

            $('#donest').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy'
            });

            $('#deadline').datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'dd/mm/yyyy'
            });

            $("#persentase").maskMoney({
                thousands:'', 
                decimal:'.', 
                allowZero:true, 
                suffix:' %',
                precision: 0,
                numeralMaxLength: 4
            });

            $("#durasi").maskMoney({
                thousands:'',
                allowZero:true, 
                suffix:' Hari',
                precision: 0,
            });

        });

        function editProgress(project, fitur){
            $('#modalEdit').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-fitur/get-info',
                type: 'post',
                data: {project: project, fitur: fitur},
                dataType: 'json',
                success: function (response) {
                    $('.loading-circle').hide();
                    $('#form-edit').show();
                    var data = response.data[0];
                    $('.point').val(data.pf_point);
                    $('.status').val(data.pf_state);
                    var persen = parseInt(data.pf_progress);
                    $('.persentase').val(persen + ' %');
                    $('.deadline').val(data.pf_deadline);
                    $('.durasi').val(data.pf_duration);
                    $('.donest').val(data.pf_doneest);
                    $('.projectcode').val(project);
                    $('.fitur').val(fitur);
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

        function simpan(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/manajemen-project/project-fitur/update-progress',
                type: 'get',
                data: $('#form-edit').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'sukses') {
                        $.toast({
                            heading: 'Sukses!',
                            text: 'Data berhasil disimpan.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 1
                        });
                        $('#modalEdit').modal('hide');
                        table.ajax.reload();
                    } else if (response.status == 'gagal') {
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

        function convertToAngka(teks)
        {
            return parseInt(teks.replace(/,.*|[^0-9]/g, ''), 10);
        }

        function cekPersentase(){
            var input = $('.persentase').val();
            input = convertToAngka(input);
            input = parseInt(input);
            if (input > 100) {
                $('.persentase').val('100 %');
            }
        }

    </script>
@endsection
