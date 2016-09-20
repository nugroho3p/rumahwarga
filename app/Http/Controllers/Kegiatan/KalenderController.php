<?php
/**
 * Created by PhpStorm.
 * User: rizkadwiu
 * Date: 2/5/2016
 * Time: 11:09 AM
 */

namespace App\Http\Controllers\Kegiatan;



use App\Models\Kalender\KegiatanModel;
use App\Models\Kalender\Users_KegiatanModel;
use App\Models\Kalender\UsersKegiatan;
use App\Models\Peta\KlasterModel;
use App\Models\Warga\WargaModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class KalenderController extends Controller
{
    public function getIndex()
    {
        $dataWarga = WargaModel::all();
        //$dataEvent = DB::table('kegiatan')
            //->join('users','users.id','=','kegiatan.id')
            //->where('kegiatan.id','=',Auth::user()->id)
            //->select('kegiatan.*','users.*')
          //  ->get();
        $dataKlas = KlasterModel::where('id_klaster','=',Auth::user()->id_klaster)->first();

        $kegiatan = [
            "getDataWarga" => $dataWarga,
            //"getDataEvent" => $dataEvent,
            "klaster" => $dataKlas
        ];
        return view("kegiatan.kalender",$kegiatan);

    }

    public function postSubmit(Request $request){
        try{
            $kegiatan = new KegiatanModel();

            $kegiatan->title = $request->input("title");
            $kegiatan->start = $request->input("start");
            $kegiatan->end = $request->input("end");
            $kegiatan->description = $request->input("description");
            $kegiatan->id_pembuat = Auth::user()->id;
            $kegiatan->created_by = Auth::user()->id;
            $kegiatan->updated_by = Auth::user()->id;

            $kegiatan->save();

            $id = $request->input("id");
            $count = count($id);

            foreach ($id as $row){
                $user = new Users_KegiatanModel();

                $user->id = $row;
                $user->created_by = Auth::user()->id;
                $user->updated_by = Auth::user()->id;
                $kegiatan->Users_Kegiatan()->save($user);
            }

            \Session::flash('flash_message','Event Berhasil Ditambahkan.');
            return redirect("kalender");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function postSubmitEdit(Request $request){
        try{
                if($request->input("id_kegiatan")!=null){
                    $data=KegiatanModel::findOrNew($request->input("id_kegiatan"));
                }else{
                    $data=new KegiatanModel();
                }

                $data->title = $request->input("title");
                $data->start = $request->input("start");
                $data->end = $request->input("end");
                $data->waktu_mulai=$request->input("waktu_mulai");
                $data->waktu_selesai=$request->input("waktu_selesai");
                $data->description = $request->input("description");
                $data->pemilik_acara = Auth::user()->name;
                $data->id = $request->input("id");
                $data->created_by = Auth::user()->id;
                $data->updated_by = Auth::user()->id;

                $data->save();

            \Session::flash('flash_message','Event Berhasil Ditambahkan.');
            return redirect("kalender");
        }
        catch (QueryException $e){
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors(['Gagal menyimpan. Coba ulangi']);
        }

    }

    public function getAdd(WargaModel $wargaModel){

        $dataWarga = $wargaModel->whereNotIn("id",[Auth::user()->id])->get();

        $kegiatan = [
            "getDataWarga" => $dataWarga
        ];
        return view("kegiatan.kegiatanAdd",$kegiatan);
    }

    public function getEdit($id_kegiatan){

        $data = [
            "getData" => KegiatanModel::find($id_kegiatan),
            "getDataWarga" => $dataWarga = WargaModel::all()
        ];

        return view("kalender.kegiatanEdit",$data);
    }

    /*public function getDelete($id_kegiatan)
    {
        try {
           /* $kegiatan = KegiatanModel::where('id_kegiatan','=',$id_kegiatan)
            ->delete();
            //print_r($id_kegiatan);
                //$kegiatan->delete();

                \Session::flash('flash_message','Data Berhasil Dihapus.');
                return redirect('/kalender');
        } catch (QueryException  $e) {
            Log::error($e->getMessage());
            return redirect('/kalender')->withErrors([
                'telah terjadi suatu kesalahan, coba lagi nanti'
            ]);
        }
    } */

    public function getHapus($id_kegiatan){
        $kegiatan = DB::table('kegiatan')->where('id_kegiatan','=',$id_kegiatan)->get();
        $kegiatan->delete();
        return redirect('kalender');
    }

    public function getEvent(){
        try {
            $pembuat = DB::table('kegiatan')
                ->join('users','users.id','=','kegiatan.id_pembuat')
                ->Where('kegiatan.id_pembuat','=',Auth::user()->id)
                ->select('kegiatan.*','users.name')
                ->get();

            $warga = DB::table('users_kegiatan')
                ->join('kegiatan','kegiatan.id_kegiatan','=','users_kegiatan.id_kegiatan')
                ->where('users_kegiatan.id','=',Auth::user()->id)
                ->select('kegiatan.*')
                ->get();


            $event = array_merge($pembuat , $warga);

            //print_r($event); exit;
            return Response::json($event);
        }catch (QueryException $e){
            \Log::error($e->getMessage());
            return redirect('/kalender');
        }
    }
}