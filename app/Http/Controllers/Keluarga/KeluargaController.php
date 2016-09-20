<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 09-Feb-16
 * Time: 09:37 AM
 */

namespace App\Http\Controllers\Keluarga;


use App\Models\Tagihan\TagihanModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KeluargaController extends Controller{

    public function getIndex(Request $request, WargaModel $wargaModel){
        if(Auth::user()->status == "Kepala Keluarga"){
            $dataWarga = WargaModel::where("parent", "=", Auth::user()->id)
                ->orWhere('id','=',Auth::user()->id)
                ->orderBy('name','asc')
                ->get();
        } else {
            $dataWarga = WargaModel::where("parent", "=", Auth::user()->parent)
                ->orWhere('id','=',Auth::user()->id)
                ->orWhere('id','=',Auth::user()->parent)
                ->orderBy('name','asc')
                ->get();
        }
        $parent = $wargaModel::where("id","=",Auth::user()->parent)->first();
        $data = [
            "getDataWarga" => $dataWarga,
            "parent" => $parent
        ];
        return view("keluarga.keluarga",$data);
        }


    public function postSubmit(Request $request){
        try {
            $data = WargaModel::findOrNew($request->input("id"));
            $data->name = $request->input("name");
            $data->email = $request->input("email");
            $data->password = bcrypt($request->input("password"));
            $data->status = $request->input("status");
            $data->foto = "no_image.png";
            $data->id_klaster = Auth::user()->id_klaster;
            $data->parent = Auth::user()->id;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();

            /*$users_role = new Users_RoleModels();
            $users_role->id = $request->input("id");
            $users_role->id_role = "3";
            $users_role->created_by = Auth::user()->id;
            $users_role->updated_by = Auth::user()->id;
            $users_role->save();*/
            \Session::flash('flash_message','Anggota keluarga berhasil ditambahkan.');
            return redirect("keluarga");

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/keluarga')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function getDelete($id){
        try {
            $obj = WargaModel::findOrNew($id);
            if (count($obj) > 0) {
                $obj->delete();
                return redirect('/keluarga')->with('Sukses dihapus');
            } else {
                return redirect('/keluarga')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        }catch (QueryException  $e){
            \Log::error($e->getMessage());
            return redirect('/keluarga')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

    public function getProfil($id){
        $find = WargaModel::find($id);
        $dataTagih = TagihanModel::where("id", "=", Auth::user()->id)->get();
        $dataWarga = WargaModel::where("parent", "=", Auth::user()->id)
            ->orWhere('id','=',Auth::user()->id)
            ->get();
        $join = DB::table('klaster')->join('users', "klaster.id_klaster", '=', 'users.id_klaster')
            ->select('klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
        $data = [
            "profil" => $find,
            "getDatawarga" => $dataWarga,
            "getDataTagih" => $dataTagih,
            "join" => $join
        ];
        return view("profil/detailprofil",$data);
    }
}