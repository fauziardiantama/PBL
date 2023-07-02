@extends('mahasiswa.layouts.base')
@section('title', 'Magang')
@section('path')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Magang</li>
@endsection
@section('content')
    @include('partials.simple-dataview-with-navbar', [
        'list' => [
            [
                'title' => 'Detail Magang',
                'id' => 'detailmagang',
                'value' => view('mahasiswa.detail_magang.detail_magang', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailmagang') ? true : false,
            ],
            [
                'title' => 'Detail Instansi',
                'id' => 'detailinstansi',
                'value' => view('mahasiswa.detail_magang.detail_instansi', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailinstansi') ? true : false,
            ],
            [
                'title' => 'Rencana Magang',
                'id' => 'rencanamagang',
                'value' => view('mahasiswa.detail_magang.rencana_magang', compact('magang','rencana'))->render(),
                'status' => ($magang->instansi()->exists() && ($magang->instansi->status_instansi == 0 || $magang->instansi->status_instansi == -1) )? false : true ,
                'active' => ($magang->instansi()->exists() && ($magang->instansi->status_instansi == 0 || $magang->instansi->status_instansi == -1) && Request::get('active') && Request::get('active') == 'rencanamagang') ? true : false,
            ],
            [
                'title' => 'Surat Magang',
                'id' => 'suratmagang',
                'value' => view('mahasiswa.detail_magang.surat_magang', compact('magang'))->render(),
                'status' => ($magang->id_status_daftar < 3)? false : true,
                'active' => ($magang->id_status_daftar < 3 && Request::get('active') && Request::get('active') == 'suratmagang') ? true : false,
            ],
            [
                'title' => 'Bimbingan Dosen',
                'id' => 'bimbingandosen',
                'value' => view('mahasiswa.detail_magang.bimbingan_dosen', compact('bimbingan'))->render(),
                'status' => ($magang->id_status_daftar < 5)? false : true,
                'active' => ($magang->id_status_daftar < 5 && Request::get('active') && Request::get('active') == 'bimbingandosen') ? true : false,
            ],
            [
                'title' => 'Bimbingan Instansi',
                'id' => 'bimbinganinstansi',
                'value' => view('mahasiswa.detail_magang.bimbingan_instansi', compact('bimbingan_instansi'))->render(),
                'status' => ($magang->id_status_daftar < 5)? false : true,
                'active' => ($magang->id_status_daftar < 5 && Request::get('active') && Request::get('active') == 'bimbinganinstansi') ? true : false,
            ],
        ],
    ])
@endsection
@section('modal')
    @if($magang->id_status_daftar > 4)
        @include('partials.simple-modal-form', ['title' => 'Tambah Bimbingan Dosen',
            'id' => 'modal-add-dosen',
            'form' => [
                'action' => url('/mahasiswa/magang/bimbingan/dosen'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'Data bimbingan',
                        'type' => 'text',
                        'name' => 'data_bimbingan',
                        'disabled' => false,
                        'value' => old('data_bimbingan')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])
        @include('partials.simple-modal-form', ['title' => 'Tambah Bimbingan Instansi',
            'id' => 'modal-add-instansi',
            'form' => [
                'action' => url('/mahasiswa/magang/bimbingan/instansi'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'Data bimbingan',
                        'type' => 'text',
                        'name' => 'data_bimbingan',
                        'disabled' => false,
                        'value' => old('data_bimbingan')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])
    @endif
    @if($magang->id_status_daftar == 3 && !$magang->surat_magang()->where('jenis_surat',1)->exists())
        @include('partials.simple-modal-form', ['title' => 'Upload surat pengantar',
            'id' => 'add-surat-pengantar',
            'form' => [
                'action' => url('/mahasiswa/magang/pengajuan'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'File surat',
                        'type' => 'file',
                        'name' => 'file_surat',
                        'disabled' => false,
                        'value' => old('file_surat')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])    
    @elseif($magang->id_status_daftar == 3 && $magang->status_pengajuan_instansi == 0)
        @include('partials.simple-modal-form', ['title' => 'Upload surat pengantar',
            'id' => 'edit-surat-pengantar',
            'form' => [
                'action' => url('/mahasiswa/magang/pengajuan'),
                'method' => 'put',
                'inputs' => [
                    [
                        'label' => 'File surat',
                        'type' => 'file',
                        'name' => 'file_surat',
                        'disabled' => false,
                        'value' => old('file_surat')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ]) 
    @endif
    @if($magang->id_status_daftar == 3 && !$magang->surat_magang()->where('jenis_surat',2)->exists())
        @include('partials.simple-modal-form', ['title' => 'Buat surat serah terima magang',
            'id' => 'add-surat-serah-terima',
            'form' => [
                'action' => url('/mahasiswa/magang/serah-terima'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'Nama mahasiswa',
                        'type' => 'text',
                        'name' => 'nama_mahasiswa',
                        'disabled' => false,
                        'value' => old('nama_mahasiswa')
                    ],
                    [
                        'label' => 'NIM mahasiswa',
                        'type' => 'text',
                        'name' => 'nim',
                        'disabled' => false,
                        'value' => old('nim')
                    ],
                    [
                        'label' => 'Nama pembimbing',
                        'type' => 'text',
                        'name' => 'nama_pembimbing',
                        'disabled' => false,
                        'value' => old('nama_pembimbing')
                    ],
                    [
                        'label' => 'NIK pembimbing',
                        'type' => 'text',
                        'name' => 'nik',
                        'disabled' => false,
                        'value' => old('nik')
                    ],
                    [
                        'label' => 'Nomor telepon pembimbing',
                        'type' => 'text',
                        'name' => 'nomor_telepon_pembimbing',
                        'disabled' => false,
                        'value' => old('nomor_telepon_pembimbing')
                    ],
                    [
                        'label' => 'Nama Instansi',
                        'type' => 'text',
                        'name' => 'nama_instansi',
                        'disabled' => false,
                        'value' => old('nama_instansi')
                    ],
                    [
                        'label' => 'Alamat Instansi',
                        'type' => 'text',
                        'name' => 'alamat_instansi',
                        'disabled' => false,
                        'value' => old('alamat_instansi')
                    ],
                    [
                        'label' => 'Rencana Judul',
                        'type' => 'text',
                        'name' => 'rencana_judul',
                        'disabled' => false,
                        'value' => old('rencana_judul')
                    ],
                    [
                        'label' => 'Tanggal mulai',
                        'type' => 'date',
                        'name' => 'tanggal_mulai',
                        'disabled' => false,
                        'value' => old('tanggal_mulai')
                    ],
                    [
                        'label' => 'Tanggal selesai',
                        'type' => 'date',
                        'name' => 'tanggal_selesai',
                        'disabled' => false,
                        'value' => old('tanggal_selesai')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ]) 
    @elseif($magang->id_status_daftar == 3)
        @include('partials.simple-modal-form', ['title' => 'Buat surat serah terima magang',
            'id' => 'edit-surat-serah-terima',
            'form' => [
                'action' => url('/mahasiswa/magang/serah-terima'),
                'method' => 'put',
                'inputs' => [
                    [
                        'label' => 'Nama mahasiswa',
                        'type' => 'text',
                        'name' => 'nama_mahasiswa',
                        'disabled' => false,
                        'value' => old('nama_mahasiswa')
                    ],
                    [
                        'label' => 'NIM mahasiswa',
                        'type' => 'text',
                        'name' => 'nim',
                        'disabled' => false,
                        'value' => old('nim')
                    ],
                    [
                        'label' => 'Nama pembimbing',
                        'type' => 'text',
                        'name' => 'nama_pembimbing',
                        'disabled' => false,
                        'value' => old('nama_pembimbing')
                    ],
                    [
                        'label' => 'NIK pembimbing',
                        'type' => 'text',
                        'name' => 'nik',
                        'disabled' => false,
                        'value' => old('nik')
                    ],
                    [
                        'label' => 'Nomor telepon pembimbing',
                        'type' => 'text',
                        'name' => 'nomor_telepon_pembimbing',
                        'disabled' => false,
                        'value' => old('nomor_telepon_pembimbing')
                    ],
                    [
                        'label' => 'Nama Instansi',
                        'type' => 'text',
                        'name' => 'nama_instansi',
                        'disabled' => false,
                        'value' => old('nama_instansi')
                    ],
                    [
                        'label' => 'Alamat Instansi',
                        'type' => 'text',
                        'name' => 'alamat_instansi',
                        'disabled' => false,
                        'value' => old('alamat_instansi')
                    ],
                    [
                        'label' => 'Rencana Judul',
                        'type' => 'text',
                        'name' => 'rencana_judul',
                        'disabled' => false,
                        'value' => old('rencana_judul')
                    ],
                    [
                        'label' => 'Tanggal mulai',
                        'type' => 'date',
                        'name' => 'tanggal_mulai',
                        'disabled' => false,
                        'value' => old('tanggal_mulai')
                    ],
                    [
                        'label' => 'Tanggal selesai',
                        'type' => 'date',
                        'name' => 'tanggal_selesai',
                        'disabled' => false,
                        'value' => old('tanggal_selesai')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ]) 
    @endif
    @if(($magang->id_status_daftar < 3 || $magang->status_dosen == 0) && $magang->instansi()->exists() && $magang->instansi->status_instansi === 1 )
        @include('partials.simple-modal-form', ['title' => 'Tambah Rencana Kegiatan',
            'id' => 'modal-add-rencana',
            'form' => [
                'action' => url('/mahasiswa/magang/rencana'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'Kegiatan',
                        'type' => 'text',
                        'name' => 'kegiatan',
                        'disabled' => false,
                        'value' => old('kegiatan')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])
    @endif
    @if($magang->id_status_daftar == 4 && $magang->status_diterima_instansi == 0)
        @include('partials.simple-modal-form', ['title' => 'Upload surat jawaban',
            'id' => 'add-surat-jawaban',
            'form' => [
                'action' => url('/mahasiswa/magang/jawaban'),
                'method' => 'post',
                'inputs' => [
                    [
                        'label' => 'File surat',
                        'type' => 'file',
                        'name' => 'file_surat',
                        'disabled' => false,
                        'value' => old('file_surat')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])    
    @endif
    @if($magang->id_status_daftar == 4 && $magang->surat_jawaban()->exists() && $magang->status_diterima_instansi == 0)
        @include('partials.simple-modal-form', ['title' => 'Upload surat jawaban',
            'id' => 'edit-surat-jawaban',
            'form' => [
                'action' => url('/mahasiswa/magang/jawaban'),
                'method' => 'put',
                'inputs' => [
                    [
                        'label' => 'File surat',
                        'type' => 'file',
                        'name' => 'file_surat',
                        'disabled' => false,
                        'value' => old('file_surat')
                    ],
                ],
                'submit' => [
                    'label' => 'Simpan',
                ],
            ]
        ])     
    @endif
@endsection
@section('javascript')
<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @error('gagal')
            $(function() {
                Toast.fire({
                    icon: 'error',
                    title: '{{ $message }}'
                })
            });
        @enderror
        @if (session('berhasil'))
            $(function() {
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('berhasil') }}'
                })
            });
        @endif
    });
</script>
<script>
    $(document).ready(function () {
        $(".disabled-link").click(function () {
        return false;
        });
    });
</script>
@endsection
@section('css')
<style>
    .disabled-link {
        color: rgb(153,153,153) !important;
        cursor: not-allowed !important;
    }
</style>
@endsection











{{-- <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#detailmagang" data-toggle="tab">Detail Magang</a></li>
              <li class="nav-item"><a class="nav-link" href="#detailinstansi" data-toggle="tab">Detail Instansi</a></li>
              <li class="nav-item"><a class="nav-link @if($magang->instansi()->exists() && $magang->instansi->status_instansi == 0) disabled-link @endif" href="#rencanamagang" data-toggle="tab">Rencana Magang</a></li>
              <li class="nav-item"><a class="nav-link @if($magang->id_status_daftar < 3) disabled-link @endif" href="#suratmagang" data-toggle="tab">Surat Magang</a></li>
              <li class="nav-item"><a class="nav-link @if($magang->id_status_daftar < 5) disabled-link @endif" href="#bimbingandosen" data-toggle="tab">Bimbingan Dosen</a></li>
              <li class="nav-item"><a class="nav-link @if($magang->id_status_daftar < 5) disabled-link @endif" href="#bimbinganinstansi" data-toggle="tab">Bimbingan Instansi</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="detailmagang">
                 <h5>Detail Magang</h5>
                 <dl class="row">
                    <dt class="col-sm-4">Tahun</dt>
                    <dd class="col-sm-8">{{ $magang->Tahun->tahun }}</dd>
                    <dt class="col-sm-4">Topik</dt>
                    <dd class="col-sm-8">{{ $magang->topik->nama_topik }}</dd>
                    <dt class="col-sm-4">Nama instansi</dt>
                    <dd class="col-sm-8">{{ $magang->Instansi->nama }}</dd>
                    <dt class="col-sm-4">Dosen</dt>
                    <dd class="col-sm-8">{{ (!$magang->dosen()->exists())? 'Belum ditentukan' : $magang->dosen->nama }} {!! ($magang->dosen()->exists())? (($magang->status_dosen === null)? '<span class="badge bg-gray">belum diverifikasi</span>': (($magang->status_dosen === 0)? '<span class="badge bg-danger">Ditolak</span>' : '<span class="badge bg-success">Disetujui</span>')) : ''  !!}</dd>
                    </dd>
                    <a href="{{ url('/mahasiswa/magang/daftar') }}" class="btn btn-sm text-white" style="background-color:#010080; border-color:#010080 ;">
                        <i class="fas fa-plus"></i> Daftar Magang
                    </a>
                </dl>
              </div>
              <div class="tab-pane" id="detailinstansi">
                <h5>Detail Instansi</h5>
                <dl class="row">
                    <dt class="col-sm-4">Nama instansi</dt>
                    <dd class="col-sm-8">{{ $magang->Instansi->nama }}</dd>
                    <dt class="col-sm-4">E-mail</dt>
                    <dd class="col-sm-8"> {{ $magang->Instansi->email }}</dd>
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $magang->Instansi->alamat }}</dd>
                    <dt class="col-sm-4">Telepon</dt>
                    <dd class="col-sm-8">{{ $magang->Instansi->no_telp }}</dd>
                    <dt class="col-sm-4">Website</dt>
                    <dd class="col-sm-8">{{ $magang->Instansi->web }}</dd>
                    <dt class="col-sm-4">Status Persetujuan Instansi</dt>
                    <dd class="col-sm-8">{!! ($magang->instansi->status_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($magang->instansi->status_instansi === 0)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
                </dl>
              </div>
              @if($magang->instansi()->exists() && $magang->instansi->status_instansi === 1)
              <div class="tab-pane" id="rencanamagang">
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
              </div>
              @endif
              @if($magang->id_status_daftar > 2 )
              <div class="tab-pane" id="suratmagang">
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
              </div>
              @endif
              @if($magang->id_status_daftar > 4)
              <div class="tab-pane" id="bimbingandosen">
                @if($bimbingan != null)
                    <div class="table-responsive">
                        <table class="table">
                    @foreach($bimbingan as $b)
                        @if(Request::get('editdosen') && Request::get('editdosen') == $b->id_bimbingan_dosen && $b->status == 0)
                        <form action="{{ url('/mahasiswa/magang/bimbingan/dosen/'.$b->id_bimbingan_dosen) }}" style="display:inline-flex;width:100%" method="post">
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
                                    <a href="{{ url('/mahasiswa/magang') }}" class="btn btn-sm btn-danger">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        </form>
                        @else
                            <tr>
                                <th>{{ $b->tanggal }}</th>
                                <td>{{ $b->data_bimbingan }}</td>
                                <td>{{ ($b->status === null) ? 'Menunggu' : (($b->status === 0)? 'Ditolak' : 'Diterima')}}</td>
                                <td>
                                    @if($b->status == 0)
                                    <a href="{{ url('/mahasiswa/magang?editdosen='.$b->id_bimbingan_dosen) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ url('/mahasiswa/magang/bimbingan/dosen/'.$b->id_bimbingan_dosen.'/delete') }}" class="btn btn-sm btn-danger">
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
                    <a href="#" class="btn btn-sm text-white" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add-dosen">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </dt>
              </div>
              <div class="tab-pane" id="bimbinganinstansi">
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
                                <a href="{{ url('/mahasiswa/magang') }}" class="btn btn-sm btn-danger">
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    </form>
                    @else
                        <tr>
                            <th>{{ $b->tanggal }}</th>
                            <td>{{ $b->data_bimbingan }}</td>
                            <td>{{ ($b->status === null) ? 'Menunggu' : (($b->status === 0)? 'Ditolak' : 'Diterima')}}</td>
                            <td>
                                @if($b->status == 0)
                                <a href="{{ url('/mahasiswa/magang?editinstansi='.$b->id_bimbingan_instansi) }}" class="btn btn-sm btn-warning">
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
              </div>
              @endif
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div><!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
</div> --}}
        {{-- <div class="modal fade" id="modal-add-dosen" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/bimbingan/dosen') }}" method="post">
                    @csrf
                <div class="modal-header">
                <h4 class="modal-title">Tambah Bimbingan Dosen</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="data_bimbingan">Data bimbingan</label>
                            <input type="text" class="form-control @error('data_bimbingan') is-invalid @enderror" id="data_bimbingan" name="data_bimbingan" value="{{ old('data_bimbingan') }}" placeholder="Masukkan data bimbingan">
                            @error('data_bimbingan')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> --}}
        {{-- <div class="modal fade" id="modal-add-instansi" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/bimbingan/instansi') }}" method="post">
                    @csrf
                <div class="modal-header">
                <h4 class="modal-title">Tambah Bimbingan Instansi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="data_bimbingan">Data bimbingan</label>
                            <input type="text" class="form-control @error('data_bimbingan') is-invalid @enderror" id="data_bimbingan" name="data_bimbingan" value="{{ old('data_bimbingan') }}" placeholder="Masukkan data bimbingan">
                            @error('data_bimbingan')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> --}}
            {{-- <div class="modal fade" id="add-surat-pengantar" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/pengajuan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    <h4 class="modal-title">Upload surat pengantar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="file_surat">Kegiatan</label>
                                <input type="file" class="form-control @error('file_surat') is-invalid @enderror" id="file_surat" name="file_surat" value="{{ old('file_surat') }}" placeholder="Masukkan file surat">
                                @error('file_surat')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
    </div> --}}

            {{-- <div class="modal fade" id="add-surat-serah-terima" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/serah-terima') }}" method="post">
                    @csrf
                <div class="modal-header">
                <h4 class="modal-title">Buat surat serah terima magang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_mahasiswa">Nama mahasiswa</label>
                            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $magang->mahasiswa->nama }}" placeholder="Masukkan nama mahasiswa">
                            @error('nama_mahasiswa')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM mahasiswa</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ $magang->mahasiswa->nim }}" placeholder="Masukkan nim mahasiswa">
                            @error('nim')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pembimbing">Nama pembimbing</label>
                            <input type="text" class="form-control @error('nama_pembimbing') is-invalid @enderror" id="nama_pembimbing" name="nama_pembimbing" value="{{ $magang->dosen->nama }}" placeholder="Masukkan nama pembimbing">
                            @error('nama_pembimbing')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">Nama pembimbing</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ $magang->dosen->nik }}" placeholder="Masukkan nik pembimbing">
                            @error('nik')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon_pembimbing">No. telp pembimbing</label>
                            <input type="text" class="form-control @error('nomor_telepon_pembimbing') is-invalid @enderror" id="nomor_telepon_pembimbing" name="nomor_telepon_pembimbing" value="{{ old('nomor_telepon_pembimbing') }}" placeholder="Masukkan nomor telepon pembimbing">
                            @error('nomor_telepon_pembimbing')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_instansi">Nama Instansi</label>
                            <input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" id="nama_instansi" name="nama_instansi" value="{{ $magang->instansi->nama }}" placeholder="Masukkan nama instansi">
                            @error('nama_instansi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instansi">Alamat Instansi</label>
                            <input type="text" class="form-control @error('alamat_instansi') is-invalid @enderror" id="alamat_instansi" name="alamat_instansi" value="{{ $magang->instansi->alamat }}" placeholder="Masukkan alamat instansi">
                            @error('alamat_instansi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rencana_judul">Rencana Judul</label>
                            <input type="text" class="form-control @error('rencana_judul') is-invalid @enderror" id="rencana_judul" name="rencana_judul" value="{{ old('rencana_judul') }}" placeholder="Masukkan rencana judul">
                            @error('rencana_judul')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="text" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" placeholder="Masukkan tanggal mulai">
                            @error('tanggal_mulai')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" placeholder="Masukkan tanggal selesai">
                            @error('tanggal_selesai')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> --}}
                {{-- <div class="modal fade" id="edit-surat-serah-terima" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/serah-terima') }}" method="post">
                    @csrf
                    @method('PUT')
                <div class="modal-header">
                <h4 class="modal-title">Buat surat serah terima magang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama_mahasiswa">Nama mahasiswa</label>
                            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ $magang->mahasiswa->nama }}" placeholder="Masukkan nama mahasiswa">
                            @error('nama_mahasiswa')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nim">NIM mahasiswa</label>
                            <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ $magang->mahasiswa->nim }}" placeholder="Masukkan nim mahasiswa">
                            @error('nim')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pembimbing">Nama pembimbing</label>
                            <input type="text" class="form-control @error('nama_pembimbing') is-invalid @enderror" id="nama_pembimbing" name="nama_pembimbing" value="{{ $magang->dosen->nama }}" placeholder="Masukkan nama pembimbing">
                            @error('nama_pembimbing')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nik">Nama pembimbing</label>
                            <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ $magang->dosen->nik }}" placeholder="Masukkan nik pembimbing">
                            @error('nik')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon_pembimbing">No. telp pembimbing</label>
                            <input type="text" class="form-control @error('nomor_telepon_pembimbing') is-invalid @enderror" id="nomor_telepon_pembimbing" name="nomor_telepon_pembimbing" value="{{ old('nomor_telepon_pembimbing') }}" placeholder="Masukkan nomor telepon pembimbing">
                            @error('nomor_telepon_pembimbing')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_instansi">Nama Instansi</label>
                            <input type="text" class="form-control @error('nama_instansi') is-invalid @enderror" id="nama_instansi" name="nama_instansi" value="{{ $magang->instansi->nama }}" placeholder="Masukkan nama instansi">
                            @error('nama_instansi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_instansi">Alamat Instansi</label>
                            <input type="text" class="form-control @error('alamat_instansi') is-invalid @enderror" id="alamat_instansi" name="alamat_instansi" value="{{ $magang->instansi->alamat }}" placeholder="Masukkan alamat instansi">
                            @error('alamat_instansi')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rencana_judul">Rencana Judul</label>
                            <input type="text" class="form-control @error('rencana_judul') is-invalid @enderror" id="rencana_judul" name="rencana_judul" value="{{ old('rencana_judul') }}" placeholder="Masukkan rencana judul">
                            @error('rencana_judul')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="text" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" placeholder="Masukkan tanggal mulai">
                            @error('tanggal_mulai')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="text" class="form-control @error('tanggal_selesai') is-invalid @enderror" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" placeholder="Masukkan tanggal selesai">
                            @error('tanggal_selesai')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div> --}}
    {{-- <div class="modal fade" id="modal-add-rencana" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/rencana') }}" method="post">
                    @csrf
                <div class="modal-header">
                <h4 class="modal-title">Tambah Rencana Kegiatan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="kegiatan">Kegiatan</label>
                            <input type="text" class="form-control @error('kegiatan') is-invalid @enderror" id="kegiatan" name="kegiatan" value="{{ old('kegiatan') }}" placeholder="Masukkan kegiatan">
                            @error('kegiatan')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
    </div> --}}

    {{-- <div class="modal fade" id="add-surat-jawaban" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/jawaban') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                    <h4 class="modal-title">Upload surat jawaban</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="file_surat">File surat</label>
                                <input type="file" class="form-control @error('file_surat') is-invalid @enderror" id="file_surat" name="file_surat" value="{{ old('file_surat') }}" placeholder="Masukkan file surat">
                                @error('file_surat')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
    </div> --}}

    {{-- <div class="modal fade" id="edit-surat-jawaban" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('/mahasiswa/magang/pengajuan') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                    <h4 class="modal-title">Upload surat pengantar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="file_surat">Kegiatan</label>
                                <input type="file" class="form-control @error('file_surat') is-invalid @enderror" id="file_surat" name="file_surat" value="{{ old('file_surat') }}" placeholder="Masukkan file surat">
                                @error('file_surat')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
    </div> --}}