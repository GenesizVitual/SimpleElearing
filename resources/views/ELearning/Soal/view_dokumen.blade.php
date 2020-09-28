@extends('ELearning.base')

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
@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $data->judul_soal }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item ">Dokumen Soal</li>
                    {{--<li class="breadcrumb-item active">{{ $data->linkToFileSoal->nama_file }}</li>--}}
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
            @if(!empty($data->linkToDaftarSoal))
                @php($no=1)
                @foreach($data->linkToDaftarSoal->sortBy('no_urut') as $soal)
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Soal No. {{ $no++ }}</h3>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table style="width: 100%">
                                    <tr>
                                        <td colspan="2">
                                            @if($data->status_lagunge==0)
                                                {!! $soal->soal !!}
                                            @else
                                            <div class="text-arab">
                                                {!! $soal->soal !!}
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            @if($data->status_lagunge==0)
                                                <img src="{{ asset('gambar_bhs_arab/'.$soal->gambar) }}" style="width: 20%">

                                            @else
                                               @if(!empty($soal->gambar))
                                                    <div class="text-arab">
                                                        <img src="{{ asset('gambar_bhs_arab/'.$soal->gambar) }}" style="width: 20%">
                                                    </div>
                                               @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @if(!empty($soal->linkToPilihan))
                                        @foreach($soal->linkToPilihan->sortBy('label') as $datas)
                                            @if($data->status_lagunge == 0)
                                                <tr
                                                    @if(!empty($soal->linkToJawaban))
                                                            @if($soal->linkToJawaban->jawaban==$datas->label)
                                                                style="background-color: lawngreen"
                                                            @endif
                                                    @endif
                                                >
                                                    <td style="width: 15px">{{ $datas->label }}).</td>
                                                    <td>{{ $datas->text }} </td>
                                                </tr>
                                            @else
                                                <tr
                                                        @if(!empty($soal->linkToJawaban))
                                                        @if($soal->linkToJawaban->jawaban==$datas->label)
                                                        style="background-color: lawngreen"
                                                        @endif
                                                        @endif
                                                >
                                                    <td>
                                                        <h1 class="text-arab">{{ $datas->text }} @if(!empty($datas->gambar)) <img src="{{ asset('gambar_bhs_arab/pilihan/'.$datas->gambar) }}" style="width: 5%">@endif</h1>
                                                    </td>
                                                    <td style="width: 45px;">
                                                            @if($datas->label=='a')
                                                                <h5 class="text-arab">{{ "أ" }} .</h5>
                                                            @elseif($datas->label=='b')
                                                                <h5 class="text-arab">{{ "ب" }} .</h5>
                                                            @elseif($datas->label=='c')
                                                                <h5 class="text-arab">{{ "ج" }} .</h5>
                                                            @elseif($datas->label=='d')
                                                                <h5 class="text-arab">{{ "د" }} .</h5>
                                                            @endif
                                                        </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop

@section('jsContainer')
        {{--<script src="{{ asset('PDFObject/pdfobject.js') }}"></script>--}}
        {{--<script>PDFObject.embed("https://drive.google.com/file/d/1YlISufiCbleEF3gsluP7tjM5f58L2D3a/view?usp=sharing", "#example1");</script>--}}
@stop