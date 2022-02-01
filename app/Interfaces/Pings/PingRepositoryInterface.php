<?php

namespace App\Interfaces\Pings;

interface PingRepositoryInterface
{
    /**
     * @param $current
     * @return array
     */
    public function getTimeOutAndLastPing($current):array;

    /**
     * @param $id
     * @param $current
     */
    public function updatePingNull($id, $current): void;

    /**
     * @param $id
     * @param $current
     */
    public function updatePingCounterFieldOneSentAlertOne($id, $current): void;

    /**
     * @param $id
     * @param $current
     */
    public function updatePingCounterFieldOne($id, $current): void;

    /**
     * @param $current
     * @return array
     */
    public function selectLastPingAndOneMinute($current): array;

    /**
     * @param $current
     * @return array
     */
    public function getUrlOutTimeAndLastPingFieldOneSentAlertOne($current): array;
}
