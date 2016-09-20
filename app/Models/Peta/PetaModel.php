<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 4/3/2016
 * Time: 00:09
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PetaModel extends Model{
    protected $table = "peta";
    protected $primaryKey = "id_peta";
    protected $fillable = ["nama_peta","kode","id_klaster","id_role"];
    public $timestamps = true;

    public function PetaModel(){
    }

    public function getData(){
        return $this->all();
    }

    public function getLokasi(){
        return $this->join('klaster','peta.id_klaster','=', 'klaster.id_klaster')
            ->join('users', 'klaster.id_klaster','=','users.id_klaster')
            ->select('peta.*','klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
    }

    public function getPeta($id_peta){
        return $this->where('id_peta','=',$id_peta)->first();
    }


}