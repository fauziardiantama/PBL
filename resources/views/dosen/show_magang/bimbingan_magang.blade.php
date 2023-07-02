@if ($magang->status_dosen == 1)
<h5>Daftar Bimbingan</h5>
<dl class="row">
    @if($bimbingan->count() > 0)
        @foreach($bimbingan as $bimbingan)
            <dt class="col-sm-3">{{ $bimbingan->tanggal }}</dt>
            <dd class="col-sm-4">{{ $bimbingan->data_bimbingan }}</dd>
            <dd class="col-sm-2">{!! ($bimbingan->status === null) ? "<span class='badge bg-gray'>menunggu</span>" : (($bimbingan->status === 0||$bimbingan->status === -1)? "<span class='badge bg-danger'>ditolak</span>" : "<span class='badge bg-success'>diterima</span>") !!}</dd>
            <dd class="col-sm-3">
                @if($bimbingan->status !== 1)<a href="{{ url('/dosen/magang/'.$magang->id_magang.'/bimbingan/'.$bimbingan->id_bimbingan_dosen.'/approve') }}" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>@endif
                @if($bimbingan->status !== 0)<a href="{{ url('/dosen/magang/'.$magang->id_magang.'/bimbingan/'.$bimbingan->id_bimbingan_dosen.'/reject') }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>@endif
            </dd>
        @endforeach
    @else
        <dt class="col-sm-12">Belum ada bimbingan</dt>
    @endif
</dl>
@elseif($magang->status_dosen === null)
<dl class="row">
    <h5>Konfirmasi Bimbingan</h5>
    <dt class="col-sm-6">
        <a href="{{ url('/dosen/magang/'.$magang->id_magang.'/approve') }}" class="btn btn-primary">terima</a>
    </dt>
    <dd class="col-sm-6">
        <a href="{{ url('/dosen/magang/'.$magang->id_magang.'/reject') }}" class="btn btn-danger">Tolak</a>
    </dd>
</dl>
@elseif($magang->status_dosen === 0 || $magang->status_dosen === -1)
<dl class="row">
    <h5>Bimbingan ditolak dosen</h5>
</dl>
@endif