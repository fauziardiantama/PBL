@extends('admin.layouts.base')
@section('title', 'Pertanyaan dan saran')
@section('path')
    <li class="breadcrumb-item">
        <a href="#">Home</a>
    </li>
    <li class="breadcrumb-item active">Pertanyaan dan saran</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Pertanyaan dan saran</h3>
                        <div class="card-tools">
                            {{ $hubungi_kami->links() }}
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 20%">Subjek</th>
                                    <th style="width: 20%">E-mail</th>
                                    <th style="width: 30%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($hubungi_kami->count() > 0)
                                    @foreach ($hubungi_kami as $item)
                                    @php
                                        $index = ($hubungi_kami->currentPage() - 1) * $hubungi_kami->perPage() + $loop->index + 1;
                                    @endphp
                                        <tr>
                                            <td>{{ $index }}</td>
                                            <td>{{ $item->subjek }}</td>
                                            <td>{{ $item->email }} </td>
                                            <td>
                                            {{-- button that show a modal --}}
                                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default-{{ $item->id }}">Detail</button>
                                                <form action="{{ url('admin/kontak/'.$item->id) }}" method="post"
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
                                    <td colspan="4" class="text-center">Tidak ada data</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
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

            @if (session('berhasillogin'))
                $(function() {
                    Toast.fire({
                        icon: 'success',
                        title: '{{ session('berhasillogin') }}'
                    })
                });
            @endif
        });
    </script>
@endsection
@section('modal')
    @foreach ($hubungi_kami as $item)
    <div class="modal fade" id="modal-default-{{ $item->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ $item->subjek }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button></div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $item->nama }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $item->email }}</td>
                        </tr>
                        <tr>
                            <th>Subjek</th>
                            <td>{{ $item->subjek }}</td>
                        </tr>
                        <tr>
                            <th>Pesan</th>
                            <td>{{ $item->pesan }}</td>
                        </tr>
                    </tbody>
                </table>
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
@endsection