@extends('admin.layouts.base')
@section('title', 'Progres')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Progres</li>
@endsection
@section('content')
<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Progres</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 20%">Progres</th>
                            <th style="width: 20%">ID Progres</th>
                            <th style="width: 30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($progres->count() > 0)
                            @foreach ($progres as $item)
                                @if(Request::get('edit') && Request::get('edit') == $item->id_progres)
                                <form action="{{ url('admin/progres/' . $item->id_progres) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <tr>
                                        <td>2.</td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('progres') is-invalid @enderror" name="progres"
                                                    style="height: 30px" id="progres"
                                                    placeholder="Masukkan progres" value="{{ $item->progres }}">
                                                    @error('progres')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control @error('id_progres') is-invalid @enderror" name="id_progres"
                                                    style="height: 30px" id="id_progres"
                                                    placeholder="Masukkan progres" value="{{ $item->id_progres }}">
                                                    @error('id_progres')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                            </div>
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
                                    <td>{{ $item->progres }}</td>
                                    <td>{{ $item->id_progres }} </td>
                        
                                    <td>
                                    <a href="{{ url('admin/progres?edit='.$item->id_progres) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ url('admin/progres/'.$item->id_progres) }}" method="post"
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
                            <td colspan="4" class="text-center">Tidak ada data progres</td>
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
