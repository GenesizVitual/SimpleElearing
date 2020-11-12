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
                <h1 class="m-0 text-dark">Tahun Angkatan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Tahun Angkatan</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman ini akan menampilkan daftar tahun angkatan yang aktif atau tidak.
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Tahun Angkatan</h3>

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
                                <th>Tahun Angkatan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($no=1)
                            @foreach($data as $data_tahun)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data_tahun->thn_lalu }}/{{ $data_tahun->thn_depan }}</td>
                                    <td>
                                        @if($data_tahun->status == 1)
                                            {{ 'Aktif' }}
                                        @else
                                            {{ 'Tidak Aktif' }}
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ url('tahun-angkatan/'.$data_tahun->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="delete">
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-info btn-warning" onclick="edit('{{ $data_tahun->id }}')"><i class="fa fa-pen"></i></a>
                                                <button type="submit" class="btn btn-info btn-danger" onclick="return confirm('Apakah anda ingin menghapus tahun angkatan ini..?')"><i class="fa fa-eraser"></i></button>
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
                    <h4 class="modal-title">Panel Tahun Angkatan</h4>
                </div>
                <form action="{{ url('tahun-angkatan') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <div class="form-group">
                            <label for="exampleInputFile">Tahun lalu</label>
                            <div class="custom-file">
                                <input type="year" class="form-control" name="thn_lalu" id="customFile" value="{{ $thn_lalu }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Tahun depan</label>
                            <div class="custom-file">
                                <input type="year" class="form-control" name="thn_depan" id="customFile" value="{{ $thn_depan }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Status</label>
                            <div class="custom-file">
                                <input type="radio" name="status" value="1" id="radio1" required> Aktif
                                <input type="radio" name="status" value="0" id="radio2" required> Tidak Aktif
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" id="batal" class="btn btn-danger float-left">Batal</button>
                        <small>Isilah data tahun angkatan sesuai yang anda inginkan </small>
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
                    url:  '{{ url('tahun-angkatan') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                        $('[name="thn_lalu"]').val(result.thn_lalu);
                        $('[name="thn_depan"]').val(result.thn_depan);
                        $('[name="_method"]').val("put");
                        if(result.status=='0'){
                            $('#radio2').prop('checked', true);
                        }else{
                            $('#radio1').prop('checked', true);
                        }

                        $('#form').attr('action','{{ url('tahun-angkatan') }}/'+id);
                        $('#modal-default-proses').modal({
                            backdrop:'static',
                            keyboard:false,
                        });
                    }
                });
            }

            $('#batal').click(function () {
                $('#form').attr('action','{{ url('tahun-angkatan') }}/');
                $('#modal-default-proses').modal('hide');
            });

        });
    </script>
@stop