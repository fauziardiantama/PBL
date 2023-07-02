@extends('admin.layouts.base')
@section('title', 'Dashboard')
@section('path')
    <li class="breadcrumb-item">
        <a href="#">Home</a>
    </li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mahasiswa terdaftar</span>
                        <span class="info-box-number">
                            {{ $mahasiswas->count() }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-graduation-cap"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Banyak magang</span>
                        <span class="info-box-number">{{ $magangs->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Banyak dosen</span>
                        <span class="info-box-number">{{ $dosens->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-building"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Banyak instansi</span>
                        <span class="info-box-number">{{ $instansis->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Magang tahun ini ({{ date('Y') }}) </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if ($tahuns->contains('tahun', '2023'))
                            @if ($magangs->contains('tahun', '2023'))
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Instansi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($magangs->where('tahun', '2023') as $magang)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $magang->mahasiswa->nim }}</td>
                                                    <td>{{ $magang->mahasiswa->nama }}</td>
                                                    <td>{{ $magang->instansi->nama }}</td>
                                                    <td>
                                                        <a href="{{ url('admin/magang/' . $magang->id_magang) }}"
                                                            class="btn btn-sm btn-primary">Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-center">Belum ada magang tahun ini</p>
                            @endif
                        @else
                            <div class="card-body">
                                <h3 class="text-center">Tahun 2023 belum di daftarkan ke database</h3>
                                <a href="{{ url('admin/tahun') }}">Tambahkan sekarang agar mahasiswa bisa mendaftar >></a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Mahasiswa belum terverifikasi</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>E-mail</th>
                                        <th>No. Telepon</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($mahasiswas->contains('status', null))
                                        @foreach ($mahasiswas->where('status', null) as $mahasiswa)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $mahasiswa->nim }}</td>
                                                <td>{{ $mahasiswa->nama }}</td>
                                                <td>{{ $mahasiswa->email }}</td>
                                                <td>{{ $mahasiswa->no_telp }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada mahasiswa yang belum
                                                terverifikasi</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary mb-3 card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Berita</h3>
                        <div class="card-tools">
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive mailbox-messages">
                            @if (count($beritas) > 0)
                                <table class="table table-hover table-striped">
                                    <tbody>
                                        @foreach ($beritas as $b)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $b->judul }}</td>
                                                <td>{!! strlen($b->deskripsi) > 100
                                                    ? substr(
                                                            preg_replace(
                                                                '/<p\b[^>]*>(.*?)<\/p>/i',
                                                                '<span>$1</span>',
                                                                preg_replace('/<img\s[^>]*>/i', '[image]', $b->deskripsi),
                                                            ),
                                                            0,
                                                            100,
                                                        ) . '...'
                                                    : substr(preg_replace('/<p\b[^>]*>(.*?)<\/p>/i', '<span>$1</span>', $b->deskripsi), 0, 100) !!}</td>
                                                <td>
                                                    @if ($b->status_publikasi == false)
                                                        <span class="badge bg-danger">belum dipublish</span>
                                                    @else
                                                        <span class="badge bg-success">sudah dipublish</span>
                                                    @endif
                                                </td>
                                                <td style="width:25%">
                                                    <a href="{{ url('admin/berita/' . $b->id_berita) }}"
                                                        class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
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
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">Progres Mahasiswa</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="position-relative mb-4">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="sales-chart" height="200" style="display: block; width: 661px; height: 200px;"
                                width="661" class="chartjs-render-monitor"></canvas>
                        </div>
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
    <script>
        $(function() {
            'use strict'
            var ticksStyle = {
                fontColor:  $('body').hasClass('dark-mode') ? '#fff' : '#495057',
                fontStyle: 'bold'
            }
            var mode = 'index'
            var intersect = true
            var $salesChart = $('#sales-chart')

            var data = [];
            @foreach($progress as $progres)
                var count = @json($progres->magang()->count());
                data.push(count);
            @endforeach

            var salesChart = new Chart($salesChart,{
                type: 'bar',
                data: {
                    labels: @json($progress->pluck('progres')),
                    datasets: [{
                        backgroundColor: '#007bff',
                        borderColor: '#007bff',
                        data: data
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        mode: mode,
                        intersect: intersect
                    },
                    hover: {
                        mode: mode,
                        intersect: intersect
                    },
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                display: true,
                                lineWidth: '5px',
                                color: 'rgba(0, 0, 0, .2)',
                                zeroLineColor: 'transparent'
                            },
                            ticks: $.extend({
                                beginAtZero: true,
                                callback: function(value) {
                                    if (value >= 1000) {
                                        value /= 1000
                                        value += 'k'
                                    }
                                    return value
                                }
                            }, ticksStyle)
                        }],
                        xAxes: [{
                            display: true,
                            gridLines: {
                                display: false
                            },
                            ticks: ticksStyle
                        }]
                    }
                }
            })
        });
    </script>
@endsection
