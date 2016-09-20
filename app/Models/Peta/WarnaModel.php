<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/15/2016
 * Time: 11:58
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;

class WarnaModel extends Model{
    protected $table = "warna";
    protected $primaryKey = "id_warna";
    protected $fillable = ["warna","tipe"];
    public $timestamps = true;

    public function WarnaModel(){
    }

    public function getData(){
        return $this->all();
    }


}