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
                                    <button type="button" data-toggle="modal" data-target="#gantipassword" data-animation="fadein"  data-plugin="custommodal" data-overlayspeed="200" data-overlaycolor="#36404a" onclick="gantiPassword()" class="btn btn-success waves-effect waves-light">
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
                    <h4 class="modal-title edit-fitur" id="modal-title">Catatan Fitur</h4>
                </div>
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="messaging">
                            <div class="inbox_msg">
                                <div class="mesgs" style="width: 100%">
                                    <input type="hidden" name="id_pp" id="id_pp">
                                    <input type="hidden" name="id_project" id="id_project">
                                    <div class="msg_history" id="konten-chat" style="width: 100%">
                                        
                                    </div>
                                    <div class="type_msg">
                                        <div class="input_msg_write">
                                            <input type="text" id="write_msg" class="write_msg" placeholder="Type a message"/>
                                            <button class="msg_send_btn" id="msg_send_btn" type="button" onclick="writeNote()"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


@endsection

@section('extra_scripts')
    <script type="text/javascript">
        function gantiPassword () {
            
        }
    </script>
@endsection