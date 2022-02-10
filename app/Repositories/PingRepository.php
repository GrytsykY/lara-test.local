<?php

namespace App\Repositories;

use App\Interfaces\PingRepositoryInterface;
use DB;

class PingRepository implements PingRepositoryInterface
{
    /**
     * @param string $title
     * @return array
     */
    public function start(string $title): array
    {
        return DB::table('employments')
            ->where('title','=', $title)
            ->get()
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param string $title
     * @param bool $flag
     * @return bool
     */
    public function startUpdate(string $title, bool $flag): bool
    {
        return DB::table('employments')->where('title', '=', $title)->update(['flag' => $flag]);
    }

}
