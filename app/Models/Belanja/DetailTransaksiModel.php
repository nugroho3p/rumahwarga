<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/11/2016
 * Time: 13:43
 */

namespace App\Models\Belanja;


use Illuminate\Database\Eloquent\Model;

class DetailTransaksiModel extends Model{

    protected $table = "detail_transaksi";
    protected $primaryKey = "id_detail_transaksi";
    protected $fillable = ["id_transaksi", "kuantitas", "subtotal", "penjual", "id_detail_barang"];
    public $timestamps = true;

    public function DetailTransaksiModel()
    {
    }

    public function getData(){
        return $this->all();
    }

    public function Transaksi(){
        return $this->belongsTo('App\Models\Belanja\TransaksiModel','id_transaksi');
    }
}