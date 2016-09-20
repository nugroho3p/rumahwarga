<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 04-Feb-16
 * Time: 01:52 PM
 */

namespace App\Models\Peta;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NegaraModel extends Model {
    protected $table = "negara";
    protected $primaryKey = "id_negara";
    protected $fillable = ["kode_negara","nama_negara"];
    public $timestamps = true;

    public function getData(){
        return $this->all();
    }

}