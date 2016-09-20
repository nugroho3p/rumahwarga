<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 04-Feb-16
 * Time: 11:11 PM
 */

namespace App\Http\Controllers\Pengguna;

use App\Models\Peta\KlasterModel;
use App\Models\Role\RoleModel;
use App\Models\Warga\WargaModel;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller {
    public function getIndex(){

        if(Auth::user()->status == "Penanggung Jawab Lokasi")
            $dataWarga = DB::table('users')->join('role','role.id_role','=','users.id_role')
                ->whereNotIn("users.id_role" , [1,2])
                ->where("id_klaster","=",Auth::user()->id_klaster)
                ->select('users.*','role.*')
                ->get();
        else
            $dataWarga = WargaModel::join('klaster','klaster.id_klaster','=','users.id_klaster')
                ->whereIn("id_role", [2])->get();

        $dataKlaster = KlasterModel::all();
        $dataRole = RoleModel::whereNotIn("id_role",[1,2])->get();
        $data = [
            "getDataWarga" => $dataWarga,
            "getKlaster" => $dataKlaster,
            "role" => $dataRole
        ];
        return view("pengguna.pengguna",$data);
    }

    public function postSubmit(Request $request){
        try {
            $data = WargaModel::findOrNew($request->input("id"));
            $data->name = $request->input("name");
            $data->email = $request->input("email");
            $data->password = bcrypt($request->input("password"));
            $data->foto = "no_image.png";
            $data->parent = $request->input("id");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            if(Auth::user()->id == 2) {
                $data->status = "Penanggung Jawab Lokasi";
                $data->id_role = 2;
                $data->id_klaster = $request->input("klaster");
            }else {
                $data->status = "Kepala Keluarga";
                $data->id_klaster = Auth::user()->id_klaster;
                $data->id_role = 3;
            }

            $data->save();
            \Session::flash('flash_message','Data warga berhasil ditambahkan.');

            /* Setup the validator
            $rules = array('name' => 'required|email', 'password' => 'required');
            $validator = Validator::make(Input::all(), $rules);

            // Validate the input and return correct response
            if ($validator->fails())
            {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 400); // 400 being the HTTP code for an invalid request.
            }*/
            return redirect("pengguna");// Response::json(array('success' => true), 200);



        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return redirect('/pengguna')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function getDelete($id)
    {
        try {
            $user = WargaModel::find($id);
            if (count($user) > 0) {
                $user->delete();
                return redirect('/pengguna')->with('Sukses dihapus');
            } else {
                return redirect('/pengguna')->withErrors([
                    'Data tidak ditemukan'
                ]);
            }
        } catch (QueryException  $e) {
            \Log::error($e->getMessage());
            return redirect('/pengguna')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    }

    public function postRole($id, Request $request){
        //$user = WargaModel::find($id);

        DB::table('users')->where('id','=',$id)
            ->update(['id_role' => $request->input('id_role')]);

        return redirect('pengguna');
    }

}