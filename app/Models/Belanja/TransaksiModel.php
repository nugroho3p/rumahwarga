<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/7/2016
 * Time: 15:01
 */

namespace App\Models\Belanja;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TransaksiModel extends Model{
    protected $table = "transaksi";
    protected $primaryKey = "id_transaksi";
    protected $fillable = ["jumlah_barang","total_harga","pembeli","status"];
    public $timestamps = true;

    public function TransaksiModel(){

    }

    public function DetailTransaksi(){
        return $this->hasMany('App\Models\Belanja\DetailTransaksiModel', 'id_transaksi');
    }

    public function getTransUser(){
        return $this
            ->join('users',"users.id","=","transaksi.pembeli")
            ->get();
    }

    public function getTransDetail(){
        return $this
            ->join('users','users.id','=','transaksi.pembeli')
            ->join('detail_transaksi','detail_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_barang','detail_barang.id_detail_barang','=','detail_transaksi.id_detail_barang')
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('detail_transaksi.penjual','=',Auth::user()->id)
            ->where('detail_transaksi.status','!=','Transaksi dibatalkan')
            ->where('detail_transaksi.status','!=','Transaksi Berhasil')
            ->select('detail_transaksi.id_transaksi','nama_barang','harga','kuantitas','name','sub_total','detail_transaksi.id_detail_transaksi','detail_transaksi.status','detail_barang.*');
    }

    public function getTransPembeli(){
        return $this
            ->join('detail_transaksi','detail_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('users','users.id','=','detail_transaksi.penjual')
            ->join('detail_barang','detail_barang.id_detail_barang','=','detail_transaksi.id_detail_barang')
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('transaksi.pembeli','=',Auth::user()->id)
            ->where('detail_transaksi.status','!=','Transaksi Berhasil')
            ->where('detail_transaksi.status','!=','Transaksi dibatalkan')
            ->select('detail_transaksi.*','barang.*','users.name','detail_barang.*');
    }

    public function getRiwayatTrans(){
        return $this
            ->join('users','users.id','=','transaksi.pembeli')
            ->join('detail_transaksi','detail_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('detail_barang','detail_barang.id_detail_barang','=','detail_transaksi.id_detail_barang')
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('detail_transaksi.penjual','=',Auth::user()->id)
            ->where('detail_transaksi.status','=','Transaksi dibatalkan')
            ->Orwhere('detail_transaksi.status','=','Transaksi Berhasil')
            ->select('detail_transaksi.id_transaksi','nama_barang','harga','id','kuantitas','name','sub_total','detail_transaksi.id_detail_transaksi','detail_transaksi.status','detail_barang.*');
    }

    public function getRiwayatPesan(){
        return $this
            ->join('detail_transaksi','detail_transaksi.id_transaksi','=','transaksi.id_transaksi')
            ->join('users','users.id','=','detail_transaksi.penjual')
            ->join('detail_barang','detail_barang.id_detail_barang','=','detail_transaksi.id_detail_barang')
            ->join('barang','barang.id_barang','=','detail_barang.id_barang')
            ->where('transaksi.pembeli','=',Auth::user()->id)
            ->where('detail_transaksi.status','=','Transaksi dibatalkan')
            ->Orwhere('detail_transaksi.status','=','Transaksi Berhasil')
            ->select('detail_transaksi.*','barang.*','users.name','detail_barang.*');
    }

    public function getNotifPenjual(){
        return $this
            ->join('users',"users.id","=","transaksi.pembeli")
            ->join('detail_transaksi',"detail_transaksi.id_transaksi","=","transaksi.id_transaksi")
            ->where('detail_transaksi.penjual','=',Auth::user()->id)
            ->where('detail_transaksi.status', '=', 'Belum dikonfirmasi')
            ->get();
    }

    public function getNotifPembeli(){
        return $this
            ->join('detail_transaksi',"detail_transaksi.id_transaksi","=","transaksi.id_transaksi")
            ->join('users',"users.id","=","detail_transaksi.penjual")
            ->where('transaksi.pembeli','=',Auth::user()->id)
            ->where('detail_transaksi.status', '=', 'Transaksi dibatalkan')
            ->get();
    }



}