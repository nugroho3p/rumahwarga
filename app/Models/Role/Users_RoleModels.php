<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/17/2016
 * Time: 16:16
 */

namespace App\Models\Role;


use Illuminate\Database\Eloquent\Model;

class Users_RoleModels extends Model{
    protected $table = "users_role";
    protected $fillable = ["id","id_role"];
    public $timestamps = true;

    public function getData(){
        return $this->all();
    }

}