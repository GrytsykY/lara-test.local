<?php

namespace App\Repositories;


use App\Interfaces\Urls\UrlRepositoryInterface;
use App\Models\Url;
use Carbon\Carbon;
use DB;

class UrlRepository implements UrlRepositoryInterface
{

    public function store($request): array
    {
        $url = new Url($request->validated());
        $url->save();
        return $url->toArray();
    }

    public function edit($id): array
    {
        return Url::find($id)->toArray();
    }

    public function update($request, $id): mixed
    {
        return Url::find($id)
            ->update($request->all());
    }

    public function delete($id): array
    {
        $url = Url::find($id);
        $url->delete();
        return DB::table('urls')
            ->where('id_project', '=', $url->id_project)
            ->get()->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    public function ajaxUrlShowTable($id): array
    {
        $urls = DB::table('urls')->where('id_project', '=', $id)->get()->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();;

        return $urls;
    }


    public function selectUrlOutTimeAndLastPing(): \Illuminate\Support\Collection
    {
        $current = $this->dateNow();
        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', false)
            ->get();
        return $urls;
    }

    public function getUrlByIdProject(int $idProject): array
    {
        return DB::table('urls')->where('id_project', '=', $idProject)->get()->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();
    }


    public function getUrlProjectIdOneAll(): array
    {
        return DB::table('urls')
            ->orderBy('id', 'asc')
            ->where('id_project', '=', 1)
            ->get()->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }
}
