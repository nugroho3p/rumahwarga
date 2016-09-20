<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 25-Feb-16
 * Time: 11:13 PM
 */

namespace App\Http\Controllers\Role;


use App\Models\Role\RoleModel;
use App\Models\Role\Users_RoleModels;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AkunController extends Controller
{
    public function getIndex(){

        $dataRole = RoleModel::all();
        $joinUsersRole = DB::table('users_role')->join('users', 'users.id', '=', 'users_role.id')
            ->join('role',"users_role.id_role",'=','role.id_role')
            ->select('users_role.*','users.*','role.*')
            ->get();
        $dataWarga = WargaModel::where('id_klaster','=',Auth::user()->id_klaster)
            ->get();

        $satuAkunRole = [
            "warga" => $dataWarga,
            "getDataRole" => $dataRole,
            "getJoinUsersRole" => $joinUsersRole,

        ];
        return view("role.userRole",$satuAkunRole);

    }

    public function postSubmitHub(Request $request){
        try
        {
            $data=Users_RoleModels::findOrNew($request->input("id"));
            $data->id = $request->input("id");
            $data->id_role = $request->input("id_role");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("akun");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/akun')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function postSubmitRole(Request $request){
        try
        {
            $data=RoleModel::findOrNew($request->input("id_role"));
            $data->nama_role = $request->input("nama_role");
            $data->status = $request->input("status");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("akun");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/akun')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }
}