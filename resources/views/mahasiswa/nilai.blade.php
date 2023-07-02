@extends('mahasiswa.layouts.base')
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
  @include('partials.simple-dataview-with-navbar', [
    'list' => [
        [
            'title' => 'Nilai instansi',
            'id' => 'nilaiinstansi',
            'value' => view('mahasiswa.nilai.nilai_instansi', compact('nilaiinstansi'))->render(),
            'status' => true,
            'active' => (Request::get('active') && Request::get('active') == 'nilaiinstansi') ? true : false,
        ],
        [
            'title' => 'Nilai bimbingan',
            'id' => 'nilaibimbingan',
            'value' => view('mahasiswa.nilai.nilai_bimbingan', compact('nilaibimbingan'))->render(),
            'status' => true,
            'active' => (Request::get('active') && Request::get('active') == 'nilaibimbingan') ? true : false,
        ],
        [
            'title' => 'Nilai seminar',
            'id' => 'nilaiseminar',
            'value' => view('mahasiswa.nilai.nilai_seminar', compact('nilaiseminar'))->render(),
            'status' => true,
            'active' => (Request::get('active') && Request::get('active') == 'nilaiseminar') ? true : false,
        ],
        [
            'title' => 'Nilai akhir',
            'id' => 'nilaiakhir',
            'value' => view('mahasiswa.nilai.nilai_akhir', compact('nilaiakhir'))->render(),
            'status' => true,
            'active' => (Request::get('active') && Request::get('active') == 'nilaiakhir') ? true : false,
        ],
    ],
  ])
@endsection
@section('modal')
@if($nilaiinstansi == null)
  @include('partials.simple-modal-form', ['title' => 'Upload dokumen nilai',
    'id' => 'modal-add-dokumen',
    'form' => [
        'action' => url('/mahasiswa/nilai/instansi'),
        'method' => 'post',
        'inputs' => [
            [
                'label' => 'Dokumen nilai',
                'type' => 'file',
                'name' => 'dokumen',
                'disabled' => false,
                'value' => old('dokumen')
            ],
        ],
        'submit' => [
            'label' => 'Simpan',
        ],
    ]
  ])
@elseif($nilaiinstansi->status != 1)
  @include('partials.simple-modal-form', ['title' => 'Update dokumen nilai',
    'id' => 'modal-update-dokumen',
    'form' => [
        'action' => url('/mahasiswa/nilai/instansi'),
        'method' => 'put',
        'inputs' => [
            [
                'label' => 'Dokumen nilai',
                'type' => 'file',
                'name' => 'dokumen',
                'disabled' => false,
                'value' => old('dokumen')
            ],
        ],
        'submit' => [
            'label' => 'Simpan',
        ],
    ]
  ])
@endif
@endsection

{{-- <div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#nilaiinstansi" data-toggle="tab">Nilai Instansi</a></li>
            <li class="nav-item"><a class="nav-link" href="#nilaibimbingan" data-toggle="tab">Nilai Bimbingan</a></li>
            <li class="nav-item"><a class="nav-link" href="#nilaiseminar" data-toggle="tab">Nilai Seminar</a></li>
            <li class="nav-item"><a class="nav-link" href="#nilaiakhir" data-toggle="tab">Nilai Akhir</a></li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="nilaiinstansi">
               <h5>Nilai Instansi</h5>
               <div class="mb-5">
                  <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>parameter</th>
                        <th>nilai</th>
                    </tr>
                  @if($nilaiinstansi != null && $nilaiinstansi->detail_nilai_instansi()->exists())
                      @foreach($nilaiinstansi->detail_nilai_instansi()->orderBy('id_parameter', 'asc')->get() as $nilai)
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $nilai->parameter->parameter }}</td>
                              <td>{{ $nilai->nilai }}</td>
                          </tr>
                      @endforeach
                  @else
                  <tr>
                      <td colspan="3" class="text-center">Belum ada nilai</td>
                  </tr>
                  @endif
                  </table>
                  <dl class="row">
                      <dt class="col-sm-4">Dokumen Nilai Instansi</dt>
                      <dd class="col-sm-8">
                          @if($nilaiinstansi == null)
                          <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-add-dokumen">
                              Upload dokumen
                          </button>
                          @elseif($nilaiinstansi->status !== 1)
                          <button type="button" class="btn btn-sm btn-primary m-1" data-toggle="modal" data-target="#modal-update-dokumen">
                            Ubah dokumen
                          </button>
                          <a href="{{ url('documents/nilai-instansi/'.$nilaiinstansi->dokumen) }}" class="btn btn-sm btn-primary m-1">Download dokumen</a>
                          @else
                          <a href="{{ url('documents/nilai-instansi/'.$nilaiinstansi->dokumen) }}" class="btn btn-sm btn-primary m-1">Download dokumen</a>
                          @endif
                      </dd>
                  </dl>
               </div>
            </div>
            <div class="tab-pane" id="nilaibimbingan">
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
                              <td>{{ $nilai->parameter->parameter }}</td>
                              <td>{{ $nilai->nilai }}</td>
                          </tr>
                      @endforeach
                  @else
                  <tr>
                      <td colspan="3" class="text-center">Belum ada nilai</td>
                  </tr>
                  @endif
                  </table>
               </div>
            </div>
            <div class="tab-pane" id="nilaiseminar">
              <h5>Nilai Seminar</h5>
               <div class="mb-5">
                  <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>parameter</th>
                        <th>nilai</th>
                    </tr>
                  @if($nilaiseminar != null)
                      @foreach($nilaiseminar as $nilai)
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $nilai->parameter->parameter }}</td>
                              <td>{{ $nilai->nilai }}</td>
                          </tr>
                      @endforeach
                  @else
                  <tr>
                      <td colspan="3" class="text-center">Belum ada nilai</td>
                  </tr>
                  @endif
                  </table>
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
</div> --}}
