<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/26/2016
 * Time: 13:26
 */

namespace App\Models\Belanja;


use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarangModel extends Model{
    protected $table = "barang";
    protected $primaryKey = "id_barang";
    protected $fillable = ["nama_barang","gambar"];
    public $timestamps = true;

    public function BarangModel(){
    }

    public function getDataSearch($search=""){
        $detail_barang = DetailBarangModel::all();

        $data = [];
        foreach($detail_barang as $key => $row) {
            $data[] = $row->id_barang;
        }

        $barang = $this
            ->where('nama_barang','LIKE','%'.$search.'%')
            ->whereIn('id_barang',$data)
            ->select('id_barang','nama_barang','gambar')
            ->paginate(8);
        return $barang;
    }

    public function getBarangUkur($id_barang, $ukuran)
    {
        $joinUser = DB::table('barang')
            ->join('detail_barang', "detail_barang.id_barang", '=', 'barang.id_barang')
            ->join('users',"users.id","=","detail_barang.id_penjual")
            ->where("detail_barang.id_barang","=",$id_barang)
            ->where("detail_barang.ukuran","=",$ukuran)
            ->get();
        return $joinUser;
    }

    public function getUkuranBarang($id_barang)
    {
        $joinUser = DB::table('barang')
            ->join('detail_barang', "detail_barang.id_barang", '=', 'barang.id_barang')
            ->join('users',"users.id","=","detail_barang.id_penjual")
            ->where("detail_barang.id_barang","=",$id_barang)
            ->get();
        return $joinUser;
    }

    public function getDetail($id_barang){
        return $this->where("id_barang","=",$id_barang)->first();
    }

    public function keranjang(){
        $keranjang = Cart::content();
        return $keranjang;
    }

    public function getProduk(){
        $dataBarang = DB::table('barang')
            ->join('users','users.id','=','barang.created_by')
            ->get();
        return $dataBarang;
    }

    public function getUkuran($id_barang){
        return $this->join('detail_barang','detail_barang.id_barang','=','barang.id_barang')
            ->where('detail_barang.id_barang',$id_barang)
            ->select('ukuran')
            ->get();
    }
}