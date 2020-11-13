<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h4 class="card-title m-0" style="font-weight: bold">Daftar Berkas</h4>
        </div>
        <div class="card-body">
            Daftar berkas yang harus anda upload
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Deskripsi</th>
                    <th>Format Berkas</th>
                    <th style="width: 40px">Status</th>
                    <th style="width: 40px">Aksi</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($berkas))
                    @php($no=1)
                    @foreach($berkas as $data_berkas)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $data_berkas->deskripsi }}</td>
                            <td>
                                {{ $data_berkas->format_berkas }}
                            </td>
                            <td>
                                @if(!empty($data->LinkToBerkas->where('id_berkas', $data_berkas->id)->first()))
                                    <span class="badge bg-success">Berkas telah diupload</span>
                                @else
                                    <span class="badge bg-danger">Berkas belum tersedia</span>
                                @endif
                            </td>
                            <td><button class="btn btn-success" onclick="upload_berkas('{{ $data_berkas->id }}')">Upload</button></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
