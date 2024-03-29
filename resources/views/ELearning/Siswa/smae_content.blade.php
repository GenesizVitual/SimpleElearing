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
                <h1 class="m-0 text-dark">Cek Siswa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Cek Siswa</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman Ini akan menampilkan data yang tidak terimport karena kode siswa sudah ada.
        <div class="row">
            @if(Session::get('level') != 0)
                <div class="col-md-12" style="padding-bottom: 10px">
                    <button type="button" class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#modal-default"> Import Data Guru </button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Guru</h3>
                        @if(Session::get('level') != 0)
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-target="#modal-default-proses" data-toggle="modal" data-backdrop="static" data-keyboard="false" ><i class="fas fa-plus"></i>
                            </button>
                        </div>
                        @endif
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-data" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Guru</th>
                                <th>Password</th>
                                @if(Session::get('level') != 0)
                                <th>Aksi</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @php($no=1)
                            @foreach($data as $data_guru)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data_guru->kode }}</td>
                                    <td>{{ $data_guru->nama }}</td>
                                    <td>Password Anda terenkripsi</td>
                                    @if(Session::get('level') != 0)
                                    <td>
                                        <form action="{{ url('guru/'.$data_guru->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-info btn-warning" onclick="edit('{{ $data_guru->id }}')"><i class="fa fa-pen"></i></a>
                                                <button type="submit" class="btn btn-info btn-danger" onclick="return confirm('Apakah anda ingin menghapus data guru ini {{ $data_guru->nama }} ..?')"><i class="fa fa-eraser"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Import Guru</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('import-guru') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputFile">Import Data Guru</label>
                                <div class="custom-file">
                                    <input type="file" class="form-control" name="file" id="customFile" required>
                                    <span>*format excel guru dapat didownload <a href="{{ asset('file/format_excel_guru.xlsx') }}">disini</a></span>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small>Format file yang didukung adalah *xlsx dan ukuran besar file 1.5 MB</small>
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
                    <h4 class="modal-title">Panel Guru</h4>
                    <button type="button" class="close" onclick="$('#form').attr('action','{{ url('guru') }}')" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('guru') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
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
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small>Isilah data guru dengan sebenar-benarnya</small>
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