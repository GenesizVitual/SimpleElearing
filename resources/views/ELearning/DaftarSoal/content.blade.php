@extends('ELearning.base')

@section('css')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/summernote/summernote-bs4.css') }}">
 @stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Daftar Soal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Soal</li>
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
            <div class="col-md-12">
                <div class="card card-danger">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h3>Soal No. {{ $no_urut }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('daftar-soal') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="no_urut" value="{{ $no_urut }}">
                            <input type="hidden" name="id_tema_soal" value="{{ $id_tema_soal }}">
                            <div class="row">
                                <div class="col-md-12">
                                <textarea class="textarea" placeholder="Masukan Soalnya disini" name="soal"
                                style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                </textarea>
                                </div>
                                <div class="col-md-6">
                                    <p>Pengaturan pilihan ganda</p>
                                    <hr>
                                    <table style="width: 100%">
                                        @foreach($pilihan as $pilihan_ganda)
                                            <tr>
                                                <td width="10"><h4>{{ $pilihan_ganda }}</h4></td>
                                                <td>:</td>
                                                <td>
                                                    <input type="hidden" class="form-control" name="label[]" value="{{ $pilihan_ganda }}" required></input>
                                                    <textarea class="form-control" name="pilihan[]" required></textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <p>Pengaturan Soal</p>
                                    <hr>
                                    <table style="width: 100%">
                                            <tr>
                                                <td width="200"><h4>Kunci Jawaban</h4></td>
                                                <td>:</td>
                                                <td>
                                                    <select class="form-control" name="jawaban">
                                                        @foreach($pilihan as $pilihan_ganda)
                                                            <option value="{{ $pilihan_ganda }}">{{ $pilihan_ganda }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Skor</h4></td>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" class="form-control" name="skor" placeholder="Nilai Skor Soal" value="0" required/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Waktu</h4></td>
                                                <td>:</td>
                                                <td>
                                                    <input type="time" class="form-control" value="00:05" name="waktu_kerja" placeholder="Waktu Pengerjaan setiap soal" required>
                                                </td>
                                            </tr>
                                        <tr>
                                            <td colspan="3">
                                             <br>
                                             <br>
                                             <br>
                                             <br>
                                                <button type="submit" class="btn btn-primary" style="width: 100%" onclick="return confirm('Pastikan soal yang anda masukan sudah benar ... ?')">Simpan</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            @php($nomor_urut_soal=1)

            @foreach($data_soal as $key=> $soal)
            <div class="col-md-12">
                <div class="card card-success">
                    <!-- /.card-header -->
                    <div class="card-header">
                        <h4 class="card-title">Soal No. {{ $nomor_urut_soal++ }} </h4>
                        <div class="card-tools">
                            <form action="{{ url('daftar-soal/'.$soal->id) }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete">
                                <input type="hidden" name="id_daftar_soal" value="{{ $soal->id }}">
                                <button type="submit" onclick="return confirm('Menghapus soal dapat merubah urutan soal')" class="btn btn-danger btn-sm" ><i class="fas fa-eraser"></i>
                                    Hapus Soal
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('daftar-soal') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="no_urut" value="{{ $soal->no_urut }}">
                            <input type="hidden" name="id_tema_soal" value="{{ $soal->id_tema_soal }}">
                            <div class="row">
                                <div class="col-md-12">
                                <textarea class="textarea" placeholder="Masukan Soalnya disini" name="soal" style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                                    {{ $soal->soal }}
                                </textarea>
                                </div>
                                <div class="col-md-6">
                                    <p>Pengaturan pilihan ganda</p>
                                    <hr>
                                    <table style="width: 100%">
                                        @foreach($pilihan as $pilihan_ganda)
                                            <tr>
                                                <td width="10"><h4>{{ $pilihan_ganda }}</h4></td>
                                                <td>:</td>
                                                <td>
                                                    <input type="hidden" class="form-control" name="label[]" value="{{ $pilihan_ganda }}" required>
                                                    <textarea class="form-control" name="pilihan[]" required>@if(!empty($soal->linkToPilihan->where('label',$pilihan_ganda)->first())) {{ $soal->linkToPilihan->where('label',$pilihan_ganda)->first()->text }} @endif</textarea>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <p>Pengaturan Soal </p>
                                    <hr>
                                    <table style="width: 100%">
                                        <tr>
                                            <td width="200"><h4>Kunci Jawaban</h4></td>
                                            <td>:</td>
                                            <td>
                                                <select class="form-control" name="jawaban">
                                                    @foreach($pilihan as $pilihan_ganda)
                                                        <option value="{{ $pilihan_ganda }}"
                                                                @if(!empty($soal->linkToJawaban))
                                                                    @if($soal->linkToJawaban->jawaban==$pilihan_ganda) selected @endif
                                                                @endif
                                                        >{{ $pilihan_ganda }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><h4>Skor</h4></td>
                                            <td>:</td>
                                            <td>
                                                <input type="number" class="form-control" name="skor" placeholder="Nilai Skor Soal"
                                                       @if(!empty($soal->linkToJawaban))
                                                            value="{{ $soal->linkToJawaban->score }}"
                                                       @endif
                                                       required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><h4>Waktu</h4></td>
                                            <td>:</td>
                                            <td>
                                                <input type="time" class="form-control" value="{{ $soal->waktu_kerja }}" name="waktu_kerja" placeholder="Waktu Pengerjaan setiap soal" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <button type="submit" class="btn btn-primary" style="width: 100%">Simpan</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            @endforeach

            {{ $data_soal->links() }}
        </div>
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

@stop

@section('jsContainer')
    <!-- Summernote -->
    <script src="{{ asset('admin_asset/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
            // Summernote
            $('.textarea').summernote({
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana', 'Amiri'],
                fontNamesIgnoreCheck: ['Amiri']
            });
        })
    </script>
@stop