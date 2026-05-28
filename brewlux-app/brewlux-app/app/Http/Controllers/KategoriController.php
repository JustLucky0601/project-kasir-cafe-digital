<?php
namespace App\Http\Controllers;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    public function index() {
        $kategoris = Kategori::withCount('produks')->latest()->get();
        return view('admin.categories.index', compact('kategoris'));
    }
    public function store(Request $request) {
        $request->validate(['nama_kategori'=>'required|string|max:50|unique:kategoris,nama_kategori','icon'=>'required|string|max:10']);
        Kategori::create($request->only('nama_kategori','icon'));
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil ditambahkan!');
    }
    public function update(Request $request, Kategori $kategori) {
        $request->validate(['nama_kategori'=>'required|string|max:50|unique:kategoris,nama_kategori,'.$kategori->id,'icon'=>'required|string|max:10']);
        $kategori->update($request->only('nama_kategori','icon'));
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil diperbarui!');
    }
    public function destroy(Kategori $kategori) {
        if ($kategori->produks()->count() > 0)
            return redirect()->route('admin.categories.index')->with('error','Kategori masih memiliki produk, tidak bisa dihapus!');
        $kategori->delete();
        return redirect()->route('admin.categories.index')->with('success','Kategori berhasil dihapus!');
    }
}
