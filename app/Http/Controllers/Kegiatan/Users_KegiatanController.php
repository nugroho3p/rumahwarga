<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 4/6/2016
 * Time: 3:10 PM
 */

namespace App\Http\Controllers\Kegiatan;

use App\Models\Kegiatan\KegiatanModel;
use App\Models\Warga\WargaModel;
use Illuminate\Routing\Controller;

class Users_KegiatanController extends Controller {

    public function getIndex(){

        $kegiatan = KegiatanModel::all();
        $dataWarga = WargaModel::where("id_klaster","=",Auth::user()->id_klaster)
            ->whereNotIn('id',[2,3])->get();
        $data = [
            "getDataWarga" => $dataWarga,
            "getData" => $kegiatan
        ];

        return view("kegiatan.kegiatanUndang",$data);
    }

    public function submitWarga(){

    }
}