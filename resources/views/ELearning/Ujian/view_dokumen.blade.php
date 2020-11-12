@extends('Elearning.base')

@section('css')
    <style>
        @font-face {

            font-family: 'me_quran';

            src: url('https://cdn.rawgit.com/KompiAjaib/font/master/me_quran.eot');

            src: url('https://cdn.rawgit.com/KompiAjaib/font/master/me_quran.eot?#iefix') format('embedded-opentype'), url('https://cdn.rawgit.com/KompiAjaib/font/master/me_quran.woff') format('woff'), url('https://cdn.rawgit.com/KompiAjaib/font/master/me_quran.ttf') format('truetype'), url('https://cdn.rawgit.com/KompiAjaib/font/master/me_quran.svg#me_quran') format('svg');

            font-weight: normal;

            font-weight: 400;

            font-style: normal;

        }

        .text-arab {

            font-size: 22px;

            line-height: 2.2;

            font-family: me_quran, sans-serif;

            font-weight: normal;

            text-align: right;

            direction: rtl;

        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">
    <link rel="stylesheet" href="{{ asset('thumbnail/thumbnail-gallery.css') }}">
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

    <div class="container-fluid tz-gallery" style="padding-top: 0">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary" >
                    <div class="card-body">
                        <h3 style="text-align: center">Kejujuran akan menyelamatkanmu meski kamu merasa takut akan hal itu. <br>  " Ali bin Abi Thalib "</h3>
                    </div>
                </div>
            </div>
            {{--@foreach($data_ujian as $data)--}}
            @if(!empty($data_ujian[0][0]))
                <div class="col-md-8" style="height: 80%">
                    <div class="card card-primary" >
                        <div class="card-header">

                                <label class="float-right" id="demo"></label>
                                <label class="float-left "  style="color: white" >Soal Nomor. {{ $data_ujian[0][2] }} </label>
                                <label class="float-left " id="demo2" style="color: #007bff" ></label>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <form action="{{ url('jawab-ujian') }}" method="post">
                            {{ csrf_field() }}

                            <div class="card-body @if($data_ujian[0][8]==1) text-arab @endif" style=" padding-right: 2%;padding-left: 5%;">

                                @if(!empty($data_ujian[0][0]))
                                    {!! str_replace('1.','', $data_ujian[0][0]) !!}
                                @endif
                                <p>
                                    @if(!empty($data_ujian[0][9]))
                                        <a class="lightbox" href="@if(empty(SiteUrl::getUrl())) {{ asset('gambar_bhs_arab/'.$data_ujian[0][9]) }} @else {{ SiteUrl::getUrl().'gambar_bhs_arab/'.$data_ujian[0][9] }} @endif">
                                            <img src="@if(empty(SiteUrl::getUrl())) {{ asset('gambar_bhs_arab/'.$data_ujian[0][9]) }} @else {{ SiteUrl::getUrl().'gambar_bhs_arab/'.$data_ujian[0][9] }} @endif" style="width: 50%">
                                        </a>
                                    @endif
                                </p>
                                <hr>
                                @if(!empty($data_ujian[0][3]))
                                <table>

                                    <input type="hidden" name="id_siswa" value="{{ $id_siswa }}">
                                    <input type="hidden" name="no_urut">
                                    <input type="hidden" name="id_kunci_jabawan">
                                    <input type="hidden" name="id_ujian">
                                    <input type="hidden" name="_method" value="put">
                                    <input type="hidden" name="jawaban" >

                                   @foreach($data_ujian[0][3] as $pilihan)
                                        <tr>
                                            <td style="width: 50px">
                                                <input type="radio" name="pilihan" onclick="onSelected('{{ $data_ujian[0][4] }}' ,'{{ $data_ujian[0][5] }}','{{ $data_ujian[0][6] }}','{{ $pilihan->label }}','{{ $data_ujian[0][2] }}')" required>
                                                @if($data_ujian[0][8]==1)
                                                    @if($pilihan->label=='a')
                                                        {{ "أ" }}.
                                                    @elseif($pilihan->label=='b')
                                                        {{ "ب" }}.
                                                    @elseif($pilihan->label=='c')
                                                        {{ "ج" }}.
                                                    @elseif($pilihan->label=='d')
                                                        {{ "د" }}.
                                                    @endif
                                                @else
                                                    {{ $pilihan->label }}).
                                                @endif

                                            </td>
                                            <td>{{ $pilihan->text }}
                                                @if(!empty($pilihan->gambar))
                                                    <a class="lightbox" href="@if(empty(SiteUrl::getUrl())) {{ asset('gambar_bhs_arab/pilihan/'.$pilihan->gambar) }} @else {{ SiteUrl::getUrl().'gambar_bhs_arab/pilihan/'.$pilihan->gambar }} @endif ">
                                                        <img src="@if(empty(SiteUrl::getUrl())) {{ asset('gambar_bhs_arab/pilihan/'.$pilihan->gambar) }} @else {{ SiteUrl::getUrl().'gambar_bhs_arab/pilihan/'.$pilihan->gambar }} @endif " style="width: 50%; margin-right: 20px">
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small style="color: red">
                                            * Selesaikan soal ujian sebelum waktu pengerjaan soal habis.<br>
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" id="button-next" disabled class="btn btn-success float-right">Lanjut Ke Soal Berikutnya</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-4" style="height: 425px; overflow-y: auto">
                    <div class="card card-primary" >
                        <div class="card-body">
                            <p>Bagian ini hanya akan menampilkan soal yang telah terjawab atau belum</p>
                            <div class="row">

                            @if(!empty($data_jawaban))
                                @foreach($data_jawaban->linkToDaftarSoal as $data)
                                    <div class="col-md-12" style="padding: 10px">
                                        <a href="{{ url('jawaban-soal/'.$data->id) }}" class="btn btn-warning">{{ $data->no_urut }}</a>
                                        @foreach($data->linkToPilihan->sortBy('label') as $pilihan)
                                            @if(!empty($data->linkToJawaban->linkToKunciJabawan))
                                                @if(!empty($data->linkToJawaban->linkToKunciJabawan->where('id_siswa', Session::get('id_siswa'))->where('no_urut', $data->no_urut)->first()->jawaban))
                                                    <button type="button" class="btn @if($data->linkToJawaban->linkToKunciJabawan->where('id_siswa', Session::get('id_siswa'))->where('no_urut', $data->no_urut)->first()->jawaban == $pilihan->label )) btn-success @else btn-danger @endif">{{ $pilihan->label }}</button>
                                                @else
                                                    <button type="button" class="btn btn-danger">{{ $pilihan->label }}</button>
                                                @endif
                                            @else
                                                <button type="button" class="btn btn-danger">{{ $pilihan->label }}</button>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            @endif

                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-8" >
                    <div class="card card-primary" >
                        <div class="card-header">

                            <label class="float-right" id="demo"></label>
                            <label class="float-left" id="demo2"></label>
                            <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->

                            <div class="card-body">
                                <h1 style="text-align: center">Soal ujian anda telah terjawab semua</h1>
                                <center>
                                    <button class="btn btn-lg btn-danger" onclick="cek = function(){ if(confirm('Apakah kamu ingin mengakhiri ujian ini ...?')){ tutup_ujian() }else{ alert('lanjutkan ujian anda')} }; cek()"> Akhiri Ujian </button>
                                </center>
                            </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-4" style="height: 425px; overflow-y: auto">
                    <div class="card card-primary" >
                        <div class="card-body">
                            <p>Bagian ini hanya akan menampilkan soal yang telah terjawab atau belum</p>
                            <div class="row">

                                @if(!empty($data_jawaban))
                                    @foreach($data_jawaban->linkToDaftarSoal as $data)
                                        <div class="col-md-12" style="padding: 10px">
                                            <a href="{{ url('jawaban-soal/'.$data->id) }}" class="btn btn-warning">{{ $data->no_urut }}</a>
                                            @foreach($data->linkToPilihan->sortBy('label') as $pilihan)
                                                @if(!empty($data->linkToJawaban->linkToKunciJabawan))
                                                    @if(!empty($data->linkToJawaban->linkToKunciJabawan->where('id_siswa', Session::get('id_siswa'))->where('no_urut', $data->no_urut)->first()->jawaban))
                                                        <button type="button" class="btn @if($data->linkToJawaban->linkToKunciJabawan->where('id_siswa', Session::get('id_siswa'))->where('no_urut', $data->no_urut)->first()->jawaban == $pilihan->label )) btn-success @else btn-danger @endif">{{ $pilihan->label }}</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger">{{ $pilihan->label }}</button>
                                                    @endif
                                                @else
                                                    <button type="button" class="btn btn-danger">{{ $pilihan->label }}</button>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
<script>
   baguetteBox.run('.tz-gallery');
</script>
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
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });


            endedUjian = function () {
                $.ajax({
                    url:'{{ url('update-status') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                        if(result.status_button==2){
                            $('#button-next').prop('disabled', true);
                        }
//                        Toast.fire({
//                            icon: result.status,
//                            title: result.message
//                        })

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
            @else
                var  countDownDate  =TimeOperations('{{ $date }}','{{ $month }}','{{ $jam }}','{{ $minute }}');
            @endif
            var countDownDate2 = TimeOperations('{{ $date }}','{{ $month }}','{{ $jam }}','{{ $minute }}');

            if(countDownDate2 < countDownDate){
                countDownDate = countDownDate2;
            }

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
//                document.getElementById("demo2").innerHTML =  " Waktu ujian :"+hours + " Jam "
//                    + minutes + " Menit " + seconds + " detik ";

                // If the count down is finished, write some text
                if (hours==0 && minutes==0 && seconds==0) {
                    clearInterval(x);
                    if(countDownDate2 < countDownDate){
                        countDownDate = countDownDate2;
                    }
                    document.getElementById("demo2").innerHTML = "Waktu Pengerjaan Telah Berakhir";
                    Toast.fire({
                        icon: 'info',
                        title: 'Waktu Pengerjaan telah berkahir, anda akan diahlikan ke halaman ujian'
                    })
                    tutup_ujian();

                    var close = setInterval(function () {
                        {{--window.location.href="{{ url('ujian') }}";--}}
                    }, 5000)
                    clearInterval(y);
//                    alert('Waktu Pengerjaan Soal telah selesai');

                }

            }, 1000);

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distances = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distances / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distances % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distances % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distances % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("demo").innerHTML =  "Waktu Pengerjaan Soal: "+hours + " Jam "
                    + minutes + " Menit " + seconds + " detik ";

                // If the count down is finished, write some text
                if (hours==0 && minutes==0 && seconds==0) {
                    @if(!empty($data_ujian[0]))
                        {{--times_up('{{ $data_ujian[0][4] }}' ,'{{ $data_ujian[0][5] }}','{{ $data_ujian[0][6] }}','-','{{ $data_ujian[0][2] }}');--}}
                    @endif
//                    window.location.reload();
                }


            }, 1000);

        </script>


        <script>

            refreshPage = function () {
                return false;
            }

            onSelected= function (id,id_siswa,id_ujian,jawaban, no_urut) {
                $('[name="no_urut"]').val(no_urut);
                $('[name="id_kunci_jabawan"]').val(id);
                $('[name="jawaban"]').val(jawaban);
                $('[name="id_ujian"]').val(id_ujian);
                $('#button-next').prop('disabled',false);
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

            result = function () {
                $.ajax({
                    url:'{{ url('nilai-ujian') }}',
                    type:'post',
                    data:{
                        'id_siswa': '{{$id_siswa }}',
                        'id_tema_soal': '{{ $id_tema_siswa }}',
                        '_token':'{{ csrf_token() }}'
                    },success:function (result) {
                        $('#modal-default').modal('show')
                        $('#jawaban_benar').text('Benar :'+result.jawaban_benar);
                        $('#jawaban_salah').text('Salah :'+result.jawaban_salah);
                        $('#total_score').text('Jumlah Score :'+result.jawaban_score);
                    }
                })
            }

            tutup_ujian = function () {
                endedUjian();
                result();
            }
        </script>
@stop