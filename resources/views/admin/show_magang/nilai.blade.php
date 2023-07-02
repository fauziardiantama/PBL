<h5>Nilai Bimbingan Instansi</h5>
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
                <td>{{ $nilai->parameter->parameter }}</td>
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
            @if($nilaiinstansi != null)
            <a href="{{ url('documents/nilai-instansi/'.$nilaiinstansi->dokumen) }}" class="btn btn-sm btn-primary m-1">Download dokumen</a>
            <a href="{{ url('admin/bimbingan/'.$magang->id_magang.'/nilaiinstansi/approve') }}" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a>
            <a href="{{ url('admin/bimbingan/'.$magang->id_magang.'/nilaiinstansi/reject') }}" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a>
            @else
            Belum ada dokumen
            @endif
        </dd>
        <dt class="col-sm-4">Dokumen Nilai Instansi</dt>
        <dd class="col-sm-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-nilai-instansi">
                Masukkan Nilai
            </button>
        </dd>
    </dl>
</div>
<h5>Nilai Bimbingan dosen</h5>
<div class="mb-5">
    <table class="table table-bordered">
      <tr>
          <th>#</th>
          <th>parameter</th>
          <th>nilai</th>
      </tr>
    @if($nilaibimbingan != null)
        @foreach($nilaibimbingan as $nilai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $nilai->parameter->parameter }}</td>
                <td>{{ $nilai->nilai }}</td>
            </tr>
        @endforeach
    @else
    <tr>
        <td colspan="3" class="text-center">Belum ada nilai</td>
    </tr>
    @endif
    </table>
</div>
<h5>Nilai Seminar</h5>
<div class="mb-5">
    <table class="table table-bordered">
      <tr>
          <th>#</th>
          <th>parameter</th>
          <th>nilai pembimbing</th>
          <th>nilai penguji</th>
          <th>nilai</th>
      </tr>
    @if($nilaiseminar != null)
        @foreach($nilaiseminar as $nilai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $nilai->parameter->parameter }}</td>
                <td>{{ $nilai->nilai_pembimbing }}</td>
                <td>{{ $nilai->nilai_penguji }}</td>
                <td>{{ $nilai->nilai }}</td>
            </tr>
        @endforeach
    @else
    <tr>
        <td colspan="5" class="text-center">Belum ada nilai</td>
    </tr>
    @endif
    </table>
 </div>
 <h5>Nilai Akhir</h5>
 <div class="mb-5">
    <dl class="row">
        <dt class="col-sm-4">Nilai Akhir</dt>
        @if(Request::get('editnilaiakhir') && Request::get('editnilaiakhir') == 'true')
        <dd class="col-sm-8">
            <form action="{{ url('admin/magang/'.$magang->id_magang.'/nilaiakhir') }}" method="post">
                @csrf
                @method('put')
                <input type="text" name="nilai_akhir" class="form-control" value="{{ $nilaiakhir->nilai_akhir }}">
                <button type="submit" class="btn btn-sm btn-success mt-2">Simpan</button>
            </form>
        </dd>
        @else
            <dd class="col-sm-8">
                @if($nilaiakhir != null)
                {{ $nilaiakhir->nilai_akhir }}
                <a href="{{ url('admin/magang/'.$magang->id_magang.'?active=nilai&editnilaiakhir=true') }}" class="btn btn-sm btn-success">Edit</a>
                @else
                <a href="{{ url('admin/magang/'.$magang->id_magang.'/kalkulasi') }}" class="btn btn-sm btn-success">Hitung nilai</a>
                @endif
            </dd>
        @endif
    </dl>
 </div>