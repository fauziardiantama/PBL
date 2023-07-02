@extends('dosen.layouts.base')
@section('title', 'Detail Penguji')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Penguji</li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Penguji Seminar {{ $seminar->judul_kmm }}
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
                <dl class="row">
                    <dt class="col-sm-4">Judul kmm</dt>
                    <dt class="col-sm-8">: {{ $seminar->judul_kmm }}</dt>
                    <dt class="col-sm-4">Nama mahasiswa</dt>
                    <dt class="col-sm-8">: {{ $magang->mahasiswa->nama }}</dt>
                    <dt class="col-sm-4">NIM mahasiswa</dt>
                    <dt class="col-sm-8">: {{ $magang->mahasiswa->nim }}</dt>
                    <dt class="col-sm-4">Tanggal daftar</dt>
                    <dt class="col-sm-8">: {{ $seminar->tgl_daftar }}</dt>
                    <dt class="col-sm-4">Tanggal seminar</dt>
                    <dt class="col-sm-8">: {{ ($seminar->tgl_seminar != null)? $seminar->tgl_seminar : 'Belum ditentukan' }}</dt>
                    <dt class="col-sm-4">Laporan kmm</dt>
                    <dt class="col-sm-8">: <a href="{{ asset('storage/seminar/'.$seminar->draft_kmm) }}" target="_blank">{{ $seminar->draft_kmm }}</a></dt>
                    <dt class="col-sm-4">KRS terbaru</dt>
                    <dt class="col-sm-8">: <a href="{{ asset('storage/seminar/'.$seminar->krs) }}" target="_blank">{{ $seminar->krs }}</a></dt>
                    <dt class="col-sm-4">Foto dokumentasi kmm</dt>
                    <dt class="col-sm-8">: <a href="{{ asset('storage/seminar/'.$seminar->foto) }}" target="_blank">{{ $seminar->foto }}</a></dt>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-text-width"></i>
                    Nilai
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
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>parameter</th>
                        <th>nilai pembimbing</th>
                        <th>nilai penguji</th>
                        <th>nilai</th>
                    </tr>
                    @if($nilaiseminar != null)
                        @foreach($nilaiseminar as $nilai)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nilai->parameter->parameter }}</td>
                                <td>{{ $nilai->nilai_pembimbing }}</td>
                                <td>{{ $nilai->nilai_penguji }}</td>
                                <td>{{ $nilai->nilai }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Belum ada nilai</td>
                    </tr>
                    @endif
                  </table>
                  <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-add-penguji">
                    Masukkan nilai
                  </button>
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
<div class="modal fade" id="modal-add-penguji" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/dosen/penguji/'.$magang->id_magang.'/nilai') }}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="modal-header">
          <h4 class="modal-title">Masukkan nilai pengujir</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="form-group">
                    <label for="id_parameter">Parameter</label>
                    <select class="form-control @error('id_parameter') is-invalid @enderror" id="id_parameter" name="id_parameter">
                        @foreach($parameter_seminar as $parameter)
                            <option value="{{ $parameter->id_parameter }}">{{ $parameter->parameter }}</option>
                        @endforeach
                    </select>
                    @error('id_parameter')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                  <label for="nilai_penguji">Nilai Penguji</label>
                  <input type="text" class="form-control @error('nilai_penguji') is-invalid @enderror" id="nilai_penguji" name="nilai_penguji" value="{{ old('nilai_penguji') }}" placeholder="Masukkan nilai penguji">
                  @error('nilai_penguji')
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