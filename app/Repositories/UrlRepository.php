<?php

namespace App\Repositories;


use App\Http\Requests\UrlRequest;
use App\Interfaces\UrlRepositoryInterface;
use App\Models\Url;
use DB;
use Illuminate\Support\Collection;

class UrlRepository implements UrlRepositoryInterface
{
    /**
     * @param UrlRequest $request
     * @return array
     */
    public function store(UrlRequest $request): array
    {
        $url = new Url($request->validated());
        $url->save();
        return $url->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function edit(int $id): array
    {
        return Url::find($id)->toArray();
    }

    /**
     * @param UrlRequest $request
     * @param int $id
     * @return bool
     */
    public function update(UrlRequest $request, int $id):bool
    {
        return Url::find($id)->update($request->all());
    }

    /**
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        $url = Url::find($id);
        $url->delete();
        return $this->urlAll($url);
    }

    /**
     * @param int $id
     * @return array
     */
    public function ajaxUrlShowTable(int $id): array
    {
        return DB::table('urls')->where('id_project', '=', $id)->get()->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();
    }

    /**
     * @param int $idProject
     * @return array
     */
    public function getUrlByIdProject(int $idProject): array
    {
        return DB::table('urls')->where('id_project', '=', $idProject)
            ->whereNull('deleted_at')
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();
    }

    /**
     * @return array
     */
    public function getUrlProjectIdOneAll(): array
    {
        return DB::table('urls')
            ->orderBy('id', 'asc')
            ->where('id_project', '=', 1)
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param string $current
     * @return array
     */
    public function getTimeOutAndLastPing(string $current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 0)
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param int $id
     * @param string $current
     */
    public function updatePingNull(int $id, string $current): void
    {
        \Log::debug($current);
        DB::table('urls')
            ->where('id', '=', $id)
            ->update([
                'is_failed' => 0,
                'ping_counter' => 0,
                'is_sent_alert' => 0,
                'last_ping' => $current
            ]);
    }

    /**
     * @param array $url
     * @param string $current
     */
    public function updatePingCounterFieldOneSentAlertOne(array $url, string $current): void
    {
        DB::table('urls')
            ->where('id', '=', $url['id'])
            ->update([
                'ping_counter' => $url['ping_counter'] + 1,
                'is_failed' => 1,
                'is_sent_alert' => 1,
                'last_ping' => $current
            ]);
    }

    /**
     * @param array $url
     * @param string $current
     */
    public function updatePingCounterFieldOne(array $url, string $current): void
    {
        DB::table('urls')
            ->where('id', '=', $url['id'])
            ->update([
                'ping_counter' => $url['ping_counter'] + 1,
                'is_failed' => 1,
                'last_ping' => $current
            ]);
    }

    /**
     * @param string $current
     * @return array
     */
    public function selectLastPingAndOneMinute(string $current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL 1 MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 0)
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param string $current
     * @return array
     */
    public function getUrlOutTimeAndLastPingFieldOneSentAlertOne(string $current): array
    {
        return DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 1)
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @param Url $url
     * @return array
     */
    protected function urlAll(Url $url): array
    {
        return DB::table('urls')
            ->where('id_project', '=', $url->id_project)
            ->get()
            ->whereNull('deleted_at')
            ->map(function ($obj) {
                return get_object_vars($obj);
            })->toArray();
    }

    /**
     * @return array
     */
    public function basket(): array
    {
        return $this->softDelShow();
    }

    /**
     * @param int $id
     */
    public function restore(int $id): void
    {
        $url = Url::withTrashed()->find($id);
        $url->restore();
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteTrash(int $id): array
    {
        Url::withTrashed()->where('id', $id)->forceDelete();
        return $this->softDelShow();
    }

    /**
     * @return array
     */
    protected function softDelShow(): array
    {
        return DB::table('urls')
            ->where('deleted_at', '!=', 'null')
            ->get()
            ->map(function ($obj) {
            return get_object_vars($obj);
        })->toArray();
    }
}
