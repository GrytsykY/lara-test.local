<?php

namespace App\Interfaces\Alerts;

interface AlertRepositoryInterface
{
    /**
     * @return array
     */
    public function getAlertAll(): array;

    /**
     * @param $idAlert
     * @return array
     */
    public function getByIdAlert(int $idAlert): array;
}
