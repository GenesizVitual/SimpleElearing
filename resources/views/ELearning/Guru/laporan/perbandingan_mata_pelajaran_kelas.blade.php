@extends('Elearning.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
                    <div id="canvas" style="height: 400px; width: 100%;"></div>

                    <script>
                        var chart = new CanvasJS.Chart("canvas", {
                            animationEnabled: true,
                            theme: "light2",
                            title:{
                                text: "Perkembangan Nilai Rerata Kelas"
                            },
                            axisY:{
                                includeZero: true
                            },
                            legend:{
                                cursor: "pointer",
//                                verticalAlign: "center",
//                                horizontalAlign: "right",
                                itemclick: toggleDataSeries
                            },
                            data: [
                                @foreach($data as $semester=> $data_semester)
                                {
                                    type: "column",
                                    name: "Semester {{ $semester }}",
                                    indexLabel: "{y}",
                                    yValueFormatString: "#0.##",
                                    showInLegend: true,
                                    dataPoints: <?php echo json_encode($data_semester, JSON_NUMERIC_CHECK); ?>
                                },
                                @endforeach

                            ]
                        });

                        function toggleDataSeries(e){
                            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else{
                                e.dataSeries.visible = true;
                            }
                            chart.render();
                        }
                        chart.render();
                    </script>
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