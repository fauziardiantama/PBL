<div class="mb-5">
    <table class="table table-bordered">
      <tr>
          <th>#</th>
          <th>parameter</th>
          <th>nilai</th>
      </tr>
    @if($nilaibimbingan != null)
        @foreach($nilaibimbingan as $nilai)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ($nilai->parameter()->exists())? $nilai->parameter->parameter : 'Parameter tidak diketahui' }}</td>
                <td>{{ $nilai->nilai }}</td>
            </tr>
        @endforeach
    @else
    <tr>
        <td colspan="3" class="text-center">Belum ada nilai</td>
    </tr>
    @endif
    </table>
 </div>