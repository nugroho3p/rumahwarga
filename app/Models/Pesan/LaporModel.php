<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 5/23/2016
 * Time: 6:00 PM
 */

namespace App\Models\Pesan;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LaporModel extends Model
{
    protected $table = "laporan";
    protected $primaryKey = "id_lapor";
    protected $fillable = ["id_pengirim", "id_penerima", "isi","status","kategori","target"];
    public $timestamp = "true";


    public function LaporModel()
    {

    }

    public function getData()
    {
        return $this->all();

    }

    public function getNotifLapor(){
        return $this
            ->where('id_penerima','=',Auth::user()->id)
            ->where('status','=','Belum Diproses')
            ->get();

    }
}