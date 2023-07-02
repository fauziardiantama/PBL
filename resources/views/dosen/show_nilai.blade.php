@extends('dosen.layouts.base')
@section('title', 'Detail Nilai Mahaisiswa')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Nilai Mahasiswa</li>
<li class="breadcrumb-item active">Detail</li>
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
        @if (session('berhasil'))
            $(function() {
                Toast.fire({
                    icon: 'success',
                    title: '{{ session('berhasil') }}'
                })
            });
        @endif
    });
</script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#nilaibimbingan" data-toggle="tab">Nilai Bimbingan</a></li>
              <li class="nav-item"><a class="nav-link" href="#nilaiseminar" data-toggle="tab">Nilai Seminar</a></li>
              <li class="nav-item"><a class="nav-link" href="#nilaiakhir" data-toggle="tab">Nilai Akhir</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="nilaibimbingan">
                <h5>Nilai Bimbingan</h5>
                 <div class="mb-5">
                    <table class="table table-bordered">
                      <tr>
                          <th>#</th>
                          <th>parameter</th>
                          <th>nilai</th>
                      </tr>
                      @if($nilaibimbingan != null)
                          @foreach($nilaibimbingan as $nilai)
                              <tr>
                                  <td>{{ $loop->iteration }}</td>
                                  <td>{{ ($nilai->parameter()->exists())? $nilai->parameter->parameter : 'Parameter tidak diketahui' }}</td>
                                  <td>{{ $nilai->nilai }}</td>
                              </tr>
                          @endforeach
                      @else
                      <tr>
                          <td colspan="3" class="text-center">Belum ada nilai</td>
                      </tr>
                      @endif
                    </table>
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-add-bimbingan">
                      Masukkan nilai
                    </button>
                 </div>
              </div>
              <div class="tab-pane" id="nilaiseminar">
                <h5>Nilai Seminar</h5>
                 <div class="mb-5">
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
                                  <td>{{ ($nilai->parameter()->exists())? $nilai->parameter->parameter : 'Parameter tidak diketahui' }}</td>
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
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-add-seminar">
                      Masukkan nilai
                    </button>
                 </div>
              </div>
              <div class="tab-pane" id="nilaiakhir">
                <h5>Nilai Akhir</h5>
                 <div class="mb-5">
                    <dl class="row">
                        <dt class="col-sm-4">Nilai Akhir</dt>
                        <dd class="col-sm-8">
                            {{ ($nilaiakhir != null)? $nilaiakhir->nilai_akhir : 'belum ada nilai' }}
                        </dd>
                    </dl>
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
</div>

@endsection
@section('modal')
<div class="modal fade" id="modal-add-bimbingan" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/dosen/nilai/'.$magang->id_magang.'/nilaibimbingan') }}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="modal-header">
          <h4 class="modal-title">Masukkan nilai bimbingan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="form-group">
                    <label for="id_parameter">Parameter</label>
                    <select class="form-control @error('id_parameter') is-invalid @enderror" id="id_parameter" name="id_parameter">
                        @foreach($parameter_bimbingan as $parameter)
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
                  <label for="nilai">Nilai</label>
                  <input type="text" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" value="{{ old('nilai') }}" placeholder="Masukkan nilai">
                  @error('nilai')
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
<div class="modal fade" id="modal-add-seminar" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('/dosen/nilai/'.$magang->id_magang.'/nilaiseminar') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Masukkan nilai seminar</h4>
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
                <label for="nilai_pembimbing">Nilai</label>
                <input type="text" class="form-control @error('nilai_pembimbing') is-invalid @enderror" id="nilai_pembimbing" name="nilai_pembimbing" value="{{ old('nilai_pembimbing') }}" placeholder="Masukkan nilai seminar">
                @error('nilai_pembimbing')
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
<div class="modal fade" id="modal-add-akhir" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('/dosen/nilai/'.$magang->id_magang.'/nilaiakhir') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Masukkan nilai akhir</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
              <div class="form-group">
                <label for="nilai_akhir">Nilai akhir</label>
                <input type="text" class="form-control @error('nilai_akhir') is-invalid @enderror" id="nilai_akhir" name="nilai_akhir" value="{{ old('nilai_akhir') }}" placeholder="Masukkan nilai akhir">
                @error('nilai_akhir')
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
