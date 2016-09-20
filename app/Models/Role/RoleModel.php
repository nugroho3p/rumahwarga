<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 25-Feb-16
 * Time: 10:08 PM
 */

namespace App\Models\Role;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoleModel extends Model
{
    protected $table = "role";
    protected $primaryKey = "id_role";
    protected $fillable = ["nama_role","status"];
    public $timestamps = true;


    public function getData(){
        return $this->all();
    }

    public function getRole(){
        return $this->join('users','users.id_role','=','role.id_role')
            ->where('role.id_role','=',Auth::user()->id_role)
            ->first();

    }

}