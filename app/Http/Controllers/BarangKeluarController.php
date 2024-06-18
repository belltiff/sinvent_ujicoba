<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $rsetBarangKeluar = BarangKeluar::with('barang')->latest()->paginate(10);
        return view('barang_keluar.index', compact('rsetBarangKeluar'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $abarangkeluar = Barang::all();
        return view('barang_keluar.create',compact('abarangkeluar'));
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'tgl_keluar'     => 'required',
            'qty_keluar'     => 'required',
            'barang_id'     => 'required',
        ]);

        // $barang = Barang::find($request->barang_id);

        // //Validasi jika jumlah qty_keluar lebih besar dari stok saat itu maka muncul pesan eror
        // if ($request->qty_keluar > $barang->stok) {
        //     return redirect()->back()->withInput()->withErrors(['qty_keluar' => 'Jumlah barang keluar melebihi stok!']);
        // }

        // // Validasi jika tanggal barang keluar sebelum tanggal barang masuk
        // if ($request->tgl_keluar < $barang->tgl_masuk) {
        //     return redirect()->back()->withInput()->withErrors(['tgl_keluar' => 'Tanggal barang keluar tidak boleh sebelum tanggal barang masuk!']);
        // }
        $tgl_keluar = $request->tgl_keluar;
        $barang_id = $request->barang_id;
    
        // Check if there's any BarangMasuk with a date later than tgl_keluar
        $existingBarangMasuk = BarangMasuk::where('barang_id', $barang_id)
            ->where('tgl_masuk', '>', $tgl_keluar)
            ->exists();
    
        if ($existingBarangMasuk) {
            return redirect()->back()->withInput()->withErrors(['tgl_keluar' => 'Tanggal keluar tidak boleh mendahului tanggal masuk!']);
        }
    
        $barang = Barang::find($barang_id);
    
        if ($request->qty_keluar > $barang->stok) {
            return redirect()->back()->withInput()->withErrors(['qty_keluar' => 'Jumlah barang keluar melebihi stok!']);
        }
        
        BarangKeluar::create([
            'tgl_keluar'        => $request->tgl_keluar,
            'qty_keluar'        => $request->qty_keluar,
            'barang_id'        => $request->barang_id,
        ]);

        return redirect()->route('barang_keluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    public function show($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        return view('barang_keluar.show', compact('barangKeluar'));
    }
    

    //delete record di tambel barangkeluar tanpa memengaruhi stok di tabel barang
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('barang_keluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }


    public function edit($id)
    {
        $barangKeluar= BarangKeluar::findOrFail($id);
        $abarangkeluar = Barang::all();

        return view('barang_keluar.edit', compact('barangKeluar', 'abarangkeluar'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'tgl_keluar'     => 'required',
            'qty_keluar'     => 'required',
            'barang_id'     => 'required',
        ]);


        $tgl_keluar = $request->tgl_keluar;
        $barang_id = $request->barang_id;
    
        // Check if there's any BarangMasuk with a date later than tgl_keluar
        $existingBarangMasuk = BarangMasuk::where('barang_id', $barang_id)
            ->where('tgl_masuk', '>', $tgl_keluar)
            ->exists();
    
        if ($existingBarangMasuk) {
            return redirect()->back()->withInput()->withErrors(['tgl_keluar' => 'Tanggal keluar tidak boleh mendahului tanggal masuk!']);
        }

        $barang = Barang::find($request->barang_id);

        //Validasi jika jumlah qty_keluar lebih besar dari stok saat itu maka muncul pesan eror
        if ($request->qty_keluar > $barang->stok) {
            return redirect()->back()->withInput()->withErrors(['qty_keluar' => 'Jumlah barang keluar melebihi stok!']);
        }
        //update record barang keluar
        $barangKeluar = BarangKeluar::findOrFail($id);
            $barangKeluar->update([
                'tgl_keluar' => $request->tgl_keluar,
                'qty_keluar' => $request->qty_keluar,
                'barang_id' => $request->barang_id,
            ]);

        return redirect()->route('barang_keluar.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

}