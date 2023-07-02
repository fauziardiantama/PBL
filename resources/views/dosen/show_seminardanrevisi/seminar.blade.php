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
    <dt class="col-sm-8">{!! ($seminar->status === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($seminar->status === 0 || $seminar->status === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}
</dl>
@if($seminar->status != 1) <a href="{{ url('dosen/seminardanrevisi/'.$magang->id_magang.'/seminar/approve') }}" class="btn btn-primary">Approve</a> @endif
@if($seminar->status == 1 || $seminar->status === null)<a href="{{ url('dosen/seminardanrevisi/'.$magang->id_magang.'/seminar/reject') }}" class="btn btn-danger">Reject</a> @endif