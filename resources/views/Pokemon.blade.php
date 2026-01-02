<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ujian Kominfo </title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #174ec4ff;
        padding: 24px;
    }

    h1 {
        text-align: center;
        margin-bottom: 18px;
        color: #ffffffff;
        font-weight: 600;
    }

    .filter {
        text-align: center;
        margin-bottom: 16px;
    }

    .filter a {
        margin: 0 10px;
        text-decoration: none;
        font-weight: 600;
        color: #db9c08ff;
    }

    .filter a:hover {
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #ffffff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    th, td {
        border: 1px solid #e6e9ef;
        padding: 12px;
        font-size: 14px;
    }

    th {
        background-color: #e0b90eff;
        color: #ffffff;
        text-align: center;
        font-weight: 600;
    }

    td {
        vertical-align: middle;
        color: #259eceff;
    }

    td:nth-child(1),
    td:nth-child(2) {
        text-align: center;
    }

    td:nth-child(3) {
        text-align: left;
    }

    td:nth-child(4),
    td:nth-child(5) {
        text-align: right;
    }

    tr:nth-child(even) {
        background-color: #f8f9fd;
    }

    tr:hover {
        background-color: #f1f2fb;
    }

    img {
        width: 100px;
        display: block;
        margin: 0 auto;
    }
</style>
</head>
<body>

<h1>Hasil Data Pokemon </h1>

<div class="filter">
    <a href="{{ url('/Pokemon') }}">Semua</a>
    <a href="{{ url('/Pokemon?weight=light') }}">Ringan</a>
    <a href="{{ url('/Pokemon?weight=medium') }}">Sedang</a>

</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Berat</th>
            <th>Experience</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($Pokemon as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if ($item->image_path)
                        <img src="{{ asset($item->image_path) }}" alt="pokemon">
                    @else
                        -
                    @endif
                </td>
                <td>{{ ucfirst($item->name) }}</td>
                <td>{{ $item->weight }}</td>
                <td>{{ $item->experience }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Data belum ada</td>
            </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>
