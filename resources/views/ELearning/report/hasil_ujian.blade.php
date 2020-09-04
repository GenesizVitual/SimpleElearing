@extends('ELearning.base')

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
                    <h1 class="m-0 text-dark">Hasil Ujian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Hasil Ujian</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            Halaman ini adalah halaman untuk menampilkan semua siswa yang masuk ujian.
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Hasil Ujian</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick=" $('#modal-default-proses').modal('show');" ><i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="table-data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Kelas</th>
                                    <th rowspan="2">Jenis kelas</th>
                                    <th >Hasil</th>
                                </tr>
                                <tr>
                                    <th>Benar</th>
                                    <th>Salah</th>
                                    <th>Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($no=1)
                                @if(!empty($data_ujian))
                                    @foreach($data_ujian as $data)
                                        <tr>
                                            <th >{{ $data['no'] }}</th>
                                            <th>{{ $data['nama'] }}</th>
                                            <th>{{ $data['kode'] }}</th>
                                            <th>{{ $data['kelas'] }}</th>
                                            <th>{{ $data['jenis_kelas'] }}</th>
                                            <td>{{ $data['hasil']['jawaban_benar'] }}</td>
                                            <td>{{ $data['hasil']['jawaban_salah'] }}</td>
                                            <td>{{ $data['hasil']['jawaban_score'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>


            </div>
        </div><!-- /.container-fluid -->


        </div>
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


        });
    </script>
@stop