@extends('mahasiswa.layouts.base')
@section('title', 'Daftar Magang')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Magang</li>
<li class="breadcrumb-item active">Daftar</li>
@endsection
@section('css')
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">
<style>
    .hidden {display:none;}
    .f1-steps { overflow: hidden; position: relative; margin-top: 20px; }

    .f1-progress { position: absolute; top: 24px; left: 0; width: 100%; height: 1px; background: #ddd; }
    .f1-progress-line { position: absolute; top: 0; left: 0; height: 1px; background: #010080; }

    .f1-step { position: relative; float: left; text-align: center; width: 25%; padding: 0 5px; }

    .f1-step-icon {
        display: inline-block; width: 40px; height: 40px; margin-top: 4px; background: #ddd;
        font-size: 16px; color: #fff; line-height: 40px;
        -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%;
    }
    .f1-step.activated .f1-step-icon {
        background: #fff; border: 1px solid #010080; color: #010080; line-height: 38px;
    }
    .f1-step.active .f1-step-icon {
        width: 48px; height: 48px; margin-top: 0; background: #010080; font-size: 22px; line-height: 48px;
    }

    .f1-step p { color: #ccc; }
    .f1-step.activated p { color: #010080; }
    .f1-step.active p { color: #010080; }

    .f1 fieldset { display: none; text-align: left; }

    .f1-buttons { text-align: right; }

    .f1 .input-error { border-color: #f35b3f; }

</style>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
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
        <script>
                        function scroll_to_class(element_class, removed_height) {
                            var scroll_to = $(element_class).offset().top - removed_height;
                            if($(window).scrollTop() != scroll_to) {
                                $('html, body').stop().animate({scrollTop: scroll_to}, 0);
                            }
                        }
            
                        function bar_progress(progress_line_object, direction) {
                            var number_of_steps = progress_line_object.data('number-of-steps');
                            var now_value = progress_line_object.data('now-value');
                            var new_value = 0;
                            if(direction == 'right') {
                                new_value = now_value + ( 100 / number_of_steps );
                            }
                            else if(direction == 'left') {
                                new_value = now_value - ( 100 / number_of_steps );
                            }
                            progress_line_object.attr('style', 'width: ' + new_value + '%;').data('now-value', new_value);
                        }
            
                        $(document).ready(function() {
                            // Form
                            $('.f1 fieldset:first').fadeIn('slow');
                            
                            // step selanjutnya (ketika klik tombol selanjutnya)
                            $('.f1 .btn-next').on('click', function() {
                                //var parent_fieldset = $(this).parents('fieldset');
                                //var next_step = true;
                                // navigation steps / progress steps
                                var current_active_step = $(this).parents('.f1').find('.f1-step.active');
                                var progress_line = $(this).parents('.f1').find('.f1-progress-line');
                                
                                $(this).parents('fieldset').fadeOut(400, function() {
                                    // change icons
                                    current_active_step.removeClass('active').addClass('activated').next().addClass('active');
                                    // progress bar
                                    bar_progress(progress_line, 'right');
                                    // show next step
                                    if($(this).next().is('form'))
                                    {
                                        $(this).next().find('fieldset:first').fadeIn();
                                    } else if($(this).next().length === 0) {
                                        $(this).parents('form').next().fadeIn();
                                    } else {
                                        $(this).next().fadeIn();
                                    }
                                    // scroll window to beginning of the form
                                    scroll_to_class( $('.f1'), 20 );
                                });
                            });
                            
                            // step sbelumnya (ketika klik tombol sebelumnya)
                            $('.f1 .btn-previous').on('click', function() {
                                // navigation steps / progress steps
                                var current_active_step = $(this).parents('.f1').find('.f1-step.active');
                                var progress_line = $(this).parents('.f1').find('.f1-progress-line');
                                
                                $(this).parents('fieldset').fadeOut(400, function() {
                                    // change icons
                                    current_active_step.removeClass('active').prev().removeClass('activated').addClass('active');
                                    // progress bar
                                    bar_progress(progress_line, 'left');
                                    // show previous step

                                    if($(this).prev().is('form'))
                                    {
                                        $(this).prev().find('fieldset:last').fadeIn();
                                    } else if($(this).prev().length === 0) {
                                        $(this).parents('form').prev().fadeIn();
                                    } else {
                                        $(this).prev().fadeIn();
                                    }

                                    // scroll window to beginning of the form
                                    scroll_to_class( $('.f1'), 20 );
                                });
                            });
                            
                        });
            </script>
            <script>
                $(document).ready(function() {
                    const buatInstansiBaruRadio = $('#buat_instansi_baru');
                    const pilihInstansiRadio = $('#pilih_instansi');
                    const buatInstansiBaruDiv = $('#buat-instansi-baru-div');
                    const pilihInstansiDiv = $('#pilih-instansi-div');
        
                    buatInstansiBaruRadio.on('change', function() {
                        if (this.checked) {
                            buatInstansiBaruDiv.find('input').prop('disabled', false);
                            pilihInstansiDiv.find('select').prop('disabled', true);
                            pilihInstansiDiv.find('option:selected').prop('selected', false);
                            buatInstansiBaruDiv.removeClass('hidden');
                            pilihInstansiDiv.addClass('hidden');
                        } else {
                            buatInstansiBaruDiv.find('input').prop('disabled', true);
                            pilihInstansiDiv.find('select').prop('disabled', false);
                            buatInstansiBaruDiv.addClass('hidden');
                            pilihInstansiDiv.removeClass('hidden');
                        }
                    });
        
                    pilihInstansiRadio.on('change', function() {
                        if (this.checked) {
                            pilihInstansiDiv.find('select').prop('disabled', false);
                            buatInstansiBaruDiv.find('input').prop('disabled', true);
                            buatInstansiBaruDiv.find('input[type="text"]').val('');
                            buatInstansiBaruDiv.find('input[type="checkbox"]').prop('checked', false);
                            buatInstansiBaruDiv.addClass('hidden');
                            pilihInstansiDiv.removeClass('hidden');
                        } else {
                            pilihInstansiDiv.find('select').prop('disabled', true);
                            buatInstansiBaruDiv.find('input').prop('disabled', false);
                            pilihInstansiDiv.addClass('hidden');
                            buatInstansiBaruDiv.removeClass('hidden');
                        }
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    const topikSelect = $('#topik');
        
                    topikSelect.on('change', function() {
                        const selectedValue = this.value;
                        $('div[id^="dosentopik-topik"]').each(function() {
                            const divId = $(this).attr('id');
                            if (divId === 'dosentopik-topik' + selectedValue) {
                                $(this).removeClass('hidden');
                                $(this).find('select').prop('disabled', false);
                            } else {
                                $(this).addClass('hidden');
                                $(this).find('select').prop('disabled', true);
                            }
                        });
                    });
                });
        
            </script>
            @if($magang != null && $magang->instansi()->exists() && $magang->instansi->status_instansi === 1)                         
            <script>
                $(document).ready(function() {
                    $('#pilih_instansi').click();
                });
            </script>
            @endif
            <script src="{{ url('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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
    $( "#instansi" ).select2({
        theme: "bootstrap"
    });
    $( "#topik" ).select2({
        theme: "bootstrap"
    });
    // foreach element of class .dosen_pembimbing, function element
    $('.dosen_pembimbing').each(function() {
        // select element with id dosen_pembimbing
        $(this).select2({
            theme: "bootstrap"
        });
    });
</script>
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-offset-1">
        <div class="f1">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="25" data-number-of-steps="4" style="width: 25%;"></div>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-info"></i></div>
                    <p>Alur pendaftaran</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-book"></i></div>
                    <p>Tahun dan Topik</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-building"></i></div>
                    <p>Instansi magang</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Dosen Pembimbing</p>
                </div>
            </div>
            <!-- step 0-->
            <fieldset class="p-3">
                <h5 class="mb-2">Alur pendaftaran Magang</h5>
                <div class="">
                    1. Mahasiswa memilih tahun dan topik magang yang tersedia.<br>
                    2. Mahasiswa memilih instansi magang yang tersedia atau membuat instansi baru.<br>
                    3. Admin akan memverifikasi instansi yang dibuat mahasiswa.<br>
                    4. Mahasiswa membuat rencana magang. <br>
                    5. Mahasiswa mengajukan dosen pembimbing magang. <br>
                    6. Dosen akan memverifikasi mahasiswa yang mengajukan. <br>
                    7. Mahasiswa melakukan pengajuan magang ke instansi. <br>
                    8. Mahasiswa mengupload berkas diterima instansi. <br>
                    9. Admin akan memverifikasi berkas yang diupload mahasiswa. <br>
                    10. Mahasiswa melakukan bimbingan magang dosen serta instansi.
                </div>
                <div class="f1-buttons">
                    <button type="button" class="btn btn-primary btn-next">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                </div>
            </fieldset>
            <!-- step 1 -->
            @if($magang == null || (!$magang->instansi()->exists() || $magang->instansi->status_instansi === 0 || $magang->status_diterima_instansi === 0 || $magang->status_pengajuan_instansi === 0))
            <form action="{{ url('mahasiswa/magang/daftar/tahun-topik-instansi') }}" method="POST">
            @endif
                <fieldset class="p-3">
                    @csrf
                    @if($magang != null && (!$magang->instansi()->exists() || $magang->instansi->status_instansi === 0 || $magang->status_diterima_instansi === 0 || $magang->status_pengajuan_instansi === 0))
                    @method('PUT')
                    @endif
                        <h5 class="mb-2">Masukkan tahun dan topik magang</h5>
                        <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-select form-control" name="tahun" id="tahun" @disabled(true)>
                                @foreach($tahun as $t)
                                    <option value="{{ $t->tahun }}" {{ ($magang != null && $magang->tahun == $t->tahun)? "selected": (($magang == null && $t->tahun == date("Y"))? "selected" : "") }}>{{ $t->tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Topik</label>
                            <select class="form-select form-control" name="id_topik" id="topik">
                                @foreach($topik as $t)
                                    <option value="{{ $t->id_topik }}" @if($magang == null && $loop->first) selected @endif {{ ($magang != null && $magang->topik->id_topik == $t->id_topik)? "selected" : "" }}>{{ $t->nama_topik }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-warning btn-previous"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                            <button type="button" class="btn btn-primary btn-next">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                        </div>
                </fieldset>
                <!-- step 2 -->
                <fieldset class="p-3">
                        <h5 class="mb-2">Pilih atau masukkan informasi instansi tempat magang</h5>
                        <div class="form-group">
                            <label for="instansi">Pilih Instansi atau buat baru</label>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="instansi" id="pilih_instansi" value="lama">
                            <label class="form-check-label" for="pilih_instansi">
                                Pilih Instansi
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="instansi" id="buat_instansi_baru" value="baru">
                            <label class="form-check-label" for="buat_instansi_baru">
                                Buat baru
                            </label>
                            </div>
                        </div>
                        <div id="pilih-instansi-div" class="form-group hidden">
                            <label for="instansi">Pilih Instansi</label>
                            <select class="form-select form-control" name="id_instansi" id="instansi"  @disabled(true)>
                                @foreach($instansi as $i)
                                @if($i->status_instansi == 1)
                                    <option value="{{ $i->id_instansi }}" {{ ($magang != null && $magang->instansi->id_instansi == $i->id_instansi)? "selected" : "" }}>{{ $i->nama }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div id="buat-instansi-baru-div" class="form-group hidden">
                            <div class="form-group">
                            <label for="nama_instansi">Nama instansi</label>
                            <input type="text" class="form-control" name="nama" id="nama_instansi" placeholder="Masukkan nama instansi" @disabled(true)>
                            </div>
                            <div class="form-group">
                            <label for="email_instansi">Email instansi</label>
                            <input type="email" class="form-control" name="email" id="email_instansi" placeholder="Masukkan email instansi" @disabled(true)>
                            </div>
                            <div class="form-group">
                            <label for="alamat_instansi">Alamat instansi</label>
                            <input type="text" class="form-control" name="alamat" id="alamat_instansi" placeholder="Masukkan alamat instansi" @disabled(true)>
                            </div>
                            <div class="form-group">
                            <label for="telepon_instansi">Telepon instansi</label>
                            <input type="text" class="form-control" name="no_telp" id="telepon_instansi" placeholder="Masukkan telepon instansi" @disabled(true)>
                            </div>
                            <div class="form-group">
                            <label for="website_instansi">Website instansi</label>
                            <input type="text" class="form-control" name="web" id="website_instansi" placeholder="Masukkan website instansi" @disabled(true)>
                            </div>
                        </div>
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-warning btn-previous"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                            @if($magang == null || (!$magang->instansi()->exists() || $magang->instansi->status_instansi === 0 || $magang->status_diterima_instansi === 0 || $magang->status_pengajuan_instansi === 0))
                                <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-save"></i> Submit</button>
                            @elseif($magang != null && $magang->instansi->status_instansi === null )
                                <button type="button" class="btn btn-primary btn-next" @disabled(true)>Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            @else
                                <button type="button" class="btn btn-primary btn-next">Selanjutnya <i class="fa fa-arrow-right"></i></button>
                            @endif
                        </div>
                </fieldset>
            @if($magang == null || (!$magang->instansi()->exists() || $magang->instansi->status_instansi === 0 || $magang->status_diterima_instansi === 0 || $magang->status_pengajuan_instansi === 0))
            </form>
            @endif
            <!-- step 3 -->
            <fieldset class="p-3">
                @if($magang != null && $magang->instansi()->exists() && $magang->instansi->status_instansi === 1)
                    <h5 class="mb-2">Pilih dosen pembimbing sesuai topik</h5>
                    @if($magang->status_dosen == 0)
                    <form action="{{ url('mahasiswa/magang/daftar/dosen') }}" method="POST">
                        @csrf
                    @endif
                    @if($magang->id_dosen != null && $magang->status_dosen === 0)
                        @method('PUT')
                    @endif
                        @foreach($topik as $t)
                        <div id="dosentopik-topik{{ $t->id_topik }}" class="form-group" @if(($magang == null && !$loop->first )|| ($magang != null && $t->id_topik != $magang->topik->id_topik)) hidden @endif>
                            <label for="dosen_pembimbing_{{ $t->id_topik }}">Dosen pembimbing {{ $t->nama_topik }}</label>
                            @if ($t->dosen->count() > 0)
                                <select class="form-select form-control dosen_pembimbing" name="id_dosen" id="dosen_pembimbing_{{ $t->id_topik }}"  @if(($magang == null && !$loop->first )|| ($magang != null && $t->id_topik != $magang->topik->id_topik)) disabled @endif>
                                    @foreach($t->dosen as $dosen)
                                        <option value="{{ $dosen->id_dosen }}" {{ ($magang != null && $magang->dosen()->exists() && $dosen->id_dosen == $magang->dosen->id_dosen)? "selected" : ""}}>
                                            {{ $dosen->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <p>Tidak ada dosen yang memenuhi topik</p>
                            @endif
                        </div>
                        @endforeach
                        <div class="f1-buttons">
                            <button type="button" class="btn btn-warning btn-previous"><i class="fa fa-arrow-left"></i> Sebelumnya</button>
                            @if($magang->status_dosen == 0)<button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-save"></i> Submit</button>@endif
                        </div>
                    @if($magang->status_dosen == 0)
                    </form>
                    @endif
                @else
                <h5>Instansi belum disetujui</h5>
                @endif
            </fieldset>
        </div>
    </div>
</div>
@endsection