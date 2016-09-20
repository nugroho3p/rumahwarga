<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/18/2016
 * Time: 1:52 PM
 */

namespace App\Models\Kalender;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KegiatanModel extends Model {
    protected $table="kegiatan";
    protected $primaryKey="id_kegiatan";
    protected $fillable =["title","start","end","waktu_mulai","waktu_selesai","description",'pemilik_acara'];
    public $timestamps=true;

    public function EventModel(){
    }

    public function getData(){
        return $this->all();
    }

    public function getDataEvent(){
        return DB::table('kegiatan')->select('*')->get();
    }

    public function Users_Kegiatan(){
        return $this->hasMany('App\Models\Kalender\KegiatanModel','id_kegiatan');
    }

}