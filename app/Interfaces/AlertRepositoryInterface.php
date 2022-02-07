<?php

namespace App\Interfaces;

interface AlertRepositoryInterface
{
    /**
     * @return array
     */
    public function getAlertAll(): array;

    /**
     * @param int $idAlert
     * @return array
     */
    public function getByIdAlert(int $idAlert): array;
}
