<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 05-Feb-16
 * Time: 03:04 PM
 */

namespace App\Models\Peta;

use Illuminate\Database\Eloquent\Model;

class ProvinsiModel extends Model{
    protected $table = "provinsi";
    protected $primaryKey = "id_prov";
    protected $fillable = ["nama_prov","id_negara"];
    public $timestamps = true;

    public function getData(){
        return $this->join('negara','provinsi.id_negara','=','negara.id_negara')->get();
    }

   }