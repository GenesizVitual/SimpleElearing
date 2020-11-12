@extends('Elearning.base')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Soal</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Soal</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        Halaman Ini akan menampilkan semua data soal yang telah dibuat.
        <div class="row">
           <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Tabel Soal</h3>
                        @if(!empty(Session::get('id_guru')))
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" onclick=" $('#modal-default-proses').modal('show');" ><i class="fas fa-plus"></i>
                                </button>
                            </div>
                        @else
                            {{--@if($data_soal->status==0) Tidak Aktif @else Aktif  @endif--}}
                        @endif
                        <br>

                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p><a href="{{ url('monitoring-hasil-ujian-aktif') }}">Monitoring Semua Ujian Yang Aktif</a></p>
                        <table id="table-data" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Guru</th>
                                <th>Judul Soal</th>
                                <th>Jenis Kelas</th>
                                <th>Kelas</th>
                                <th>Semester</th>
                                <th>Total Waktu</th>
                                <th>Token</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($no=1)
                            @foreach($data as $data_soal)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data_soal->linkToGuru->nama }}</td>
                                    <td><p>{{ $data_soal->linkToMataPelajaran->mata_pelajaran }}</p> <p>{{ $data_soal->judul_soal }}</p></td>
                                    <td>{{ $data_soal->jenis_kelas }}</td>
                                    <td>{{ $data_soal->kelas }}</td>
                                    <td>{{ $data_soal->semester }}</td>
                                    <td>
                                        @if($data_soal->status_waktu==1)
                                            @if(!empty($data_soal->linkToDaftarSoal))
                                                @php($time=DB::select('SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( waktu_kerja ) ) ) AS timeSum   FROM `tbl_daftar_soal` where id_tema_soal='.$data_soal->id))
                                                {{ $time[0]->timeSum }}
                                            @endif
                                        @else
                                            {{ $data_soal->time }}
                                        @endif
                                    </td>
                                    <td>{{ $data_soal->token }}</td>
                                    <td>
                                        <div class="form-group">
                                            @if(!empty(Session::get('id_guru')))
                                            <button type="button"  onclick="ubah_status_aktif({{ $data_soal->id }})" @if($data_soal->status==0) class="btn btn-danger" @else class="btn btn-success"  @endif>
                                                @if($data_soal->status==0) Tidak Aktif @else Aktif  @endif
                                            </button>
                                            @else
                                                @if($data_soal->status==0) Tidak Aktif @else Aktif  @endif
                                            @endif
                                            <br>

                                            @if(!empty($data_soal->linkToDaftarSoal->count('id')))
                                                <small style="color: green;">Soal telah dibuat</small>
                                            @else
                                                <small style="color:red">Soal Belum dibuat</small>
                                            @endif
                                        </div>

                                    </td>
                                    <td>
                                        <div class="btn-group dropup">
                                            <button type="button" class="btn btn-info"><i class="fa fa-door-open"></i></button>
                                            <button type="button" class="btn btn-info dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                                <div class="dropdown-menu dropdown-menu-right" role="menu" style="">
                                                    @if(!empty(Session::get('id_guru')))
                                                        <a class="dropdown-item" href="#" onclick="window.location.href='{{ url('daftar-soal/'.$data_soal->id) }}'"><i class="fa fa-upload"></i> Soal</a>
                                                        <a class="dropdown-item" href="#" onclick="window.location.href='{{ url('lihat-dokumen-soal/'. $data_soal->id) }}' "><i class="fa fa-eye"></i> Lihat Soal</a>
                                                        <a class="dropdown-item" href="#" onclick="window.location.href='{{ url('kunci-jawaban/'. $data_soal->id) }}' "><i class="fa fa-key"></i> Kunci Jawaban</a>
                                                        <a class="dropdown-item" href="#" onclick="window.location.href='{{ url('hasil-ujian/'. $data_soal->id) }}' "><i class="fa fa-book"></i> Hasil Ujian</a>
                                                        <a class="dropdown-item" href="#" onclick="window.open('{{ url('monitor-ujian/'. $data_soal->id) }}','_blank') " ><i class="fa fa-eye"></i> Monitoring Ujian</a>
                                                        <hr>
                                                        <a class="dropdown-item" href="#" onclick="edit('{{ $data_soal->id }}')"><i class="fa fa-pen"></i> ubah</a>
                                                        <a class="dropdown-item" href="#" onclick="onDelete('{{ $data_soal->id }}')"><i class="fa fa-eraser"></i> hapus</a>
                                                    @else
                                                        <a class="dropdown-item" href="#" onclick="window.location.href='{{ url('hasil-ujian/'. $data_soal->id) }}' "><i class="fa fa-book"></i> Hasil Ujian</a>
                                                        <a class="dropdown-item" href="#" onclick="window.open('{{ url('monitor-ujian/'. $data_soal->id) }}','_blank') " ><i class="fa fa-eye"></i> Monitoring Ujian</a>
                                                    @endif
                                                </div>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Embend Soal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('upload-soal') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="exampleInputFile">Masukan Code Embedend</label>
                            <div class="custom-file">
                                <textarea class="form-control" name="file" required></textarea>
                                <input type="hidden" class="form-control" name="id_tema_soal">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="row">
                            <div class="col-md-9">
                                <small>Code Embenden soal diperoleh dari google drive. Jika anda membagikan dokumen soal yang anda upload</small>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success float-right">Proses</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modal-default-proses">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Panel Tema Soal </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('soal') }}" method="post" id="form" enctype="multipart/form-data">
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="post">
                        <div class="form-group">
                            <label>Tahun Angkatan</label>
                            <select class="form-control select2" name="id_thn_angkatan" style="width: 100%;" required>
                                @foreach($thn_angkatan as $data)
                                    <option value="{{ $data->id }}">{{ $data->thn_lalu }}/{{ $data->thn_depan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mata Pelajaran</label>
                            <select class="form-control select2" name="id_mata_pelajaran" style="width: 100%;" required>
                                @foreach($mata_pelajaran as $data)
                                    <option value="{{ $data->id }}">{{ $data->mata_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Semester</label><br>
                            <input type="radio" name="semester" value="1" id="semester_1"  checked required> I
                            <input type="radio" name="semester" value="2" id="semester_2" required> II
                        </div>
                        <div class="form-group">
                            <label>Guru</label>
                            <select class="form-control select2" name="id_guru" style="width: 100%;" required>
                                <option>Pilih Nama Guru</option>
                                @foreach($guru as $data)
                                    <option value="{{ $data->id }}">{{ $data->kode }} - {{ $data->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Judul Soal</label>
                            <div class="custom-file">
                                <textarea type="input" class="form-control" name="judul_soal" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pilihan Jenis Kelas</label>
                            <select class="form-control select2" name="jenis_kelas" style="width: 100%;" required>
                                <option>Semua Jenis Kelas</option>
                                @foreach($group_jenis_kelas as $jenis_kelas=> $data)
                                    <option value="{{ $jenis_kelas }}">{{ $jenis_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pilihan Kelas</label>
                            <select class="form-control select2" name="kelas" style="width: 100%;" required>
                                <option>Semua Kelas</option>
                                @foreach($group_kelas as $kelas=> $data)
                                    <option value="{{ $kelas }}">{{ $kelas }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Jenis Huruf</label><br>
                            <input type="radio" name="status_lagunge" value="0" id="status_lagunge_0" checked required> Alfabet <br>
                            <input type="radio" name="status_lagunge" value="1" id="status_lagunge_1" required> Unik<br>
                            <small style="color: orange;">*pilih jenis huruf selain menggunakan huruf alfabet</small>
                        </div>
                        <div class="form-group" >
                            <label>Perhitungan Waktu Soal</label><br>
                            <input type="radio" name="status_waktu" value="1" id="status_waktu_1" required onchange="timeClick(1)"> Waktu Persoal<br>
                            <input type="radio" name="status_waktu" value="0" id="status_waktu_0" required onchange="timeClick(0)"> Waktu Seluruh Soal <br>
                        </div>
                        <div class="form-group" id="time">
                            <label for="exampleInputFile">Durasi Soal</label>
                            <div class="custom-file">
                                {{--<input type="time" class="form-control" name="time" value="00:00">--}}
                                <div class="row">
                                    {{--@if(!empty($soal->waktu_kerja))--}}
                                    {{--@endif--}}
                                     <div class="col-md-6">
                                        <input type="number" min="0" max="24" class="form-control" name="jam"  placeholder="Jam" >
                                    </div>
                                    <div class="col-md-6">
                                        <input type="number" min="0" max="59" class="form-control" name="menit" placeholder="Menit">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <small>Isilah data tema soal dengan sebenar-benarnya</small>
                        <button type="submit" class="btn btn-success float-right">Proses</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
<!-- /.content -->

@stop

@section('jsContainer')
    <script src="{{ asset('admin_asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin_asset/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function () {

            $('#time').hide();

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            timeClick =function(value){
                if(value==1){
                    $('#time').hide();
                }else{
                    $('#time').show();
                }
            }

            $('.select2').select2()

            $('#table-data').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            edit = function (id) {
                $.ajax({
                    url:  '{{ url('soal') }}/'+id+'/edit',
                    type: 'get',
                    success :function (result) {
                        console.log(result);
                        $('[name="id_guru"]').val(result.id_guru).trigger('change');
                        $('[name="judul_soal"]').text(result.judul_soal);
                        $('[name="jenis_kelas"]').val(result.jenis_kelas).trigger('change');
                        $('[name="id_thn_angkatan"]').val(result.id_thn_angkatan).trigger('change');
                        $('[name="id_mata_pelajaran"]').val(result.id_mata_pelajaran).trigger('change');
                        $('[name="kelas"]').val(result.kelas).trigger('change');
                        $('[name="_method"]').val("put");
//                        $('[name="time"]').val(result.time);

                        if(result.status_waktu==1){
                            $('#status_waktu_1').prop('checked',true);
                        }else{
                            $('#status_waktu_0').prop('checked',true);
                        }

                        if(result.status_lagunge==1){
                            $('#status_lagunge_1').prop('checked',true);
                        }else{
                            $('#status_lagunge_0').prop('checked',true);
                        }

                        if(result.semester==1){
                            $('#semester_1').prop('checked',true);
                        }else{
                            $('#semester_2').prop('checked',true);
                        }

                        if(result.status_waktu==0){
                            $('#time').show();
                            var time = result.time.split(':');
                            $('[name="jam"]').val(time[0]);
                            $('[name="menit"]').val(time[1]);
                        }else{
                            $('#time').hide();
                        }
                        $('#form').attr('action','{{ url('soal') }}/'+id);
                        $('#modal-default-proses').modal('show');
                    }
                });
            }

            ubah_status_aktif = function (id) {
                $.ajax({
                    url:'{{ url('statu-update') }}',
                    type:'post',
                    data: {
                        '_token':'{{ csrf_token() }}',
                        '_method':'put',
                        'id':id
                    },success: function (res) {
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        })
                        setTimeout(5000);
                        window.location.reload();
                    }
                })
            }

            upload = function (id) {
                $('[name="id_tema_soal"]').val(id);
                $('#modal-default').modal('show');
            }


            onDelete=function (id) {
                if(confirm('Apakah anda yakin menghapus data ... ?')){
                    $.ajax({
                        url:'{{ url('soal') }}/'+id,
                        type:'post',
                        data:{
                            '_method':'delete',
                            'id':id,
                            '_token':'{{ csrf_token() }}'
                        },success: function (res) {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            })
                            setTimeout(5000);
                            window.location.reload();
                        }
                    })
                }else{
                    Toast.fire({
                        icon: 'info',
                        title: 'Proses dibatankan'
                    })
                }
            }

            bsCustomFileInput.init();
        });
    </script>
@stop