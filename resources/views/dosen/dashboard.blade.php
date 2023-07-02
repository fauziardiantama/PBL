@extends('dosen.layouts.base')
@section('title', 'Dashboard')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Magang tahun ini ({{ date('Y') }}) </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                @if ($tahuns->contains('tahun', '2023'))
                    @if ($magangs->contains('tahun', '2023'))
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Instansi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($magangs->where('tahun', '2023') as $magang)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $magang->mahasiswa->nim }}</td>
                                            <td>{{ $magang->mahasiswa->nama }}</td>
                                            <td>{{ $magang->instansi->nama }}</td>
                                            <td>
                                                <a href="{{ url('dosen/magang/' . $magang->id_magang) }}"
                                                    class="btn btn-sm btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">Belum ada magang tahun ini</p>
                    @endif
                @else
                    <div class="card-body">
                        <h3 class="text-center">Tahun 2023 belum di daftarkan ke database oleh admin</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Permintaan pembimbing belum terverifikasi</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>E-mail</th>
                                <th>No. Telepon</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($magangs->contains('status_dosen', null))
                                @foreach ($magangs->where('status', null) as $magang)
                                    <tr>
                                        
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada permintaan pembimbingan yang belum
                                        terverifikasi</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
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
      
      @if(session('berhasillogin'))
        $(function() {
        Toast.fire({
            icon: 'success',
            title: '{{ session("berhasillogin") }}'
        })
        });
      @endif
    });
</script>
@endsection