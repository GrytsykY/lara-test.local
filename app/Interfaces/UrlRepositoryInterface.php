<?php

namespace App\Interfaces;

use App\Http\Requests\UrlRequest;

interface UrlRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
    public function getUrlByIdProject(int $idProject): array;

    /**
     * @param UrlRequest $request
     * @return array
     */
    public function store(UrlRequest $request): array;

    /**
     * @param int $id
     * @return array
     */
    public function edit(int $id): array;

    /**
     * @param UrlRequest $request
     * @param int $id
     * @return bool
     */
    public function update(UrlRequest $request, int $id): bool;

    /**
     * @param int $id
     * @return array
     */
    public function ajaxUrlShowTable(int $id): array;

    /**
     * @return array
     */
    public function getUrlProjectIdOneAll(): array;

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id): array;

    /**
     * @param string $current
     * @return array
     */
    public function getTimeOutAndLastPing(string $current): array;

    /**
     * @param int $id
     * @param string $current
     */
    public function updatePingNull(int $id, string $current): void;

    /**
     * @param array $url
     * @param string $current
     */
    public function updatePingCounterFieldOneSentAlertOne(array $url, string $current): void;

    /**
     * @param array $url
     * @param string $current
     */
    public function updatePingCounterFieldOne(array $url, string $current): void;

    /**
     * @param string $current
     * @return array
     */
    public function selectLastPingAndOneMinute(string $current): array;

    /**
     * @param string $current
     * @return array
     */
    public function getUrlOutTimeAndLastPingFieldOneSentAlertOne(string $current): array;

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
