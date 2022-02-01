<?php

namespace App\Interfaces\Urls;

interface UrlRepositoryInterface
{
    /**
     * @param int $idProject
     * @return array
     */
   public function getUrlByIdProject(int $idProject):array;

    /**
     * @param $request
     * @return array
     */
    public function store($request):array;

    /**
     * @param $id
     * @return array
     */
    public function edit($id):array;

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id): mixed;

    /**
     * @param $id
     * @return array
     */
    public function ajaxUrlShowTable($id):array;

    /**
     * @return array
     */
    public function getUrlProjectIdOneAll(): array;

    /**
     * @param $url
     * @return array
     */
    public function delete($url):array;
}
