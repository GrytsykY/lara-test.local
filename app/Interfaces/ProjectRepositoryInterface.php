<?php

namespace App\Interfaces;

interface ProjectRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
    public function getProjectByIdProject(int $idProject):array;

    /**
     * @return array
     */
    public function getProjectAll(): array;
}
