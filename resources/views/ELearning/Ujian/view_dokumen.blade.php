@extends('ELearning.base')

@section('css')

@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                {{--<button type="button" class="btn btn-primary"  id="tombol-jawab" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fa fa-fire"></i> Jawab</button>--}}
            </div><!-- /.col -->
            <div class="col-sm-6">

            </div><!-- /.col -->
            <div class="col-sm-3">
              {{--<button type="button" class="btn btn-danger float-right" onclick="tutup_ujian()">Akhiri Ujian</button>--}}
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">

    <div class="container-fluid">
        <div class="row">
            {{--@foreach($data_ujian as $data)--}}
            @if(!empty($data_ujian[0][0]))
                <div class="col-md-12" >
                    <div class="card card-primary" >
                        <div class="card-header">

                                <label class="float-right" id="demo"></label>
                                <label class="float-left" id="demo2"></label>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                            {{ csrf_field() }}
                            <div class="card-body">
                                @if(!empty($data_ujian[0][0]))
                                {!! $data_ujian[0][0] !!}
                                @endif
                                <hr>
                                @if(!empty($data_ujian[0][3]))
                                <table>
                                    @foreach($data_ujian[0][3] as $pilihan)
                                        <tr>
                                            <td><input type="radio" name="jawaban" onclick="onSelected('{{ $data_ujian[0][4] }}' ,'{{ $data_ujian[0][5] }}','{{ $data_ujian[0][6] }}','{{ $pilihan->label }}','{{ $data_ujian[0][2] }}')" required>{{ $pilihan->label }}). </td>
                                            <td>{{ $pilihan->text }}</td>
                                        </tr>
                                    @endforeach
                                </table>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small style="color: red">
                                            * Selesaikan ujian ini sebelum waktu ujian berakhir.<br>
                                            * Selesaikan soal sebelum waktu pengerjaan soal habis. jika waktu pengerjaan soal habis maka sistem akan melewati soal ini tampa ada jawaban
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="button-next" disabled class="btn btn-success float-right">Lanjut Ke Soal Berikutnya</button>
                                    </div>
                                </div>
                            </div>

                        <!-- /.card-body -->
                    </div>
                </div>
            @else
                <div class="col-md-12" >
                    <div class="card card-primary" >
                        <div class="card-header">

                            <label class="float-right" id="demo"></label>
                            <label class="float-left" id="demo2"></label>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->

                            <div class="card-body">
                                <h1 style="text-align: center"> Ujian Telah Berkahir atau Soal Ujian Belum Dibuka</h1>
                            </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            @endif
            {{--@endforeach--}}
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
    $(function () {
        $(document).keydown(function (e) {
            return (e.which || e.keyCode) != 116;
        });

        $(document).ready(function() {
            function disableBack() { window.history.forward() }

            window.onload = disableBack();
            window.onpageshow = function(evt) { if (evt.persisted) disableBack() }

        });
    });
</script>

        <script>

            $("iframe").tooltip('hide');

            // Time Per soal

            endedUjian = function () {

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
                            $('##button-next').prop('disabled', true);
                        }
                        Toast.fire({
                            icon: result.status,
                            title: result.message
                        })

                    }
                })
            }

            TimeOperations = function(date,month,jam,minute){
                var todays = new Date();
                todays.setDate(parseInt(date));
                todays.setMonth(parseInt(month));

                var date2 = todays.getFullYear()+'-'+(todays.getMonth() )+'-'+todays.getDate();
                todays.setHours(parseInt(jam));
                todays.setMinutes(parseInt(minute));
                var time2 =  todays.getHours()+ ":" + todays.getMinutes() + ":" + todays.getSeconds();

                var current_date3 = date2+' '+time2;
                var countDownDate3 = new Date(current_date3).getTime();
                return countDownDate3;
            }

            @if(!empty($data_ujian[0]))
                var countDownDate = TimeOperations('{{ $data_ujian[0]['date'] }}','{{ $data_ujian[0]['month'] }}','{{ $data_ujian[0]['jam'] }}','{{ $data_ujian[0]['minute'] }}');
            @endif
            var countDownDate2 = TimeOperations('{{ $date }}','{{ $month }}','{{ $jam }}','{{ $minute }}');

            if(countDownDate2 < countDownDate){
                countDownDate = countDownDate2;
            }


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
                document.getElementById("demo").innerHTML =  "Waktu Pengerjaan Soal: "+hours + " Jam "
                    + minutes + " Menit " + seconds + " detik ";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    @if(!empty($data_ujian[0]))
                        times_up('{{ $data_ujian[0][4] }}' ,'{{ $data_ujian[0][5] }}','{{ $data_ujian[0][6] }}','-','{{ $data_ujian[0][2] }}');
                    @endif
                    window.location.reload();
                }

            }, 1000);

            //=============== Time Ujian

            // Update the count down every 1 second
            var y = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate2 - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("demo2").innerHTML =  " Waktu ujian :"+hours + " Jam "
                    + minutes + " Menit " + seconds + " detik ";

                // If the count down is finished, write some text
                if (distance < 0) {
                    clearInterval(x);
                    if(countDownDate2 < countDownDate){
                        countDownDate = countDownDate2;
                    }
                    document.getElementById("demo2").innerHTML = "Waktu Pengerjaan Telah Berakhir";
                    window.location.href="{{ url('ujian') }}";
                    endedUjian();
                    alert('Waktu Pengerjaan Soal telah selesai');

                }

            }, 1000);

        </script>


        <script>

            refreshPage = function () {
                return false;
            }

            onSelected= function (id,id_siswa,id_ujian,jawaban,no_urut) {
               const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url :'{{ url('jawab-ujian') }}',
                    type:'post',
                    data : {
                        'id_siswa':id_siswa,
                        'no_urut':no_urut,
                        'id_kunci_jabawan':id,
                        'id_ujian':id_ujian,
                        'jawaban':jawaban,
                        '_token':'{{ csrf_token() }}',
                        '_method':'put',
                    }, success:function (result) {
                        Toast.fire({
                            icon: result.status,
                            title: result.message
                        })
                        $('#button-next').attr('disable',false);
                    }
                })
            }



            times_up= function (id,id_siswa,id_ujian,jawaban,no_urut) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });

                $.ajax({
                    url :'{{ url('jawab-ujian') }}',
                    type:'post',
                    data : {
                        'id_siswa':id_siswa,
                        'no_urut':no_urut,
                        'id_kunci_jabawan':id,
                        'id_ujian':id_ujian,
                        'jawaban':jawaban,
                        '_token':'{{ csrf_token() }}',
                        '_method':'put',
                    }, success:function (result) {
                        Toast.fire({
                            icon: result.status,
                            title: 'Waktu pengerjaan persoal selesai, sistem akan anda tidak menjawab pertanyaan ini'
                        })

                    }
                })
            }
        </script>
@stop