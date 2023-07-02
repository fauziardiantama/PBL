<dl class="row">
    @if($bimbinganinstansi != null)
        @foreach($bimbinganinstansi as $bimbingan)
            <dt class="col-sm-3">{{ $bimbingan->tanggal }}</dt>
            <dd class="col-sm-5">{{ $bimbingan->data_bimbingan }}</dd>
            <dd class="col-sm-2">{{ ($bimbingan->status === null) ? 'Menunggu' : (($bimbingan->status === 0)? 'Ditolak' : 'Diterima') }}</dd>
            <dd class="col-sm-2">
                @if($bimbingan->status !== 1)<a href="{{ url('/admin/bimbingan/'.$magang->id_magang.'/instansi/'.$bimbingan->id_bimbingan_instansi.'/approve') }}" class="btn btn-success btn-sm"><i class="fas fa-check"></i></a>@endif
                @if($bimbingan->status !== 0)<a href="{{ url('/admin/bimbingan/'.$magang->id_magang.'/instansi/'.$bimbingan->id_bimbingan_instansi.'/reject') }}" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></a>@endif
            </dd>
        @endforeach
    @else
        <dt class="col-sm-12">Belum ada bimbingan</dt>
    @endif
</dl>