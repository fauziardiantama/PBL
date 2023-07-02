@extends('admin.layouts.base')
@section('title', 'Detail Berita')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Berita</li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-9">
      <div class="card card-primary card-outline">
        <div class="card-header">
          <h3 class="card-title">Detail Berita</h3>
          <div class="card-tools">
            <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <div class="mailbox-read-info">
            <h5 class="font-weight-bolder">{{ $b->judul }}</h5>
            <h6>Author : {{ $b->author }}
              <span class="mailbox-read-time float-right">{{ $b->tanggal }}</span></h6>
          </div>
          <!-- /.mailbox-read-info -->
         
          <!-- /.mailbox-controls -->
          <div class="mailbox-read-message">
            {!! $b->deskripsi !!}
          </div>
          <!-- /.mailbox-read-message -->
        </div>
        <!-- /.card-footer -->
      </div>
    </div>
    <div class="col-lg-3">
      <div class="d-lg-flex flex-column">
        <a href="{{ url('/admin/berita/'.$b->id_berita.'?edit=true') }}" class="btn btn-primary btn-lg mb-2" type="button">Edit</a>
          @if(!$b->status_publikasi)
          <form action="{{ url('admin/berita/'.$b->id_berita.'/publish') }}" method="POST" style="display:contents">
              @csrf
              @method('PUT')
              <input type="submit"  class="btn btn-lg mb-2 btn-success"  value="Publish">
          </form>
          @else
          <form action="{{ url('admin/berita/'.$b->id_berita.'/unpublish') }}" method="POST" style="display:contents">
              @csrf
              @method('PUT')
              <input type="submit"  class="btn btn-lg mb-2 btn-danger"  value="Unpublish">
          </form>
          @endif
          <form action="{{ url('admin/berita/'.$b->id_berita) }}" method="POST" style="display:contents">
              @csrf
              @method('DELETE')
              <input type="submit"  class="btn btn-lg mb-2 btn-danger" value="Hapus">
          </form>
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