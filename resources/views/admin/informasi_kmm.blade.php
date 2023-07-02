@extends('admin.layouts.base')
@section('title', 'Informasi KMM')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Informasi KMM</li>
@endsection
@section('content')
<div class="row">
  <!-- /.col -->
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Daftar Dokumen KMM</h3>

        <div class="card-tools">
          <ul class="pagination pagination-sm float-right">
            {{ $d->links() }}
          </ul>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body p-0">
        <table class="table">
          <thead>
            <tr>
              <th style="width: 10%">#</th>
              <th style="width: 30%">Judul</th>
              <th style="width: 20%">Download</th>
              <th style="width: 10%">Tanggal</th>
              <th style="width: 30%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @if($d->count() > 0)
              @foreach($d as $doc)
                @php
                    $index = ($d->currentPage() - 1) * $d->perPage() + $loop->index + 1;
                @endphp
              <tr>
                <td>{{ $index }}</td>
                <td>{{ $doc->judul }}</td>
                <td><a href="{{ url('/documents/'.$doc->dokumen) }}">{{ $doc->dokumen }}</a></td>
                <td><span class="badge bg-success">{{ $doc->tanggal }}</span></td>
                <td>
                  <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-deskripsi-{{ $doc->id_informasi }}">Deskripsi</a>
                  @if($doc->status_publikasi == 0)
                  <form action="{{ url('/admin/informasi-kmm/'.$doc->id_informasi.'/publish') }}" style="display: contents" method="post">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-sm btn-success">Publish</button>
                  </form> 
                  @else
                  <form action="{{ url('/admin/informasi-kmm/'.$doc->id_informasi.'/unpublish') }}" style="display: contents" method="post">
                  @csrf
                  @method('PUT')
                  <button type="submit" class="btn btn-sm btn-danger">Unpublish</button>
                  </form>
                  @endif
                  <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit-{{ $doc->id_informasi }}">Edit</a>
                  <form action="{{ url('/admin/informasi-kmm/'.$doc->id_informasi) }}" style="display: contents" method="post">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                  </form>
                </td>
              </tr>
              @endforeach
            @else
            <tr>
              <td colspan="5" class="text-center">Tidak ada data dokumen</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <div>
      <a href="#" class="btn btn-primary" style="background-color:#010080; border-color:#010080 ;" data-toggle="modal" data-target="#modal-add">Tambah Dokumen</a>
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
  @foreach($d as $doc)
  <div class="modal fade" id="modal-deskripsi-{{ $doc->id_informasi }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">{{ $doc->judul }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Deskripsi :</p>
          <p>{!! $doc->deskripsi !!}</p>
          <p>Preview :</p>
          <iframe src="{{ url('/documents/'.$doc->dokumen) }}" style="width: 100%;height:300px" allow="autoplay"></iframe>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @endforeach
  <div class="modal fade" id="modal-add" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/admin/informasi-kmm') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="modal-header">
          <h4 class="modal-title">Tambah Dokumen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul') }}" id="judul" name="judul" placeholder="Masukkan judul">
                @error('judul')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror  
                </div>
                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" value="{{ old('deskripsi') }}" rows="3" name="deskripsi" placeholder="Masukkan Deskripsi..."></textarea>
                @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                </div>
                <div class="form-group">
                  <label for="dokumen">Dokumen</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control @error('dokumen') is-invalid @enderror" name="dokumen" id="dokumen">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    @error('dokumen')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <div>
              <input type="submit" name="submit" value="Publish" class="btn btn-success">
              <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @foreach($d as $doc)
  <div class="modal fade" id="modal-edit-{{ $doc->id_informasi }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form action="{{ url('/admin/informasi-kmm/'.$doc->id_informasi) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
          <div class="modal-header">
          <h4 class="modal-title">Edit Dokumen</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
          </div>
          <div class="modal-body">
              <div class="card-body">
                <div class="form-group">
                <label for="judul">Judul</label>
                <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ $doc->judul }}" placeholder="Masukkan Judul">
                @error('judul')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror    
                </div>
                <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('judul') is-invalid @enderror" rows="3" id="deskripsi" name="deskripsi" placeholder="Masukkan Deskripsi...">{{ $doc->deskripsi }}</textarea>
                @error('deskripsi')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror  
                </div>
                <div class="form-group">
                  <label for="dokumen">Dokumen</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input form-control @error('judul') is-invalid @enderror" id="dokumen" name="dokumen">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    @error('dokumen')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <div>
              @if($doc->status_publikasi == 0)
              <input type="submit" name="submit" value="Publish" class="btn btn-success">
              @else
                <input type="submit" name="submit" value="Unpublish" class="btn btn-danger">
                @endif
              <input type="submit" name="submit" value="Simpan" class="btn btn-primary">
            </div>
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @endforeach
@endsection