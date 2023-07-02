<dl class="row">
    <dt class="col-sm-4">Tahun</dt>
    <dd class="col-sm-8">{{ $magang->Tahun->tahun }}</dd>
    <dt class="col-sm-4">Topik</dt>
    <dd class="col-sm-8">{{ $magang->topik->nama_topik }}</dd>
    <dt class="col-sm-4">Nama instansi</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->nama }}</dd>
    <dt class="col-sm-4">Dosen</dt>
    <dd class="col-sm-8">{{ (!$magang->dosen()->exists())? 'Belum ditentukan' : $magang->dosen->nama }} {!! ($magang->dosen()->exists())? (($magang->status_dosen === null)? '<span class="badge bg-gray">belum diverifikasi</span>': (($magang->status_dosen === 0)? '<span class="badge bg-danger">Ditolak</span>' : '<span class="badge bg-success">Disetujui</span>')) : ''  !!}</dd>
    </dd>
    <a href="{{ url('/mahasiswa/magang/daftar') }}" class="btn btn-sm text-white" style="background-color:#010080; border-color:#010080 ;">
        <i class="fas fa-plus"></i> Daftar Magang
    </a>
</dl>