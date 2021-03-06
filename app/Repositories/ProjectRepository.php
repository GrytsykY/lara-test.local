<?php

namespace App\Repositories;


use App\Interfaces\ProjectRepositoryInterface;
use DB;

class ProjectRepository implements ProjectRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
    public function getProjectByIdProject(int $idProject): array
    {
        return DB::table('projects')->where('id', '=', $idProject)->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    /**
     * @return array
     */
    public function getProjectAll(): array
    {
        return DB::table('projects')->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }
}
