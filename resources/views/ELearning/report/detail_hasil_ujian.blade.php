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
                    <h1 class="m-0 text-dark">Detail Hasil Ujian </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Detail Hasil Ujian</li>
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
                            <h3 class="card-title">Tabel Hasil Jawaban Siswa</h3>

                            <div class="card-tools">
                                <a href="{{ url('cetak-detail-hasil-ujian/'.$id_soal_ujian) }}" class="btn btn-primary"><i class="fa fa-print"></i> Print </a>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table style="width: 100%">
                                <tr>
                                    <th style="width: 50px">Nama</th>
                                    <th style="width: 10px">:</th>
                                    <th>{{ $siswa->nama }}</th>
                                </tr>
                                <tr>
                                    <th style="width: 100px">Jenis Kelas</th>
                                    <th style="width: 10px">:</th>
                                    <th>{{ $siswa->jenis_kelas }}</th>
                                </tr>
                                <tr>
                                    <th style="width: 50px">Kelas</th>
                                    <th style="width: 10px">:</th>
                                    <th>{{ $siswa->kelas }}</th>
                                </tr>
                                <tr>
                                    <th style="width: 50px">Tema Soal</th>
                                    <th style="width: 10px">:</th>
                                    <th>{{ $tema_soal->judul_soal }}</th>
                                </tr>
                            </table>
                            <table id="table-data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Kode Soal</th>
                                    <th rowspan="2">Kunci Jawaban</th>
                                    <th rowspan="2">Skor</th>
                                    <th rowspan="2">Jawaban Siswa</th>
                                    <th colspan="3">Sub Skor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($no=1)
                                @if(!empty($data_jawaban))
                                    @foreach($data_jawaban as $data)
                                        <tr>
                                            <th >{{ $data['no'] }}</th>
                                            <th>{{ $data['kode_soal'] }}</th>
                                            <th>{{ $data['kunci_jawaban'] }}</th>
                                            <th>{{ $data['skor'] }}</th>
                                            <th>{{ $data['jawaban_siswa'] }}</th>
                                            <th>{{ $data['sub_skor'] }}</th>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <th colspan="5">Total Skor</th>
                                            <th>{{ $total_skor }}</th>
                                        </tr>
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });


        });
    </script>
@stop