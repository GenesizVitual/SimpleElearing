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
                <h1 class="m-0 text-dark">Grafik Perkembangan Nilai Rerata Kelas</h1>
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
        <div class="row">



            @if(!empty($data))
                @foreach($data as $key=>$semester)
                    <div class="col-md-12"><h4>Semester {{ $key+1 }}</h4>  </div>
                    @foreach($semester as $key_kelas=>$kelas)
                        <div class="col-md-4">
                            <div class="card card-success">
                                <h4 style="text-align: center">Kelas {{ $key_kelas }}</h4>
                                <table class="table table-bordered table-striped">
                                    <tr style="background-color: deepskyblue">
                                        <th>Kelas</th>
                                        <th>Rerata kelas</th>
                                        <th>Rerata Rangking</th>
                                    </tr>
                                    @php($i=1)
                                    <?php usort($kelas, function ($a,$b){ return (int)$b['y']-(int)$a['y']; })?>
                                    @foreach($kelas as $data)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $data['label'] }}</th>
                                            <th>{{ round($data['y'],2) }}</th>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div><!-- /.container-fluid -->


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