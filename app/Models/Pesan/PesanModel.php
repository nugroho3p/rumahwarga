<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/19/2016
 * Time: 1:44 PM
 */

namespace App\Models\Pesan;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PesanModel extends Model {
    protected $table="pesan";
    protected $primaryKey="id_pesan";
    protected $fillable=["id_penerima","isi_pesan","lampiran","id_pengirim","status"];
    public $timestamps=true;

    public function PesanModel(){

    }

    public function getData(){
        return $this->all();
    }

    public function getDataSearch ($search=""){
        $pesan =  DB::table('users as tbl1')->join('pesan','tbl1.id','=','pesan.id_pengirim')
                ->join('users as tbl2','tbl2.id','=','pesan.id_penerima')
            ->where('pesan.id_penerima','=',Auth::user()->id)
            ->select('tbl1.*','tbl2.*','pesan.*','tbl1.name as pengirim','tbl2.name as penerima','pesan.lampiran')
            ->orderBy('pesan.created_at')
            ->get();

        return $pesan;
    }

    public function getNotifPesan(){
        return $this
            ->join('users as tbl1','tbl1.id','=','pesan.id_penerima')
            ->join('users as tbl2','tbl2.id','=','pesan.id_pengirim')
            ->where('pesan.id_penerima','=',Auth::user()->id)
            ->where('pesan.status','=','unread')
            ->select('tbl1.name as penerima','tbl2.name as pengirim','pesan.*')
            ->get();

    }


}