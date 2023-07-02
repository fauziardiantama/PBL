<dl class="row">
    @if($rencana != null)
        @foreach($rencana as $r)
            @if(Request::get('editrencana') && Request::get('editrencana') == $r->id_rencana)
                @if($magang->id_status_daftar < 3 || $magang->status_dosen == 0)
                    <form action="{{ url('/mahasiswa/magang/rencana/'.$r->id_rencana) }}" style="display:inline-flex;width:100%" method="post">
                        @csrf
                        @method('PUT')
                        <dt class="col-sm-9">
                            <input type="text" name="kegiatan" class="form-control" value="{{ $r->kegiatan }}">
                        </dt>
                        <dd class="col-sm-3">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fas fa-check"></i>
                            </button>
                            <a href="{{ url('/mahasiswa/magang') }}" class="btn btn-sm btn-danger">
                                <i class="fas fa-times"></i>
                            </a>
                        </dd>
                    </form>
                @endif
            @else
                <dt class="col-sm-4">Minggu ke-{{ $r->minggu }}</dt>
                <dd class="col-sm-5">{{ $r->kegiatan }}</dd>
                @if($magang->id_status_daftar < 3 || $magang->status_dosen == 0)
                <dd class="col-sm-3">
                    <a href="{{ url('/mahasiswa/magang?editrencana='.$r->id_rencana) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                </dd>
                @endif
            @endif
        @endforeach
    @endif
    @if($magang->id_status_daftar < 3 || $magang->status_dosen == 0)
    <dt class="col-sm-12">
        <a href="#" class="btn btn-sm text-white" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add-rencana">
            <i class="fas fa-plus"></i> Tambah
        </a>
        <form action="{{ url('/mahasiswa/magang/rencana') }}" method="post" style="display:inline-flex">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger text-white">
                <i class="fas fa-trash"></i> Hapus rencana terakhir
            </button>
        </form>
    </dt>
    @endif
</dl>