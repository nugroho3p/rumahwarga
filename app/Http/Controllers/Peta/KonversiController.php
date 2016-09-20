<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/17/2016
 * Time: 10:36
 */

namespace App\Http\Controllers\Peta;


use App\Models\Peta\KlasterModel;
use App\Models\Peta\PetaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KonversiController extends Controller {

    public function getIndex(){
        if(Auth::guest()){
            return redirect('login');
        }else {
            $klas = PetaModel::select('id_klaster')->get();
            $dataKlaster = KlasterModel::whereNotIn('id_klaster', $klas)->get();
            $klaster = DB::table('klaster')->join('users', "klaster.id_klaster", '=', 'users.id_klaster')
                ->select('klaster.*')
                ->where('klaster.id_klaster', '=', Auth::user()->id_klaster)
                ->first();
            $data = [
                "klaster" => $klaster,
                "getKlaster" => $dataKlaster
            ];
            return view('peta.konversi', $data);
        }
    }

    public function postAddMap(Request $request){
        try {
            $data = PetaModel::findOrNew($request->input("id_peta"));

            $data->nama_peta = $request->input("nama_peta");
            $data->kode = $request->input("kode");
            $data->id_klaster = $request->input("klaster");
            $data->created_by= Auth::user()->id;
            $data->updated_by= Auth::user()->id;

            $data->save();
            \Session::flash('flash_message','Peta Berhasil ditambahkan.');
            return redirect("peta");

        }catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/peta');
        }
    }

    public function getMapName($id_klaster){
        $klaster = new KlasterModel();
        $data = $klaster->getDataKlaster($id_klaster);
        $html = '<label>Nama Peta <small>(nama klaster)</small>:</label>
                <input class="form-control" type="text" id="setting-map-name" name="nama_peta" value="'.$data->nama_klaster.'"/>';
        return $html;
    }

}