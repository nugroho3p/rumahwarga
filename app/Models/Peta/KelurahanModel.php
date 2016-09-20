<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 05-Feb-16
 * Time: 03:51 PM
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;

class KelurahanModel extends Model{
    protected $table = "kelurahan";
    protected $primaryKey = "id_kel";
    protected $fillable = ["nama_kel","id_kec"];
    public $timestamps = true;


    public function getData(){
        return $this->join('kecamatan','kelurahan.id_kec','=','kecamatan.id_kec')
            ->join('kota','kecamatan.id_kota','=','kota.id_kota')
            ->join('provinsi','kota.id_prov','=','provinsi.id_prov')
            ->join('negara','provinsi.id_negara','=','negara.id_negara')->get();
    }

}