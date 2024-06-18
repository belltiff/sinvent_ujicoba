<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);
        return view('barang_masuk.index', compact('rsetBarangMasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarangmasuk = Barang::all();
        return view('barang_masuk.create',compact('abarangmasuk'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required',
        ]);

        $barang = Barang::find($request->barang_id);

    // Validasi jika tanggal barang keluar ada dan jika tanggal barang keluar sebelum tanggal barang masuk
    if ($barang->tgl_keluar && $request->tgl_masuk > $barang->tgl_keluar) {
        return redirect()->back()->withInput()->withErrors(['tgl_masuk' => 'Tanggal barang masuk tidak boleh sesudah tanggal barang keluar!']);
    }


        //create post
        BarangMasuk::create([
            'tgl_masuk'        => $request->tgl_masuk,
            'qty_masuk'        => $request->qty_masuk,
            'barang_id'        => $request->barang_id,
        ]);

        return redirect()->route('barang_masuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function show($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('barang_masuk.show', compact('barangMasuk'));
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        
        // Cek apakah ada record terkait di tabel BarangKeluar
        $barangKeluar = BarangKeluar::where('barang_id', $id)->first();
        if ($barangKeluar) {
            return redirect()->route('barang_masuk.index')->withErrors(['error' => 'Tidak dapat menghapus, ada barang yang sudah keluar terkait dengan barang masuk ini.']);
        }
        
        // Jika tidak ada, lanjutkan penghapusan
        $barangMasuk->delete();
        
        return redirect()->route('barang_masuk.index')->with('success', 'Barang masuk berhasil dihapus.');
    }
    
    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $abarangmasuk = Barang::all();

        return view('barang_masuk.edit', compact('barangMasuk', 'abarangmasuk'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required',
        ]);

        $barang = Barang::find($request->barang_id);

        if ($request->tgl_masuk > $barang->tgl_keluar) {
            return redirect()->back()->withInput()->withErrors(['tgl_masuk' => 'Tanggal barang masuk tidak boleh sesudah tanggal barang keluar!']);
        }

        //create post
        $barangMasuk = BarangMasuk::findOrFail($id);
            $barangMasuk->update([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id,
            ]);

        return redirect()->route('barang_masuk.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}