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

        <h3 class="profile-username text-center">{{ $m->nama }}</h3>

        <p class="text-muted text-center">{{ $m->nim }}</p>

        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <a href="#">{{ $m->email }}</a>
          </li>
          <li class="list-group-item">
            <a href="#">{{ $m->no_telp }}</a>
          </li>
        </ul>
        @if($m->status)
        <form action="{{ url('admin/user/mahasiswa/'.$m->nim.'/nonaktif') }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger btn-block">Nonaktifkan</button>
        </form>
        @else
        <form action="{{ url('admin/user/mahasiswa/'.$m->nim.'/aktif') }}" method="post">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success btn-block">Aktifkan</button>
        </form>
        @endif
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
          <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Dokumen pendaftaran</a></li>
          <li class="nav-item"><a class="nav-link" href="#kondisi" data-toggle="tab">Kondisi Mahasiswa</a></li>
          <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit</a></li>
        </ul>
      </div><!-- /.card-header -->
      <div class="card-body">
        <div class="tab-content">
          <!-- /.tab-pane -->
          <div class="active tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="mailbox-attachments d-flex justify-content-between clearfix">
              <li>
                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                <div class="mailbox-attachment-info">
                  <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->krs != null)? 'documents/krs/'.$m->dokumen->krs : '') }}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{ ($m->dokumen()->exists() && $m->dokumen->krs != null)?$m->dokumen->krs : 'Tidak ada dokumen' }}</a>
                  <span class="mailbox-attachment-size clearfix mt-1">
                    <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->krs != null)? 'documents/krs/'.$m->dokumen->krs : '') }}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                  </span>
                </div>
              </li>
              <li>
                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                <div class="mailbox-attachment-info">
                  <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->transkrip != null)? 'documents/transkrip/'.$m->dokumen->transkrip : '') }}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{ ($m->dokumen()->exists() && $m->dokumen->transkrip != null)?$m->dokumen->transkrip : 'Tidak ada dokumen' }}</a>
                      <span class="mailbox-attachment-size clearfix mt-1">
                        
                        <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->transkrip != null)? 'documents/transkrip/'.$m->dokumen->transkrip : '') }}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                      </span>
                </div>
              </li>
              <li>
                <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>

                <div class="mailbox-attachment-info">
                  <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->bukti_seminar != null)? 'documents/bukti_seminar/'.$m->dokumen->bukti_seminar : '') }}" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i>{{ ($m->dokumen()->exists() && $m->dokumen->bukti_seminar != null )?$m->dokumen->tbukti_seminar : 'Tidak ada dokumen' }}</a>
                      <span class="mailbox-attachment-size clearfix mt-1">
                        
                        <a href="{{ url(($m->dokumen()->exists() && $m->dokumen->bukti_seminar != null)? 'documents/bukti_seminar/'.$m->dokumen->bukti_seminar : '') }}" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                      </span>
                </div>
              </li>
            </ul>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="kondisi">
            <!-- The timeline -->
            <div class="table-responsive">
              @if($m->kondisi)
              <table class="table">
                <tr>
                  <th>Nama lengkap</th>
                  <td>{{ $m->kondisi->nama_lengkap }}</td>
                </tr>
                <tr>
                  <th>Fakultas</th>
                  <td>{{ $m->kondisi->fakultas }}</td>
                </tr>
                <tr>
                  <th>Program Studi</th>
                  <td>{{ $m->kondisi->program_prodi }}</td>
                </tr>
                <tr>
                  <th>No. Telp</th>
                  <td>{{ $m->kondisi->nomor_telepon }}</td>
                </tr>
                <tr>
                  <th>E-mail</th>
                  <td>{{ $m->kondisi->email_SSO }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal</th>
                  <td>{{ $m->kondisi->alamat_asal_jalan_dan_nomor_rumah }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal RT/RW</th>
                  <td>{{ $m->kondisi->alamat_asal_RT_RW }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal Kelurahan</th>
                  <td>{{ $m->kondisi->alamat_asal_kelurahan }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal Kabupaten/Kota</th>
                  <td>{{ $m->kondisi->alamat_asal_kabupaten_kota }}</td>
                </tr>
                <tr>
                  <th>Alamat Asal Provinsi</th>
                  <td>{{ $m->kondisi->alamat_asal_provinsi }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo</th>
                  <td>{{ $m->kondisi->alamat_di_solo }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo Jalan dan Nomor Rumah</th>
                  <td>{{ $m->kondisi->alamat_solo_jalan_dan_nomor_rumah }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo RT/RW</th>
                  <td>{{ $m->kondisi->alamat_solo_RT_RW }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo Kelurahan</th>
                  <td>{{ $m->kondisi->alamat_solo_kelurahan }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo Kecamatan</th>
                  <td>{{ $m->kondisi->alamat_solo_kecamatan }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo Kabupaten/Kota</th>
                  <td>{{ $m->kondisi->alamat_solo_kabupaten_kota }}</td>
                </tr>
                <tr>
                  <th>Alamat di Solo Provinsi</th>
                  <td>{{ $m->kondisi->alamat_solo_provinsi }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi</th>
                  <td>{{ $m->kondisi->alamat_saat_isi }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi Jalan dan Nomor Rumah</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_jalan_dan_nomor_rumah }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi RT/RW</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_RT_RW }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi Kelurahan</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_kelurahan }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi Kecamatan</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_kecamatan }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi Kabupaten/Kota</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_kabupaten_kota }}</td>
                </tr>
                <tr>
                  <th>Alamat saat Isi Provinsi</th>
                  <td>{{ $m->kondisi->alamat_saat_isi_provinsi }}</td>
                </tr>
                <tr>
                  <th>Keadaan sekarang</th>
                  <td>{{ $m->kondisi->keadaan_sekarang }}</td>
                </tr>
                <tr>
                    <th>Sakit keterangan</th>
                    <td>{{ $m->kondisi->sakit_keterangan }}</td>
                </tr>
                <tr>
                    <th>Sakit status periksa</th>
                    <td>{{ $m->kondisi->sakit_status_periksa }}</td>
                </tr>
                <tr>
                    <th>Sakit periksa diagnosa saran dokter</th>
                    <td>{{ $m->kondisi->sakit_periksa_diagnosa_saran_dokter }}</td>
                </tr>
                <tr>
                    <th>Tanggal submit</th>
                    <td>{{ $m->kondisi->tanggal_submit }}</td>
                </tr>

              </table>
              @else
                <div class="text-center">
                  <p class="lead">Belum mengisi kondisi</p>
                </div>
              @endif
            </div>
          </div>
          <div class="tab-pane" id="settings">
            <form class="form-horizontal"action="{{ url('admin/user/mahasiswa/'.$m->nim) }}" method="post">
                @csrf
                @method('PUT')
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ $m->nim }}" placeholder="Masukkan nim">
                    @error('nim')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $m->nama }}" placeholder="Masukkan nama">
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
                <input type="email" class="form-control @error('nama') is-invalid @enderror" id="email" name="email" value="{{ $m->email }}" placeholder="Masukkan email">
                @error('nama')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group">
                <label for="no_telp">No. Telepon</label>
                <input type="email" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ $m->no_telp }}" placeholder="Masukkan nomor telepon">
                @error('no_telp')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
              <div class="form-group row pl-1 pr-1 justify-content-between">
                  <button type="submit" class="btn btn-success">Simpan</button>
             </form>
                <form action="{{ url('admin/user/mahasiswa/'.$m->nim) }}" method="post">
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