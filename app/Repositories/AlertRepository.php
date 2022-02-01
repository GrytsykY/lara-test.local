<?php

namespace App\Repositories;

use App\Interfaces\Alerts\AlertRepositoryInterface;
use DB;


class AlertRepository implements AlertRepositoryInterface
{

    public function getAlertAll(): array
    {
        return DB::table('alerts')->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    public function getByIdAlert(int $idAlert): array
    {
        return DB::table('alerts')->where('id', '=', $idAlert)->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

}
