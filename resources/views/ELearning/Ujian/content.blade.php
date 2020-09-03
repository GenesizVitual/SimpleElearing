@extends('ELearning.base')

@section('content')

<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <div class="login-box">
                <div class="login-logo">
                    <a href="../../index2.html"><b>Formulir Login</b> Ujian</a>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Silahkan lengkapi formulir dibawah ini</p>

                        <form action="{{ url('ikut-ujian') }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-group mb-3">
                                <input type="hidden" class="form-control" name="id_siswa" value="{{ $id_siswa }}">
                                <input type="text" class="form-control" name="kode_siswa" value="{{ $kode }}" placeholder="Kode Siswa" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-code"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Token" name="token" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('Apakah kamu bersedia mengikuti ujian, Waktu ujian akan berjalan ketika anda telah masuk ujian ...?')"><i class="fa fa-door-open"></i> Masuk Ujian</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop