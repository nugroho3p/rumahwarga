<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 25-Feb-16
 * Time: 10:06 PM
 */

namespace App\Http\Controllers\Role;


use App\Models\MenuModel;
use App\Models\Role_MenuModel;
use App\Models\RoleModel;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function getIndex(){
        $dataRole = RoleModel::all();
        $dataMenu = MenuModel::all();
        $joinRole = DB::table('role_menu')->join('menu', 'menu.id_menu', '=', 'role_menu.id_menu')
            ->join('role',"role_menu.id_role",'=','role.id_role')
            ->select('role_menu.*','menu.*','role.*')
            ->get();

        $satuRoleMenu = [
            "getDataRole" => $dataRole,
            "getDataMenu" => $dataMenu,
            "getDataJoin" => $joinRole
        ];
        return view("roleMenu",$satuRoleMenu);

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
            return redirect("menu");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/menu')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function postSubmitMenu(Request $request){
        try
        {
            $data=MenuModel::findOrNew($request->input("id_menu"));
            $data->nama_menu = $request->input("nama_menu");
            $data->deskripsi = $request->input("deskripsi");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("menu");
        }
        catch (QueryException $e){
            \Log::error($e->getMessage());
            return redirect('/menu')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function postSubmit(Request $request){
        try
        {
            $data=Role_MenuModel::findOrNew($request->input("id_role"));
            $data->id_role = $request->input("id_role");
            $data->id_menu = $request->input("id_menu");
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;

            $data->save();
            return redirect("menu");
        }
         catch (QueryException $e){
            \Log::error($e->getMessage());
            return redirect('/menu')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }
}