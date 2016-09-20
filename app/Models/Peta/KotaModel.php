<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 05-Feb-16
 * Time: 03:16 PM
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;

class KotaModel extends Model {
    protected $table = "kota";
    protected $primaryKey = "id_kota";
    protected $fillable = ["nama_kota","id_prov"];
    public $timestamps = true;

    public function getData(){
        return $this->join('provinsi','kota.id_prov','=','provinsi.id_prov')
        ->join('negara','provinsi.id_negara','=','negara.id_negara')->get();
    }

}