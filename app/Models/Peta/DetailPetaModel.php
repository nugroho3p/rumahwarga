<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/15/2016
 * Time: 16:16
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailPetaModel extends Model{
    protected $table = "detail_peta";
    protected $primaryKey = "kode_svg";
    protected $fillable = ["no_rumah","alamat","jenis","id_warna","id_warga","warna"];
    public $timestamps = true;

    public function DetailPetaModel(){
    }

    public function getData(){
        return $this->all();
    }

    public function getDataColor(){

        return DB::table('detail_peta')->select('kode_svg','warna')->get();
    }

    public function getDataPeta($id_peta){
        return $this
            ->where('id_peta','=',$id_peta)
            ->select('detail_peta.kode_svg','detail_peta.warna');
    }

    public function getDelete($kode_svg){
        $data = $this->where("kode_svg","=",$kode_svg)->first();
        return $data;
    }

    public function getDetail($kode_svg){
        $peta = DB::table('peta')->join('klaster','peta.id_klaster','=', 'klaster.id_klaster')
            ->join('users', 'klaster.id_klaster','=','users.id_klaster')
            ->select('peta.*','klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
        $detail = DB::table('detail_peta')
            ->where('kode_svg','=',$kode_svg)
            ->where('id_peta','=',$peta->id_peta)
            ->select('*')
            ->first();
        return $detail;
    }

    public function getPetaDetail($id_peta){
        $data = $this->where('id_peta','=',$id_peta)->delete();
        return $data;
    }


}