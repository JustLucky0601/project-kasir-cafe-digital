<?php
namespace App\Http\Controllers;
use App\Models\{Produk, Kategori};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller {
    public function index(Request $request) {
        $query = Produk::with('kategori');
        if ($request->filled('search')) $query->where('nama_produk','like','%'.$request->search.'%');
        if ($request->filled('kategori')) $query->where('kategori_id',$request->kategori);
        $produks   = $query->latest()->paginate(12)->withQueryString();
        $kategoris = Kategori::all();
        return view('admin.products.index', compact('produks','kategoris'));
    }

    public function create() {
        $kategoris = Kategori::all();
        return view('admin.products.create', compact('kategoris'));
    }

    public function store(Request $request) {
        $v = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'nullable|string|max:500',
            'foto'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            $f = $request->file('foto');
            $name = time().'_'.preg_replace('/\s+/','_',$f->getClientOriginalName());
            error_log('DEBUG: Uploading file: ' . $name);
            error_log('DEBUG: File size: ' . $f->getSize());
            error_log('DEBUG: File mime: ' . $f->getMimeType());
            try {
                $result = $f->storeAs('products',$name,'public');
                error_log('DEBUG: storeAs result: ' . ($result ? $result : 'FALSE'));
                if ($result) {
                    $files = Storage::disk('public')->files('products');
                    error_log('DEBUG: Files in products: ' . json_encode($files));
                    $v['foto'] = $name;
                } else {
                    error_log('ERROR: storeAs returned false');
                }
            } catch (Exception $e) {
                error_log('ERROR: Upload exception: ' . $e->getMessage());
            }
        }
        $v['tersedia'] = $request->boolean('tersedia',true);
        Produk::create($v);
        return redirect()->route('admin.products.index')->with('success','Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk) {
        $kategoris = Kategori::all();
        return view('admin.products.edit', compact('produk','kategoris'));
    }

    public function update(Request $request, Produk $produk) {
        $v = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga'       => 'required|integer|min:0',
            'stok'        => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi'   => 'nullable|string|max:500',
            'foto'        => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            if ($produk->foto) Storage::disk('public')->delete('products/'.$produk->foto);
            $f = $request->file('foto');
            $name = time().'_'.preg_replace('/\s+/','_',$f->getClientOriginalName());
            $f->storeAs('products',$name,'public');
            $v['foto'] = $name;
        } elseif ($request->boolean('hapus_foto')) {
            if ($produk->foto) Storage::disk('public')->delete('products/'.$produk->foto);
            $v['foto'] = null;
        }
        $v['tersedia'] = $request->boolean('tersedia',true);
        $produk->update($v);
        return redirect()->route('admin.products.index')->with('success','Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk) {
        if ($produk->foto) Storage::disk('public')->delete('products/'.$produk->foto);
        $produk->delete();
        return redirect()->route('admin.products.index')->with('success','Produk berhasil dihapus!');
    }
}
