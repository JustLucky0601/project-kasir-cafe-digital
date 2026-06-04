<?php
namespace App\Http\Controllers;
use App\Models\{Produk, Kategori};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $f->storeAs('products',$name,'public');
            $v['foto'] = $name;
        }
        $v['tersedia'] = $request->boolean('tersedia',false);
        $v['best_seller'] = $request->boolean('best_seller', false);
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
            // Pastikan checkbox yang tidak tercentang disimpan sebagai false
            $v['tersedia'] = $request->has('tersedia') ? 1 : 0;
            $v['best_seller'] = $request->has('best_seller') ? 1 : 0;

            // Terapkan perubahan secara eksplisit ke model untuk menghindari masalah filling
            $produk->fill($v);
            $produk->save();
            Log::info('Produk update received', [
                'id' => $produk->id,
                'request_all' => $request->all(),
                'saved_tersedia' => $produk->tersedia,
            ]);
        return redirect()->route('admin.products.index')->with('success','Produk berhasil diperbarui!')->with('tersedia_saved', $produk->tersedia);
    }

    public function destroy(Produk $produk) {
        if ($produk->foto) Storage::disk('public')->delete('products/'.$produk->foto);
        $produk->delete();
        return redirect()->route('admin.products.index')->with('success','Produk berhasil dihapus!');
    }
}
