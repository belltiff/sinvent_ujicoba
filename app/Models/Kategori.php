<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['kategori','jenis'];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    public static function infoKategori(){
        return DB::table('kategori')
            ->select('kategori.id','kategori',DB::raw('infoKategori(jenis) as Info'))->get();
    }

    public function ketKategorik()
    {
        switch ($this->kategori) {
            case 'M':
                return 'Modal Barang';
            case 'A':
                return 'Alat';
            case 'BHP':
                return 'Bahan Habis Pakai';
            case 'BTHP':
                return 'Bahan Tidak Habis Pakai';
            default:
                return 'Unknown';
        }
    }

    public static function getKategoriAll(){
        return DB::table('kategori')
            ->select('kategori.id','kategori',DB::raw('ketKategorik(jenis) as ketkategorik'));

        return self::query();
    }

}