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
                        <h4 class="header-title m-b-15 m-t-0 pull-left">Daftar Project</h4>
                        <button type="button" onclick="addProject()"
                                class="btn btn-sm btn-custom pull-right w-md waves-effect waves-light"><i
                                class="fa fa-plus"></i> Progress
                        </button>
                        <div class="col-sm-12" style="margin-top: 50px;">

                            <table class="table table-hover table-bordered table-colored table-custom"
                                   cellspacing="0" width="100%" id="daftar-project">
                                <thead>
                                <th>Nama Project</th>
                                <th>Tanggal</th>
                                <th>Team</th>
                                <th>Fitur</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Tamma Food</td>
                                    <td class="text-center"> 17 Sep 2018</td>
                                    <td>
                                        Mahmud Efendi
                                    </td>
                                    <td>
                                        <span onclick="detail()" style="cursor: pointer;">Master Supplier <span
                                                class="badge badge-danger noti-icon-badge">H</span></span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan="3">Tamma Food</td>
                                    <td class="text-center"> 17 Sep 2018</td>
                                    <td>
                                        Mahmud Efendi
                                    </td>
                                    <td>
                                        <span onclick="detail()" style="cursor: pointer;">Master Supplier <span
                                                class="badge badge-danger noti-icon-badge">H</span></span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"> 17 Sep 2018</td>
                                    <td>
                                        Mahmud Efendi
                                    </td>
                                    <td>
                                        <span onclick="detail()" style="cursor: pointer;">Master Pegawai <span
                                                class="badge badge-danger noti-icon-badge">H</span></span><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"> 17 Sep 2018</td>
                                    <td>
                                        Mahmud Efendi
                                    </td>
                                    <td>
                                        <span onclick="detail()" style="cursor: pointer;">Pembelian Supplier <span
                                                class="badge badge-danger noti-icon-badge">H</span></span><br>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-project" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Pilih Project</h4>
                </div>
                <div class="modal-body">

                    <table class="table table-striped table-bordered table-hover table-colored table-custom">
                        <thead>
                        <th>Nama Project</th>
                        </thead>
                        <tbody>
                        <tr style="cursor: pointer;">
                            <td>Tamma Food</td>
                        </tr>
                        <tr style="cursor: pointer;">
                            <td>Perwita</td>
                        </tr>
                        <tr style="cursor: pointer;">
                            <td>JPM</td>
                        </tr>
                        <tr style="cursor: pointer;">
                            <td>Atonergi</td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

@endsection

@section('extra_scripts')
    <script type="text/javascript">
        function addProject() {
            $('#modal-project').modal('show');
        }

        function detail() {
            alert('asdf');
        }

        var tds = document.querySelectorAll("td, th");
        var groups = [];

        for (var i = 0; i < tds.length; i++) {
            if (tds[i].getAttribute('rowspan') != null) {
                var rspan = tds[i];
                groups.push({
                    parent: rspan.parentNode,
                    height: rspan.getAttribute('rowspan')
                });
            }
        }

        var count = 0;
        var rows = document.querySelectorAll('tr');
        var dark = true;

        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var index = groupIndex(row);
            if (index != null && dark) {
                var group = groups[index];
                var height = parseInt(group.height);
                for (var j = i; j < i + height; j++) {
                    rows[j].classList.add('dark');
                }
                i += height - 1;
                dark = !dark;
                continue;
            }
            if (dark) {
                rows[i].classList.add('dark');
            }
            dark = !dark;
        }

        function groupIndex(element) {
            for (var i = 0; i < groups.length; i++) {
                var group = groups[i].parent;
                if (group == element) {
                    return i;
                }
            }
            return null;
        }
    </script>
@endsection
