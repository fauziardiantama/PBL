<!DOCTYPE html>
<html>
<head>
    <title>Informasi</title>
</head>
<body>
    <h1>Informasi</h1>
    <p>Ini adalah halaman informasi</p>
    <ul>
        @foreach($d as $doc)
        <li>
            <span>{{ $doc->judul }}</span><span> | </span><span>{!! $doc->deskripsi !!}</span><span> | </span><span><a href="{{ url('/documents/'.$doc->dokumen) }}">Download</a></span>
        </li>
        @endforeach
    </ul>
</body>
</html>