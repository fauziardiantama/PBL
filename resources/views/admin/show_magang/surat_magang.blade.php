<h5>Surat Pengajuan</h5>
<dl class="row">
    <dt class="col-sm-4">Status surat magang</dt>
    <dd class="col-sm-8">{!! ($magang->status_pengajuan_instansi === null ) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($magang->status_pengajuan_instansi === 0 || $magang->status_pengajuan_instansi === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
    @if($magang->surat_magang()->exists())
        @foreach($magang->surat_magang as $surat)
            <dt class="col-sm-4">{{ ($surat->jenis_surat == 1)? 'surat pengantar' : 'surat serah terima' }}</dt>
            <dd class="col-sm-8">
                <a href="{{ url('documents/pengajuan-instansi/'.$surat->file_surat) }}">{{ $surat->nomor_surat }}</a>
            </dd>
        @endforeach
            <dt class="col-sm-4">Setujui</dt>
            <dd>
                <a href="{{ url('admin/magang/'.$magang->id_magang.'/pengajuan-instansi/approve') }}" class="btn btn-sm btn-success">
                    <i class="fas fa-check"></i>
                </a>
                <a href="{{ url('admin/magang/'.$magang->id_magang.'/pengajuan-instansi/reject') }}" class="btn btn-sm btn-danger">
                    <i class="fas fa-times"></i>
                </a>
            </dd>
    @else
        <dt class="col-sm-12">Belum ada surat</dt>
    @endif
</dl>
<h5>Surat Jawaban</h5>
<dl class="row">
    <dt class="col-sm-4">Status surat diterima</dt>
    <dd class="col-sm-8">{!! ($magang->status_diterima_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($magang->status_diterima_instansi === 0 || $magang->status_diterima_instansi === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
    @if($magang->surat_jawaban()->exists())
        <dt class="col-sm-4">Surat jawaban</dt>
        <dd class="col-sm-8">
            <a href="{{ url('documents/jawaban-instansi/'.$magang->surat_jawaban->file_surat) }}">{{ $magang->surat_jawaban->file_surat }}</a>
        </dd>
        <dt class="col-sm-4">Setujui</dt>
        <dd>
            <a href="{{ url('admin/magang/'.$magang->id_magang.'/diterima-instansi/approve') }}" class="btn btn-sm btn-success">
                <i class="fas fa-check"></i>
            </a>
            <a href="{{ url('admin/magang/'.$magang->id_magang.'/diterima-instansi/reject') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-times"></i>
            </a>
        </dd>
    @else
        <dt class="col-sm-12">Belum ada surat jawaban</dt>
    @endif
</dl>              