<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/18/2016
 * Time: 1:52 PM
 */

namespace App\Models\Kalender;



use Illuminate\Database\Eloquent\Model;

class EventModel extends Model {
    protected $table="kegiatan";
    protected $primaryKey="id_kegiatan";
    protected $fillable=["nama_kegiatan","tanggal_mulai","tanggal_selesai","waktu_mulai","waktu_selesai","deskripsi"];
    public $timestamps=true;

    public function EventModel(){
    }


    protected $dates = ['tanggal_mulai', 'tanggal_selesai'];
    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function isAllDay()
    {
        return (bool) $this->all_day;
    }

    public function getStart()
    {
        return $this->tanggal_mulai;
    }

    public function getEnd()
    {
        return $this->tanggal_selesai;
    }

}