@if ($magang->status_dosen == 1)
<dl class="row">
    @if($bimbingandosen->count() > 0)
        @foreach($bimbingandosen as $bimbingan)
            <dt class="col-sm-4">{{ $bimbingan->tanggal }}</dt>
            <dd class="col-sm-5">{{ $bimbingan->data_bimbingan }}</dd>
            <dd class="col-sm-3">{!! ($bimbingan->status === null) ? "<span class='badge bg-gray'>menunggu</span>" : (($bimbingan->status === 0||$bimbingan->status === -1)? "<span class='badge bg-danger'>ditolak</span>" : "<span class='badge bg-success'>diterima</span>") !!}</dd>
        @endforeach
    @else
        <dt class="col-sm-12">Belum ada bimbingan</dt>
    @endif
</dl>
@elseif($magang->status_dosen === null)
<dl class="row">
    <h5>Bimbingan belum diverifikasi dosen</h5>
</dl>
@elseif($magang->status_dosen === 0 || $magang->status_dosen === -1)
<dl class="row">
    <h5>Bimbingan ditolak dosen</h5>
</dl>
@endif