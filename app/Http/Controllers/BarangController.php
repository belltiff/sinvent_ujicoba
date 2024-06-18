<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\Storage;
use DB;

class BarangController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            // Filter hasil berdasarkan pencarian
            $rsetBarang = Barang::with('kategori')
                                ->whereHas('kategori', function ($q) use ($query) {
                                    $q->where('kategori', 'LIKE', "%{$query}%")
                                      ->orWhere('jenis', 'LIKE', "%{$query}%");
                                })
                                ->orWhere('merk', 'LIKE', "%{$query}%")
                                ->latest()
                                ->paginate(10);
        } else {
            // Jika tidak ada pencarian, ambil semua data
            $rsetBarang = Barang::with('kategori')->latest()->paginate(10);
        }
    
        return view('barang.index', compact('rsetBarang'))->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    

    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    public function store(Request $request)
    {
        //return $request;
        //validate form
        $this->validate($request, [
            'merk'              => 'required',
            'seri'              => 'required',
            'spesifikasi'       => 'required',
            'kategori_id'          => 'required'
            // 'foto'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        //upload image
        //$foto = $request->file('foto');
        //$foto->storeAs('public/foto', $foto->hashName());
        //create post
        Barang::create([
            'merk'              => $request->merk,
            'seri'              => $request->seri,
            'spesifikasi'       => $request->spesifikasi,
            'kategori_id'       => $request->kategori_id
            //'foto'              => $foto->hashName()
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        //return view
        return view('barang.show', compact('rsetBarang'));
    }

    public function edit(string $id)
    {
        $akategori = array('blank'=>'Pilih Kategori',
                                    'M'=>'M',
                                    'A'=>'A',
                                    'BHP'=>'BHP',
                                    'BTHP'=>'BTHP'
        );

        $rsetBarang = Barang::find($id);
        return view('barang.edit', compact('rsetBarang','akategori'));
    }

    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'merk'              => 'required',
            'seri'              => 'required',
            'spesifikasi'       => 'required',
            //'stok'              => 'required',
            'kategori_id'          => 'required',
            // 'foto'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $rsetBarang = Barang::find($id);

        // //check if image is uploaded
        // if ($request->hasFile('foto')) {

        //     //upload new image
        //     $foto = $request->file('foto');
        //     $foto->storeAs('public/foto', $foto->hashName());

        //     //delete old image
        //     Storage::delete('public/foto/'.$rsetBarang->foto);

        //     //update post with new image
        //     $rsetBarang->update([
        //         'merk'              => $request->merk,
        //         'seri'              => $request->seri,
        //         'spesifikasi'       => $request->spesifikasi,
        //         'stok'              => $request->stok,
        //         'kategori'          => $request->kategori,
        //         'foto'              => $foto->hashName()
        //     ]);

        // } else {

            //update post without image
            $rsetBarang->update([
                'merk'              => $request->merk,
                'seri'              => $request->seri,
                'spesifikasi'       => $request->spesifikasi,
                //'stok'              => $request->stok,
                'kategori_id'          => $request->kategori_id
            ]);
        // }

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Data Barang Berhasil Diubah!']);

    }

    public function destroy(string $id)

    {

        //cek apakah kategori_id ada di tabel barang.kategori_id ?

        if (DB::table('barangmasuk')->where('barang_id', $id)->exists() or (DB::table('barangkeluar')->where('barang_id', $id)->exists())){

            return redirect()->route('barang.index')->with(['Gagal' => 'Data Gagal Dihapus!']);


        } else {

            $rsetBarang = Barang::find($id);

            $rsetBarang->delete();

            return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);

        }

    }
}