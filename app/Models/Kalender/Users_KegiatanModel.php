<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 15-Apr-16
 * Time: 08:49 AM
 */

namespace App\Models\Kalender;


use Illuminate\Database\Eloquent\Model;

class Users_KegiatanModel extends Model
{
    protected $table = "users_kegiatan";
    protected $fillable = ["id_kegiatan","id"];
    public $timestamps = false;

    public function Users_KegiatanModel(){
    }

    public function getData(){
        return $this->all();
    }

    public function Kegiatan(){
        return $this->belongsTo('App\Models\Kalender\KegiatanModel','id_kegiatan');
    }

}