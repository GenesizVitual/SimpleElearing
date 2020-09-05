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
                <h1 class="m-0 text-dark">Siswa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Siswa</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman Ini akan menampilkan data siswa yang telah digrup berdasarkan kelas dan jenis kelas.
        <div class="row">
            <div class="col-md-12" style="padding-bottom: 10px">
                <button  class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#modal-default"> Import Data Siswa </button>
            </div>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                        @foreach($data->sortByDesc('angkatan')->groupBy('angkatan') as $angkatan=>$data_angkatan)
                                <div class="col-md-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Angkatan tahun : {{ $angkatan }}</h3>

                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                            <!-- /.card-tools -->
                                        </div>
                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <div class="row">
                                                @foreach($data_angkatan->groupBy('kelas') as $kelas=>  $data_kelas)
                                                    <ul>
                                                        <li>
                                                            Kelas :{{ $kelas }}
                                                            <ul>
                                                                @foreach($data_kelas->groupBy('jenis_kelas') as $jenis_kelas => $data_jenis_kelas)
                                                                    <li>{{ $jenis_kelas }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                        <!-- /.card -->
                        @endforeach
                        </div>
                        <div class="col-md-9">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Tabel Siswa</h3>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="table-data" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Angkatan</th>
                                            <th>Kode</th>
                                            <th>Password</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jenis Kelas</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($no=1)
                                        @foreach($data as $data_siswa)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $data_siswa->angkatan }}</td>
                                                <td>{{ $data_siswa->kode }}</td>
                                                <td>{{ $data_siswa->see_password }}</td>
                                                <td>{{ $data_siswa->nama }}</td>
                                                <td>{{ $data_siswa->kelas }}</td>
                                                <td>{{ $data_siswa->jenis_kelas }}</td>
                                                <td>
                                                    <form action="{{ url('siswa/'.$data_siswa->id) }}" method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="_method" value="delete">
                                                        <div class="btn-group">
                                                            <a href="#" class="btn btn-info btn-warning" onclick="edit('{{ $data_siswa->id }}')"><i class="fa fa-pen"></i></a>
                                                            <button type="submit" class="btn btn-info btn-danger" onclick="return confirm('Apakah anda ingin menghapus data siswa ini ..?')"><i class="fa fa-eraser"></i></button>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>


        </div>
    </div><!-- /.container-fluid -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Import Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('import-siswa') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputFile">Import Data Siswa</label>
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="file" id="customFile" required>
                                    <span>*format excel siswa dapat didownload <a href="{{ asset('file/format_excel_siswa.xlsx') }}">disini</a></span>

                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small>Format file yang didukung adalah *xlc atau *csv. besar file 1.5 MB</small>
                        <button type="submit" class="btn btn-success float-right">Proses</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-default-proses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Siswa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('siswa') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <div class="form-group">
                            <label for="exampleInputFile">Angkatan</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="angkatan" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Kode</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="kode" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Password</label>
                            <div class="custom-file">
                                <input type="password" class="form-control" name="password" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Nama</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="nama" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Kelas</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="kelas" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Jenis Kelas</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="jenis_kelas" id="customFile" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small>Isilah data siswa dengan sebenar-benarnya</small>
                        <button type="submit" class="btn btn-success float-right">Proses</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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

            edit = function (id) {
                $.ajax({
                    url:  '{{ url('siswa') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                        console.log(result);
                        $('[name="angkatan"]').val(result.angkatan);
                        $('[name="kode"]').val(result.kode);
                        $('[name="password"]').val(result.password);
                        $('[name="nama"]').val(result.nama);
                        $('[name="kelas"]').val(result.kelas);
                        $('[name="jenis_kelas"]').val(result.jenis_kelas);
                        $('[name="_method"]').val("put");
                        $('#form').attr('action','{{ url('siswa') }}/'+id);
                        $('#modal-default-proses').modal('show');
                    }
                });
            }
        });
    </script>
@stop