@extends('main')
@section('title', 'Dashboard')
@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title float-left">Dashboard</h4>

                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ol>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Project Progress</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-progress" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Fitur</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Daftar Project</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-list" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Supervisor</th>
                                    <th>Deadline</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title m-t-0 m-b-30">Catatan</h4>

                    <div>
                        <table class="table table-hover table-bordered table-colored table-custom table-striped dataTable no-footer dtr-inline" cellspacing="0" width="100%" id="project-note" role="grid" aria-describedby="project-progress_info" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Project</th>
                                    <th>Dari</th>
                                    <th>Preview</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->


    </div> <!-- container -->
</div> <!-- content -->
@endsection

@section('extra_scripts')
<script type="text/javascript">
    var projectprogress;
    var projectlist;
    var projectnote;
    var start = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
    var end = '{{ Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y') }}';
    $(document).ready(function(){
        setTimeout(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            projectprogress = $("#project-progress").DataTable({
                "search": {
                    "caseInsensitive": true
                },
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": baseUrl + '/manajemen-project/project-progress/getProjectProgress',
                    "type": "post",
                    "data": {awal: start, akhir: end, project: 'all'}
                },
                columns: [
                    {data: 'p_name', name: 'p_name'},
                    {data: 'pf_detail', name: 'pf_detail'},
                    {data: 'aksi', name: 'aksi'}
                ],
                responsive: true,
                scrollY:'50vh',
                scrollCollapse: true,
                paging:false,
                searching: false,
                "pageLength": 10,
                "aaSorting": [],
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
                "language": dataTableLanguage,
            });
        }, 500);
    });
</script>
@endsection
