@extends('Elearning.base')

@section('css')

@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary"  id="tombol-jawab" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fa fa-fire"></i> Jawab</button>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <h2 style="text-align: center" id="demo">Waktu Ujian Dimulai</h2>
            </div><!-- /.col -->
            <div class="col-sm-3">
              <button type="button" class="btn btn-danger float-right" onclick="tutup_ujian()">Akhiri Ujian</button>
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
                {{--{!! $data_ujian->linkToFileSoal->nama_file !!}--}}
                <iframe id="frame" src="{{ $data_ujian->linkToFileSoal->nama_file }}" width="100%" height="500"></iframe>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pesan Hasil Pengerjaan Soal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h1 style="color: black; text-align: center;" id="jawaban_benar">Benar :</h1>
                        </div>
                        <div class="col-md-6">
                            <h1 style="color: black;text-align: center;" id="jawaban_salah">Salah</h1>
                        </div>
                        <div class="col-md-12">
                            <h1 style="color: black;text-align: center;" id="total_score">Score</h1>
                        </div>
                    </div>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@stop

@section('jsContainer')
        {{--<script src="{{ asset('PDFObject/pdfobject.js') }}"></script>--}}
        {{--<script>PDFObject.embed("https://drive.google.com/file/d/1YlISufiCbleEF3gsluP7tjM5f58L2D3a/view?usp=sharing", "#example1");</script>--}}
        <script>

            $("iframe").tooltip('hide');

            // Set the date we're counting down to
            var today = new Date();
            today.setDate(parseInt('{{ $date }}'));
            today.setMonth(parseInt('{{ $month }}'));

            var date = today.getFullYear()+'-'+(today.getMonth() )+'-'+today.getDate();
            today.setHours(parseInt('{{ $jam }}'));
            today.setMinutes(parseInt('{{ $minute }}'));
            var time =  today.getHours()+ ":" + today.getMinutes() + ":" + today.getSeconds();

            var current_date = date+' '+time;
            console.log(current_date);
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
//                update_time(hours+':'+minutes+':'+seconds);
                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "Waktu Pengerjaan Telah Berakhir";
                    update_status();
                    result();
                }

            }, 1000);


            update_status = function () {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url:'{{ url('update-status') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                        if(result.status_button==2){
                            $('#tombol-jawab').prop('disabled', true);
                        }
                        Toast.fire({
                            icon: result.status,
                            title: result.message
                        })

                    }
                })
            }

            result = function () {
                $.ajax({
                    url:'{{ url('nilai-ujian') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                       console.log(result);
                        var frame = document.getElementById("frame");
                        frame.parentNode.removeChild(frame);
                        $('#modal-default').modal('show')
                       $('#jawaban_benar').text('Benar :'+result.jawaban_benar);
                       $('#jawaban_salah').text('Salah :'+result.jawaban_salah);
                       $('#total_score').text('Jumlah Score :'+result.jawaban_score);

                    }
                })
            }

            tutup_ujian = function () {
                if(confirm('Apakah anda akan mengakhiri ujian ini ... ?')){
                    update_status();
                    result();
                }else{
                    alert('Ujian dilanjutkan');
                }
            }
        </script>
@stop