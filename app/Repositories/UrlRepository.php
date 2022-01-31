<?php

namespace App\Repositories;


use App\Interfaces\UrlRepositoryInterface;
use App\Models\Alert;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UrlRepository implements UrlRepositoryInterface
{


    public function userProjectAll(): array
    {
        $user = \Auth::user();
//dd($user);
        if ($user->role == 0) {
            $urls = DB::table('urls')->where('id_project', '=', $user->id_project)->get();
            $projects = DB::table('projects')->where('id', '=', $user->id_project)->get();
            $urls_proj = ['urls' => $urls, 'project' => $projects];
            return $urls_proj;
        } else {
            $urls = DB::table('urls')
                ->orderBy('id_project', 'asc')
                ->where('id_project', '=', 1)
                ->get();
            $projects = Project::all();

            $urls_proj = ['urls' => $urls, 'project' => $projects];
            return $urls_proj;
        }
    }

    public function edit()
    {
        $user = \Auth::user();

        if ($user->role == 0) {
            $projects = DB::table('projects')->where('id', '=', $user->id_project)->get();
        } else {
            $projects = Project::all();
        }

        return $projects;
    }

    public function deleteUrl($url): \Illuminate\Support\Collection
    {
        $urls = DB::table('urls')
            ->where('id_project', '=', $url->id_project)
            ->get();

        return $urls;
    }

    public function ajaxUrlProdForm($id): \Illuminate\Support\Collection
    {
        $urls = DB::table('urls')->where('id_project', '=', $id)->get();

        return $urls;
    }

    public function updatePingNull($id)
    {
        DB::table('urls')
            ->where('id', '=', $id)
            ->update([
                'is_failed' => 0,
                'ping_counter' => 0,
                'is_sent_alert' => 0,
                'last_ping' => $this->dateNow()
            ]);
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

    public function selectUrlOutTimeAndLastPingFieldOneSentAlertOne(): \Illuminate\Support\Collection
    {
        $current = $this->dateNow();
        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 1)
            ->get();
        return $urls;
    }


    public function selectAlertId($url): \Illuminate\Support\Collection
    {
        $alert = DB::table('alerts')->where('id', '=', $url->id_alert)->get();
        return $alert;
    }

    public function selectProjectId($url): \Illuminate\Support\Collection
    {
        $project = DB::table('projects')->where('id', '=', $url->id_project)->get();
        return $project;
    }

    public function updatePingCounterFieldOneSentAlertOne($url)
    {
        DB::table('urls')
            ->where('id', '=', $url->id)
            ->update([
                'ping_counter' => $url->ping_counter + 1,
                'is_failed' => 1,
                'is_sent_alert' => 1,
                'last_ping' => $this->dateNow()
            ]);
    }

    public function updatePingCounterFieldOne($url)
    {
        DB::table('urls')
            ->where('id', '=', $url->id)
            ->update([
                'ping_counter' => $url->ping_counter + 1,
                'is_failed' => 1,
                'last_ping' => $this->dateNow()
            ]);
    }

   public function selectLastPingAndOneMinute(): \Illuminate\Support\Collection
   {
       $current = $this->dateNow();
       $urls = DB::table("urls")
           ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL 1 MINUTE)")
           ->where('is_failed', '=', 1)
           ->where('is_sent_alert', '=', 0)
           ->get();
       return $urls;
   }

    protected function dateNow(): Carbon
    {
        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');
        return $current;
    }

    public function getUrlByIdProject(int $idProject): array
    {
        return DB::table('urls')->where('id_project', '=', $idProject)->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    public function getProjectByIdProject(int $idProject):array
    {
        return DB::table('projects')->where('id', '=', $idProject)->get()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    public function getAlertAll(): array
    {
        return Alert::all()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }

    public function getProjectAll(): array
    {
        return DB::table('urls')
            ->orderBy('id_project', 'asc')
            ->where('id_project', '=', 1)
            ->get()->map(function ($obj){
                return get_object_vars($obj);
            })->toArray();
    }

    public function getUrlProjectIdOneAll(): array
    {
        return Project::all()->map(function ($obj){
            return get_object_vars($obj);
        })->toArray();
    }
}
