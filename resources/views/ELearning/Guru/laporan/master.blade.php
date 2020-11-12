@extends('Elearning.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Laporan Guru</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Laporan Guru</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-success">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="{{ url('grafik-hasil-ujian') }}" method="post">
                            {{ csrf_field() }}
                            <p><input type="radio" name="semester" value="1" required> Semester 1 <input type="radio" name="semester" value="2" required> Semester 2</p>
                            <button type="submit" class="btn btn-primary" style="width: 100%"><i class="fa fa-chart-bar"></i> Grafik Perbandingan Hasil Ujian</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-success">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Hasil Ujian Akan ditampilkan permata pelajaran dan persemester</p>
                        <a href="{{ url('grafik-perbandingan-hasil-ujian') }}" class="btn btn-primary" style="width: 100%"><i class="fa fa-chart-bar"></i> Perbandingan Hasil Ujian Permata Pelajaran</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Perkembangan Nilai Rerata Kelas</p>
                        <a href="{{ url('grafik-perkembangan-nilai-rerata-kelas') }}" class="btn btn-primary" style="width: 100%"><i class="fa fa-chart-bar"></i> Grafik Perkembangan Nilai Rerata Kelas</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-success">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Nilai Rerata kelas semester</p>
                        <a href="{{ url('nilai-terata-kelas-semester') }}" class="btn btn-primary" style="width: 100%"><i class="fa fa-table"></i> Tabel nilai rerata kelas semester</a>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->


    <!-- /.modal -->
</div>
<!-- /.content -->

@stop

@section('jsContainer')
    <script src="{{ asset('admin_asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(function () {
            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            edit = function (id) {
                $.ajax({
                    url:  '{{ url('guru') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                       $('[name="kode"]').val(result.kode);
                        $('[name="password"]').val(result.password);
                        $('[name="nama"]').val(result.nama);
                        $('[name="_method"]').val("put");
                        $('#form').attr('action','{{ url('guru') }}/'+id);
                        $('#modal-default-proses').modal({backdrop: 'static', keyboard: false});
                    }
                });
            }

        });
    </script>
@stop