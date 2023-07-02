@extends('dosen.layouts.base')
@section('title', 'Nilai Mahaisiswa')
@section('path')
<li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item">Nilai Mahasiswa</li>
@endsection
@section('content')
<div class="row justify-content-between ml-1 mr-1 mb-4">
    <a href="{{ url('/mahasiswa/magang/daftar') }}" class="btn btn-primary">Daftar Magang disini</a>
    <div class="custom-control custom-switch">
      <label class="pr-5" for="customSwitch">List</label>
      <input type="checkbox" class="custom-control-input" id="customSwitch" checked />
      <label class="custom-control-label" for="customSwitch">Card</label>
    </div>
  </div>            
  <div id="list" class="row">
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">List Daftar Magang</h3>
          <div class="card-tools">
            <ul class="pagination pagination-sm float-right">
                {{ $magang->links() }}
            </ul>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>NIM</th>
                <th>Nama Instansi</th>
                <th>Topik</th>
                <th>Dosen pembimbing</th>
                <th>Tahun</th>
                <th>Progres</th>
                <th style="width: 25%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @if($magang != null)
              @foreach($magang as $m)
                @php
                    $index = ($magang->currentPage() - 1) * $magang->perPage() + $loop->index + 1;
                @endphp
              <tr>
                  <td>{{ $index }}</td>
                  <td>{{ ($m->mahasiswa->exists()? $m->mahasiswa->nim : 'Tidak ada mahasiswa')}}
                  <td>{{ (!$m->Instansi->status_instansi)? $m->Instansi->nama.' (belum diverifikasi)': $m->Instansi->nama }}</td>
                  <td>{{ $m->topik()->exists()? $m->topik->nama_topik : 'Tidak ada topik' }}</td>
                  <td>{{ $m->dosen()->exists()? $m->Dosen->nama : 'Tidak ada dosen' }}</td>
                  <td>{{ $m->tahun()->exists()? $m->Tahun->tahun : 'Tidak ada tahun' }}</td>
                  <td>{{ $m->progres()->exists()? $m->Progres->progres : 'Tidak ada progres' }}</td>
                  <td>
                      <a href="{{ '/dosen/nilai/' . $m->id_magang }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-info-circle"> </i>
                        View
                      </a>
                      <a href="{{ '/mahasiswa/magang/' . $m->id_magang . '/edit' }}" class="btn btn-info btn-sm">
                        <i class="fas fa-pencil-alt"> </i>
                        Edit
                      </a>
                      <form action="{{ '/mahasiswa/magang/' . $m->id_magang }}" style="display: contents" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"> </i>
                          Delete
                          </button>
                      </form>
                    </td>
              </tr>
              @endforeach
              @else
              <tr>
                  <td colspan="7" class="text-center">Tidak ada data</td>
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
  <div id="card">
    @foreach($tahun as $t)
    <div>
        <p class="h2">{{ $t->tahun }}</p>
    </div>
    <div class="row">
        @if($magang_all != null)
        @foreach($magang_all->filter(function($item) use ($t) {
          return $item->tahun == $t->tahun;
          }) as $m)
              <div class="col-lg-4">
                      <div class="card card-custom card-margin">
                          <div class="card-header no-border">
                          <h5 class="card-title">{{ $m->mahasiswa()->exists()? $m->mahasiswa->nim.' '.$m->mahasiswa->nama : 'Tidak ada mahasiswa' }}</h5>
                          </div>
                          <div class="card-body pt-0">
                          <div class="widget-49">
                              <div class="widget-49-title-wrapper">
                                  <div class="widget-49-date-primary">
                                      <span class="widget-49-date-day">{{ $m->Tahun->tahun }}</span>
                                  </div>
                                  <div class="widget-49-meeting-info">
                                      <span class="widget-49-pro-title">{{ 'Dosen : '.($m->dosen()->exists()? $m->dosen->nama : 'Tidak ada dosen') }}</span>
                                      <span class="widget-49-pro-title">{{ 'Instansi : '.((!$m->instansi()->exists())? 'Tidak ada instansi' : ((!$m->Instansi->status_instansi)? $m->Instansi->nama.' (belum diverifikasi)': $m->Instansi->nama)) }}</span>
                                      <span class="widget-49-meeting-time">{{ $m->topik->nama_topik }}</span>
                                  </div>
                              </div>
                              <div class="widget-49-meeting-points">
                              <span>Progres : {{ ($m->progres()->exists())? $m->Progres->progres : 'Tidak ada progres' }}</span>
                              <div>
                                  @php
                                  if ($m->progres()->exists())
                                  {
                                      $totalProgress = $progres->count();
                                      $currentProgress = $m->Progres->id_progres;
                                      $progressValue = ($currentProgress / $totalProgress) * 100;
                                  }
                                  else
                                  {
                                      $progressValue = 0;
                                  }
                                  @endphp
                                  <div class="progress mt-1 mb-4">
                                      <div class="progress-bar" role="progressbar" aria-valuenow="{{ $progressValue }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progressValue }}%;"></div>
                                  </div>
                              </div>
                              </div>
                              <div class="widget-49-meeting-action">
                              <a href="{{ '/dosen/magang/' . $m->id_magang }}" class="btn btn-sm btn-outline-primary">View</a>
                              
                              </div>
                          </div>
                          </div>
                      </div>
              </div>
              @if($loop->iteration % 3 === 0)
      </div>
      <div class="row">
              @endif
          @endforeach
        @else
        <p>Tidak ada data</p>
        @endif
    </div>
    @endforeach
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
  <script>
    $(document).ready(function () {
      // Get references to the list and card divs
      var listDiv = $("#list");
      var cardDiv = $("#card");

      listDiv.hide();
      cardDiv.show();

      // Add an event listener to the toggle switch input element
      $("#customSwitch").change(function () {
        if (this.checked) {
          // If the toggle switch is checked, show the card div and hide the list div
          cardDiv.show();
          listDiv.hide();
        } else {
          // If the toggle switch is not checked, show the list div and hide the card div
          cardDiv.hide();
          listDiv.show();
        }
      });
    });
  </script>
  <script>
    //when  <input type="checkbox" class="custom-control-input" id="customSwitch" is not checked, save in local storage
        $(document).ready(function () {
        $("#customSwitch").click(function () {
            //if not checked, save in local storage
            if (!this.checked) {
            localStorage.setItem("customSwitch", $(this).is(":checked"));
            } else {
            //if checked, delete from local storage
            localStorage.removeItem("customSwitch");
            }
        });
        //get the value of the local storage and check if the toggle switch is checked
        if (localStorage.getItem("customSwitch") == "false") {
            $("#customSwitch").click();
        }
        });
    </script>
@endsection
@section('css')
<style>
    .user-body {
        border-bottom: 0 !important;
    }
    .card-margin {
        margin-bottom: 1.875rem;
    }
    
    .card-custom {
        border: 0;
        box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -webkit-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -moz-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
        -ms-box-shadow: 0px 0px 10px 0px rgba(82, 63, 105, 0.1);
    }
    .card-custom {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #ffffff;
        background-clip: border-box;
        border: 1px solid #e6e4e9;
        border-radius: 8px;
    }
    
    .card-custom .card-header.no-border {
        border: 0;
    }
    .card-custom .card-header {
        background: none;
        padding: 0 0.9375rem;
        font-weight: 500;
        display: flex;
        align-items: center;
        min-height: 50px;
    }
    .card-custom .card-header:first-child {
        border-radius: calc(8px - 1px) calc(8px - 1px) 0 0;
    }
    
    .widget-49 .widget-49-title-wrapper {
        display: flex;
        align-items: center;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #edf1fc;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-day {
        color: #4e73e5;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-primary .widget-49-date-month {
        color: #4e73e5;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fcfcfd;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-day {
        color: #dde1e9;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-secondary .widget-49-date-month {
        color: #dde1e9;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-success {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #e8faf8;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-day {
        color: #17d1bd;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-success .widget-49-date-month {
        color: #17d1bd;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-info {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebf7ff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-day {
        color: #36afff;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-info .widget-49-date-month {
        color: #36afff;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-warning {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: floralwhite;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-day {
        color: #FFC868;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-warning .widget-49-date-month {
        color: #FFC868;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-danger {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #feeeef;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-day {
        color: #F95062;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-danger .widget-49-date-month {
        color: #F95062;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-light {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #fefeff;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-day {
        color: #f7f9fa;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-light .widget-49-date-month {
        color: #f7f9fa;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-dark {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #ebedee;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-day {
        color: #394856;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-dark .widget-49-date-month {
        color: #394856;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-base {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        background-color: #f0fafb;
        width: 4rem;
        height: 4rem;
        border-radius: 50%;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-day {
        color: #68CBD7;
        font-weight: 500;
        font-size: 1.5rem;
        line-height: 1;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-date-base .widget-49-date-month {
        color: #68CBD7;
        line-height: 1;
        font-size: 1rem;
        text-transform: uppercase;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-pro-title {
        color: #3c4142;
        font-size: 14px;
    }
    
    .widget-49 .widget-49-title-wrapper .widget-49-meeting-info .widget-49-meeting-time {
        color: #B1BAC5;
        font-size: 13px;
    }
    
    .widget-49 .widget-49-meeting-points {
        font-weight: 400;
        font-size: 13px;
        margin-top: .5rem;
    }
    
    .widget-49 .widget-49-meeting-points .widget-49-meeting-item {
        display: list-item;
        color: #727686;
    }
    
    .widget-49 .widget-49-meeting-points .widget-49-meeting-item span {
        margin-left: .5rem;
    }
    
    .widget-49 .widget-49-meeting-action {
        text-align: right;
    }
    
    .widget-49 .widget-49-meeting-action a {
        text-transform: uppercase;
    }
</style>
@endsection
