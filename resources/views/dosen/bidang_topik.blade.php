@extends('dosen.layouts.base')
@section('title', 'Bidang Topik')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Bidang Topik</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header" style="background-color: #010080;">
                <h3 class="card-title">Tambah Topik</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('/dosen/bidang-topik') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="id_topik">Select</label>
                            <select name="id_topik" class="form-control">
                                @foreach ($lt as $list_topik)
                                    <option value="{{ $list_topik->id_topik }}">{{ $list_topik->nama_topik }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"
                        style="background-color: #010080; border-color:#010080">Tambah</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Topik KMM</h3>

                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 50%">Topik</th>
                            <th style="width: 40%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($t->count() > 0)
                        @foreach ($t as $topik)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $topik->nama_topik }}</td>
                            <td>
                                <form action="{{ url('/dosen/bidang-topik') }}" method="post"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id_topik" value="{{ $topik->id_topik }}">
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">Tidak ada data topik</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
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