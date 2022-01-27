<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Models\Alert;
use App\Models\Project;
use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {

        $user = \Auth::user();

        if ($user->role == 0) {
            $urls = DB::table('urls')->where('id_project', '=', $user->id_project)->get();
            $projects = DB::table('projects')->where('id', '=', $user->id_project)->get();
        } else {
            $urls = DB::table('urls')
                ->orderBy('id_project', 'asc')
                ->where('id_project', '=', 1)
                ->get();
            $projects = Project::all();
        }
//        dd($urls);
        $alerts = Alert::all();

        return view('urls.index', compact('urls', 'projects', 'alerts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(UrlRequest $request): \Illuminate\Http\JsonResponse
    {
        $url = new Url($request->validated());
        $url->save();
        return response()->json(['data' => $url]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return string
     */
    public function edit($id): string
    {
        $user = \Auth::user();

        if ($user->role == 0) {
            $projects = DB::table('projects')->where('id', '=', $user->id_project)->get();
        } else {
            $projects = Project::all();
        }
        $urls = Url::find($id);
        $alerts = Alert::all();

        return view('urls.edit', compact('urls', 'projects', 'alerts'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UrlRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $urls = Url::find($id);
        $urls->update($request->all());

        return redirect()->route('url.edit', $id)->with('success', 'Успешно обновлено.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return string
     */
    public function destroy($id): string
    {

        $url = Url::find($id);
        if ($url) $url->delete();

        $urls = DB::table('urls')
            ->where('id_project', '=', $url->id_project)
            ->get();

        return view('ajax.ajaxUrlShow', compact('urls'))->render();

    }

    /**
     * @param $id
     * @return string
     */
    protected function ajaxUrlProdForm(Request $request, $id)
    {

        $urls = DB::table('urls')->where('id_project', '=', $id)->get();

        if ($request->ajax()) {
            return view('ajax.ajaxUrlShow', compact('urls'))->render();
        }
    }


    public function curl($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        return $status;
    }

    public function ajaxCheckUrl(Request $request)
    {
        $urls = Url::all();
        $users = User::all();

        $url = $request->url_check;

        $status = $this->curl($url);

//        $message = [];
//        foreach ($urls as $value) {
//            foreach ($users as $user) {
//                if ($user->id == $value->id_user) {
//                    if ($status == $value->status_code) {
//
//                        $message[] = [
//                            'success ' => 'Success',
//                            'user_name' => $user->name,
//                            'id_user' => $user->id,
//                            'url' => $value->url,
//                            'code' => $value->status_code,
//                        ];
//                    } else {
//                        $message[] = [
//                            'success ' => 'Error',
//                            'user_name' => $user->name,
//                            'id_user' => $user->id,
//                            'url' => $value->url,
//                            'code' => $value->status_code,
//                        ];
//                    }
//                }
//            }
//        }

        return response()->json(['status' => $status]);
    }

    public function updatePingNull($id, $current)
    {
         DB::table('urls')
            ->where('id', '=', $id)
            ->update([
                'is_failed' => 0,
                'ping_counter' => 0,
                'is_sent_alert' => 0,
                'last_ping' => $current
            ]);
    }

    public function ping1()
    {

        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');

        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', false)
            ->get();

//        $count_ping = DB::table('urls')->pluck('max_count_ping');
        dump($urls);
        foreach ($urls as $url) {

            $status = $this->curl($url->url);
            dump($url->url . ' ' . $status);
            if ($status == $url->status_code) {
                // отправляем сообщение

                $this->updatePingNull($url->id, $current);

            } else {

                if ($url->max_count_ping == 1) {
                    $status = $this->curl($url->url);


                    if ($status == $url->status_code) {

                        $this->updatePingNull($url->id, $current);
                    } else {

                        $alert = DB::table('alerts')->where('id', '=', $url->id_alert)->get();
                        $project = DB::table('projects')->where('id', '=', $url->id_project)->get();

                        if ($project)
                            $this->tel_curl($project[0]->chat_id, $url->name . ' ' . $alert[0]->name .
                                ' ' . $alert[0]->description);

                        DB::table('urls')
                            ->where('id', '=', $url->id)
                            ->update([
                                'ping_counter' => $url->ping_counter + 1,
                                'is_failed' => 1,
                                'is_sent_alert' => 1,
                                'last_ping' => $current
                            ]);
                    }
                } else {

                    if ($url->max_count_ping == $url->ping_counter) {
                        dump(' alert');
                    }

                    DB::table('urls')
                        ->where('id', '=', $url->id)
                        ->update([
                            'ping_counter' => $url->ping_counter + 1,
                            'is_failed' => 1,
                            'last_ping' => $current
                        ]);
                }
            }

        }


    }

    public function ping2()
    {

        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');

        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL 1 MINUTE)")
            ->where('is_failed', '=', true)
            ->where('is_sent_alert', '=', false)
            ->get();


//        $count_ping = DB::table('urls')->pluck('max_count_ping');


        foreach ($urls as $url) {

            $status = $this->curl($url->url);
            dump($status);
            if ($status == $url->status_code) {
                // отправляем сообщение

                $this->updatePingNull($url->id, $current);

            } else {

                if ($url->max_count_ping >= 1) {
                    $status = $this->curl($url->url);


                    if ($status == $url->status_code) {

                        $project = DB::table('projects')->where('id', '=', $url->id_project)->get();
                        if ($project)
                            $this->tel_curl($project[0]->chat_id, 'Сайт работает');

                        $this->updatePingNull($url->id, $current);

                    } else {

                        DB::table('urls')
                            ->where('id', '=', $url->id)
                            ->update([
                                'ping_counter' => $url->ping_counter + 1,
                                'is_failed' => 1,
                                'last_ping' => $current
                            ]);


                        if ($url->max_count_ping == $url->ping_counter + 1) {
                            $alert = DB::table('alerts')->where('id', '=', $url->id_alert)->get();
                            $project = DB::table('projects')->where('id', '=', $url->id_project)->get();
                            if ($project)
                                $this->tel_curl($project[0]->chat_id, $url->name . ' ' . $alert[0]->name .
                                    ' ' . $alert[0]->description);

                            DB::table('urls')
                                ->where('id', '=', $url->id)
                                ->update([
                                    'is_failed' => 1,
                                    'is_sent_alert' => 1,
                                    'last_ping' => $current
                                ]);
                        }
                    }
                }
            }

        }

        dump($urls);
    }

    public function ping3()
    {
        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');

        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->where('is_failed', '=', 1)
            ->where('is_sent_alert', '=', 1)
            ->get();
        dump($urls);
        foreach ($urls as $url) {

            $status = $this->curl($url->url);

            if ($status == $url->status_code) {
                $project = DB::table('projects')->where('id', '=', $url->id_project)->get();
                if ($project)
                    $this->tel_curl($project[0]->chat_id, 'Сайт работает');

                $this->updatePingNull($url->id, $current);

            }


        }

        dump($urls);
    }

    public function tel_curl($id, $message)
    {
        $botToken = '5243206235:AAEsYTDkugFDDt6pGq8iw1CeivhNwVRP3ck';
        $website = "https://api.telegram.org/bot" . $botToken;
        $params = [
            'chat_id' => $id,
            'text' => $message,
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
//https://habr.com/ru/post/350778/
