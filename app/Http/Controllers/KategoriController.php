<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        if ($query) {
            // Filter hasil berdasarkan pencarian
            $rsetKategori = Kategori::getKategoriAll()
                                    ->where('kategori', 'LIKE', "%{$query}%")
                                    ->orWhere('jenis', 'LIKE', "%{$query}%")
                                    ->paginate(10);
        } else {
            // Jika tidak ada pencarian, ambil semua data
            $rsetKategori = Kategori::getKategoriAll()->paginate(10);
        }

        return view('kategori.index', compact('rsetKategori'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $akategori = array('blank'=>'Pilih Jenis',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('kategori.create',compact('akategori'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'kategori'              => 'required|unique:kategori',
            'jenis'              => 'required|in:M,A,BHP,BTHP'
        ]);

        try {
            DB::beginTransaction(); // Start the transaction

            // Insert a new category using Eloquent
            Kategori::create([
                'kategori' => $request->kategori,
                'jenis'  => $request->jenis,
                'status'    => 'pending',
            ]);

            DB::commit(); // Commit the changes

            // Flash success message to the session
            Session::flash('success', 'Kategori berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback in case of an exception
            report($e); // Report the exception

            // Flash failure message to the session
            Session::flash('gagal', 'Kategori gagal disimpan!');
        }

        //redirect to index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetKategori = Kategori::find($id);
        return view('kategori.show', compact('rsetKategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $akategori = array(
        'blank' => 'Pilih Jenis',
        'M' => 'M',
        'A' => 'A',
        'BHP' => 'BHP',
        'BTHP' => 'BTHP'
    );

    $rsetKategori = Kategori::find($id);
    return view('kategori.edit', compact('rsetKategori', 'akategori'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $this->validate($request, [
        'kategori' => 'required',
        'jenis' => 'required',
    ]);

    $rsetKategori = Kategori::find($id);

    $rsetKategori->update([
        'kategori' => $request->kategori,
        'jenis' => $request->jenis,
        // other fields...
    ]);

    return redirect()->route('kategori.index')->with(['success' => 'Data Kategori Berhasil Diubah!']);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)

    {

        //cek apakah kategori_id ada di tabel barang.kategori_id ?

        if (DB::table('barang')->where('kategori_id', $id)->exists()){

            return redirect()->route('kategori.index')->with(['Gagal' => 'Data Gagal Dihapus!']);

        } else {

            $rsetKategori = Kategori::find($id);

            $rsetKategori->delete();

            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);

        }
    
    }
}