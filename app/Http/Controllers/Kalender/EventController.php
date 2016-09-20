<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/18/2016
 * Time: 1:50 PM
 */

namespace App\Http\Controllers\Kalender;


use App\Models\Kalender\KegiatanModel;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class EventController extends Controller {

    public function getIndex(){
        $dataEvent = KegiatanModel::all();
        $join = DB::table('kegiatan')
            ->join('users',"users.id",'=','kegiatan.id')
            ->select('users.*','kegiatan.*')
            ->get();
        $data = [
            'getDataEvent' => $dataEvent,
            "getJoin" => $join
        ];
        return view('kalender.kegiatan', $data);
    }

}