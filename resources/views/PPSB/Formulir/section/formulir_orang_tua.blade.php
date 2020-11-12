<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title m-0" style="font-weight: bold">Formulir Identitas Orang Tua</h4>
        </div>
        <div class="card-body">
            <form method="post" action="{{ url('formulir-orang-tua') }}">
                {{ csrf_field() }}
                <ul style="padding: 0;"><h5 style="color: deepskyblue; font-weight: bold">Ayah/Wali</h5>
                    <li style="list-style-type: none; padding-left: 15px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nama Lengkap</label><label style="color: red">*</label>
                                    <input type="text" name="nama_ayah" value="{{ $data->LinkToOrangTua->nama_ayah }}" class="form-control" placeholder="Masukan nama lengkap ayah/wali" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. KTP</label><label style="color: red">*</label>
                                    <input type="text" name="no_ktp_ayah" value="{{ $data->LinkToOrangTua->no_ktp_ayah }}" class="form-control" placeholder="Masukan No. KTP" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pendidikan</label><label style="color: red">*</label>
                                    <input type="text" name="pendidikan_ayah" value="{{ $data->LinkToOrangTua->pendidikan_ayah }}" class="form-control" placeholder="Masukan Pendidikan Terakhir" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pekerjaan</label><label style="color: red">*</label>
                                    <input type="text" name="pekerjaan_ayah" value="{{ $data->LinkToOrangTua->pekerjaan_ayah }}" class="form-control" placeholder="Masukan Pekerjaan" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Alamat</label><label style="color: red">*</label>
                                    <input type="text" name="alamat_ayah" value="{{ $data->LinkToOrangTua->alamat_ayah }}" class="form-control" placeholder="Masukan Alamat" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Desa/Kelurahan</label><label style="color: red">*</label>
                                    <input type="text" name="desa_ayah" value="{{ $data->LinkToOrangTua->desa_ayah }}" class="form-control" placeholder="Masukan Desa/Kelurahan" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Provinsi</label><label style="color: red">*</label>
                                    <input type="text" name="provinsi_ayah" value="{{ $data->LinkToOrangTua->provinsi_ayah }}" class="form-control" placeholder="Masukan Provinsi" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kecamatan</label><label style="color: red">*</label>
                                    <input type="text" name="kecamatan_ayah" value="{{ $data->LinkToOrangTua->kecamatan_ayah }}" class="form-control" placeholder="Masukan Kecamatan" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. Handphone/Telp. Rumah</label><label style="color: red">*</label>
                                    <input type="text" name="no_hp_ayah" value="{{ $data->LinkToOrangTua->no_hp_ayah }}" class="form-control" placeholder="Masukan No. Handphone(Hp) atau telp. rumah" required>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <hr></hr>
                <ul style="padding: 0;"><h5 style="color: deepskyblue; font-weight: bold">Ibu/Wali</h5>
                    <li style="list-style-type: none; padding-left: 15px;">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Nama Lengkap</label><label style="color: red">*</label>
                                    <input type="text" name="nama_ibu" value="{{ $data->LinkToOrangTua->nama_ibu }}" class="form-control" placeholder="Masukan nama lengkap ibu/wali" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. KTP</label><label style="color: red">*</label>
                                    <input type="text" name="no_ktp_ibu" value="{{ $data->LinkToOrangTua->no_ktp_ibu }}" class="form-control" placeholder="Masukan No. KTP" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pendidikan</label><label style="color: red">*</label>
                                    <input type="text" name="pendidikan_ibu" value="{{ $data->LinkToOrangTua->pendidikan_ibu }}" class="form-control" placeholder="Masukan Pendidikan Terakhir" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pekerjaan</label><label style="color: red">*</label>
                                    <input type="text" name="pekerjaan_ibu" value="{{ $data->LinkToOrangTua->pekerjaan_ibu }}" class="form-control" placeholder="Masukan Pekerjaan" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Alamat</label><label style="color: red">*</label>
                                    <input type="text" name="alamat_ibu" value="{{ $data->LinkToOrangTua->alamat_ibu }}" class="form-control" placeholder="Masukan Alamat" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Desa/Kelurahan</label><label style="color: red">*</label>
                                    <input type="text" name="desa_ibu" value="{{ $data->LinkToOrangTua->desa_ibu }}" class="form-control" placeholder="Masukan Desa/Kelurahan" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Provinsi</label><label style="color: red">*</label>
                                    <input type="text" name="provinsi_ibu" value="{{ $data->LinkToOrangTua->provinsi_ibu }}"  class="form-control" placeholder="Masukan Provinsi" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Kecamatan</label><label style="color: red">*</label>
                                    <input type="text" name="kecamatan_ibu" value="{{ $data->LinkToOrangTua->kecamatan_ibu }}" class="form-control" placeholder="Masukan Kecamatan" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. Handphone/Telp. Rumah</label><label style="color: red">*</label>
                                    <input type="text" name="no_hp_ibu" value="{{ $data->LinkToOrangTua->no_hp_ibu }}" class="form-control" placeholder="Masukan No. Handphone(Hp) atau telp. rumah" required>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
                <hr>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Total Penghasilan</label>
                            <input type="radio" name="total_penghasilan" value="1" @if($data->LinkToOrangTua->total_penghasilan==1) checked @endif required> Kurang Dari 1 Juta
                            <input type="radio" name="total_penghasilan" value="2" @if($data->LinkToOrangTua->total_penghasilan==2) checked @endif required> 2-3 Juta
                            <input type="radio" name="total_penghasilan" value="3" @if($data->LinkToOrangTua->total_penghasilan==3) checked @endif required> 4-5 Juta
                            <input type="radio" name="total_penghasilan" value="4" @if($data->LinkToOrangTua->total_penghasilan==4) checked @endif required> 6-7 Juta
                            <input type="radio" name="total_penghasilan" value="5" @if($data->LinkToOrangTua->total_penghasilan==5) checked @endif required> Lebih dari 7 Juta
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