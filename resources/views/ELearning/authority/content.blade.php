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
                <h1 class="m-0 text-dark">Authority</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Authority</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman Ini akan menampilkan semua data authority(hak akses ke dalam sistem).
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Authority</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-target="#modal-default-proses" data-toggle="modal" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="table-data" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pengguna</th>
                                <th>Password</th>
                                <th>Level</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($no=1)
                            @foreach($data as $data_authority)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data_authority->username }}</td>
                                    <td>Password anda terenkripsi</td>
                                    <td>{{ $authority[$data_authority->authority] }}</td>
                                    <td>
                                        <form action="{{ url('authority/'.$data_authority->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-info btn-warning" onclick="edit('{{ $data_authority->id }}')"><i class="fa fa-pen"></i></a>
                                                <button type="submit" class="btn btn-info btn-danger" onclick="return confirm('Apakah anda ingin menghapus data authority ini {{ $data_authority->nama }} ..?')"><i class="fa fa-eraser"></i></button>
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

            </div>
        </div>
    </div><!-- /.container-fluid -->

    <div class="modal fade" id="modal-default-proses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Authority</h4>
                </div>
                <form action="{{ url('authority') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <div class="form-group">
                            <label for="exampleInputFile">Nama Pengguna</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="username" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Password</label>
                            <div class="custom-file">
                                <input type="password" class="form-control" name="password" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Authority</label>
                            <div class="custom-file">
                                <select class="form-control" name="authority" required>
                                    @foreach($authority as $key=> $data)
                                        <option value="{{ $key }}">{{ $data }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="batal" class="btn btn-danger float-left">Batal</button>
                        <small>Isilah data authority sesuai dengan tanggung jawabnya</small>
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
                    url:  '{{ url('authority') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                        $('[name="username"]').val(result.username);
                        $('[name="password"]').val(result.password);
                        $('[name="authority"]').val(result.authority);
                        $('[name="_method"]').val("put");
                        $('#form').attr('action','{{ url('authority') }}/'+id);
                        $('#modal-default-proses').modal({
                            backdrop:'static',
                            keyboard:false,
                        });
                    }
                });
            }

            $('#batal').click(function () {
                $('#form').attr('action','{{ url('authority') }}/');
                $('#modal-default-proses').modal('hide');
            });

        });
    </script>
@stop