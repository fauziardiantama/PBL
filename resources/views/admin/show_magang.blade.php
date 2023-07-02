@extends('admin.layouts.base')
@section('title', 'Detail Magang')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Magang</li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')
    @include('partials.simple-dataview-with-navbar', [
        'list' => [
            [
                'title' => 'Detail Magang',
                'id' => 'detailmagang',
                'value' => view('admin.show_magang.detail_magang', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailmagang') ? true : false,
            ],
            [
                'title' => 'Detail Instansi',
                'id' => 'detailinstansi',
                'value' => view('admin.show_magang.detail_instansi', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailinstansi') ? true : false,
            ],
            [
                'title' => 'Rencana Magang',
                'id' => 'rencanamagang',
                'value' => view('admin.show_magang.rencana_magang', compact('rencana'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'rencanamagang') ? true : false,
            ],
            [
                'title' => 'Surat Magang',
                'id' => 'suratmagang',
                'value' => view('admin.show_magang.surat_magang', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'suratmagang') ? true : false,
            ],
            [
                'title' => 'Bimbingan Dosen',
                'id' => 'bimbingandosen',
                'value' => view('admin.show_magang.bimbingan_dosen', compact('magang','bimbingandosen'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'bimbingandosen') ? true : false,
            ],
            [
                'title' => 'Bimbingan Instansi',
                'id' => 'bimbinganinstansi',
                'value' => view('admin.show_magang.bimbingan_instansi', compact('magang','bimbinganinstansi'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'bimbinganinstansi') ? true : false,
            ],
            [
                'title' => 'Seminar dan revisi',
                'id' => 'seminardanrevisi',
                'value' => view('admin.show_magang.seminar_dan_revisi', compact('magang','seminar','revisi','dosenthistopik','dosenpenguji'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'seminardanrevisi') ? true : false,
            ],
            [
                'title' => 'Nilai',
                'id' => 'nilai',
                'value' => view('admin.show_magang.nilai', compact('magang','nilaiakhir','nilaiseminar','nilaibimbingan','nilaiinstansi'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'nilai') ? true : false,
            ]
        ],
    ])
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
<script>
    $(document).ready(function () {
        $(".disabled-link").click(function () {
        return false;
        });
    });
</script>
@endsection
@section('css')
<style>
    .disabled-link {
        color: rgb(153,153,153) !important;
        cursor: not-allowed !important;
    }
</style>
@endsection
@section('modal')
<div class="modal fade" id="modal-nilai-instansi" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/admin/bimbingan/'.$magang->id_magang.'/nilaiinstansi') }}" method="post" enctype="multipart/form-data">
            @csrf
          <div class="modal-header">
          <h4 class="modal-title">Masukkan nilai instansi</h4>
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
@endsection