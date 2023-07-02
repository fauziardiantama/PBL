@extends('dosen.layouts.base')
@section('title', 'Profil')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Profil</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Profil</a></li>
          <li class="nav-item"><a class="nav-link" href="#kondisi" data-toggle="tab">Edit Profil</a></li>
          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Ubah Password</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- /.tab-pane -->
          <div class="active tab-pane" id="timeline">
             <!-- The timeline -->
             <div class="table-responsive">
              <table class="table">
                <tr>
                    <th>NIK :</th>
                    <td>{{ $d->nik }}</td>
                </tr>
                <tr>
                  <th>Nama :</th>
                  <td>{{ $d->nama }}</td>
                </tr>
                <tr>
                  <th>E-mail :</th>
                  <td>{{ $d->email }}</td>
                </tr>
                </tr>
              </table>
            </div>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="kondisi">
            <form class="form-horizontal" action="{{ url('dosen/profil') }}" method="post">
                @csrf
                @method('PUT')
                    <div class="form-group">
                      <label for="nik">NIK</label>
                      <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ $d->nik }}" placeholder="Masukkan NIK">
                      @error('nik')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $d->nama }}" placeholder="Masukkan nama">
                    @error('nama')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $d->email }}" placeholder="Masukkan email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group row pl-1 pr-1 justify-content-between">
                  <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
          </div>
          <div class="tab-pane" id="settings">
            <form class="form-horizontal" action="{{ url('dosen/profil/ubahpassword') }}" method="post">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group row pl-1 pr-1 justify-content-between">
                  <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div><!-- /.card-body -->
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
