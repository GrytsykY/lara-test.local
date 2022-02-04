<?php

namespace App\Interfaces;

interface UrlRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
   public function getUrlByIdProject(int $idProject):array;

    /**
     * @param object $request
     * @return array
     */
    public function store(object $request):array;

    /**
     * @param int $id
     * @return array
     */
    public function edit(int $id):array;

    /**
     * @param object $request
     * @param int $id
     * @return mixed
     */
    public function update(object $request, int $id): mixed;

    /**
     * @param int $id
     * @return array
     */
    public function ajaxUrlShowTable(int $id):array;

    /**
     * @return array
     */
    public function getUrlProjectIdOneAll(): array;

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id):array;

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
     * @param $url
     * @param $current
     */
    public function updatePingCounterFieldOneSentAlertOne($url, $current): void;

    /**
     * @param $url
     * @param $current
     */
    public function updatePingCounterFieldOne($url, $current): void;

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

    /**
     * @return array
     */
    public function basket(): array;

    /**
     * @param int $id
     */
    public function restore(int $id);

    /**
     * @param int $id
     * @return array
     */
    public function deleteTrash(int $id): array;
}
