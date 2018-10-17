<meta charset="utf-8">
<title>SIMA | @yield('title')</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description">
<meta content="Coderthemes" name="author">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!--Footable-->
<link href="{{ asset('assets/plugins/footable/css/footable.core.css') }}" rel="stylesheet">
<!-- App favicon -->
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
<!-- Spinkit css -->
<link href="{{ asset('assets/plugins/spinkit/spinkit.css') }}" rel="stylesheet" />
<!-- C3 charts css -->
<link href="{{ asset('assets/plugins/c3/c3.min.css') }}" rel="stylesheet" type="text/css"/>
<!-- Jquery filer css -->
<link href="{{ asset('assets/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" rel="stylesheet" />
<!-- Bootstrap fileupload css -->
<link href="{{ asset('assets/plugins/bootstrap-fileupload/bootstrap-fileupload.css') }}" rel="stylesheet" />
<!-- Toastr css -->
<link href="{{ asset('assets/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />
<!-- Time Picker -->
<link href="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet">
<!-- Color Picker -->
<link href="{{ asset('assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}" rel="stylesheet">
<!-- Date Picker -->
<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<!-- Clock Picker -->
<link href="{{ asset('assets/plugins/clockpicker/css/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
<!-- Date Range Picker -->
<link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet">
<!-- Contextmenu -->
<link href="{{ asset('assets/css/jquery.contextMenu.css') }}" rel="stylesheet" type="text/css">
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
    @media (min-width: 768px) {
	  .modal-xl {
	    width: 90%;
	   max-width:1200px;
	  }
	}
</style>

<script type="text/javascript">
	var baseUrl = "{{ url('/') }}";
</script>
<style type="text/css">
	.topbar{
		height: 50px;
	}
</style>
