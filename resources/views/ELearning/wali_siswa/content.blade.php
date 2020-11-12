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
                <h1 class="m-0 text-dark">Wali Siswa</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Wali Murid</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman Ini akan menampilkan semua data wali siswa.
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Wali Siswa</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-target="#modal-default-proses" data-toggle="modal" data-backdrop="static" data-keyboard="false" ><i class="fas fa-plus"></i>
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
                                <th>Nama Wali</th>
                                <th>Password</th>
                                <th>Siswa</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($data))
                                @php($no=1)
                                @foreach($data as $data_wali)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data_wali->nama_pengguna }}</td>
                                        <td>Password anda terenkripsi</td>
                                        <td>{{ $data_wali->linkToSiswa->nama }}</td>
                                        <td>
                                            <form action="{{ url('wali-siswa/'.$data_wali->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete">
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-info btn-warning" onclick="edit('{{ $data_wali->id }}')"><i class="fa fa-pen"></i></a>
                                                    <button type="submit" class="btn btn-info btn-danger" onclick="return confirm('Apakah anda ingin menghapus data authority ini {{ $data_wali->nama_pengguna }} ..?')"><i class="fa fa-eraser"></i></button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
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
                    <h4 class="modal-title">Panel Wali Siswa</h4>
                </div>
                <form action="{{ url('wali-siswa') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <div class="form-group">
                            <label for="exampleInputFile">Nama Wali</label>
                            <div class="custom-file">
                                <input type="text" class="form-control" name="nama_pengguna" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Password</label>
                            <div class="custom-file">
                                <input type="password" class="form-control" name="password" id="customFile" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Siswa</label>
                            <div class="custom-file">
                                <select class="form-control select2" name="id_siswa" required>
                                    @foreach($siswa as $key=> $data)
                                        <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="batal" class="btn btn-danger float-left">Batal</button>
                        {{--<small>Isilah data authority sesuai dengan tanggung jawabnya</small>--}}
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
            $('.select2').select2()

            edit = function (id) {
                $.ajax({
                    url:  '{{ url('wali-siswa') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                        $('[name="nama_pengguna"]').val(result.nama_pengguna);
                        $('[name="password"]').val(result.password);
                        $('[name="id_siswa"]').val(result.id_siswa).trigger('change');
                        $('[name="_method"]').val("put");
                        $('#form').attr('action','{{ url('wali-siswa') }}/'+id);
                        $('#modal-default-proses').modal({
                            backdrop:'static',
                            keyboard:false,
                        });
                    }
                });
            }

            $('#batal').click(function () {
                $('#form').attr('action','{{ url('wali-siswa') }}');
                $('#modal-default-proses').modal('hide');
            });

        });
    </script>
@stop