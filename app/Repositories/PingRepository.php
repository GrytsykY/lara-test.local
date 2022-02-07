<?php

namespace App\Repositories;

use App\Http\Requests\PingRequest;
use App\Interfaces\PingRepositoryInterface;
use App\Models\Ping;
use DB;

class PingRepository implements PingRepositoryInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function start(int $id): array
    {
        return DB::table('pings')
            ->where('id','=', $id)
            ->get()
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param int $id
     * @param bool $flag
     * @return bool
     */
    public function startUpdate(int $id, bool $flag): bool
    {
        return DB::table('pings')->where('id', '=', $id)->update(['flag' => $flag]);
    }

}
