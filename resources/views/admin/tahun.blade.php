@extends('admin.layouts.base')
@section('title', 'Tahun')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Tahun</li>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header" style="background-color: #010080;">
                <h3 class="card-title">Tahun</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ url('admin/tahun') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun') }}" id="tahun" name="tahun"
                            placeholder="Masukkan Tahun">
                            @error('tahun')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
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
                            <th style="width: 20%">Tahun</th>
                            <th style="width: 30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tahun->count() > 0)
                            @foreach ($tahun as $item)
                                @if(Request::get('edit') && Request::get('edit') == $item->tahun)
                                <form action="{{ url('admin/topik-kmm/' . $item->tahun) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td>2.</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('tahun') is-invalid @enderror" name="tahun"
                                                    style="height: 30px" id="tahun"
                                                    placeholder="Masukkan tahun" value="{{ $item->tahun }}">
                                                    @error('tahun')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                            </div>
                                        </td>
                                        <td>{{ $item->tahun }}

                                        </td>
                                    <td>
                                            <button type="submit"
                                                class="btn btn-sm btn-success">Simpan</button>
                                        </td>
                                    </tr>
                                </form>
                                @else
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tahun }}</td>
                        
                                    <td>
                                       
                                        <form action="{{ url('admin/tahun/'.$item->tahun) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data topik</td>
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