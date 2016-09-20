<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 05-Feb-16
 * Time: 03:19 PM
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;

class KecamatanModel extends Model{
    protected $table = "kecamatan";
    protected $primaryKey = "id_kec";
    protected $fillable = ["nama_kec","id_kota"];
    public $timestamps = true;

    public function getData(){
        return $this->join('kota','kecamatan.id_kota','=','kota.id_kota')
            ->join('provinsi','kota.id_prov','=','provinsi.id_prov')
            ->join('negara','provinsi.id_negara','=','negara.id_negara')->get();
    }


}