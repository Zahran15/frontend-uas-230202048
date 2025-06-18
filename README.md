Backend

Langkah pertama:
Jalankan di terminal pc/laptop
composer create-project codeigniter4/appstarter backend_perpustakaan

Langkah kedua:
Di routes.php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->resource('buku');
$routes->get( "buku/(:num)", 'Buku::show/$1');
$routes->post('buku', 'Buku::create');
$routes->put('buku/(:num)', 'Buku::update/$1');
$routes->delete('buku/(:num)', 'Buku::delete/$1');

$routes->resource('peminjaman');
$routes->get( "peminjaman/(:num)", 'Peminjaman::show/$1');
$routes->post('peminjaman', 'Peminjaman::create');
$routes->put('peminjaman/(:num)', 'Peminjaman::update/$1');
$routes->delete('peminjaman/(:num)', 'Peminjaman::delete/$1');

Langkah ketiga:
Di folder Controller tambah
Buku.php:
<?php 

namespace App\Controllers;

use App\Models\BukuModel;
use CodeIgniter\RESTful\ResourceController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

class Buku extends ResourceController 
{
    protected $modelName = 'App\\Models\\BukuModel';
    protected $format    = 'json';

    public function __construct()
    {
        $this->model = new BukuModel();
    }

    public function index()
    {
        $buku = $this->model->findAll();
        return $this->respond($buku);
    }

    public function show($id = null)
    {
        $buku = $this->model->find($id);
        if (!$buku) {
            return $this->failNotFound('Buku not found');
        }
        return $this->respond($buku);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['id' => $this->model->insertID()]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Buku updated successfully']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Buku deleted successfully']);
        } else {
            return $this->failNotFound('Buku not found');
        }
    }
}

Peminjaman.php:
<?php 
namespace App\Controllers;

use App\Models\PeminjamanModel;
use CodeIgniter\RESTful\ResourceController;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

class Peminjaman extends ResourceController {
    protected $modelName = 'App\\Models\\PeminjamanModel';
    protected $format    = 'json';

    public function __construct()
    {
        $this->model = new PeminjamanModel();
    }

    public function index()
    {
        $peminjaman = $this->model->findAll();
        return $this->respond($peminjaman);
    }

    public function show($id = null)
    {
        $peminjaman = $this->model->find($id);
        if (!$peminjaman) {
            return $this->failNotFound('Peminjaman not found');
        }
        return $this->respond($peminjaman);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);
        if ($this->model->insert($data)) {
            return $this->respondCreated(['id' => $this->model->insertID()]);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }   


    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Peminjaman updated successfully']);
        } else {
            return $this->failValidationErrors($this->model->errors());
        }
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Peminjaman deleted successfully']);
        } else {
            return $this->failNotFound('Peminjaman not found');
        }
    }
}

Langkah keempat:
Tes di postman 
apakah bisa dipanggil atau tidak


Frontend
Langkah pertama:
Jalankan Diterminal pc/laptop:
composer create-project --prefer-dist laravel/laravel frontend_uas_230202048

Langkah kedua:
buka folder app\Http\Controllers dan buat file 
BukuController.php:
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class BukuController extends Controller
{   
   public function exportPDF()
    {
        $response = Http::get('http://localhost:8080/buku');
        $data = $response->json(); // asumsi response JSON berisi array of buku

        $pdf = Pdf::loadView('buku.export-pdf', ['data' => $data]);
        return $pdf->download('data_buku.pdf');
    }
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

PeminjamanController.php:
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{   
public function exportSinglePDF($id)
{
    $response = Http::get("http://localhost:8080/peminjaman/$id");

    if ($response->successful()) {
        $peminjaman = $response->json();

        $pdf = Pdf::loadView('peminjaman.export-pdf-single', ['peminjaman' => $peminjaman]);
        return $pdf->download("peminjaman_{$id}.pdf");
    }

    return back()->with('error', 'Data peminjaman tidak ditemukan.');
}
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

Langkah