@extends('admin.layouts.base')
@section('title', 'Nilai Magang')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Nilai Magang</li>
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
              <li class="nav-item"><a class="nav-link active" href="#bobotnilai" data-toggle="tab">Bobot Nilai</a></li>
              <li class="nav-item"><a class="nav-link" href="#parameterseminar" data-toggle="tab">Parameter Nilai Seminar</a></li>
              <li class="nav-item"><a class="nav-link" href="#parameterbimbingan" data-toggle="tab">Parameter Nilai Bimbingan</a></li>
              <li class="nav-item"><a class="nav-link" href="#parameterinstansi" data-toggle="tab">Parameter Nilai Instansi</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="active tab-pane" id="bobotnilai">
                 <h5>Bobot Nilai</h5>
                 <div class="mb-5">
                    <table class="table table-bordered">
                      <tr>
                          <th>tahun</th>
                          <th>jenis nilai</th>
                          <th>persentase</th>
                      </tr>
                    @if($bobotnilai->count() > 0)
                        @foreach($bobotnilai as $bobot)
                            <tr>
                                <td>{{ $bobot->tahun }}</td>
                                <td>{{ $bobot->jenis_nilai }}</td>
                                <td>{{ $bobot->persentase }}%</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Belum ada bobot nilai</td>
                    </tr>
                    @endif
                    </table>
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-bobot-nilai">
                      Tambah Bobot Nilai
                    </button>
                 </div>
              </div>
              <div class="tab-pane" id="parameterseminar">
                <h5>Parameter Seminar</h5>
                 <div class="mb-5">
                    <table class="table table-bordered">
                      <tr>
                          <th>Tahun</th>
                          <th>parameter</th>
                      </tr>
                    @if($parameterseminar->count() > 0)
                        @foreach($parameterseminar as $parameter)
                            <tr>
                              <td>{{ $parameter->tahun }}</td>
                              <td>{{ $parameter->parameter }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Belum ada parameter</td>
                    </tr>
                    @endif
                    </table>
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-parameter-seminar">
                      Tambah Parameter Seminar
                    </button>
                 </div>
              </div>
              <div class="tab-pane" id="parameterbimbingan">
                <h5>Parameter Bimbingan</h5>
                 <div class="mb-5">
                    <table class="table table-bordered">
                      <tr>
                          <th>Tahun</th>
                          <th>parameter</th>
                      </tr>
                    @if($parameterbimbingan->count() > 0)
                        @foreach($parameterbimbingan as $parameter)
                            <tr>
                              <td>{{ $parameter->tahun }}</td>
                              <td>{{ $parameter->parameter }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Belum ada parameter</td>
                    </tr>
                    @endif
                    </table>
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-parameter-bimbingan">
                      Tambah Parameter Bimbingan
                    </button>
                 </div>
              </div>
              <div class="tab-pane" id="parameterinstansi">
                <h5>Parameter Instansi</h5>
                 <div class="mb-5">
                    <table class="table table-bordered">
                      <tr>
                          <th>Tahun</th>
                          <th>parameter</th>
                      </tr>
                    @if($parameterinstansi->count() > 0)
                        @foreach($parameterinstansi as $parameter)
                            <tr>
                              <td>{{ $parameter->tahun }}</td>
                              <td>{{ $parameter->parameter }}</td>
                            </tr>
                        @endforeach
                    @else
                    <tr>
                        <td colspan="3" class="text-center">Belum ada parameter</td>
                    </tr>
                    @endif
                    </table>
                    <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#add-parameter-instansi">
                      Tambah Parameter Instansi
                    </button>
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
<div class="modal fade" id="add-bobot-nilai" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/admin/nilai/bobotnilai') }}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="modal-header">
          <h4 class="modal-title">Tambah Bobot Nilai</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <select class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                      @foreach($tahun as $t)
                      <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                      @endforeach
                    </select>
                    @error('tahun')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                  <label for="jenis_nilai">Jenis nilai</label>
                  <select class="form-control @error('jenis_nilai') is-invalid @enderror" id="jenis_nilai" name="jenis_nilai" value="{{ old('jenis_nilai') }}">
                    <option value="bimbingan">bimbingan</option>
                    <option value="seminar">Seminar</option>
                    <option value="instansi">Instansi</option>
                  </select>
                  @error('jenis_nilai')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="persentase">Persentase</label>
                  <input type="text" class="form-control @error('persentase') is-invalid @enderror" id="persentase" name="persentase" value="{{ old('persentase') }}" placeholder="Masukkan persentase">
                  @error('persentase')
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
<div class="modal fade" id="add-parameter-seminar" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('/admin/nilai/parameternilaiseminar') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Tambah Parameter Nilai Seminar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
              <div class="form-group">
                  <label for="tahun">Tahun</label>
                  <select class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                    @foreach($tahun as $t)
                    <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                    @endforeach
                  </select>
                  @error('tahun')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <div class="form-group">
                <label for="parameter">Parameter</label>
                <input type="text" class="form-control @error('parameter') is-invalid @enderror" id="parameter" name="parameter" value="{{ old('parameter') }}" placeholder="Masukkan parameter">
                @error('parameter')
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
<div class="modal fade" id="add-parameter-bimbingan" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('/admin/nilai/parameternilaibimbingan') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Tambah Parameter Nilai Bimbingan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
              <div class="form-group">
                  <label for="tahun">Tahun</label>
                  <select class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                    @foreach($tahun as $t)
                    <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                    @endforeach
                  </select>
                  @error('tahun')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <div class="form-group">
                <label for="parameter">Parameter</label>
                <input type="text" class="form-control @error('parameter') is-invalid @enderror" id="parameter" name="parameter" value="{{ old('parameter') }}" placeholder="Masukkan parameter">
                @error('parameter')
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
<div class="modal fade" id="add-parameter-instansi" aria-hidden="true" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ url('/admin/nilai/parameternilaiinstansi') }}" method="post" enctype="multipart/form-data">
          @csrf
        <div class="modal-header">
        <h4 class="modal-title">Tambah Parameter Nilai Instansi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
              <div class="form-group">
                  <label for="tahun">Tahun</label>
                  <select class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" value="{{ old('tahun') }}">
                    @foreach($tahun as $t)
                    <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                    @endforeach
                  </select>
                  @error('tahun')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>
              <div class="form-group">
                <label for="parameter">Parameter</label>
                <input type="text" class="form-control @error('parameter') is-invalid @enderror" id="parameter" name="parameter" value="{{ old('parameter') }}" placeholder="Masukkan parameter">
                @error('parameter')
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
