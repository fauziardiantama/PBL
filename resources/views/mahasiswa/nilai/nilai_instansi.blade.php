<div class="mb-5">
    <table class="table table-bordered">
      <tr>
          <th>#</th>
          <th>parameter</th>
          <th>nilai</th>
      </tr>
    @if($nilaiinstansi != null && $nilaiinstansi->detail_nilai_instansi()->exists())
        @foreach($nilaiinstansi->detail_nilai_instansi()->orderBy('id_parameter', 'asc')->get() as $nilai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ($nilai->parameter()->exists())? $nilai->parameter->parameter : 'Parameter tidak diketahui' }}</td>
                <td>{{ $nilai->nilai }}</td>
            </tr>
        @endforeach
    @else
    <tr>
        <td colspan="3" class="text-center">Belum ada nilai</td>
    </tr>
    @endif
    </table>
    <dl class="row">
        <dt class="col-sm-4">Dokumen Nilai Instansi</dt>
        <dd class="col-sm-8">
            @if($nilaiinstansi == null)
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modal-add-dokumen">
                Upload dokumen
            </button>
            @elseif($nilaiinstansi->status !== 1)
            <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#modal-update-dokumen">
              Ubah dokumen
            </button>
            <a href="{{ url('documents/nilai-instansi/'.$nilaiinstansi->dokumen) }}" class="btn btn-sm btn-primary m-1">Download dokumen</a>
            @else
            <a href="{{ url('documents/nilai-instansi/'.$nilaiinstansi->dokumen) }}" class="btn btn-sm btn-primary m-1">Download dokumen</a>
            @endif
        </dd>
    </dl>
 </div>