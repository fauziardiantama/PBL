<h5>Dokumen Pengajuan</h5>
<div class="mb-5">
    <table class="table table-bordered">
      <tr>
          <th>#</th>
          <th>jenis_surat</th>
          <th>nomor_surat</th>
          <th>file_surat</th>
      </tr>
      @if($magang->surat_magang()->exists())
        @foreach($magang->surat_magang as $surat)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ ($surat->jenis_surat == 1)? 'surat pengantar' : 'surat serah terima' }}</td>
        <td>{{ $surat->nomor_surat }}</td>
        <td><a href="{{ url('documents/pengajuan-instansi/'.$surat->file_surat) }}">{{ $surat->file_surat }}</a></td>                        
      </tr>
        @endforeach
        @else
        <tr>
            <td colspan="4" class="text-center">Belum ada dokumen</td>
        </tr>
        @endif
    </table>
    <dl class="row">
        <dt class="col-sm-4">Status pengajuan</dt>
        <dd class="col-sm-8">{!! ($magang->status_pengajuan_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($magang->status_pengajuan_instansi === 0)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
        @if($magang->id_status_daftar == 3 && !$magang->surat_magang()->where('jenis_surat',1)->exists())
        <dt class="col-sm-4">Surat Pengantar</dt>
        <dt class="col-sm-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-surat-pengantar">
                Upload Surat Pengantar
            </button>
        </dt>
        @elseif($magang->id_status_daftar == 3 && $magang->status_pengajuan_instansi == 0)
        <dt class="col-sm-4">Surat Pengantar</dt>
        <dt class="col-sm-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit-surat-pengantar">
                Upload Surat Pengantar
            </button>
        </dt>
        @endif
        @if($magang->id_status_daftar == 3 && !$magang->surat_magang()->where('jenis_surat',2)->exists())
        <dt class="col-sm-4">Surat Serah Terima</dt>
        <dt class="col-sm-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-surat-serah-terima">
                Download Surat Serah Terima
            </button>
        </dt>
        @elseif($magang->id_status_daftar == 3)
        <dt class="col-sm-4">Surat Serah Terima</dt>
        <dt class="col-sm-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit-surat-serah-terima">
                Download Surat Serah Terima
            </button>
        </dt>
        @endif
    </dl>
</div>
<h5>Dokumen Jawaban</h5>
<div class="mb-5">
    <dl class="row">
        @if($magang->surat_jawaban()->exists())
        <dl class="row w-100">
            <dt class="col-4">Surat jawaban</dt>
            <dd class="col-8">
                <a href="{{ url('documents/jawaban-instansi/'.$magang->surat_jawaban->file_surat) }}">{{ $magang->surat_jawaban->file_surat }}</a>
            </dd>
        </dl>
        <dt class="col-4">Status jawaban</dt>
        <dd class="col-8">{!! ($magang->status_diterima_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($magang->status_diterima_instansi === 0)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
        @endif
        @if(!$magang->surat_jawaban()->exists())
        <dt class="col-4">Surat jawaban</dt>
        <dt class="col-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-surat-jawaban">
                Upload Surat Jawaban
            </button>
        </dt>
        @elseif($magang->status_diterima_instansi == 0)
        <dt class="col-4">Surat Pengantar</dt>
        <dt class="col-8">
            <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit-surat-jawaban">
                Ubah Surat Jawaban
            </button>
        </dt>
        @endif
    </dl>
</div>