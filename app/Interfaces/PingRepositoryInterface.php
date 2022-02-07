<?php

namespace App\Interfaces;


interface PingRepositoryInterface
{
    /**
     * @param int $id
     * @return array
     */
    public function start(int $id): array;

    /**
     * @param int $id
     * @param bool $flag
     * @return bool
     */
    public function startUpdate(int $id, bool $flag): bool;


}
