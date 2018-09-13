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
                    <h4 class="page-title float-left">Tambah Project</h4>

                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Manajemen Project</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('manajemen-project/daftar-project') }}">Daftar Project</a></li>
                        <li class="breadcrumb-item active">Tambah Project</li>
                    </ol>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
		
		<div class="row">
			<div class="col-12">
				<div class="card-box">
                    <h4 class="m-t-0 m-b-30 header-title">Form Tambah Project</h4>

                    <form class="form-horizontal form-add" role="form">
                        <div class="form-group row">
                            <label for="namaproject" class="col-2 col-form-label">Nama Project</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="namaproject" placeholder="Nama Project" name="namaproject">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="client" class="col-2 col-form-label">Perusahaan</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="client" placeholder="Perusahaan" name="client">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mulai" class="col-2 col-form-label">Mulai</label>
                            <div class="col-3">
                                <input type="text" class="form-control" id="mulai" name="mulai">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="akhir" class="col-2 col-form-label">Akhir</label>
                            <div class="col-3">
                                <input type="text" class="form-control" id="akhir" name="akhir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="note" class="col-2 col-form-label">Keterangan</label>
                            <div class="col-10">
                                <input type="text" class="form-control" id="note" placeholder="Keterangan" name="note">
                            </div>
                        </div>

                        <div class="form-group row konten-fitur">
                            <label for="fitur" class="col-2 col-form-label">Fitur</label>
                            <div class="col-10">
                                <div class="card-box">
                                	<div class="form-group row">
                                		<label class="col-2 col-form-label">Nama Fitur</label>
                                		<div class="col-10">
                                			<input type="text" class="form-control nama-fitur" placeholder="Nama Fitur" name="namafitur[]">
                                		</div>
                                	</div>
                                	<div class="form-group row">
                                		<label class="col-2 col-form-label">Keterangan</label>
                                		<div class="col-10">
                                			<input type="text" class="form-control note-fitur" placeholder="Keterangan Fitur" name="notefitur[]">
                                		</div>
                                	</div>
                                	<div class="form-group row">
                                        <div class="col-12 padding-left-0 padding-right-0">
                                            <input type="file" name="image-fitur[]" class="filer_input0" multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-10 offset-2" style="margin-top: -30px;">
                            <div class="form-group row offset-10">
                                <div class="col-12">
                                    <button type="button" onclick="tambah()" style="float: right;" class="btn btn-pink waves-effect waves-light btn-xs pull-right" style="float: right;"><i class="mdi mdi-plus"></i> Tambah Fitur</button>
                                </div>
                            </div>
                        </div>

                        <div class="offset-2 col-9">
                            <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>	
</div>

@endsection
@section('extra_scripts')
<script type="text/javascript">
    var hitung = 0;
	$(document).ready(function(){
		$('#mulai').datepicker({
	        autoclose: true,
	        format: "dd/mm/yyyy",
	        todayHighlight: true
	    });
	    $('#akhir').datepicker({
	        autoclose: true,
	        format: "dd/mm/yyyy",
	        todayHighlight: true
	    });
	    //Example 2
	    $('.filer_input0').filer({
	        limit: 3,
	        maxSize: 3,
	        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
	        changeInput: true,
	        showThumbs: true,
	        addMore: true
	    });
	});

    function tambah(){
        hitung = hitung + 1;
        var halaman = '<div class="col-10 offset-2 halaman'+hitung+'"><div class="card-box"><div class="form-group row"><label class="col-2 col-form-label">Nama Fitur</label><div class="col-10"><input type="text" class="form-control nama-fitur" placeholder="Nama Fitur" name="namafitur[]"></div></div><div class="form-group row"><label class="col-2 col-form-label">Keterangan</label><div class="col-10"><input type="text" class="form-control note-fitur" placeholder="Keterangan Fitur" name="notefitur[]"></div></div><div class="form-group row"><div class="col-12 padding-left-0 padding-right-0"><input type="file" name="image-fitur[]" class="filer_input'+hitung+'" multiple="multiple"></div></div></div></div>';
        $('.konten-fitur').append(halaman);
        $('.filer_input'+hitung).filer({
            limit: 3,
            maxSize: 3,
            extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd'],
            changeInput: true,
            showThumbs: true,
            addMore: true
        });
    }
</script>
@endsection