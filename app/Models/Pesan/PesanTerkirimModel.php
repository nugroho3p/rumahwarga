<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/19/2016
 * Time: 1:44 PM
 */

namespace App\Models\Pesan;


use Illuminate\Database\Eloquent\Model;

class PesanTerkirimModel extends Model {
    protected $table="pesan_terkirim";
    protected $primaryKey="id_pesan";
    protected $fillable=["id_penerima","isi_pesan","lampiran","id_pengirim","judul","status"];
    public $timestamps=true;

    public function PesanTerkirimModel(){

    }

    public function getData(){
        return $this->all();
    }

    public function getNotifPesanTerkirim(){
        return $this
            ->join('users as tbl1')->join('pesan_terkirim','tbl1.id','=','pesan_terkirim.id_pengirim')
            ->join('users as tbl2','tbl2.id','=','pesan_terkirim.id_penerima')
            ->where('pesan_terkirim.id_penerima','=',Auth::user()->id)
            ->where('pesan_terkirim.status','=','unread')
            ->get();

    }
}