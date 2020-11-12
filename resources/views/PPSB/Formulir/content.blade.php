@extends('PPSB.base')

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">

    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->


<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    {{--<div class="col-md-12">--}}
                        {{--<div class="card card-primary">--}}
                            {{--<img style="height: 250px; width: 200px;margin:auto;" src="https://images.assetsdelivery.com/compings_v2/jenjawin/jenjawin1904/jenjawin190400208.jpg"/>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="col-md-12 col-sm-6 col-12">
                        <a href="{{ url('formulir') }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>
                                <div class="info-box-content">
                                   <h5>Profil Calon Siswa</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12 col-sm-6 col-12">
                        <a href="{{ url('formulir-orang-tua') }}">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-user-friends"></i></span>
                                <div class="info-box-content">
                                    <h5>Data Orang Tua</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-12 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-upload fa-cloud-upload"></i></span>
                            <div class="info-box-content">
                                <h5>Upload Berkas</h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-9">
                <div class="row">
                    @if(Session::get('menu')=='formulir_siswa')
                        @include('PPSB.Formulir.section.formulir_siswa')
                    @elseif(Session::get('menu')=='formulir_orang_tua')
                        @include('PPSB.Formulir.section.formulir_orang_tua')
                    @endif
                </div>
            </div>
            {{--<div class="col text-center">--}}
                {{--<a href="#" class="btn btn-success">Formulir Pendaftaran</a>--}}
            {{--</div>--}}
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop