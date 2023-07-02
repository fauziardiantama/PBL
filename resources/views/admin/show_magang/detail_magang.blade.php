<h5>Mahasiswa</h5>
<dl class="row">
    <dt class="col-sm-4">NIM</dt>
    <dd class="col-sm-8">{{ $magang->mahasiswa->nim }}</dd>
    <dt class="col-sm-4">Nama</dt>
    <dd class="col-sm-8">{{ $magang->mahasiswa->nama }}</dd>
    <dt class="col-sm-4">No. Telp</dt>
    <dd class="col-sm-8">{{ $magang->mahasiswa->no_telp }}</dd>
</dl>
<h5>Magang</h5>
<dl class="row">
    <dt class="col-sm-4">Tahun</dt>
    <dd class="col-sm-8">{{ $magang->Tahun->tahun }}</dd>
    <dt class="col-sm-4">Topik</dt>
    <dd class="col-sm-8">{{ $magang->topik->nama_topik }}</dd>
    <dt class="col-sm-4">Nama instansi</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->nama }}</dd>
    <dt class="col-sm-4">Dosen</dt>
    <dd class="col-sm-8">{{ $magang->Dosen->nama }}
    </dd>
</dl>