@extends('dosen.layouts.base')
@section('title', 'Detail Seminar dan revisi')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Seminar dan revisi</li>
<li class="breadcrumb-item active">Detail</li>
@endsection
@section('content')
    @include('partials.simple-dataview-with-navbar', [
        'list' => [
            [
                'title' => 'Seminar',
                'id' => 'seminar',
                'value' => view('dosen.show_seminardanrevisi.seminar', compact('magang','seminar'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'seminar') ? true : false,
            ],
            [
                'title' => 'Revisi',
                'id' => 'revisi',
                'value' => view('dosen.show_seminardanrevisi.revisi', compact('magang','revisi'))->render(),
                'status' => true,
                'active' => (Request::get('active') && Request::get('active') == 'revisi') ? true : false,
            ],
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