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
{{-- <a href="{{ url('dosen/revisi/'.$magang->id_magang.'/approve') }}" class="btn btn-primary">Approve</a>
<a href="{{ url('dosen/revisi/'.$magang->id_magang.'/reject') }}" class="btn btn-danger">Reject</a> --}}
@if($revisi->status != 1) <a href="{{ url('dosen/seminardanrevisi/'.$magang->id_magang.'/revisi/approve') }}" class="btn btn-primary">Approve</a> @endif
@if($revisi->status == 1 || $revisi->status === null)<a href="{{ url('dosen/seminardanrevisi/'.$magang->id_magang.'/revisi/reject') }}" class="btn btn-danger">Reject</a> @endif
@else
<h5>Belum ada revisi</h5>
@endif