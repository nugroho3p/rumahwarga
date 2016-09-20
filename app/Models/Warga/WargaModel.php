<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 11-Feb-16
 * Time: 01:22 PM
 */

namespace App\Models\Warga;


use Illuminate\Database\Eloquent\Model;

class WargaModel extends Model
{
    protected $table = "users";
    protected $primaryKey = "id";
    protected $fillable = ["name","no_telp","alamat","status","foto","NIK","email","password","id_klaster","tanggal_lahir","tempat_lahir","pekerjaan","facebook","twitter","id_role"];
    public $timestamps = true;

    public function WargaModel(){
    }

    public function getData(){
        return $this->all();
    }

}