<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BukuController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:8080/buku');
        $buku = $response->json();
        return view('buku.index', compact('buku'));
    }

    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        $response = Http::asJson()->post('http://localhost:8080/buku', $request->all());

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
        }

        return back()->withErrors(['error' => 'Gagal menambahkan buku'])->withInput();
    }

    public function edit($id)
    {
        $response = Http::get("http://localhost:8080/buku/$id");

        if ($response->successful()) {
            $buku = $response->json();
            return view('buku.edit', compact('buku'));
        }

        return back()->with('error', 'Data buku tidak ditemukan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:100',
            'pengarang' => 'required|string|max:50',
            'penerbit' => 'required|string|max:50',
            'tahun_terbit' => 'required|digits:4|integer',
        ]);

        $response = Http::put("http://localhost:8080/buku/$id", $request->all());

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
        }

        return back()->withErrors(['error' => 'Gagal mengupdate buku'])->withInput();
    }

    public function destroy($id)
    {
        $response = Http::delete("http://localhost:8080/buku/$id");

        if ($response->successful()) {
            return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
        }

        return back()->with('error', 'Gagal menghapus buku.');
    }
}
