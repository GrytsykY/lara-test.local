<?php

namespace App\Repositories;

use App\Interfaces\Pings\PingRepositoryInterface;
use DB;

class PingRepository implements PingRepositoryInterface
{

    public function getTimeOutAndLastPing($current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 0)
            ->get()->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    public function updatePingNull($id, $current): void
    {
        DB::table('urls')
            ->where('id', '=', $id)
            ->update([
                'is_failed' => 0,
                'ping_counter' => 0,
                'is_sent_alert' => 0,
                'last_ping' => $current
            ]);
    }

    public function updatePingCounterFieldOneSentAlertOne($url, $current): void
    {
        DB::table('urls')
            ->where('id', '=', $url['id'])
            ->update([
                'ping_counter' => $url['ping_counter'] + 1,
                'is_failed' => 1,
                'is_sent_alert' => 1,
                'last_ping' => $current
            ]);
    }

    public function updatePingCounterFieldOne($url, $current): void
    {
        DB::table('urls')
            ->where('id', '=', $url['id'])
            ->update([
                'ping_counter' => $url['ping_counter'] + 1,
                'is_failed' => 1,
                'last_ping' => $current
            ]);
    }

    public function selectLastPingAndOneMinute($current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL 1 MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 0)
            ->get()->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    public function getUrlOutTimeAndLastPingFieldOneSentAlertOne($current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 1)
            ->get()->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }
}
