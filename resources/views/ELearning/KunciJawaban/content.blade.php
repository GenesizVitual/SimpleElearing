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
                <h1 class="m-0 text-dark">Kunci Jawaban</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Guru</li>
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
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Pilihan</h3>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        Halaman Ini adalah untuk memasukan kunci jawaban anda.
                        <button type="button" class="btn btn-primary" onclick="kunci_jawaban('{{ $id_tema_soal }}')">Tambah Kunci Jawaban</button>
                        <form action="{{ url('store-jabawan') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" value="{{ $id_tema_soal }}" name="id_kunci_jawaban">
                            <input type="hidden" value="{{ $banyak_soal }}" name="banyak_soal">
                            <table id="table-data" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kunci Jabawan</th>
                                    <th>Skor</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($no=1)
                                @php($no_urut=1)
                                @php($i=0)

                                @if(!empty($tbl_kunci_jawaban))
                                    @foreach($tbl_kunci_jawaban as $data_tbl)
                                        @php($no_urut = $data_tbl->no_urut)
                                        <tr>
                                            <th>{{ $no++ }}</th>
                                            <th>
                                                @foreach($option as $key=>$data)
                                                    <input name="kunci_jabawan_{{ $no_urut }}" @if($data_tbl->jawaban==$data) checked @endif type="radio" value="{{ $data }}" required> {{ $data }}
                                                @endforeach
                                            </th>
                                            <th>
                                                <input type="hidden" name="no_urut[]" value="{{ $no_urut }}">
                                                <input name="skor_jabawan[]" type="number" value="{{ $data_tbl->score }}" class="form-control" placeholder="Masukan skor anda" required/>
                                            </th>
                                        </tr>
                                        @php($i++)
                                    @endforeach
                                @endif

                                @while($no_urut <= $banyak_soal)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <th>
                                            @foreach($option as $key=>$data)
                                                <input name="kunci_jabawan_{{ $no_urut }}" type="radio" value="{{ $data }}" required> {{ $data }}
                                            @endforeach
                                        </th>
                                        <th>
                                            <input type="hidden" name="no_urut[]" value="{{ $no_urut }}">
                                            <input name="skor_jabawan[]" type="number" value="0" class="form-control" placeholder="Masukan skor anda" required/>
                                        </th>
                                    </tr>
                                    @php($no_urut++)
                                @endwhile
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-warning" id="remove">Hapus Baris tabel terakhir</button>
                            <button type="submit" class="btn btn-primary float-right" onclick="return confirm('Apakah anda telah benar memasukan jawaban anda ... ?')">Simpan</button>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->

</div>
<!-- /.content -->

<div class="modal fade" id="modal-kunci-jawaban">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Panel Kunci Jawaban</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ url('form-kunci-jawaban') }}" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="exampleInputFile">Banyak Soal</label>
                        <div class="custom-file">
                            <input type="number" min="1" class="form-control" name="banyak_soal" value="1" required/>
                            <input type="hidden" class="form-control" name="id_tema_soal">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="row">
                        <div class="col-md-9">
                            <small>Masukan banyak soal sesuai dengan soal yang anda hubungkan</small>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-success float-right">Proses</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


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
                        console.log(result);
                        $('[name="kode"]').val(result.kode);
                        $('[name="password"]').val(result.password);
                        $('[name="nama"]').val(result.nama);
                        $('[name="_method"]').val("put");
                        $('#form').attr('action','{{ url('guru') }}/'+id);
                        $('#modal-default-proses').modal('show');
                    }
                });
            }

            kunci_jawaban = function (id) {
                $('[name="id_tema_soal"]').val(id);
                $('#modal-kunci-jawaban').modal('show');
            }

            $('#remove').click(function () {
                $('#table-data tr:last').remove();
            })
        });
    </script>
@stop