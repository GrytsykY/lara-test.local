<?php

namespace App\Repositories;

use App\Http\Requests\PingRequest;
use App\Interfaces\PingRepositoryInterface;
use App\Models\Ping;
use DB;

class PingRepository implements PingRepositoryInterface
{
    /**
     * @return array
     */
    public function start(): array
    {
        return DB::table('pings')
            ->get()
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param string $column
     * @return bool
     */
    public function startUpdate(string $column): bool
    {
        return DB::table('pings')->where('id', '=', 1)->update([$column => 1]);
    }

    /**
     * @param string $column
     * @return bool
     */
    public function stopUpdate(string $column): bool
    {
        return DB::table('pings')->where('id', '=', 1)->update([$column => 0]);
    }
}
