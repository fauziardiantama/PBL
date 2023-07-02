<dl class="row">
    <dt class="col-sm-4">Nama instansi</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->nama }}</dd>
    <dt class="col-sm-4">E-mail</dt>
    <dd class="col-sm-8"> {{ $magang->Instansi->email }}</dd>
    <dt class="col-sm-4">Alamat</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->alamat }}</dd>
    <dt class="col-sm-4">Telepon</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->no_telp }}</dd>
    <dt class="col-sm-4">Website</dt>
    <dd class="col-sm-8">{{ $magang->Instansi->web }}</dd>
    <dt class="col-sm-4">Status diterima</dt>
    <dd class="col-sm-8">{!! ($magang->status_diterima_instansi) ? "<span class='badge bg-success'>diterima</span>":"<span class='badge bg-danger'>ditolak</span>" !!}</dd>
</dl>