<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PeminjamanController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/peminjaman');
        $peminjaman = $response->json();
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        return view('peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $response = Http::asJson()->post('http://localhost:8080/peminjaman', $request->all());

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => 'Gagal menambahkan data peminjaman'])->withInput();
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:8080/peminjaman/$id");

        if ($response->successful()) {
            $peminjaman = $response->json();
            return view('peminjaman.edit', compact('peminjaman'));
        }

        return back()->with('error', 'Data peminjaman tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:100',
            'judul_buku' => 'required|string|max:100',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $response = Http::put("http://localhost:8080/peminjaman/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil diperbarui.');
        }

        return back()->withErrors(['error' => 'Gagal mengupdate data peminjaman'])->withInput();
    }

    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8080/peminjaman/$id");

        if ($response->successful()) {
            return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus data peminjaman.');
    }
}
