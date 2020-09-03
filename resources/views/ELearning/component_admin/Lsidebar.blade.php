<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-2">
        @if(!empty($data_ujian))
        <h6>Pilihlah Jawaban Dibawah ini</h6>
        <p>Tekan/Klik jabawan yang anda yakin benar:</p>
        <table style="width: 100%">
            <tr>
                <td>No</td>
                <td colspan="5" style="text-align: center">Pilihan Jawaban</td>
            </tr>

            @if(!empty($data_ujian->listToKunciJawaban))
                @php($no=1)
                @foreach($data_ujian->listToKunciJawaban->sortBy('no_urut') as $pilihan_ganda)
                    <tr>
                        <form action="#" method="post" class="jawaban">
                            <td>{{ $pilihan_ganda->no_urut }} {{ csrf_field() }}</td>
                            <td><input name="jabawan_{{ $no }}" @if(!empty($pilihan_ganda->linkToKunciJabawan)) @if($pilihan_ganda->linkToKunciJabawan->jawaban == 'a') checked @endif @endif onclick="onSelected('{{ $id_siswa_ujian }}','{{ $id_siswa }}','{{ $pilihan_ganda->no_urut }}','{{ $pilihan_ganda->id }}','a')" type="radio" >A</td>
                            <td><input name="jabawan_{{ $no }}" @if(!empty($pilihan_ganda->linkToKunciJabawan)) @if($pilihan_ganda->linkToKunciJabawan->jawaban == 'b') checked @endif @endif onclick="onSelected('{{ $id_siswa_ujian }}','{{ $id_siswa }}','{{ $pilihan_ganda->no_urut }}','{{ $pilihan_ganda->id }}','b')" type="radio">B</td>
                            <td><input name="jabawan_{{ $no }}" @if(!empty($pilihan_ganda->linkToKunciJabawan)) @if($pilihan_ganda->linkToKunciJabawan->jawaban == 'c') checked @endif @endif onclick="onSelected('{{ $id_siswa_ujian }}','{{ $id_siswa }}','{{ $pilihan_ganda->no_urut }}','{{ $pilihan_ganda->id }}','c')" type="radio">C</td>
                            <td><input name="jabawan_{{ $no }}" @if(!empty($pilihan_ganda->linkToKunciJabawan)) @if($pilihan_ganda->linkToKunciJabawan->jawaban == 'd') checked @endif @endif onclick="onSelected('{{ $id_siswa_ujian }}','{{ $id_siswa }}','{{ $pilihan_ganda->no_urut }}','{{ $pilihan_ganda->id }}','d')" type="radio">D</td>
                            <td><input name="jabawan_{{ $no }}" @if(!empty($pilihan_ganda->linkToKunciJabawan)) @if($pilihan_ganda->linkToKunciJabawan->jawaban == 'e') checked @endif @endif onclick="onSelected('{{ $id_siswa_ujian }}','{{ $id_siswa }}','{{ $pilihan_ganda->no_urut }}','{{ $pilihan_ganda->id }}','e')" type="radio">E</td>
                        </form>
                    </tr>
                    @php($no++)
                @endforeach
            @endif
        </table>
        @endif
    </div>
</aside>

