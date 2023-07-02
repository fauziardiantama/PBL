<dl class="row">
    @if($rencana != null)
        @foreach($rencana as $r)
                <dt class="col-sm-6">Minggu ke-{{ $r->minggu }}</dt>
                <dd class="col-sm-6">{{ $r->kegiatan }}</dd>
        @endforeach
    @endif
</dl>