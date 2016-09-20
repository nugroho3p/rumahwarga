<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 25-Feb-16
 * Time: 10:11 PM
 */

namespace App\Models\Role;


use Illuminate\Database\Eloquent\Model;

class Role_MenuModel extends Model
{
    protected $table = "role_menu";
    protected $fillable = ["id_role","id_menu"];
    public $timestamps = true;

    public function getData(){
        return $this->all();
    }

}