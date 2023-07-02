<h5>Seminar</h5>
@if($seminar != null)
    <dl class="row">
        <dt class="col-sm-4">Judul kmm</dt>
        <dd class="col-sm-8">{{ $seminar->judul_kmm }}</dd>
        <dt class="col-sm-4">Nama mahasiswa</dt>
        <dd class="col-sm-8">{{ $magang->mahasiswa->nama }}</dd>
        <dt class="col-sm-4">NIM mahasiswa</dt>
        <dd class="col-sm-8">{{ $magang->mahasiswa->nim }}</dd>
        <dt class="col-sm-4">Tanggal daftar</dt>
        <dd class="col-sm-8">{{ $seminar->tgl_daftar }}</dd>
        <dt class="col-sm-4">Tanggal seminar</dt>
        <dd class="col-sm-8">{{ ($seminar->tgl_seminar != null)? $seminar->tgl_seminar : 'Belum ditentukan' }}</dd>
        <dt class="col-sm-4">Laporan kmm</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->draft_kmm) }}" target="_blank">{{ $seminar->draft_kmm }}</a></dd>
        <dt class="col-sm-4">KRS terbaru</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->krs) }}" target="_blank">{{ $seminar->krs }}</a></dd>
        <dt class="col-sm-4">Foto dokumentasi kmm</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->foto) }}" target="_blank">{{ $seminar->foto }}</a></dd>
        <dt class="col-sm-4">Status verifikasi</dt>
        <dd class="col-sm-8">{!! ($seminar->status === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($seminar->status === 0 || $seminar->status === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
        <dt class="col-sm-4">Penguji</dt>
        <dd class="col-sm-8">{{ ($dosenpenguji != null)? $dosenpenguji->nama : 'Belum ditentukan' }}</dd>
    </dl>
    @if($dosenpenguji == null)
    <form action="{{ url('admin/magang/'.$magang->id_magang.'/penguji') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="penguji">Penguji</label>
            <select class="form-control" id="penguji" name="penguji">
                <option value="">Pilih penguji</option>
                @foreach($dosenthistopik as $d)
                    <option value="{{ $d->id_dosen }}">{{ $d->nama }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Tentukan penguji</button>
    </form>
    @endif
@elseif($seminar === null && $magang->status_dosen == 1)
    <dl class="row">
        <h5>Belum ada seminar</h5>
    </dl>
@endif
<h5>Revisi</h5>
@if($revisi != null)
    <dl class="row">
        <dt class="col-sm-4">Nama mahasiswa</dt>
        <dd class="col-sm-8">{{ $magang->mahasiswa->nama }}</dd>
        <dt class="col-sm-4">NIM mahasiswa</dt>
        <dd class="col-sm-8">{{ $magang->mahasiswa->nim }}</dd>
        <dt class="col-sm-4">Tanggal Upload</dt>
        <dd class="col-sm-8">{{ $revisi->tgl_upload }}</dd>
        <dt class="col-sm-4">Laporan Revisi</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->laporan_revisi) }}" target="_blank">{{ $revisi->laporan_revisi }}</a></dd>
        <dt class="col-sm-4">Selesai KMM</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->selesai_kmm) }}" target="_blank">{{ $revisi->selesai_kmm }}</a></dd>
        <dt class="col-sm-4">Daftar Hadir</dt>
        <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->daftar_hadir) }}" target="_blank">{{ $revisi->daftar_hadir }}</a></dd>
        <dt class="col-sm-4">Status verifikasi</dt>
        <dt class="col-sm-8">{!! ($revisi->status === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($revisi->status === 0 || $revisi->status === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}
    </dl>
@else
<h5>Belum ada revisi</h5>
@endif