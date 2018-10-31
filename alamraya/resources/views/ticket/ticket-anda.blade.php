<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>SIMA | Ticket</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
    <meta content="Coderthemes" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Select2 -->
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Bootstrap fileupload css -->
    <link href="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet"/>
    <!-- Toastr css -->
    <link href="{{ asset('assets/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet"/>
    <!-- Date Picker -->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <!-- Date Range Picker -->
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
    <!-- DataTables -->
    <link href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
    <style type="text/css">
        .topbar .topbar-left {
            background: #64C5B1;
        }

        footer {
            left: 0px !important;
        }

        .footer {
            padding: 10px 30px 10px 10px;
        }

        .content-page {
            margin-left: 0px !important;
        }
        .preview {
            margin-bottom: 10px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th {
            padding: 8px 8px;
            vertical-align: top;
        }
        .table>thead>tr>td, .table>thead>tr>th {
            padding: 10px 8px;
            vertical-align: middle;
        }
        .footer{
            padding: 10px 30px 10px;
        }
        .checkbox.checkbox-single {

            label {
                width: 0;
                height: 16px;
                visibility: hidden;

                &
                :before,

                &
                :after {
                    visibility: visible;
                }

            }
        }
        .radio.radio-single {

            label {
                width: 0;
                height: 16px;
                visibility: hidden;

                &
                :before,

                &
                :after {
                    visibility: visible;
                }

            }
        }
        .dataTables_length .form-control{
            padding: 0px 10px 0px 10px;
            height: 30px;
        }
        .dataTables_filter .form-control{
            padding: 0px 10px 0px 10px;
            height: 30px;
        }
    </style>
</head>
<body>
<div id="wrapper">

    <div class="topbar">
        <!-- LOGO -->
        <div class="topbar-left form-group">
            <a href="{{ url('home') }}" class="logo">
                        <span>
                            <img src="{{ asset('assets/images/logo_dark.png') }}" alt="" height="30">
                        </span>
                <i>
                    <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="28">
                </i>
            </a>
        </div>

        <nav class="navbar-custom">
            <div class="pull-right" style="vertical-align: middle; margin-top: 22px; margin-right: 10px;">
                <span
                    style="color: #fff"><strong>{{ \GeniusTS\HijriDate\Hijri::convertToHijri(Carbon\Carbon::now('Asia/Jakarta'))->format('l d F o') }}</strong></span>
            </div>
        </nav>

    </div>

    <div class="content-page">

        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12" style="margin-top: 25px;">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-sm-12 row">
                                    <div class="col-12">
                                        <h3 class="font-600" style="text-align: left;">Tiket Anda</h3>
                                        <p class="text-muted" style="text-align: left;"> Menampilkan list ticket yang pernah anda buat</p>
                                    </div>
                                    
                                    <div class="col-12 form-horizontal">
                                        <div class="form-group col-12 row">
                                            <label for="input-daterange" class="col-1 col-form-label">Tanggal</label>
                                            <div class="col-5">
                                                <div class="input-daterange input-group" id="date-range">
                                                    <input type="text" class="form-control" name="start" />
                                                    <span class="input-group-addon bg-custom text-white b-0">Sampai</span>
                                                    <input type="text" class="form-control" name="end" />
                                                </div>
                                            </div>
                                            <label for="status" class="col-1 col-form-label">Status</label>
                                            <div class="col-2">
                                                <input type="text" name="status" class="form-control" id="status">
                                            </div>
                                            <label for="urgency" class="col-1 col-form-label">Prioritas</label>
                                            <div class="col-2">
                                                <input type="text" name="status" class="form-control" id="urgency">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <table class="table table-hover table-bordered table-colored table-custom table-striped" cellspacing="0" width="100%" id="list-ticket">
                                            <thead>
                                                <th>No Tiket</th>
                                                <th>Tanggal</th>
                                                <th>Project</th>
                                                <th>Fitur</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </thead>
                                        </table>
                                    </div>
                                    
                                </div><!-- end col -->
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end container -->
        </div><!-- end content -->

        <footer class="footer text-right">
                <span class="pull-right">
                    <img src="{{ asset('assets/images/logo_sm.png') }}" alt="" height="25" style="margin-top: -2px;">
                    SIMA Sistem Informasi Manajemen Alamraya
                </span>
        </footer>

    </div>

</div>

<!-- jQuery  -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Tether for Bootstrap -->
<script src="{{ asset('assets/js/tether.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/js/waves.js') }}"></script>
<script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>

<!-- plugin js -->
<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/clockpicker/js/bootstrap-clockpicker.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- Jquery contextmenu -->
<script src="{{ asset('assets/js/contextmenu.js') }}"></script>
<script src="{{ asset('assets/js/jquery.ui.position.min.js') }}"></script>
<!-- Toastr js -->
<script src="{{ asset('assets/plugins/jquery-toastr/jquery.toast.min.js') }}"></script>
<!-- Waitingfor -->
<script src="{{ asset('assets/plugins/waitingfor/waitingfor.js') }}"></script>
<!-- Autocomplete -->
<script src="{{ asset('assets/plugins/autocomplete/jquery.autocomplete.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>
<!-- Jquery filer js -->
<script src="{{ asset('assets/plugins/jquery.filer/js/jquery.filer.min.js') }}"></script>
<!-- Bootstrap fileupload js -->
<script src="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<!--Wysiwig js-->
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<!-- Datatables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.fixedColumns.min.js') }}"></script>

<script type="text/javascript">
    var tableticket;
    var dataTableLanguage = {
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": 'Pencarian',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "sZeroRecords:": "Tidak ditemukan",
        "infoEmpty": "",
        "paginate": {
            "previous": "Sebelumnya",
            "next": "Selanjutnya",
         }
    }
    $(document).ready(function() {
        $('#date-range').datepicker({
            toggleActive: true,
            autoclose: true,
            todayHighlight: true,
            format: "dd/mm/yyyy"
        });

        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            tableticket = $("#list-ticket").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ url('bantuan/ticket-anda/data') }}",
                    "type": "get"
                },
                columns: [
                    {data: 'pt_number', name: 'pt_number'},
                    {data: 'pt_asktime', name: 'pt_asktime'},
                    {data: 'p_name', name: 'p_name'},
                    {data: 'pf_detail', name: 'pf_detail'},
                    {data: 'pt_status', name: 'pt_status'},
                    {data: 'aksi', name: 'aksi'}
                ],
                responsive: true,
                "pageLength": 10,
                "aaSorting": [],
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "language": dataTableLanguage,
            });
        }, 500);

    });
</script>

</body>
</html>
