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
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title m-0" style="font-weight: bold">Persyaratan</h4>
                    </div>
                    <div class="card-body">
                        <p>Sebelum mendaftar anda harus menyediakan soft copy berkas-berkas dibawah ini:</p>
                        <ol>
                            <li>
                                Soft Copy Nilai Rapor Kelas V Semester 1 & 2 yang telah dilegalisir
                            </li>
                            <li>
                                Soft Copy Nilai Rapor Kelas VI Semester 1 & 2 yang telah dilegalisir
                            </li>
                            <li>
                                Soft Copy Akta Kelahiran
                            </li>
                            <li>
                                Soft Copy Kartu Keluarga
                            </li>
                            <li>
                                Soft Copy Foto Calon Siswa latar merah dan berjilbab bagi putri
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <a href="{{ url('formulir') }}" class="btn btn-success">Formulir Pendaftaran</a>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop