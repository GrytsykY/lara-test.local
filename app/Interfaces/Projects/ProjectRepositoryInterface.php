<?php

namespace App\Interfaces\Projects;

interface ProjectRepositoryInterface
{
    public function getProjectByIdProject(int $idProject):array;
    public function getProjectAll(): array;
}
