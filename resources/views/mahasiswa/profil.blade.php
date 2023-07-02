@extends('mahasiswa.layouts.base')
@section('title', 'Profil')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Profil</li>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#profil" data-toggle="tab">Edit Profil</a></li>
              <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Ubah Password</a></li>
              <li class="nav-item"><a class="nav-link" href="#kondisi" data-toggle="tab">Kondisi Mahasiswa</a></li>
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
                        <th>NIM :</th>
                        <td>{{ $m->nim }}</td>
                    </tr>
                    <tr>
                      <th>Nama :</th>
                      <td>{{ $m->nama }}</td>
                    </tr>
                    <tr>
                      <th>E-mail :</th>
                      <td>{{ $m->email }}</td>
                    </tr>
                    <tr>
                      <th>No. Telp :</th>
                      <td>{{ $m->no_telp }}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="profil">
                <!-- The timeline -->
                <form class="form-horizontal" action="{{ url('mahasiswa/profil/kondisi') }}" method="post">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                          <label for="nim">NIM</label>
                          <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ $m->nim }}" placeholder="Enter email">
                          @error('nim')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $m->nama }}" placeholder="Enter email">
                        @error('nama')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $m->email }}" placeholder="Enter email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                      </div>
                      <div class="form-group">
                        <label for="no_telp">No. telp</label>
                        <input type="text" class="form-control @error('no_telp') is-invalid @enderror" id="no_telp" name="no_telp" value="{{ $m->no_telp }}" placeholder="Enter email">
                        @error('no_telp')
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
                <form class="form-horizontal" action="{{ url('mahasiswa/profil/ubahpassword') }}" method="post">
                    @csrf
                    @method('PUT')
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter email">
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
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Enter email">
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
              <div class="tab-pane" id="kondisi">
                @if($m->kondisi)
                <form class="form-horizontal" action="{{ url('mahasiswa/profil/kondisi') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_lengkap">Nama lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $m->kondisi->nama_lengkap }}" placeholder="Masukkan nama lengkap" disabled>
                        @error('nama_lengkap')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="fakultas" name="fakultas" value="{{ $m->kondisi->fakultas }}" placeholder="Masukkan fakultas">
                        @error('fakultas')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                        <div class="form-group">
                            <label for="program_prodi">Program Prodi</label>
                            <input type="text" class="form-control @error('program_prodi') is-invalid @enderror" id="program_prodi" name="program_prodi" value="{{ $m->kondisi->program_prodi }}" placeholder="Masukkan program prodi">
                            @error('program_prodi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ $m->kondisi->nomor_telepon }}" placeholder="Masukkan nomor telepon" disabled>
                            @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email_SSO">Email SSO</label>
                            <input type="email" class="form-control @error('email_SSO') is-invalid @enderror" id="email_SSO" name="email_SSO" value="{{ $m->kondisi->email_SSO }}" placeholder="Masukkan email SSO" disabled>
                            @error('email_SSO')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_jalan_dan_nomor_rumah">Alamat Asal Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_asal_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_asal_jalan_dan_nomor_rumah" name="alamat_asal_jalan_dan_nomor_rumah" value="{{ $m->kondisi->alamat_asal_jalan_dan_nomor_rumah }}" placeholder="Masukkan alamat asal jalan dan nomor rumah">
                            @error('alamat_asal_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_RT_RW">Alamat Asal RT RW</label>
                            <input type="text" class="form-control @error('alamat_asal_RT_RW') is-invalid @enderror" id="alamat_asal_RT_RW" name="alamat_asal_RT_RW" value="{{ $m->kondisi->alamat_asal_RT_RW }}" placeholder="Masukkan alamat asal RT RW">
                            @error('alamat_asal_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_kelurahan">Alamat Asal Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_asal_kelurahan') is-invalid @enderror" id="alamat_asal_kelurahan" name="alamat_asal_kelurahan" value="{{ $m->kondisi->alamat_asal_kelurahan }}" placeholder="Masukkan alamat asal kelurahan">
                            @error('alamat_asal_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_kabupaten_kota">Alamat Asal Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_asal_kabupaten_kota') is-invalid @enderror" id="alamat_asal_kabupaten_kota" name="alamat_asal_kabupaten_kota" value="{{ $m->kondisi->alamat_asal_kabupaten_kota }}" placeholder="Masukkan alamat asal kabupaten kota">
                            @error('alamat_asal_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_provinsi">Alamat Asal Provinsi</label>
                            <input type="text" class="form-control @error('alamat_asal_provinsi') is-invalid @enderror" id="alamat_asal_provinsi" name="alamat_asal_provinsi" value="{{ $m->kondisi->alamat_asal_provinsi }}" placeholder="Masukkan alamat asal provinsi">
                            @error('alamat_asal_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_di_solo">Alamat di Solo</label>
                            <input type="text" class="form-control @error('alamat_di_solo') is-invalid @enderror" id="alamat_di_solo" name="alamat_di_solo" value="{{ $m->kondisi->alamat_di_solo }}" placeholder="Masukkan alamat di solo">
                            @error('alamat_di_solo')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_jalan_dan_nomor_rumah">Alamat Solo Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_solo_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_solo_jalan_dan_nomor_rumah" name="alamat_solo_jalan_dan_nomor_rumah" value="{{ $m->kondisi->alamat_solo_jalan_dan_nomor_rumah }}" placeholder="Masukkan alamat solo jalan dan nomor rumah">
                            @error('alamat_solo_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_RT_RW">Alamat Solo RT RW</label>
                            <input type="text" class="form-control @error('alamat_solo_RT_RW') is-invalid @enderror" id="alamat_solo_RT_RW" name="alamat_solo_RT_RW" value="{{ $m->kondisi->alamat_solo_RT_RW }}" placeholder="Masukkan alamat solo RT RW">
                            @error('alamat_solo_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kelurahan">Alamat Solo Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_solo_kelurahan') is-invalid @enderror" id="alamat_solo_kelurahan" name="alamat_solo_kelurahan" value="{{ $m->kondisi->alamat_solo_kelurahan }}" placeholder="Masukkan alamat solo kelurahan">
                            @error('alamat_solo_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kecamatan">Alamat Solo Kecamatan</label>
                            <input type="text" class="form-control @error('alamat_solo_kecamatan') is-invalid @enderror" id="alamat_solo_kecamatan" name="alamat_solo_kecamatan" value="{{ $m->kondisi->alamat_solo_kecamatan }}" placeholder="Masukkan alamat solo kecamatan">
                            @error('alamat_solo_kecamatan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kabupaten_kota">Alamat Solo Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_solo_kabupaten_kota') is-invalid @enderror" id="alamat_solo_kabupaten_kota" name="alamat_solo_kabupaten_kota" value="{{ $m->kondisi->alamat_solo_kabupaten_kota }}" placeholder="Masukkan alamat solo kabupaten kota">
                            @error('alamat_solo_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_provinsi">Alamat Solo Provinsi</label>
                            <input type="text" class="form-control @error('alamat_solo_provinsi') is-invalid @enderror" id="alamat_solo_provinsi" name="alamat_solo_provinsi" value="{{ $m->kondisi->alamat_solo_provinsi }}" placeholder="Masukkan alamat solo provinsi">
                            @error('alamat_solo_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi">Alamat Saat Isi</label>
                            <input type="text" class="form-control @error('alamat_saat_isi') is-invalid @enderror" id="alamat_saat_isi" name="alamat_saat_isi" value="{{ $m->kondisi->alamat_saat_isi }}" placeholder="Masukkan alamat saat isi">
                            @error('alamat_saat_isi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_jalan_dan_nomor_rumah">Alamat Saat Isi Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_saat_isi_jalan_dan_nomor_rumah" name="alamat_saat_isi_jalan_dan_nomor_rumah" value="{{ $m->kondisi->alamat_saat_isi_jalan_dan_nomor_rumah }}" placeholder="Masukkan Alamat Saat Isi Jalan dan Nomor Rumah">
                            @error('alamat_saat_isi_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_RT_RW">Alamat Saat Isi RT RW</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_RT_RW') is-invalid @enderror" id="alamat_saat_isi_RT_RW" name="alamat_saat_isi_RT_RW" value="{{ $m->kondisi->alamat_saat_isi_RT_RW }}" placeholder="Masukkan Alamat Saat Isi RT RW">
                            @error('alamat_saat_isi_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kelurahan">Alamat Saat Isi Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kelurahan') is-invalid @enderror" id="alamat_saat_isi_kelurahan" name="alamat_saat_isi_kelurahan" value="{{ $m->kondisi->alamat_saat_isi_kelurahan }}" placeholder="Masukkan Alamat Saat Isi Kelurahan">
                            @error('alamat_saat_isi_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kecamatan">Alamat Saat Isi Kecamatan</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kecamatan') is-invalid @enderror" id="alamat_saat_isi_kecamatan" name="alamat_saat_isi_kecamatan" value="{{ $m->kondisi->alamat_saat_isi_kecamatan }}" placeholder="Masukkan Alamat Saat Isi Kecamatan">
                            @error('alamat_saat_isi_kecamatan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kabupaten_kota">Alamat Saat Isi Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kabupaten_kota') is-invalid @enderror" id="alamat_saat_isi_kabupaten_kota" name="alamat_saat_isi_kabupaten_kota" value="{{ $m->kondisi->alamat_saat_isi_kabupaten_kota }}" placeholder="Masukkan Alamat Saat Isi Kabupaten Kota">
                            @error('alamat_saat_isi_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_provinsi">Alamat Saat Isi Provinsi</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_provinsi') is-invalid @enderror" id="alamat_saat_isi_provinsi" name="alamat_saat_isi_provinsi" value="{{ $m->kondisi->alamat_saat_isi_provinsi }}" placeholder="Masukkan Alamat Saat Isi Provinsi">
                            @error('alamat_saat_isi_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai_tinggal_alamat_sekarang">Tanggal Mulai Tinggal Alamat Sekarang</label>
                            <input type="text" class="form-control @error('tanggal_mulai_tinggal_alamat_sekarang') is-invalid @enderror" id="tanggal_mulai_tinggal_alamat_sekarang" name="tanggal_mulai_tinggal_alamat_sekarang" value="{{ $m->kondisi->tanggal_mulai_tinggal_alamat_sekarang }}" placeholder="Masukkan Tanggal Mulai Tinggal Alamat Sekarang">
                            @error('tanggal_mulai_tinggal_alamat_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang">Moda Dipakai Meninggalkan Solo ke Alamat Sekarang</label>
                            <input type="text" class="form-control @error('moda_dipakai_meninggalkan_solo_ke_alamat_sekarang') is-invalid @enderror" id="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang" name="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang" value="{{ $m->kondisi->moda_dipakai_meninggalkan_solo_ke_alamat_sekarang }}" placeholder="Masukkan Moda Dipakai Meninggalkan Solo ke Alamat Sekarang">
                            @error('moda_dipakai_meninggalkan_solo_ke_alamat_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keadaan_sekarang">Keadaan Sekarang</label>
                            <input type="text" class="form-control @error('keadaan_sekarang') is-invalid @enderror" id="keadaan_sekarang" name="keadaan_sekarang" value="{{ $m->kondisi->keadaan_sekarang }}" placeholder="Masukkan keadaan sekarang">
                            @error('keadaan_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sakit_keterangan">Sakit Keterangan</label>
                            <input type="text" class="form-control @error('sakit_keterangan') is-invalid @enderror" id="sakit_keterangan" name="sakit_keterangan" value="{{ $m->kondisi->sakit_keterangan }}" placeholder="Masukkan sakit keterangan">
                            @error('sakit_keterangan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sakit_status_periksa">Sakit Status Periksa</label>
                            <input type="text" class="form-control @error('sakit_status_periksa') is-invalid @enderror" id="sakit_status_periksa" name="sakit_status_periksa" value="{{ $m->kondisi->sakit_status_periksa }}" placeholder="Masukkan sakit status periksa">
                            @error('sakit_status_periksa')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="sakit_periksa_diagnosa_saran_dokter">Sakit Periksa Diagnosa Saran Dokter</label>
                            <input type="text" class="form-control @error('sakit_periksa_diagnosa_saran_dokter') is-invalid @enderror" id="sakit_periksa_diagnosa_saran_dokter" name="sakit_periksa_diagnosa_saran_dokter" value="{{ $m->kondisi->sakit_periksa_diagnosa_saran_dokter }}" placeholder="Masukkan sakit periksa diagnosa saran dokter">
                            @error('sakit_periksa_diagnosa_saran_dokter')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>                                
                  <div class="form-group row pl-1 pr-1 justify-content-between">
                      <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                </form>
                @else
                <form class="form-horizontal" action="{{ url('mahasiswa/profil/kondisi') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="nama_lengkap">Nama lengkap</label>
                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $m->nama }}" placeholder="Masukkan nama lengkap" disabled>
                        @error('nama_lengkap')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fakultas">Fakultas</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="fakultas" name="fakultas" value="{{ old('fakultas') }}" placeholder="Masukkan fakultas">
                        @error('fakultas')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                        <div class="form-group">
                            <label for="program_prodi">Program Prodi</label>
                            <input type="text" class="form-control @error('program_prodi') is-invalid @enderror" id="program_prodi" name="program_prodi" value="{{ old('program_prodi') }}" placeholder="Masukkan program prodi">
                            @error('program_prodi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" id="nomor_telepon" name="nomor_telepon" value="{{ $m->no_telp }}" placeholder="Masukkan nomor telepon" disabled>
                            @error('nomor_telepon')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email_SSO">Email SSO</label>
                            <input type="email" class="form-control @error('email_SSO') is-invalid @enderror" id="email_SSO" name="email_SSO" value="{{ $m->email }}" placeholder="Masukkan email SSO" disabled>
                            @error('email_SSO')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_jalan_dan_nomor_rumah">Alamat Asal Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_asal_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_asal_jalan_dan_nomor_rumah" name="alamat_asal_jalan_dan_nomor_rumah" value="{{ old('alamat_asal_jalan_dan_nomor_rumah') }}" placeholder="Masukkan alamat asal jalan dan nomor rumah">
                            @error('alamat_asal_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_RT_RW">Alamat Asal RT RW</label>
                            <input type="text" class="form-control @error('alamat_asal_RT_RW') is-invalid @enderror" id="alamat_asal_RT_RW" name="alamat_asal_RT_RW" value="{{ old('alamat_asal_RT_RW') }}" placeholder="Masukkan alamat asal RT RW">
                            @error('alamat_asal_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_kelurahan">Alamat Asal Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_asal_kelurahan') is-invalid @enderror" id="alamat_asal_kelurahan" name="alamat_asal_kelurahan" value="{{ old('alamat_asal_kelurahan') }}" placeholder="Masukkan alamat asal kelurahan">
                            @error('alamat_asal_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_kabupaten_kota">Alamat Asal Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_asal_kabupaten_kota') is-invalid @enderror" id="alamat_asal_kabupaten_kota" name="alamat_asal_kabupaten_kota" value="{{ old('alamat_asal_kabupaten_kota') }}" placeholder="Masukkan alamat asal kabupaten kota">
                            @error('alamat_asal_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_asal_provinsi">Alamat Asal Provinsi</label>
                            <input type="text" class="form-control @error('alamat_asal_provinsi') is-invalid @enderror" id="alamat_asal_provinsi" name="alamat_asal_provinsi" value="{{ old('alamat_asal_provinsi') }}" placeholder="Masukkan alamat asal provinsi">
                            @error('alamat_asal_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_di_solo">Alamat di Solo</label>
                            <input type="text" class="form-control @error('alamat_di_solo') is-invalid @enderror" id="alamat_di_solo" name="alamat_di_solo" value="{{ old('alamat_di_solo') }}" placeholder="Masukkan alamat di solo">
                            @error('alamat_di_solo')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_jalan_dan_nomor_rumah">Alamat Solo Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_solo_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_solo_jalan_dan_nomor_rumah" name="alamat_solo_jalan_dan_nomor_rumah" value="{{ old('alamat_solo_jalan_dan_nomor_rumah') }}" placeholder="Masukkan alamat solo jalan dan nomor rumah">
                            @error('alamat_solo_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_RT_RW">Alamat Solo RT RW</label>
                            <input type="text" class="form-control @error('alamat_solo_RT_RW') is-invalid @enderror" id="alamat_solo_RT_RW" name="alamat_solo_RT_RW" value="{{ old('alamat_solo_RT_RW') }}" placeholder="Masukkan alamat solo RT RW">
                            @error('alamat_solo_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kelurahan">Alamat Solo Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_solo_kelurahan') is-invalid @enderror" id="alamat_solo_kelurahan" name="alamat_solo_kelurahan" value="{{ old('alamat_solo_kelurahan') }}" placeholder="Masukkan alamat solo kelurahan">
                            @error('alamat_solo_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kecamatan">Alamat Solo Kecamatan</label>
                            <input type="text" class="form-control @error('alamat_solo_kecamatan') is-invalid @enderror" id="alamat_solo_kecamatan" name="alamat_solo_kecamatan" value="{{ old('alamat_solo_kecamatan') }}" placeholder="Masukkan alamat solo kecamatan">
                            @error('alamat_solo_kecamatan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_kabupaten_kota">Alamat Solo Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_solo_kabupaten_kota') is-invalid @enderror" id="alamat_solo_kabupaten_kota" name="alamat_solo_kabupaten_kota" value="{{ old('alamat_solo_kabupaten_kota') }}" placeholder="Masukkan alamat solo kabupaten kota">
                            @error('alamat_solo_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_solo_provinsi">Alamat Solo Provinsi</label>
                            <input type="text" class="form-control @error('alamat_solo_provinsi') is-invalid @enderror" id="alamat_solo_provinsi" name="alamat_solo_provinsi" value="{{ old('alamat_solo_provinsi') }}" placeholder="Masukkan alamat solo provinsi">
                            @error('alamat_solo_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi">Alamat Saat Isi</label>
                            <input type="text" class="form-control @error('alamat_saat_isi') is-invalid @enderror" id="alamat_saat_isi" name="alamat_saat_isi" value="{{ old('alamat_saat_isi') }}" placeholder="Masukkan alamat saat isi">
                            @error('alamat_saat_isi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_jalan_dan_nomor_rumah">Alamat Saat Isi Jalan dan Nomor Rumah</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_jalan_dan_nomor_rumah') is-invalid @enderror" id="alamat_saat_isi_jalan_dan_nomor_rumah" name="alamat_saat_isi_jalan_dan_nomor_rumah" value="{{ old('alamat_saat_isi_jalan_dan_nomor_rumah') }}" placeholder="Masukkan Alamat Saat Isi Jalan dan Nomor Rumah">
                            @error('alamat_saat_isi_jalan_dan_nomor_rumah')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_RT_RW">Alamat Saat Isi RT RW</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_RT_RW') is-invalid @enderror" id="alamat_saat_isi_RT_RW" name="alamat_saat_isi_RT_RW" value="{{ old('alamat_saat_isi_RT_RW') }}" placeholder="Masukkan Alamat Saat Isi RT RW">
                            @error('alamat_saat_isi_RT_RW')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kelurahan">Alamat Saat Isi Kelurahan</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kelurahan') is-invalid @enderror" id="alamat_saat_isi_kelurahan" name="alamat_saat_isi_kelurahan" value="{{ old('alamat_saat_isi_kelurahan') }}" placeholder="Masukkan Alamat Saat Isi Kelurahan">
                            @error('alamat_saat_isi_kelurahan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kecamatan">Alamat Saat Isi Kecamatan</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kecamatan') is-invalid @enderror" id="alamat_saat_isi_kecamatan" name="alamat_saat_isi_kecamatan" value="{{ old('alamat_saat_isi_kecamatan') }}" placeholder="Masukkan Alamat Saat Isi Kecamatan">
                            @error('alamat_saat_isi_kecamatan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_kabupaten_kota">Alamat Saat Isi Kabupaten Kota</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_kabupaten_kota') is-invalid @enderror" id="alamat_saat_isi_kabupaten_kota" name="alamat_saat_isi_kabupaten_kota" value="{{ old('alamat_saat_isi_kabupaten_kota') }}" placeholder="Masukkan Alamat Saat Isi Kabupaten Kota">
                            @error('alamat_saat_isi_kabupaten_kota')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat_saat_isi_provinsi">Alamat Saat Isi Provinsi</label>
                            <input type="text" class="form-control @error('alamat_saat_isi_provinsi') is-invalid @enderror" id="alamat_saat_isi_provinsi" name="alamat_saat_isi_provinsi" value="{{ old('alamat_saat_isi_provinsi') }}" placeholder="Masukkan Alamat Saat Isi Provinsi">
                            @error('alamat_saat_isi_provinsi')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_mulai_tinggal_alamat_sekarang">Tanggal Mulai Tinggal Alamat Sekarang</label>
                            <input type="text" class="form-control @error('tanggal_mulai_tinggal_alamat_sekarang') is-invalid @enderror" id="tanggal_mulai_tinggal_alamat_sekarang" name="tanggal_mulai_tinggal_alamat_sekarang" value="{{ old('tanggal_mulai_tinggal_alamat_sekarang') }}" placeholder="Masukkan Tanggal Mulai Tinggal Alamat Sekarang">
                            @error('tanggal_mulai_tinggal_alamat_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang">Moda Dipakai Meninggalkan Solo ke Alamat Sekarang</label>
                            <input type="text" class="form-control @error('moda_dipakai_meninggalkan_solo_ke_alamat_sekarang') is-invalid @enderror" id="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang" name="moda_dipakai_meninggalkan_solo_ke_alamat_sekarang" value="{{ old('moda_dipakai_meninggalkan_solo_ke_alamat_sekarang') }}" placeholder="Masukkan Moda Dipakai Meninggalkan Solo ke Alamat Sekarang">
                            @error('moda_dipakai_meninggalkan_solo_ke_alamat_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keadaan_sekarang">Keadaan Sekarang</label>
                            <input type="text" class="form-control @error('keadaan_sekarang') is-invalid @enderror" id="keadaan_sekarang" name="keadaan_sekarang" value="{{ old('keadaan_sekarang') }}" placeholder="Masukkan keadaan sekarang">
                            @error('keadaan_sekarang')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sakit_keterangan">Sakit Keterangan</label>
                            <input type="text" class="form-control @error('sakit_keterangan') is-invalid @enderror" id="sakit_keterangan" name="sakit_keterangan" value="{{ old('sakit_keterangan') }}" placeholder="Masukkan sakit keterangan">
                            @error('sakit_keterangan')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="sakit_status_periksa">Sakit Status Periksa</label>
                            <input type="text" class="form-control @error('sakit_status_periksa') is-invalid @enderror" id="sakit_status_periksa" name="sakit_status_periksa" value="{{ old('sakit_status_periksa') }}" placeholder="Masukkan sakit status periksa">
                            @error('sakit_status_periksa')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="form-group">
                            <label for="sakit_periksa_diagnosa_saran_dokter">Sakit Periksa Diagnosa Saran Dokter</label>
                            <input type="text" class="form-control @error('sakit_periksa_diagnosa_saran_dokter') is-invalid @enderror" id="sakit_periksa_diagnosa_saran_dokter" name="sakit_periksa_diagnosa_saran_dokter" value="{{ old('sakit_periksa_diagnosa_saran_dokter') }}" placeholder="Masukkan sakit periksa diagnosa saran dokter">
                            @error('sakit_periksa_diagnosa_saran_dokter')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>                                
                  <div class="form-group row pl-1 pr-1 justify-content-between">
                      <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                </form>
                @endif
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
