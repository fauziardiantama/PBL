@extends('admin.layouts.base')
@section('title', 'Instansi')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Instansi</li>
@endsection
@section('content')
<div class="row">
    <!-- /.col -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Instansi</h3>
                <div class="card-tools">
                    <ul class="pagination pagination-sm float-right">
                        {{ $instansi->links() }}
                    </ul>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 10%">#</th>
                            <th style="width: 45%">Nama Instansi</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 35%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($instansi->count() > 0)
                            @foreach ($instansi as $item)
                                @php
                                    $index = ($instansi->currentPage() - 1) * $instansi->perPage() + $loop->index + 1;
                                @endphp  
                                <tr>
                                    <td>{{ $index }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{!! ($item->status_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($item->status_instansi === 0 || $item->status_instansi  === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!} </td>
                                    <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                        data-target="#modal-detail-{{$item->id_instansi}}">
                                        Detail
                                    </button>
                                    @if($item->status_instansi != 1)<a class="btn btn-sm btn-success" href="{{ url('admin/instansi/'.$item->id_instansi.'/approve') }}">Terima</a>@endif
                                    @if($item->status_instansi == 1 || $item->status_instansi === null)<a class="btn btn-sm btn-danger" href="{{ url('admin/instansi/'.$item->id_instansi.'/unapprove') }}">Tolak</a>@endif
                                        <form action="{{ url('admin/instansi/'.$item->id_instansi) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            
                            @endforeach
                        @else
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data instansi</td>
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
@section('modal')
    @foreach($instansi as $item)
        <div class="modal fade" id="modal-detail-{{$item->id_instansi}}" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Detail {{$item->nama}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <tr>
                                            <th>Nama Instansi</th>
                                            <td>{{ $item->nama }}</td>
                                        </tr>
                                        <tr>
                                            <th>Alamat</th>
                                            <td>{{ $item->alamat }}</td>
                                        </tr>
                                        <tr>
                                            <th>No.Telp</th>
                                            <td>{{ $item->no_telp }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $item->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Website</th>
                                            <td>{{ $item->web }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>{!! ($item->status_instansi === null) ? "<span class='badge bg-gray'>belum ditentukan</span>":(($item->status_instansi === 0 || $item->status_instansi  === -1)? "<span class='badge bg-danger'>ditolak</span>":"<span class='badge bg-success'>diterima</span>") !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection