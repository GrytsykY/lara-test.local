<?php

namespace App\Interfaces;

use App\Http\Requests\UrlRequest;
use Carbon\Carbon;

interface UrlRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
    public function getUrlByIdProject(int $idProject): array;

    /**
     * @param array $request
     * @return array
     */
    public function store(array $request): array;

    /**
     * @param int $id
     * @return array
     */
    public function edit(int $id): array;

    /**
     * @param array $request
     * @param int $id
     * @return bool
     */
    public function update(array $request, int $id): bool;

    /**
     * @param int $id
     * @return array
     */
    public function ajaxUrlShowTable(int $id): array;
    
    /**
     * @param int $id
     */
    public function delete(int $id): void;

    /**
     * @param Carbon $current
     * @return array
     */
    public function getTimeOutAndLastPing(Carbon $current): array;

    /**
     * @param int $id
     * @param Carbon $current
     */
    public function updatePingNull(int $id, Carbon  $current): void;

    /**
     * @param array $url
     * @param Carbon $current
     */
    public function updatePingCounterFieldOneSentAlertOne(array $url, Carbon  $current): void;

    /**
     * @param array $url
     * @param Carbon $current
     */
    public function updatePingCounterFieldOne(array $url, Carbon  $current): void;

    /**
     * @param Carbon $current
     * @return array
     */
    public function selectLastPingAndOneMinute(Carbon  $current): array;

    /**
     * @param Carbon $current
     * @return array
     */
    public function getUrlOutTimeAndLastPingFieldOneSentAlertOne(Carbon  $current): array;

    /**
     * @return array
     */
    public function basket(): array;

    /**
     * @param int $id
     */
    public function restore(int $id):void;

    /**
     * @param int $id
     * @return array
     */
    public function deleteTrash(int $id): array;


}
