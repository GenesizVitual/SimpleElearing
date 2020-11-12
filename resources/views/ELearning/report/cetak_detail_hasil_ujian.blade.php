<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin_asset/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <title>Cetak Jawaban Siswa</title>
</head>
<body style="padding: 2%">
<h3 style="text-align: center">Hasil Jawaban Siswa</h3>
<table style="width: 100%">
    <tr>
        <th style="width: 50px">Nama</th>
        <th style="width: 10px">:</th>
        <th>{{ $siswa->nama }}</th>
    </tr>
    <tr>
        <th style="width: 100px">Jenis Kelas</th>
        <th style="width: 10px">:</th>
        <th>{{ $siswa->jenis_kelas }}</th>
    </tr>
    <tr>
        <th style="width: 50px">Kelas</th>
        <th style="width: 10px">:</th>
        <th>{{ $siswa->kelas }}</th>
    </tr>
    <tr>
        <th style="width: 50px">Tema Soal</th>
        <th style="width: 10px">:</th>
        <th>{{ $tema_soal->judul_soal }}</th>
    </tr>
</table>
<table id="table-data" class="table table-bordered table-striped">
    <thead>
    <tr>
        <th rowspan="2">#</th>
        <th rowspan="2">Kode Soal</th>
        <th rowspan="2">Kunci Jawaban</th>
        <th rowspan="2">Skor</th>
        <th rowspan="2">Jawaban Siswa</th>
        <th colspan="3">Sub Skor</th>
    </tr>
    </thead>
    <tbody>
    @php($no=1)
    @if(!empty($data_jawaban))
        @foreach($data_jawaban as $data)
            <tr>
                <th >{{ $data['no'] }}</th>
                <th>{{ $data['kode_soal'] }}</th>
                <th>{{ $data['kunci_jawaban'] }}</th>
                <th>{{ $data['skor'] }}</th>
                <th>{{ $data['jawaban_siswa'] }}</th>
                <th>{{ $data['sub_skor'] }}</th>
            </tr>
        @endforeach
        <tr>
            <th colspan="5">Total Skor</th>
            <th>{{ $total_skor }}</th>
        </tr>
    @endif
    </tbody>
</table>
</body>
<!-- jQuery -->
<script src="{{ asset('admin_asset/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin_asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin_asset/dist/js/adminlte.min.js') }}"></script>

<script>
    window.print()
</script>
</html>

