<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 05-Feb-16
 * Time: 03:55 PM
 */

namespace App\Models\Peta;

use Illuminate\Database\Eloquent\Model;

class KlasterModel extends Model{
    protected $table = "klaster";
    protected $primaryKey = "id_klaster";
    protected $fillable = ["nama_klaster","id_kel","alamat"];
    public $timestamps = true;

    public function getData(){
        return $this->join('kelurahan','klaster.id_kel','=','kelurahan.id_kel')
            ->join('kecamatan','kelurahan.id_kec','=','kecamatan.id_kec')
            ->join('kota','kecamatan.id_kota','=','kota.id_kota')
            ->join('provinsi','kota.id_prov','=','provinsi.id_prov')
            ->join('negara','provinsi.id_negara','=','negara.id_negara')->get();
    }

    public function getDataKlaster($id_klaster){
        $data = $this->where('id_klaster' , '=', $id_klaster)->first();
        return $data;
    }
}