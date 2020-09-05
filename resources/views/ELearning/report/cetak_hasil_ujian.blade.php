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

    <title>Document</title>
</head>
<body style="padding: 2%">
<h3 style="text-align: center">Daftar Skor Siswa</h3>
<table style="width: 18%">
    <tr>
        <td>Mata Pelajaran</td>
        <td>:</td>
        <td>{{ $data_soal->judul_soal }}</td>
    </tr>
    <tr>
        <td>Kelas</td>
        <td>:</td>
        <td>{{ $data_soal->kelas }}</td>
    </tr>
    <tr>
        <td>Tingkat Kelas</td>
        <td>:</td>
        <td>{{ $data_soal->jenis_kelas }}</td>
    </tr>
</table>
<table id="table-data" class="table table-bordered" border="1" style="width: 100%">
    <thead>
    <tr style="background-color: green; color: white">
        <th rowspan="2">#</th>
        <th rowspan="2">Nama</th>
        <th rowspan="2">Kode</th>
        <th rowspan="2">Kelas</th>
        <th rowspan="2">Jenis kelas</th>
        <th colspan="3">Hasil</th>
    </tr>
    <tr style="background-color: green;color: white">
        <th>Benar</th>
        <th>Salah</th>
        <th>Score</th>
    </tr>
    </thead>
    <tbody>
    @php($no=1)
    @if(!empty($data_ujian))
        @foreach($data_ujian as $data)
            <tr>
                <th >{{ $data['no'] }}</th>
                <th>{{ $data['nama'] }}</th>
                <th>{{ $data['kode'] }}</th>
                <th>{{ $data['kelas'] }}</th>
                <th>{{ $data['jenis_kelas'] }}</th>
                <th>{{ $data['hasil']['jawaban_benar'] }}</th>
                <th>{{ $data['hasil']['jawaban_salah'] }}</th>
                <th>{{ $data['hasil']['jawaban_score'] }}</th>
            </tr>
        @endforeach
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

</script>
</html>

