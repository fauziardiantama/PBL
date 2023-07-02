@extends('admin.layouts.base')
@section('title', 'Berita')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Berita</li>
@endsection
@section('content')
<div class="card card-primary mb-3 card-outline">
  <div class="card-header">
    <h3 class="card-title">Daftar Berita</h3>
    <div class="card-tools">
    </div>
    <!-- /.card-tools -->
  </div>
  <!-- /.card-header -->
  <div class="card-body p-0">
    <div class="mailbox-controls">
      <div class="float-right">
        {{ $berita->links() }}
      </div>
      <!-- /.float-right -->
    </div>
    <div class="table-responsive mailbox-messages">
    @if(count($berita) > 0)
      <table class="table table-hover table-striped">
        <tbody>
          @foreach($berita as $b)
              <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $b->judul }}</td>
                  <td>{!! (strlen($b->deskripsi) > 100)? substr(preg_replace( '/<p\b[^>]*>(.*?)<\/p>/i', '<span>$1</span>', preg_replace('/<img\s[^>]*>/i', '[image]', $b->deskripsi) ), 0, 100).'...' : substr(preg_replace( '/<p\b[^>]*>(.*?)<\/p>/i', '<span>$1</span>', $b->deskripsi), 0, 100) !!}</td>
                  <td>@if($b->status_publikasi == false) <span class="badge bg-danger">belum dipublish</span> @else <span class="badge bg-success">sudah dipublish</span> @endif</td>
                  <td style="width:25%">
                      <a href="{{ url('admin/berita/'.$b->id_berita) }}"  class="btn btn-sm btn-info">Detail</a>
                      @if(!$b->status_publikasi)
                          <form action="{{ url('admin/berita/'.$b->id_berita.'/publish') }}" method="POST" style="display:contents">
                              @csrf
                              @method('PUT')
                              <input type="submit"  class="btn btn-sm btn-success"  value="Publish">
                          </form>
                      @else
                          <form action="{{ url('admin/berita/'.$b->id_berita.'/unpublish') }}" method="POST" style="display:contents">
                              @csrf
                              @method('PUT')
                              <input type="submit"  class="btn btn-sm btn-danger"  value="Unpublish">
                          </form>
                      @endif
                      <form action="{{ url('admin/berita/'.$b->id_berita) }}" method="POST" style="display:contents">
                          @csrf
                          @method('DELETE')
                          <input type="submit"  class="btn btn-sm btn-danger" value="Hapus">
                      </form>
                  </td>
              </tr>
          @endforeach
        </tbody>
      </table>
      @else
        <div class="text-center">
          <p class="lead">Belum ada berita</p>
        </div>
      @endif
      <!-- /.table -->
    </div>
    <!-- /.mail-box-messages -->
  </div>
  <!-- /.card-body -->
</div>
<div>
  <a href="{{ url('admin/berita/add') }}" class="btn btn-primary" style="background-color:#010080; border-color:#010080 ;">Buat Berita</a>
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