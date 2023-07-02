@extends('mahasiswa.layouts.base')
@section('title', 'Dashboard')
@section('path')
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Dashboard</li>
@endsection
@section('css')
<style>
    .dark-mode .timeline > div > .timeline-item {
        background-color: #182635 !important;
        color: #fff;
        border-color: #6c757d;
    }
    .bg-transparent {
        background-color: transparent!important;
    }
</style>
@endsection
@section('content')
    <div class="container-fluid dark-mode bg-transparent">
        <div class="container-fluid">
            <div class="card" style="background: linear-gradient(180deg, rgba(2,0,36,1) 0%, rgba(0,0,107,1) 20%, rgba(0,0,0,1) 100%) !important">
                <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                    <h3 class="card-title">
                        <i class="fas fa-th mr-1"></i>
                        Alur Magang
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn bg-dark btn-sm" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-red">Daftar Magang</span>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang == null)<span class="time">Belum dilakukan</span>@else<span class="time text-success">Sudah dilakukan</span>@endif
                                <h3 class="timeline-header">Pilih tahun, topik, dan pilih atau tambah Instansi</h3>
                                @if($magang == null)
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang/daftar') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->instansi()->exists() && $magang->instansi->status_instansi == 1)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu dosen memverifikasi instansi</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->rencana_magang()->count() > 4)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menambahkan rencana magang (minimal 5)</h3>
                                @if($magang == null || $magang->rencana_magang()->count() < 5)
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang?active=rencanamagang') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->dosen()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Mengajukan bimbingan magang kepada dosen</h3>
                                @if($magang == null || !$magang->dosen()->exists())
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang/daftar') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->status_dosen !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu dosen memverifikasi pengajuan bimbingan</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->surat_magang()->count() == 2)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Mengunggah dokumen pengajuan dan serah terima</h3>
                                @if($magang == null || $magang->surat_magang()->count() < 2)
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang?active=suratmagang') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->status_pengajuan_instansi !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu dokumen pengajuan diverifikasi oleh admin</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->surat_jawaban()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Mengunggah dokumen jawaban Instansi</h3>
                                @if($magang == null || !$magang->surat_jawaban()->exists())
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang?active=suratmagang') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->status_diterima_instansi !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu dokumen jawaban diverifikasi oleh admin</h3>
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-green">Bimbingan magang dosen dan instansi</span>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->bimbingan_dosen()->count() > 4 && $magang->bimbingan_instansi()->count() > 4)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menambahkan bimbingan magang dosen/intansi serta verifikasi</h3>
                                @if($magang == null || $magang->bimbingan_dosen()->count() < 5 || $magang->bimbingan_instansi()->count() < 5)
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/magang?active=bimbingandosen') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-green">Pendaftaran Seminar dan revisi</span>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->seminar()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menambahkan seminar</h3>
                                @if($magang == null || !$magang->seminar()->exists())
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/seminar') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->seminar()->exists() && $magang->seminar->tgl_seminar !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menentukan tanggal seminar</h3>
                                @if($magang == null || !$magang->seminar()->exists() || $magang->seminar->tgl_seminar === null)
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/seminar') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->seminar()->exists() && $magang->seminar->status !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu verifikasi seminar</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->revisi()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Mengisi form revisi</h3>
                                @if($magang == null || !$magang->revisi()->exists())
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/revisi') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->revisi()->exists() && $magang->revisi->status !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu verifikasi selesai magang</h3>
                            </div>
                        </div>
                        <div class="time-label">
                            <span class="bg-green">Nilai magang</span>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->nilai_instansi()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Mengupload dokumen nilai Instansi</h3>
                                @if($magang == null || !$magang->nilai_instansi()->exists())
                                <div class="timeline-footer">
                                    <a href="{{ url('/mahasiswa/nilai') }}" class="btn btn-primary btn-sm">Pergi &gt;&gt;</a>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->nilai_instansi()->exists() && $magang->nilai_instansi->status !== null)<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu admin memverifikasi dokumen nilai Instansi</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-certificate bg-blue"></i>
                            <div class="timeline-item">
                                @if($magang != null && $magang->nilai_seminar()->exists() && $magang->nilai_bimbingan()->exists() && $magang->nilai_instansi()->exists() && $magang->nilai_instansi->detail_nilai_instansi()->exists() && $magang->nilai_akhir()->exists())<span class="time text-success">Sudah dilakukan</span>@else<span class="time">Belum dilakukan</span>@endif
                                <h3 class="timeline-header">Menunggu penilaian</h3>
                            </div>
                        </div>
                        <div>
                            <i class="fas fa-clock bg-gray"></i>
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
@endsection
