<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/3/2016
 * Time: 09:58
 */

namespace App\Http\Controllers;


use App\Models\Belanja\TransaksiModel;
use App\Models\Peta\DetailPetaModel;
use App\Models\Peta\KlasterModel;
use App\Models\Peta\PetaModel;
use App\Models\Role\RoleModel;
use App\Models\Warga\WargaModel;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller{

    public function getIndex(RoleModel $roleModel, WargaModel $wargaModel, PetaModel $petaModel){
        if(Auth::guest()){
            return view('auth.login');
        }else {
            $lokasi = $petaModel->getLokasi();

            $detailpeta = DB::table('detail_peta')
                ->where('id_peta', '=', $lokasi->id_peta)
                ->select('detail_peta.kode_svg', 'detail_peta.warna')
                ->get();

            $role = $roleModel->getRole();

            $colors = [];
            foreach ($detailpeta as $data) {
                $colors[$data->kode_svg] = "'" . $data->warna . "'";
            }

            $data = [
                "users" => $wargaModel->where('id_klaster', '=', Auth::user()->id_klaster)
                    ->whereNotIn('id_role', [1, 2])
                    ->count(),
                "peta" => $lokasi,
                "role" => $role,
                "colors" => json_encode($colors),
                "petaAdmin" => $peta = PetaModel::all()
            ];

            if (Auth::user()->id_role == 1) {
                return view('dashboard.dashboardAdmin',$data);
            } elseif (Auth::user()->id_role == 2) {
                return view('dashboard.dashboardLokasi')->with($data);
            } else {
                return view('dashboard.beranda', $data);
            }
        }
    }

    public function getDetail(){
        $join = DB::table('users_tagihan')->join('tagihan', "tagihan.id_tagihan", '=', 'users_tagihan.id_tagihan')
            ->join('users',"users_tagihan.id",'=','users.id')
            ->where('users_tagihan.id','=',Auth::user()->id)
            ->select('users_tagihan.*','tagihan.*','users.*')
            ->get();

        $satuTagihan = [
            "getJoin" => $join
        ];
        return view("tagihanDetail",$satuTagihan);
    }

    public function getInfo($kode_svg){
        try {
            $detail = new DetailPetaModel();
            $obj = $detail->getDetail($kode_svg);
            if (count($obj) > 0) {
                if ($obj->id_warga > 0) {
                    $user = DB::table('detail_peta')->join('users', "users.id", '=', 'detail_peta.id_warga')
                        ->join('klaster', 'klaster.id_klaster', '=', "users.id_klaster")
                        ->join('role', 'role.id_role', '=', 'users.id_role')
                        ->where('users.id', '=', $obj->id_warga)
                        ->select('detail_peta.*', 'users.*', 'klaster.*', 'role.nama_role')
                        ->first();

                    $status = $user->nama_role;

                    $html =
                        '<div class="widget-user-header bg-red-active flat" >
                            <h3 class="widget-user-username">' . $user->name . '<span class="label label-default pull-right" style="font-size:9pt;">'.$status .'</span></h3>
                            <h6 class="widget-user-desc">' . $user->email . '</h6>
                        </div>
                        <div class="widget-user-image">
                            <img class="img-circle" src=' . asset("dist/img/profil/".$user->foto) . '>
                        </div>
                        <div class="box-footer">
                        <br>
                        <h5 class="center-block"></h5>
                            <div class="row">
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5>Klaster</h5>
                                        <small class="description-header visible-lg visible-sm">' . $user->nama_klaster . '</small>
                                        <small class="description-header visible-md"  data-toggle="tooltip" title="' . $user->nama_klaster. '">' . substr($user->nama_klaster,0,5).'...'. '</small>
                                    </div>
                                </div>
                                <div class="col-sm-4 border-right">
                                    <div class="description-block">
                                        <h5>Blok</h5>
                                        <small class="description-header">A</small>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="description-block">
                                        <h5>Nomor</h5>
                                        <small class="description-header">25</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group" aria-label="...">
                                <a href=' . url('profil/user/' . $user->id) . '>
                                    <button class="btn btn-flat btn-default"><i class="fa fa-user  margin-r-5"></i> Lihat Profil</button>
                                </a>
                            </div>
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="#">
                                    <button class="btn btn-flat btn-default"><i class="fa fa-envelope  margin-r-5"></i> Kirim Pesan</button>
                                </a>
                            </div>
                        </div>';
                    return $html;
                }
                    else{

                        $html =
                            '<div class="small-box bg-green flat" style="min-height: 25%">
                                <div class="inner" style="padding-left: 10%">
                                    <h2 >' . $obj->jenis . '</h2>
                                    <div class="icon" style="margin-right: 20px">';

                        switch($obj->jenis){
                            case "Taman":
                                $html .= '<i class="fa fa-tree" style="margin-top: 50%;"></i>';
                                break;
                            case "Jalan":
                                $html .= '<i class="fa fa-road" style="margin-top: 50%;"></i>';
                                break;
                            case "Lapangan":
                                $html .= '<i class="fa fa-futbol-o" style="margin-top: 50%;"></i>';
                                break;
                            case "Kavling":
                                $html .= '<i class="fa fa-flag-o" style="margin-top: 50%;"></i>';
                                break;
                            case "Pos Satpam":
                                $html .= '<i class="fa fa-shield" style="margin-top: 50%;"></i>';
                                break;
                            case "Tempat Ibadah":
                                $html .= '<i class="fa fa-shield" style="margin-top: 50%;"></i>';
                                break;
                        };
                        $html .= '</div>
                                </div>
                            </div>';
                        return $html;
                    }
                }
            else{
                $html =
                    '<div class="widget-user-header bg-gray-active flat" >'.
                        '<h3 class="widget-user-username"> Peta Belum Diatur</h3>
                        <a href="#" class="pull-right" style="margin-top: 35px">
                            <button class="btn btn-xs btn-danger flat">
                                <i class="fa fa-phone margin-r-5"></i> Laporkan Peta
                            </button>
                        </a>
                    </div>';
                return $html;
            }

        }catch (QueryException  $e){
            \Log::error($e->getMessage());

        }
    }



}