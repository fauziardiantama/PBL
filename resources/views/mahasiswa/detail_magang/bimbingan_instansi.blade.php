@if($bimbingan_instansi != null)
<div class="table-responsive">
    <table class="table">
@foreach($bimbingan_instansi as $b)
@if(Request::get('editinstansi') && Request::get('editinstansi') == $b->id_bimbingan_instansi  && $b->status == 0)
<form action="{{ url('/mahasiswa/magang/bimbingan/instansi/'.$b->id_bimbingan_instansi) }}" style="display:inline-flex;width:100%" method="post">
    @csrf
    @method('PUT')
    <tr>
        <th>{{ $b->tanggal }}</th>
        <td colspan="2">
            <input type="text" name="data_bimbingan" class="form-control" value="{{ $b->data_bimbingan }}">
        </td>
        <td>
            <button type="submit" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </button>
            <a href="{{ url('/mahasiswa/magang/magang?active=bimbinganinstansi') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-times"></i>
            </a>
        </td>
    </tr>
</form>
@else
    <tr>
        <th>{{ $b->tanggal }}</th>
        <td>{{ $b->data_bimbingan }}</td>
        <td>{!! ($b->status === null) ? "<span class='badge bg-gray'>menunggu</span>" : (($b->status === 0||$b->status === -1)? "<span class='badge bg-danger'>ditolak</span>" : "<span class='badge bg-success'>diterima</span>") !!}</td>
        <td>
            @if($b->status == 0)
            <a href="{{ url('/mahasiswa/magang?active=bimbinganinstansi&editinstansi='.$b->id_bimbingan_instansi) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i>
            </a>
            <a href="{{ url('/mahasiswa/magang/bimbingan/instansi/'.$b->id_bimbingan_instansi.'/delete') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-trash"></i>
            </a>
            @endif
        </td>
    </tr>
@endif
@endforeach
    </table>
</div>
@endif
<dt class="col-sm-12">
<a href="#" class="btn btn-sm text-white" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add-instansi">
    <i class="fas fa-plus"></i> Tambah
</a>
</dt>