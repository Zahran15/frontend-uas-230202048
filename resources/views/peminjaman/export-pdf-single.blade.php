<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Peminjaman</title>
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
            font-size: 14px;
        }
        td {
            border: 1px solid #000;
            padding: 8px;
        }
        .label {
            background-color: #eee;
            font-weight: bold;
            width: 30%;
        }
    </style>
</head>
<body>
    <h2>Detail Peminjaman</h2>
    <table>
        <tr>
            <td class="label">ID</td>
            <td>{{ $peminjaman['id'] }}</td>
        </tr>
        <tr>
            <td class="label">Nama Peminjam</td>
            <td>{{ $peminjaman['nama_peminjam'] }}</td>
        </tr>
        <tr>
            <td class="label">Judul Buku</td>
            <td>{{ $peminjaman['judul_buku'] }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pinjam</td>
            <td>{{ $peminjaman['tanggal_pinjam'] }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Kembali</td>
            <td>{{ $peminjaman['tanggal_kembali'] }}</td>
        </tr>
    </table>
</body>
</html>
