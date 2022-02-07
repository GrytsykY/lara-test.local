<?php

namespace App\Repositories;

use App\Interfaces\AlertRepositoryInterface;
use DB;


class AlertRepository implements AlertRepositoryInterface
{
    /**
     * @return array
     */
    public function getAlertAll(): array
    {
        return DB::table('alerts')->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    /**
     * @param int $idAlert
     * @return array
     */
    public function getByIdAlert(int $idAlert): array
    {
        return DB::table('alerts')->where('id', '=', $idAlert)->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

}
