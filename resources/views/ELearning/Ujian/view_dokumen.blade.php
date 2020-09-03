@extends('ELearning.base')

@section('css')

@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                <a class="btn btn-primary"  data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fa fa-fire"></i> Jawab</a>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <h2 style="text-align: center" id="demo">Waktu Ujian Dimulai</h2>
            </div><!-- /.col -->
            <div class="col-sm-3">
               <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item ">Dokumen Soal</li>

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

            <div class="col-md-12" id="example1" style="width: 100%">
                {!! $data_ujian->linkToFileSoal->nama_file !!}
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop

@section('jsContainer')
        {{--<script src="{{ asset('PDFObject/pdfobject.js') }}"></script>--}}
        {{--<script>PDFObject.embed("https://drive.google.com/file/d/1YlISufiCbleEF3gsluP7tjM5f58L2D3a/view?usp=sharing", "#example1");</script>--}}
        <script>
            // Set the date we're counting down to
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            today.setHours(today.getHours()+parseInt('{{ $jam }}'));
            today.setMinutes(today.getMinutes()+parseInt('{{ $minute }}'));
            var time =  today.getHours()+ ":" + today.getMinutes() + ":" + today.getSeconds();

            var current_date = date+' '+time;

            var countDownDate = new Date(current_date).getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("demo").innerHTML =  hours + " Jam "
                    + minutes + " Menit " + seconds + " detik ";
                update_time(hours+':'+minutes+':'+seconds);
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                    update_status();
                }
            }, 1000);

            update_time = function (time) {
                $.ajax({
                    url:'{{ url('update-time') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        'time': time,
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                        console.log(result);
                    }
                })
            }

            update_status = function () {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url:'{{ url('update-time') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                        Toast.fire({
                            icon: result.status,
                            title: result.message
                        })
                    }
                })
            }
        </script>
@stop