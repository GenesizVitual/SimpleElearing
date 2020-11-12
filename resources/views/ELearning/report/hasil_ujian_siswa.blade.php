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
            Halaman ini adalah halaman untuk menampilkan semua ujian yang telah diikut.
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Hasil Ujian</h3>

                            <div class="card-tools">
                                @if(!empty(Session::get('id_wali_murid')))
                                    <a href="{{ url('cetak-laporan-siswa') }}" class="btn btn-primary"><i class="fa fa-print"></i> Print </a>
                                @else
                                    <a href="{{ url('cetak-hasil-ujian-siswa') }}" class="btn btn-primary"><i class="fa fa-print"></i> Print </a>
                                @endif
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if(!empty($data_siswa))
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $data_siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>{{ $data_siswa->kelas }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelas</td>
                                    <td>:</td>
                                    <td>{{ $data_siswa->jenis_kelas }}</td>
                                </tr>
                            </table>
                            @endif
                            <table id="table-data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th rowspan="2">#</th>
                                    <th rowspan="2">Tanggal Ujian</th>
                                    <th rowspan="2">Nama</th>
                                    <th rowspan="2">Mata Pelajaran</th>
                                    <th rowspan="2">Kode</th>
                                    <th rowspan="2">Kelas</th>
                                    <th rowspan="2">Jenis kelas</th>
                                    <th colspan="3">Hasil</th>
                                </tr>
                                <tr>
                                    <th>Benar</th>
                                    <th>Salah</th>
                                    <th>Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($data_ujian))
                                    @php($no=1)
                                    @php($skore=0)
                                    @foreach($data_ujian as $key => $data_array)
                                        @foreach($data_array as $data)
                                            @php($skore+=$data['jawaban_score'])
                                            <tr>
                                            <tr>
                                                <th >{{ $no++ }}</th>
                                                <th>{{ $data['tgl_ujian'] }}</th>
                                                <th>{{ $data['nama'] }}</th>
                                                <th>{{ $data['mata_pejaharan'] }}</th>
                                                <th>{{ $data['kode'] }}</th>
                                                <th>{{ $data['kelas'] }}</th>
                                                <th>{{ $data['jenis_kelas'] }}</th>
                                                <td>{{ $data['jawaban_benar'] }}</td>
                                                <td>{{ $data['jawaban_salah'] }}</td>
                                                <td>{{ $data['jawaban_score'] }}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <th colspan="9">Total</th>
                                        <th>{{ $skore }}</th>
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