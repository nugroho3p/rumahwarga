<?php
/**
 * Created by PhpStorm.
 * User: Nugroho Tri Pambudi
 * Date: 2/3/2016
 * Time: 12:38
 */
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DashboardModel extends Model{
    public function getData(){
        return $this->all();
    }

    public function getDatasearch($search="")
    {
        $data = $this->where("nama_depan","LIKE","%".$search."%")->get();
        return $data;
    }
}