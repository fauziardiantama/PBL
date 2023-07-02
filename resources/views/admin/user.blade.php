@extends('admin.layouts.base')
@section('title', 'Daftar Pengguna')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Daftar Pengguna</li>
@endsection
@section('content')
<div class="row mb-3">
  <!-- /.col -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Dosen</h3>

        <div class="card-tools">
          {{ $d->appends(['d_page' => $d->currentPage()])->links() }}
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>NIK</th>
              <th>Nama</th>
              <th>E-mail</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          @if($d->count() > 0)
            @foreach($d as $dosen)
            @php
              $index = ($d->currentPage() - 1) * $d->perPage() + $loop->index + 1;
            @endphp 
            <tr>
              <td>{{ $index }}</td>
              <td>{{ $dosen->nik }}</td>
              <td>{{ $dosen->nama }}</td>
              <td>{{ $dosen->email }}</td>
              <td>
                <a href="{{ url('admin/user/dosen/'.$dosen->id_dosen) }}" class="btn btn-sm btn-info">Detail</a>
                <form action="{{ url('admin/user/dosen/'.$dosen->id_dosen) }}" style="display:contents" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" class="btn btn-sm btn-danger" value="Hapus">
                </form>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5" class="text-center">Tidak ada data dosen</td>
            </tr>
          @endif
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <div>
      <a href="#" class="btn btn-primary" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add">Tambah Akun Dosen</a>
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
</div>
<div class="row">
  <!-- /.col -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Mahasiswa</h3>

        <div class="card-tools">
          {{ $m->appends(['m_page' => $m->currentPage()])->links() }}
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10px">#</th>
              <th>NIM</th>
              <th>Nama</th>
              <th>E-mail</th>
              <th>No. Telepon</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          @if($m->count() > 0)
            @foreach($m as $mahasiswa)
            @php
              $index = ($m->currentPage() - 1) * $m->perPage() + $loop->index + 1;
            @endphp 
            <tr>
              <td>{{ $index }}</td>
              <td>{{ $mahasiswa->nim }}</td>
              <td>{{ $mahasiswa->nama }}</td>
              <td>{{ $mahasiswa->email }}</td>
              <td>{{ $mahasiswa->no_telp }}</td>
              <td>
                @if($mahasiswa->status)
                <span class="badge bg-success">Aktif</span>
                @else
                <span class="badge bg-danger">Tidak Aktif</span>
                @endif
              </td>
              <td>
                <a href="{{ url('admin/user/mahasiswa/'.$mahasiswa->nim) }}" class="btn btn-sm btn-info">Detail</a>
                @if($mahasiswa->status)
                <form action="{{ url('admin/user/mahasiswa/'.$mahasiswa->nim.'/nonaktif') }}" style="display:contents" method="post">
                    @csrf
                    @method('PUT')
                    <input type="submit" value="Nonaktifkan" class="btn btn-sm btn-danger">
                </form>
                @else
                <form action="{{ url('admin/user/mahasiswa/'.$mahasiswa->nim.'/aktif') }}" style="display:contents" method="post">
                    @csrf
                    @method('PUT')
                    <input type="submit" value="Aktifkan" class="btn btn-sm btn-success">
                </form>
                @endif
                <form action="{{ url('admin/user/mahasiswa/'.$mahasiswa->nim) }}" style="display:contents" method="post">
                    @csrf
                    @method('DELETE')
                    <input type="submit" value="Hapus" class="btn btn-sm btn-danger">
                </form>
              </td>
            </tr>
            @endforeach
          @else
            <tr>
              <td colspan="7" class="text-center">Tidak ada data mahasiswa</td>
            </tr>
          @endif
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.col -->
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
<div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('admin/user/dosen/add') }}" method="post">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Tambah Dosen</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" placeholder="Masukkan NIK">
                    @error('nik')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
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
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('nama') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="password_confirmation">Password</label>
                <input type="password" class="form-control @error('nama') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password">
                @error('password_confirmation')
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
