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
                        <h4 class="page-title float-left">Profile</h4>

                        <ol class="breadcrumb float-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="profile-bg-picture" style="background-image:url('{{ asset("assets/images/bg-profile.jpg") }}')">
                        <span class="picture-bg-overlay"></span><!-- overlay -->
                    </div>
                    <!-- meta -->
                    <div class="profile-user-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <span class="pull-left m-r-15"><img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="" class="thumb-lg rounded-circle"></span>
                                <div class="media-body">
                                    <h4 class="m-t-5 m-b-5 font-18 ellipsis">{{ Auth::guard('team')->user()->ct_name }}</h4>
                                    <p class="font-13"> Jabatan Anda</p>
                                    <p class="text-muted m-b-0"><small>Alamat Anda</small></p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-right">
                                    <button type="button" data-toggle="modal" data-target="#gantipassword" data-animation="fadein"   data-overlayspeed="200" data-overlaycolor="#36404a" class="btn btn-success waves-effect waves-light">
                                        <i class="mdi mdi-swap-horizontal m-r-5"></i> Ganti Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ meta -->
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <!-- Personal-Information -->
                    <div class="card-box">
                        <h4 class="header-title mt-0 m-b-20">Personal Information</h4>
                        <div class="panel-body">
                            <hr>
                            <div class="text-left">
                                <p class="text-muted font-13"><strong>Nama :</strong> <span class="m-l-15">{{ $data->ct_name }}</span></p>

                                <p class="text-muted font-13"><strong>Panggilan :</strong><span class="m-l-15">{{ $data->ct_panggilan }}</span></p>

                            </div>

                            <ul class="social-links list-inline m-t-20 m-b-0">
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a title="" data-placement="top" data-toggle="tooltip" class="tooltips" href="" data-original-title="Skype"><i class="fa fa-skype"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- Personal-Information -->

                </div>


                <div class="col-md-8">

                    <div class="card-box">
                        <h4 class="header-title mt-0 m-b-20">Experience</h4>
                        <div class="">
                            <div class="">
                                <h5 class="text-custom m-b-5">Lead designer / Developer</h5>
                                <p class="m-b-0">websitename.com</p>
                                <p><b>2010-2015</b></p>

                                <p class="text-muted font-13 m-b-0">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has
                                    been the industry's standard dummy text ever since the
                                    1500s, when an unknown printer took a galley of type and
                                    scrambled it to make a type specimen book.
                                </p>
                            </div>

                            <hr>

                            <div class="">
                                <h5 class="text-custom m-b-5">Senior Graphic Designer</h5>
                                <p class="m-b-0">coderthemes.com</p>
                                <p><b>2007-2009</b></p>

                                <p class="text-muted font-13">Lorem Ipsum is simply dummy text
                                    of the printing and typesetting industry. Lorem Ipsum has
                                    been the industry's standard dummy text ever since the
                                    1500s, when an unknown printer took a galley of type and
                                    scrambled it to make a type specimen book.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
        </div>
    </div>

    <div id="gantipassword" class="modal bs-example-modal-lg" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title edit-fitur" id="modal-title">Ganti Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <form class="form-horizontal form-ganti-password" role="form">
                            <div class="form-group row">
                                <label for="passwordlama" class="col-3 col-form-label">Password Lama</label>
                                <div class="col-9 input-group" id="passwordlama">
                                    <input type="password" class="form-control passwordlama" name="passwordlama" placeholder="Masukkan Password Lama">
                                    <div class="input-group-addon" onclick="showPassword('passwordlama')" style="cursor: pointer;">
                                        <span><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordbaru" class="col-3 col-form-label">Password Baru</label>
                                <div class="col-9 input-group" id="passwordbaru">
                                    <input type="password" class="form-control passwordbaru" onkeyup="verifikasi()"  name="passwordbaru" placeholder="Masukkan Password Baru">
                                    <div class="input-group-addon" onclick="showPassword('passwordbaru')" style="cursor: pointer;">
                                        <span><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passwordbaru2" class="col-3 col-form-label">Verifikasi Password Baru</label>
                                <div class="col-9 input-group" id="passwordbaru2">
                                    <input type="password" class="form-control passwordbaru2" name="passwordbaru2" id="passwordbaru2" onkeyup="verifikasi()" placeholder="Verifikasi Password Baru">
                                    <div class="input-group-addon" onclick="showPassword('passwordbaru2')" style="cursor: pointer;">
                                        <span><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" onclick="update()">Simpan Perubahan</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


@endsection

@section('extra_scripts')
    <script type="text/javascript">
        function verifikasi() {
            var pass1 = $('.passwordbaru').val();
            var pass2 = $('.passwordbaru2').val();
            if (pass2 == pass1 && pass2 != '') {
                $('#passwordbaru2').removeClass('has-danger');
                $('#passwordbaru2').addClass('has-success');
                $('.passwordbaru2').removeClass('form-control-danger');
                $('.passwordbaru2').addClass('form-control-success');
            } else {
                $('#passwordbaru2').removeClass('has-success');
                $('#passwordbaru2').addClass('has-danger');
                $('.passwordbaru2').removeClass('form-control-success');
                $('.passwordbaru2').addClass('form-control-danger');
            }
        }

        function showPassword(id){
            if($('#'+id+' input').attr("type") == "text"){
                $('#'+id+' input').attr('type', 'password');
                $('#'+id+' i').addClass( "fa-eye-slash" );
                $('#'+id+' i').removeClass( "fa-eye" );
            }else if($('#'+id+' input').attr("type") == "password"){
                $('#'+id+' input').attr('type', 'text');
                $('#'+id+' i').removeClass( "fa-eye-slash" );
                $('#'+id+' i').addClass( "fa-eye" );
            }
        }

        function update(){
            waitingDialog.show();
            var pass1 = $('.passwordbaru').val();
            var pass2 = $('.passwordbaru2').val();
            if (pass1 != pass2) {
                $.toast({
                    heading: 'Perhatian',
                    text: 'Password baru tidak sesuai!.',
                    position: 'top-right',
                    loaderBg: '#da8609',
                    icon: 'warning',
                    hideAfter: 3000,
                    stack: 1
                });
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/pengaturan/profile/update-password',
                type: 'get',
                data: $('.form-ganti-password').serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status == 'sukses') {
                        $.toast({
                            heading: 'Sukses!',
                            text: 'Password diubah.',
                            position: 'top-right',
                            loaderBg: '#5ba035',
                            icon: 'success',
                            hideAfter: 3000,
                            stack: 1
                        });
                        $('#gantipassword').modal('hide');
                        $('.passwordbaru').val('');
                        $('.passwordbaru2').val('');
                        $('.passwordlama').val('');
                        $('#passwordbaru2').removeClass('has-success');
                        $('.passwordbaru2').removeClass('form-control-success');
                        $('#passwordbaru2').removeClass('has-danger');
                        $('.passwordbaru2').removeClass('form-control-danger');
                    } else if (response.status == 'gagal') {
                        if (response.data == 'match') {
                            $.toast({
                                heading: 'Gagal!',
                                text: 'Password lama tidak sama!!.',
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 1
                            });
                            $('.passwordlama').focus();
                        } else if (response.data == 'pass') {
                            $.toast({
                                heading: 'Gagal!',
                                text: 'verifikasi password baru tidak sesuai.',
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 1
                            });
                            $('.passwordbaru2').focus();
                        } else if (response.data == 'user') {
                            $.toast({
                                heading: 'Gagal!',
                                text: 'User tidak ditemukan, Coba login sekali lagi.',
                                position: 'top-right',
                                loaderBg: '#bf441d',
                                icon: 'error',
                                hideAfter: 3000,
                                stack: 1
                            });
                            $('.passwordbaru2').focus();
                        }
                    }
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
                },
                error: function (xhr, status) {
                    setTimeout(function () {
                        waitingDialog.hide();
                    }, 500);
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