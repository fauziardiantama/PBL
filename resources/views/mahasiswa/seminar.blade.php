@extends('mahasiswa.layouts.base')
@section('title', 'Seminar')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Seminar</li>
@endsection
@section('content')
<div class="row">
    <!--card-->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Prasyarat Seminar
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
                <p class="card-text">
                    {{-- 1   Mahasiswa melakukan bimbingan dosen minimal lima kali dan sudah diverifikasi
                    2	Mahasiswa melakukan bimbingan instansi minimal lima kali dan sudah diverifikasi
                    3	Dosen pembimbing menginput nilai bimbingan
                    4	Nilai Instansi sudah diinput dan diverifikasi --}}
                    <table>
                        <tr>
                            <td>1.</td>
                            <td>Mahasiswa melakukan bimbingan dosen minimal lima kali dan sudah diverifikasi</td>
                            <td>
                                @if($magang->bimbingan_dosen()->where('status',1)->count() < 5)
                                <span class="badge badge-danger">Belum</span>
                                @else
                                <span class="badge badge-success">Sudah</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Mahasiswa melakukan bimbingan instansi minimal lima kali dan sudah diverifikasi</td>
                            <td>
                                @if($magang->bimbingan_instansi()->where('status',1)->count() < 5)
                                <span class="badge badge-danger">Belum</span>
                                @else
                                <span class="badge badge-success">Sudah</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        @if($seminar == null)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Daftar Seminar
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
                <form action="{{ url('mahasiswa/seminar') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nim">NIM Mahasiswa</label>
                        <input type="text" disabled class="form-control @error('nim') is-invalid @enderror" value="{{ $magang->mahasiswa->nim }}" id="nim" name="nim"
                            placeholder="Masukkan NIM mahasiswa">
                            @error('nim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Mahasiswa</label>
                        <input type="text" disabled class="form-control @error('nama') is-invalid @enderror" value="{{ $magang->mahasiswa->nama }}" id="nama" name="nama"
                            placeholder="Masukkan nama mahasiswa">
                            @error('nama')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="judul_kmm">Judul KMM</label>
                        <input type="text" class="form-control @error('judul_kmm') is-invalid @enderror" value="{{ old('judul_kmm') }}" id="judul_kmm" name="judul_kmm"
                            placeholder="Masukkan judul KMM">
                            @error('judul_kmm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="draft_kmm">Draft KMM</label>
                        <input type="file" class="form-control @error('draft_kmm') is-invalid @enderror" value="{{ old('draft_kmm') }}" id="draft_kmm" name="draft_kmm">
                            @error('draft_kmm')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="krs">KRS terbaru</label>
                        <input type="file" class="form-control @error('krs') is-invalid @enderror" value="{{ old('krs') }}" id="krs" name="krs">
                            @error('krs')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto Dokumentasi KMM</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}" id="foto" name="foto">
                            @error('foto')
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
                    Seminar {{ $seminar->judul_kmm }}
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
                <h5>Data Seminar</h5>
                <dl class="row">
                    <dt class="col-sm-4">Judul kmm</dt>
                    <dd class="col-sm-8">{{ $seminar->judul_kmm }}</dd>
                    <dt class="col-sm-4">Nama mahasiswa</dt>
                    <dd class="col-sm-8">{{ $magang->mahasiswa->nama }}</dd>
                    <dt class="col-sm-4">NIM mahasiswa</dt>
                    <dd class="col-sm-8">{{ $magang->mahasiswa->nim }}</dd>
                    <dt class="col-sm-4">Tanggal daftar</dt>
                    <dd class="col-sm-8">{{ $seminar->tgl_daftar }}</dd>
                    <dt class="col-sm-4">Tanggal seminar</dt>
                    <dd class="col-sm-8">{{ ($seminar->tgl_seminar != null)? $seminar->tgl_seminar : 'Belum ditentukan' }}</dd>
                    <dt class="col-sm-4">Laporan kmm</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->draft_kmm) }}" target="_blank">{{ $seminar->draft_kmm }}</a></dd>
                    <dt class="col-sm-4">KRS terbaru</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->krs) }}" target="_blank">{{ $seminar->krs }}</a></dd>
                    <dt class="col-sm-4">Foto dokumentasi kmm</dt>
                    <dd class="col-sm-8"><a href="{{ asset('storage/seminar/'.$seminar->foto) }}" target="_blank">{{ $seminar->foto }}</a></dd>
                    <dt class="col-sm-4">Status verifikasi</dt>
                    <dd class="col-sm-8">{!! ($seminar->status === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($seminar->status === 0 || $seminar->status === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</dd>
                </dl>
                @if($seminar->status != 1)
                <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#edit-seminar">
                    Ubah Data
                </button>
                @endif
                @if($seminar->tgl_seminar == null)
                    <h5>Tentukan tanggal seminar</h5>
                    <form action="{{ url('mahasiswa/seminar/tanggal') }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="tgl_seminar">Tanggal seminar</label>
                            <input type="date" class="form-control @error('tgl_seminar') is-invalid @enderror" value="{{ old('tgl_seminar') }}" id="tgl_seminar" name="tgl_seminar">
                                @error('tgl_seminar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #010080; border-color:#010080">Simpan</button>
                    </form>
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
@if($seminar != null && $seminar->status != 1)
    @include('partials.simple-modal-form', ['title' => 'Update seminar',
        'id' => 'edit-seminar',
        'form' => [
            'action' => url('/mahasiswa/seminar'),
            'method' => 'put',
            'inputs' => [
                [
                    'label' => 'Judul KMM',
                    'type' => 'text',
                    'name' => 'judul_kmm',
                    'disabled' => false,
                    'value' => old('judul_kmm')
                ],
                [
                    'label' => 'KRS terbaru',
                    'type' => 'file',
                    'name' => 'krs',
                    'disabled' => false,
                    'value' => old('krs')
                ],
                [
                    'label' => 'Foto dokumentasi KMM',
                    'type' => 'file',
                    'name' => 'foto',
                    'disabled' => false,
                    'value' => old('foto')
                ],
                [
                    'label' => 'Tanggal seminar',
                    'type' => 'date',
                    'name' => 'tgl_seminar',
                    'disabled' => false,
                    'value' => old('tgl_seminar')
                ]
            ],
            'submit' => [
                'label' => 'Simpan',
            ],
        ]
    ])
@endif
@endsection