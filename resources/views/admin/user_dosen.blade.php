@extends('admin.layouts.base')
@section('title', 'Detail Pengguna')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Daftar Pengguna</li>
<li class="breadcrumb-item active">Detail Pengguna</li>
@endsection
@section('content')
<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="card card-primary card-outline">
      <div class="card-body box-profile">
        <div class="text-center">
          <img class="profile-user-img img-fluid img-circle"
               src="{{ url('/assets/images/hero.png') }}"
               alt="User profile picture">
        </div>

        <h3 class="profile-username text-center">{{ $d->nama }}</h3>

        <p class="text-muted text-center">{{ $d->nik }}</p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <a href="#">{{ $d->email }}</a>
          </li>
        </ul>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <!-- /.card -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
    <div class="card">
      <div class="card-header p-2">
        <ul class="nav nav-pills">
          <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Topik</a></li>
          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- /.tab-pane -->
          <div class="active tab-pane" id="timeline">
            <!-- The timeline -->
            @if($d->topik->count() > 0)
              <div class="timeline timeline-inverse">
                  @foreach($d->topik as $t)
                    <div>
                      <i class="fas fa-star bg-info"></i>

                      <div class="timeline-item">
                        <h3 class="timeline-header border-0">{{ $t->nama_topik }}
                          <a href="#">#</a>
                          <span class="float-right text-muted">{{ $t->created_at }}</span>
                        </h3>
                      </div>
                    </div>
                  @endforeach
              </div>
            @else
              <div class="text-center">
                <h4>Belum Memilih Topik</h4>
              </div>                    
            @endif
          </div>
          <!-- /.tab-pane -->

          <div class="tab-pane" id="settings">
            <form class="form-horizontal" action="{{ url('admin/user/dosen/'.$d->id_dosen) }}" method="post">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nik">NIK</label>
                    <input type="text" class="form-control @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ $d->nik }}" placeholder="Masukkan NIK">
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
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $d->nama }}" placeholder="Masukkan Nama">
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
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $d->email }}" placeholder="Masukkan email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group row pl-1 pr-1 justify-content-between">
                  <button type="submit" class="btn btn-success">Simpan</button>
              </form>
              <form action="{{ url('admin/user/dosen/'.$d->id_dosen) }}" method="post">
                @csrf
                @method('DELETE')
                  <button type="submit" class="btn btn-danger">Delete</button>
              </form>
              </div>
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