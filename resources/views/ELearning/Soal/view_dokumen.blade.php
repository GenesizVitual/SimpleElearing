@extends('ELearning.base')

@section('css')
    <style>
        .pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
    </style>
@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $data->judul }}</h1>
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
                                        <td colspan="2">{!! $soal->soal !!}</td>
                                    </tr>
                                    @if(!empty($soal->linkToPilihan))
                                        @foreach($soal->linkToPilihan->sortBy('label') as $data)
                                            <tr
                                                @if(!empty($soal->linkToJawaban))
                                                        @if($soal->linkToJawaban->jawaban==$data->label)
                                                            style="background-color: lawngreen"
                                                        @endif
                                                @endif
                                            >
                                                <td style="width: 15px">{{ $data->label }}).</td>
                                                <td>{{ $data->text }} </td>
                                            </tr>
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