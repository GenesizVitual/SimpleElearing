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
                    <h1 class="m-0 text-dark">Monitoring Hasil Ujian</h1>
                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            Halaman ini adalah halaman untuk menampilkan semua siswa yang masih dalam pengerjaan ujian.
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Tabel Hasil Ujian</h3>

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
                                    <th colspan="3">Hasil</th>
                                </tr>
                                <tr>
                                    <th>Benar</th>
                                    <th>Salah</th>
                                    <th>Score</th>
                                </tr>
                                </thead>
                                <tbody>

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
            var table=$('#table-data').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "data":[],
                "columns":[
                    {'data' :'no'},
                    {'data' :'nama'},
                    {'data' :'kode'},
                    {'data' :'kelas'},
                    {'data' :'jenis_kelas'},
                    {'data' :'jawaban_benar'},
                    {'data' :'jawaban_salah'},
                    {'data' :'jawaban_score'},
                ],
                "order": [[ 7, "desc" ]]
            });
                
            datable_show = function () {
                $.ajax({
                    url:'{{ url('data-monitor-ujian') }}',
                    type: 'post',
                    data:{
                        'id_tema_soal': '{{ $id_tema_soal }}',
                        '_token':'{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    table.clear().draw();
                    table.rows.add(result.data_ujian).draw();
                })
            }

            datable_show();
            setInterval("datable_show();",3000)
        });
    </script>
@stop