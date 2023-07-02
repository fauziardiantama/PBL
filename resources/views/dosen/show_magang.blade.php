@extends('dosen.layouts.base')
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
                'value' => view('dosen.show_magang.detail_magang', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailmagang') ? true : false,
            ],
            [
                'title' => 'Detail Instansi',
                'id' => 'detailinstansi',
                'value' => view('dosen.show_magang.detail_instansi', compact('magang'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'detailinstansi') ? true : false,
            ],
            [
                'title' => 'Rencana Magang',
                'id' => 'rencanamagang',
                'value' => view('dosen.show_magang.rencana_magang', compact('rencana'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'rencanamagang') ? true : false,
            ],
            [
                'title' => 'Bimbingan Magang',
                'id' => 'bimbinganmagang',
                'value' => view('dosen.show_magang.bimbingan_magang', compact('magang','bimbingan'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'bimbinganmagang') ? true : false,
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