<?php
/**
 * Created by PhpStorm.
 * User: Sekar Tyas Iswari
 * Date: 11-Feb-16
 * Time: 04:05 PM
 */

namespace App\Http\Controllers\Peta;


use App\Models\Peta\PetaModel;
use Illuminate\Routing\Controller;

class PetaAdminController extends Controller
{

    public function getIndex(){

        $data = [
          "peta" => $peta = PetaModel::all()
        ];
        return view('peta.petaAdmin',$data);
    }




}