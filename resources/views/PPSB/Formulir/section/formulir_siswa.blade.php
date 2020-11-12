<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title m-0" style="font-weight: bold">Account Pengguna</h4>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>:</th>
                    <th>{{ $data->name }}</th>
                </tr>
                <tr>
                    <th>Email</th>
                    <th>:</th>
                    <th>{{ $data->email }}</th>
                </tr>
                <tr>
                    <th>Passowrd</th>
                    <th>:</th>
                    <th>Password anda telah terenkripsi</th>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title m-0" style="font-weight: bold">Calon Kategori Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('kategori-siswa') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-3">
                        <!-- text input -->
                        <div class="form-group">
                            <input type="checkbox" name="asrama" @if($data->LinkToKategoriSiswa->asrama=='on') checked @endif> Asrama
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="checkbox" name="ciber" @if($data->LinkToKategoriSiswa->ciber=='on') checked @endif> Ciber
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input type="checkbox" name="semi_ciber" @if($data->LinkToKategoriSiswa->semi_ciber=='on') checked @endif> Semi Ciber
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Pililah kategori calon siswa')"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title m-0" style="font-weight: bold">Formulir Data Calon Siswa</h4>
        </div>
        <div class="card-body">
            <form action="{{ url('formulir') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Nama Lengkap</label><label style="color: red">*</label>
                            <input type="text" class="form-control" name="nama" value="{{ $data->LinkToCalonSiswa->nama }}" placeholder="Masukan nama calon siswa" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>NIS Nasional</label><label style="color: orange">*</label>
                            <input type="text" class="form-control" name="nisn" value="{{ $data->LinkToCalonSiswa->nisn }}" placeholder="Masukan Nis Nasional" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Tempat/Tanggal Lahir</label><label style="color: red">*</label>
                            <input type="text" class="form-control" name="tempat_lahir" value="{{ $data->LinkToCalonSiswa->tempat_lahir }}" placeholder="Masukan Tepat Lahir" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label style="color: white">-</label><label style="color: red">*</label>
                            <input type="date" class="form-control" name="tgl_lahir" value="{{ $data->LinkToCalonSiswa->tgl_lahir }}" placeholder="Masukan Tanggal Lahir" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Anak Ke</label><label style="color: red">*</label>
                            <input type="number" min="0" max="20" name="anak_ke" value="{{ $data->LinkToCalonSiswa->anak_ke }}" class="form-control" placeholder="Masukan anak Ke" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >Dari</label><label style="color: red">*</label>
                            <input type="number" class="form-control" name="dari" value="{{ $data->LinkToCalonSiswa->dari }}" placeholder="Masukan dari berapa bersaudara" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Jenis Kelamin</label><label style="color: red">*</label>
                            <input type="radio" name="jenis_kelamin" value="L" @if($data->LinkToCalonSiswa->jenis_kelamin=="L") checked @endif required> Laki-laki
                            <input type="radio" name="jenis_kelamin" value="P" @if($data->LinkToCalonSiswa->jenis_kelamin=="P") checked @endif> Perempuan
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Asal Sekolah</label><label style="color: red">*</label>
                            <input type="text" class="form-control" name="asal_sekolah" value="{{ $data->LinkToCalonSiswa->asal_sekolah }}"  placeholder="Masukan asal sekolah" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>No. Kartu Keluarga</label>
                            <input type="text" class="form-control" name="no_kartu_keluarga" value="{{ $data->LinkToCalonSiswa->no_kartu_keluarga }}" placeholder="Masukan No. Kartu keluarga" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>No. KPS/KKS</label><label style="color: orange">*</label>
                            <input type="text" class="form-control" name="no_kps" value="{{ $data->LinkToCalonSiswa->no_kps }}" placeholder="Masukan KPS/KKS" >
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <!-- text input -->
                        <div class="form-group">
                            <label>No. KIP</label><label style="color: orange">*</label>
                            <input type="text" class="form-control" name="no_kip" value="{{ $data->LinkToCalonSiswa->no_kip }}" placeholder="Masukan KP" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Prestasi akademik yang pernah diraih</label><label style="color: orange">*</label>
                            <textarea class="form-control" name="prestasi_akademik" placeholder="Masukan prestasi disini">{{ $data->LinkToCalonSiswa->prestasi_akademik }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <!-- text input -->
                        <div class="form-group">
                            <label>Prestasi Non akademik yang pernah diraih</label><label style="color: orange">*</label>
                            <textarea class="form-control" name="prestasi_non_akademik" placeholder="Masukan prestasi seperti bidang olah raga, kesenian, dll">{{ $data->LinkToCalonSiswa->prestasi_non_akademik }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Pastikan formulir yang anda isi sudah benar.')"><i class="fa fa-check"></i> Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>