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
     * @param int $idProject
     * @return array
     */
   public function getProjectByIdProject(int $idProject):array;

    /**
     * @return array
     */
   public function getAlertAll():array;

    /**
     * @return array
     */
   public function getProjectAll():array;

    /**
     * @return array
     */
   public function getUrlProjectIdOneAll():array;

}
