@extends('mahasiswa.layouts.base')
@section('title', 'Instansi')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Instansi</li>
@endsection
@section('content')
<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">List instansi</h3>

          <div class="card-tools">
            <ul class="pagination pagination-sm float-right">
              <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Nama</th>
                <th>E-mail</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Website</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($instansi as $i)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $i->nama }}</td>
                  <td>{{ $i->email }}</td>
                  <td>{{ $i->alamat }}</td>
                  <td>{{ $i->no_telp }}</td>
                  <td>{{ $i->web }}</td>
                  <td>{!! ($i->status_instansi === 0)? '<span class="badge bg-danger">Belum terverifikasi</span>' : '<span class="badge bg-success">Sudah terverifikasi</span>' !!}</td>
                  <td>
                      <a href="#" class="btn btn-sm btn-danger">Request Hapus</a>
                  </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <div>
      <a href="#" class="btn btn-primary" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add">Tambah instansi</a>
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
@section('modal')
<div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/mahasiswa/instansi') }}" method="post">
            @csrf
          <div class="modal-header">
          <h4 class="modal-title">Tambah Instansi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama">
                        @error('nama')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                  </div>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat">
                    @error('alamat')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="no_telp">Nomor Telepon</label>
                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" placeholder="Masukkan nomor telepon">
                    @error('no_telp')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="web">Website</label>
                    <input type="text" class="form-control @error('web') is-invalid @enderror" id="web" name="web" value="{{ old('web') }}" placeholder="Masukkan nama website">
                    @error('web')
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
  </div>
@endsection
