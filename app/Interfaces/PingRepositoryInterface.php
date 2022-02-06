<?php

namespace App\Interfaces;


interface PingRepositoryInterface
{
    /**
     * @return array
     */
    public function start(): array;

    /**
     * @param string $column
     * @return bool
     */
    public function startUpdate(string $column): bool;

    /**
     * @param string $column
     * @return bool
     */
    public function stopUpdate(string $column): bool;

}
