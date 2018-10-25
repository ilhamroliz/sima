<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SIMA | Ticket</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
        <meta content="Coderthemes" name="author">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- Select2 -->
        <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Bootstrap fileupload css -->
        <link href="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
        <!-- Toastr css -->
        <link href="{{ asset('assets/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />
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
                        <span style="color: #fff"><strong>{{ \GeniusTS\HijriDate\Hijri::convertToHijri(Carbon\Carbon::now('Asia/Jakarta'))->format('l d F o') }}</strong></span>
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
                                    <div class="col-sm-12">
                                        <div class="text-center">
                                            <h3 class="font-600" style="text-align: left;">Buka Tiket</h3>
                                            <p class="text-muted" style="text-align: left;"> Fitur ini disediakan oleh Alamraya untuk menampung semua pertanyaan klien kami</p>
                                        </div>
                                        <form class="form-horizontal" role="form" method="post" action="{{ url('bantuan/submit') }}" id="form-tiket" enctype="multipart/form-data" accept-charset="UTF-8">
                                            <div class="form-group row">
                                                <label class="col-1 col-form-label" for="projectcode">Project</label>
                                                <div class="col-5">
                                                    <select class="form-control select2" id="projectcode" onchange="getFitur()">
                                                        <option value="" disabled selected>Pilih Project</option>
                                                        @foreach($project as $list)
                                                        <option value="{{ $list->p_code }}">{{ $list->p_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <label class="col-1 col-form-label" for="fitur">Fitur</label>
                                                <div class="col-5 fitur-select">
                                                    <select class="form-control select2" id="fitur" readonly='true'>
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-1 col-form-label" for="error">Error</label>
                                                <div class="col-5">
                                                    <select class="form-control select2" id="error">
                                                        <option value="" disabled selected>Pilih Jenis Error</option>
                                                        <option value="SERVER">SERVER</option>
                                                        <option value="MISSUNDERSTANDING">MISSUNDERSTANDING</option>
                                                        <option value="DEVELOP">DEVELOP</option>
                                                        <option value="KURANG LENGKAP">KURANG LENGKAP</option>
                                                        <option value="NOT YET">NOT YET</option>
                                                    </select>
                                                </div>
                                                <label class="col-1 col-form-label" for="prioritas">Prioritas</label>
                                                <div class="col-5">
                                                    <select class="form-control select2" id="prioritas">
                                                        <option value="" disabled selected>Pilih Jenis Prioritas</option>
                                                        <option value="NORMAL">NORMAL</option>
                                                        <option value="MEDIUM">MEDIUM</option>
                                                        <option value="UREGENT">UREGENT</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="pesan">Pesan</label>
                                                <textarea id="pesan" name="area"></textarea>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-1 col-form-label">Foto</label>
                                                <div class="col-11">
                                                    <div class="fileupload fileupload-new" data-provides="fileupload">

                                                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                                                        <div>
                                                            <button type="button" class="btn btn-secondary btn-file">
                                                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Pilih Foto</span>
                                                                <span class="fileupload-exists"><i class="fa fa-undo"></i> Ganti</span>
                                                                <input type="file" class="btn-secondary" />
                                                            </button>
                                                            <a href="#" class="btn btn-danger fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash"></i> Hapus</a>
                                                        </div>
                                                    </div>
                                                    <div class="alert alert-info alert-white"><strong>Perhatian!</strong> Foto akan tampil jika anda menggunakan browser IE10+, FF3.6+, Chrome6.0+ dan Opera11.1+.</div>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <button onclick="validasi()" type="button" class="btn btn-primary waves-effect w-md waves-light">Simpan</button>
                                            </div>

                                        </form>
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


        <script type="text/javascript">
            $(document).ready(function() {
                $('#projectcode').select2();
                $('#prioritas').select2();
                $('#error').select2();

                if($("#pesan").length > 0){
                    tinymce.init({
                        selector: "textarea#pesan",
                        theme: "modern",
                        height:300,
                        menubar: false,
                        content_css : "{{ asset('assets/plugins/tinymce/custom_css.css') }}",
                        toolbar: "bold italic | fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | forecolor backcolor emoticons",
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });
                }
            });

            function getFitur(){
                var projectcode = $('#projectcode').val();
                $.ajax({
                    url: '{{ url('bantuan/getFitur') }}',
                    type: 'get',
                    data: {project: projectcode},
                    success: function (response) {
                        if ($('#fitur').hasClass("select2-hidden-accessible")) {
                            $('#fitur').select2('destroy');
                            $('.fitur-select').empty();
                            $('.fitur-select').append('<select class="form-control select2" id="fitur" readonly="true"></select>');
                            $('#fitur').select2({
                                data: response.data
                            });
                        } else {
                            $('#fitur').select2({
                                data: response.data
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

            function validasi(){
                if ($('#projectcode').val() == null) {
                    $.toast({
                            heading: 'Peringatan!',
                            text: 'Project tidak boleh kosong.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 1
                        });
                    $('#projectcode').select2('open');
                    return false;
                }
                if ($('#fitur').val() == null) {
                    $.toast({
                            heading: 'Peringatan!',
                            text: 'Fitur tidak boleh kosong.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 1
                        });
                    $('#fitur').select2('open');
                    return false;
                }
                if ($('#error').val() == null) {
                    $.toast({
                            heading: 'Peringatan!',
                            text: 'Jenis error tidak boleh kosong.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 1
                        });
                    $('#error').select2('open');
                    return false;
                }
                if ($('#prioritas').val() == null) {
                    $.toast({
                            heading: 'Peringatan!',
                            text: 'Jenis prioritas tidak boleh kosong.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 1
                        });
                    $('#prioritas').select2('open');
                    return false;
                }
                if (tinymce.get("pesan").getContent() == null || tinymce.get("pesan").getContent() == '<p></p>' || tinymce.get("pesan").getContent() == '') {
                    $.toast({
                            heading: 'Peringatan!',
                            text: 'Tulis pesan untuk disampaikan.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'warning',
                            hideAfter: 3000,
                            stack: 1
                        });
                    return false;
                }

            }

        </script>

    </body>
</html>