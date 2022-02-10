<?php

namespace App\Interfaces;


interface PingRepositoryInterface
{
    /**
     * @param string $title
     * @return array
     */
    public function start(string $title): array;

    /**
     * @param string $title
     * @param bool $flag
     * @return bool
     */
    public function startUpdate(string $title, bool $flag): bool;


}
