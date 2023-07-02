@extends('mahasiswa.layouts.base')
@section('title','Revisi')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Revisi</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        @if($revisi == null)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Revisi KMM
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('mahasiswa/revisi') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nim">NIM Mahasiswa</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" value="{{ $magang->mahasiswa->nim }}" id="nim" name="nim"
                            placeholder="Masukkan NIM mahasiswa" disabled>
                            @error('nim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Mahasiswa</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" value="{{ $magang->mahasiswa->nama }}" id="nama" name="nama"
                            placeholder="Masukkan nama mahasiswa" disabled>
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="judul">Judul KMM</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" value="{{ $magang->seminar->judul_kmm }}" id="judul" name="judul"
                            placeholder="Masukkan judul KMM" disabled>
                            @error('judul')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="laporan_revisi">Laporan revisi KMM</label>
                        <input type="file" class="form-control @error('laporan_revisi') is-invalid @enderror" value="{{ old('laporan_revisi') }}" id="laporan_revisi" name="laporan_revisi">
                            @error('laporan_revisi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="selesai_kmm">Pernyataan selesai magang</label>
                        <input type="file" class="form-control @error('selesai_kmm') is-invalid @enderror" value="{{ old('selesai_kmm') }}" id="selesai_kmm" name="selesai_kmm">
                            @error('selesai_kmm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="daftar_hadir">Daftar Hadir Seminar</label>
                        <input type="file" class="form-control @error('daftar_hadir') is-invalid @enderror" value="{{ old('daftar_hadir') }}" id="daftar_hadir" name="daftar_hadir">
                            @error('daftar_hadir')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #010080; border-color:#010080">Tambah</button>
                </form>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Seminar {{ $revisi->magang->seminar->judul_kmm }}
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <div class="card-body">
                <h5>Detail Revisi</h5>
                <dl class="row">
                    <dt class="col-sm-4">Nama mahasiswa</dt>
                    <dd class="col-sm-8">{{ $magang->mahasiswa->nama }}</dd>
                    <dt class="col-sm-4">NIM mahasiswa</dt>
                    <dd class="col-sm-8">{{ $magang->mahasiswa->nim }}</dd>
                    <dt class="col-sm-4">Tanggal Upload</dt>
                    <dd class="col-sm-8">{{ $revisi->tgl_upload }}</dd>
                    <dt class="col-sm-4">Laporan Revisi</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->laporan_revisi) }}" target="_blank">{{ $revisi->laporan_revisi }}</a></dd>
                    <dt class="col-sm-4">Selesai KMM</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->selesai_kmm) }}" target="_blank">{{ $revisi->selesai_kmm }}</a></dd>
                    <dt class="col-sm-4">Daftar Hadir</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/revisi/'.$revisi->daftar_hadir) }}" target="_blank">{{ $revisi->daftar_hadir }}</a></dd>
                    <dt class="col-sm-4">Status verifikasi</dt>
                    <dd class="col-sm-8">{!! ($revisi->status === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($revisi->status === 0 || $revisi->status === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
                </dl>
                @if($revisi->Status != 1)
                    <button type="button" class="btn btn-primary m-1" data-toggle="modal" data-target="#edit-revisi">
                        Ubah Data
                    </button>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
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
        @if(session('berhasil'))
        $(function() {
        Toast.fire({
            icon: 'success',
            title: '{{ session("berhasil") }}'
        })
        });
        @endif
    });
</script>
@endsection
@section('modal')
@if($revisi != null && $revisi->status != 1)
    @include('partials.simple-modal-form', ['title' => 'Update revisi',
        'id' => 'edit-revisi',
        'form' => [
            'action' => url('/mahasiswa/revisi'),
            'method' => 'put',
            'inputs' => [
                [
                    'label' => 'Laporan revisi KMM',
                    'type' => 'file',
                    'name' => 'laporan_revisi',
                    'disabled' => false,
                    'value' => old('laporan_revisi')
                ],
                [
                    'label' => 'Laporan selesai KMM',
                    'type' => 'file',
                    'name' => 'selesai_kmm',
                    'disabled' => false,
                    'value' => old('selesai_kmm')
                ],
                [
                    'label' => 'Daftar hadir seminar',
                    'type' => 'file',
                    'name' => 'daftar_hadir',
                    'disabled' => false,
                    'value' => old('daftar_hadir')
                ]
            ],
            'submit' => [
                'label' => 'Simpan',
            ],
        ]
    ])
@endif
@endsection