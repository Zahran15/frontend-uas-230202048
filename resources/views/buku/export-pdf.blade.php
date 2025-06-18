<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Buku</title>
    <style>
        body {
            font-family: sans-serif;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>Daftar Buku</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $buku)
            <tr>
                <td>{{ $buku['id'] }}</td>
                <td>{{ $buku['judul'] }}</td>
                <td>{{ $buku['pengarang'] }}</td>
                <td>{{ $buku['penerbit'] }}</td>
                <td>{{ $buku['tahun_terbit'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
