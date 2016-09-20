<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/17/2016
 * Time: 20:37
 */

namespace App\Models\Belanja;



use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailBarangModel extends Model{

    protected $table = "detail_barang";
    protected $primaryKey = "id_detail_barang";
    protected $fillable = ["id_barang","id_penjual","harga","stok","ukuran"];
    public $timestamps = true;

    public function DetailBarangModel(){
    }

    public function getAll(){
        return $this->all();
    }

    public function getProdukPenjual(){
        $data = $this
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('id_penjual','=',Auth::user()->id)
            ->get();
        return $data;
    }

    public function getDataBarang(){
        return $this
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('id_penjual','!=',Auth::user()->id)
            ->select('barang.id_barang','nama_barang')
            ->get();
    }
}
