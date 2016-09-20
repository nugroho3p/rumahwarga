<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 25-Feb-16
 * Time: 10:09 PM
 */

namespace App\Models\Role;


use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $table = "menu";
    protected $primaryKey = "id_menu";
    protected $fillable = ["nama_menu","deskripsi"];
    public $timestamps = true;

    public function getData(){
        return $this->all();
    }
}