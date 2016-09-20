<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 04-Feb-16
 * Time: 09:26 PM
 */

namespace App\Http\Controllers\Profil;


use App\Models\Tagihan\TagihanModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller{

    public function getIndex(){
        $dataTagihan = DB::table('users_tagihan')->join('tagihan', "tagihan.id_tagihan", '=', 'users_tagihan.id_tagihan')
            ->join('users',"users_tagihan.id",'=','users.id')
            ->where('users_tagihan.id','=',Auth::user()->id)
            ->orwhere('users_tagihan.sisa','!=',0)
            ->select('users_tagihan.*','tagihan.*','users.*')
            ->get();
        $dataWarga = WargaModel::where("parent", "=", Auth::user()->id)
            ->orwhere("parent","=",Auth::user()->parent)
            ->orwhere("id","=",Auth::user()->parent)
            ->get();
        $join = DB::table('klaster')->join('users', "klaster.id_klaster", '=', 'users.id_klaster')
            ->select('klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
        $data = [
            "getDatawarga" => $dataWarga,
            "getTagihan" => $dataTagihan,
            "join" => $join
        ];
        return view("profil.profil",$data);
    }

    public function getProfil($id){
        $find = WargaModel::find($id);
        $dataTagihan = DB::table('users_tagihan')->join('tagihan', "tagihan.id_tagihan", '=', 'users_tagihan.id_tagihan')
            ->join('users',"users_tagihan.id",'=','users.id')
            ->where('users_tagihan.id','=',Auth::user()->id)
            ->select('users_tagihan.*','tagihan.*','users.*')
            ->get();
        $dataWarga = WargaModel::where("parent", "=", Auth::user()->id)
            ->orwhere("parent","=",Auth::user()->parent)
            ->orwhere("id","=",Auth::user()->parent)
            ->get();
        $join = DB::table('klaster')->join('users', "klaster.id_klaster", '=', 'users.id_klaster')
            ->select('klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
        $data = [
            "profil" => $find,
            "getDatawarga" => $dataWarga,
            "getTagihan" => $dataTagihan,
            "join" => $join
        ];
        return view("profil.profil",$data);
    }

    public function getUser($id){
        $find = WargaModel::find($id);
        $dataWarga = WargaModel::where("parent", "=", $id)
            ->orWhere('id','=',$id)
            ->get();
        $join = DB::table('klaster')->join('users', "klaster.id_klaster", '=', 'users.id_klaster')
            ->select('klaster.*')
            ->where('klaster.id_klaster','=',Auth::user()->id_klaster)
            ->first();
        $data = [
            "profil" => $find,
            "getDatawarga" => $dataWarga,
            "join" => $join
        ];
        return view("profil.detailprofil",$data);
    }

    public function postSubmit(Request $request){
        try{

            if($request->input("id")!= null){
                $data=WargaModel::findOrNew($request->input("id"));
                \Session::flash('flash_message','Data Berhasil Diedit.');
            }else{
                $data = new WargaModel();
                \Session::flash('flash_message','Data Berhasil Ditambah.');
            }

            $data->name = $request->input("name");
            $data->NIK = $request->input("NIK");
            $data->email = $request->input("email");
            $data->alamat = $request->input("alamat");
            $data->no_telp = $request->input("no_telp");
            $data->tempat_lahir = $request->input("tempat_lahir");
            $data->tanggal_lahir = $request->input("tanggal_lahir");
            $data->facebook = $request->input("facebook");
            $data->twitter = $request->input("twitter");
            $data->pekerjaan = $request->input("pekerjaan");
            $data->updated_by = Auth::user()->id;
            $data->created_by = Auth::user()->id;

            if($request->hasFile('foto')){

                $file = Input::file('foto');
                $name = time(). '-' .$file->getClientOriginalName();
                $path = 'dist/img/profil';

                $unLink = 'dist/img/profil'.$request->input('image_old');
                if(file_exists($unLink) && $file->getClientOriginalName() != "" && $request->input('image_old')){
                    unLink($unLink);
                }

                $file->move($path, $name);
                $data->foto = $name;
            }

            $data->save();

            return redirect("profil");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/profil')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }
    }

    public function getEdit($id){
        $data=["getData"=>WargaModel::find($id)];
        return view('profil.profilEdit',$data);
    }
}