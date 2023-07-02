{{-- include('partials.simple-modal-form', [
    'title' => 'Simple Modal Form',
    'id' => 'modal-add-dosen',
    'form' => [
        'action' => url('/mahasiswa/magang/bimbingan/dosen'),
        'method' => 'post',
        'inputs' => [
            [
                'label' => 'Data bimbingan',
                'type' => 'text',
                'name' => 'data_bimbingan',
                'disabled' => true,
                'value' => 'Data bimbingan'
            ],
            [
                'label' => 'Tanggal bimbingan',
                'type' => 'date',
                'name' => 'tanggal_bimbingan',
            ],
            [
                'label' => 'Catatan bimbingan',
                'type' => 'select',
                'name' => 'catatan_bimbingan',
                'disabled' => true,
                'options' => [
                    [
                        'label' => 'A',
                        'value' => 'a',
                        'selected' => true,
                    ],
                    [
                        'label' => 'B',
                        'value' => 'b',
                        'selected' => false,
                    ],
                    [
                        'label' => 'C',
                        'value' => 'c',
                        'selected' => false,
                    ],
                ],
            ],
            [
                'label' => 'File bimbingan',
                'type' => 'file',
                'name' => 'file_bimbingan',
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'radio',
                'name' => 'status_bimbingan',
                'options' => [
                    [
                        'label' => 'A',
                        'value' => 'a',
                        'checked' => true,
                        'disabled' => true,
                    ],
                    [
                        'label' => 'B',
                        'value' => 'b',
                        'checked' => true,
                        'disabled' => true,
                    ],
                    [
                        'label' => 'C',
                        'value' => 'c',
                        'checked' => true,
                        'disabled' => true,
                    ],
                ],
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'checkbox',
                'name' => 'status_bimbingan',
                'options' => [
                    [
                        'label' => 'A',
                        'value' => 'a',
                    ],
                    [
                        'label' => 'B',
                        'value' => 'b',
                    ],
                    [
                        'label' => 'C',
                        'value' => 'c',
                    ],
                ],
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'textarea',
                'name' => 'status_bimbingan',
                'value' => 'Data bimbingan'
                'disabled' => true,
                'rows' => 3,
                'cols' => 3,
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'password',
                'name' => 'status_bimbingan',
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'email',
                'name' => 'status_bimbingan',
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'url',
                'name' => 'status_bimbingan',
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'color',
                'name' => 'status_bimbingan',
            ],
            [
                'label' => 'Status bimbingan',
                'type' => 'range',
                'name' => 'status_bimbingan',
                'min' => 0,
                'max' => 100,
            ],
        ],
        'data' => $data,
        'submit' => [
            'label' => 'Simpan',
        ],
    ],
) --}}

<div class="modal fade" id="{{ $id }}" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{ $form['action'] }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method(strtoupper($form['method']))
        <div class="modal-header">
        <h4 class="modal-title">{{ $title }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                @foreach($form['inputs'] as $input)
                <div class="form-group">
                    <label for="{{ $input['name'] }}">{{ ucfirst($input['label']) }}</label>
                    @php
                        $commontypes = ['text', 'date', 'file', 'password', 'email', 'url', 'color'];
                    @endphp
                    @if(in_array($input['type'], $commontypes))
                        <input type="{{ $input['type'] }}" class="form-control @error($input['name']) is-invalid @enderror" id="{{ $input['name'] }}" name="{{ $input['name'] }}" value="{{ (strtolower($form['method']) == 'post') ? old($input['name']) : $input['value'] }}" placeholder="Masukkan {{ strtolower($input['label']) }}"  @if($input['disabled']) disabled @endif>
                    @elseif($input['type'] == 'select')
                    <select class="form-select form-control" name="{{ $input['name'] }}" id="{{ $input['name'] }}" @if($input['disabled']) disabled @endif>
                        @foreach($input['options'] as $o)
                            <option value="{{ $o['value'] }}" @if($o['selected']) selected @endif>{{ $o['label'] }}</option>
                        @endforeach
                    </select>
                    @elseif($input['type'] == 'radio' || $input['type'] == 'checkbox')
                        @foreach($input['options'] as $o)
                        <div class="form-check">
                            <input class="form-check-input" type="{{ $input['type'] }}" name="{{ $input['name'] }}" value="{{ $o['value'] }}" @if($o['selected']) checked @endif @if($o['disabled']) disabled @endif>
                            <label class="form-check-label">{{ $o['label'] }}</label>
                        </div>
                        @endforeach
                    @elseif($input['type'] == 'textarea')
                        <textarea class="form-control @error($input['name']) is-invalid @enderror" name="{{ $input['name'] }}" id="{{ $input['name'] }}" rows="{{ $input['rows'] }}" cols="{{ $input['cols'] }}" placeholder="Masukkan {{ strtolower($input['label']) }}" @if($input['disabled']) disabled @endif>{{ (strtolower($form['method']) == 'post') ? old($input['name']) : $input['value'] }}</textarea>
                    @elseif($input['type'] == 'range')
                        <input type="range" class="custom-range  @error($input['name']) is-invalid @enderror" id="{{ $input['name'] }}" name="{{ $input['name'] }}" min="{{ $input['min'] }}" max="{{ $input['max'] }}">
                    @endif
                    @error($input['name'])
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                @endforeach
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">{{ $form['submit']['label'] }}</button>
        </div>
        </form>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>