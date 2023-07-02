{{-- include('partials.simple-dataview-with-navbar', [
    'list' => [
        [
            'title' => 'a',
            'id' => 'a',
            'value' => 'a is the first word in the alphabet',
            'status' => true,
            'active' => true,
        ],
        [
            'title' => 'b',
            'id' => 'b',
            'value' => 'b is the second word in the alphabet',
            'status' => false,
            'active' => false,
        ],
    ],
    'title' => 'Simple Dataview With Navbar',
) --}}
@php
$hasActive = false;
@endphp

@foreach($list as $l)
    @if($l['active'])
        @php
        $hasActive = true;
        @endphp
    @endif
@endforeach

<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
            @foreach($list as $l)
              <li class="nav-item"><a class="nav-link @if((!$hasActive && $loop->first) || ($hasActive && $l['active'])) active @endif @if(!$l['status']) disabled-link @endif" href="#{{ $l['id'] }}" data-toggle="tab">{{ $l['title'] }}</a></li>
            @endforeach
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
            @foreach($list as $l)
                @if($l['status'])
                    <div class="@if((!$hasActive && $loop->first) || ($hasActive && $l['active'])) active @endif tab-pane" id="{{ $l['id'] }}">
                        <h5>{{ $l['title'] }}</h5>
                        <hr>
                        {!! $l['value'] !!}
                    </div>
                @endif
            @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
</div>