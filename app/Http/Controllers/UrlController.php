<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Project;
use App\Models\Url;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $urls = Url::all();
        $projects = Project::all();
        $alerts = Alert::all();

        return view('urls.index', compact('urls', 'projects', 'alerts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|max:2048',
            'name' => 'required|string|min:3',
            'time_out' => 'required|integer|max:60',
            'max_count_ping' => 'required|integer',
            'status_code' => 'required|integer|min:200|max:500',
            'id_alert' => 'required|integer|exists:alerts,id',
            'id_user' => 'required|integer|exists:users,id',
            'id_project' => 'required|integer|exists:projects,id',
        ]);
        if (!$validator->passes()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }
        $url = new Url($validator->validated());
        $url->save();
        return response()->json(['data' => $url]);
//        return redirect()->route('url.index')->with('success','Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Url $urls
     * @return \Illuminate\Http\Response
     */
    public function show(Url $urls)
    {
        dd("r34545");
//        return view('urls.show',compact('urls'));
//        return redirect('index', $urls);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Url $urls
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $urls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Url $urls
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $urls)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Url $urls
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $urls)
    {
        //
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


        $message = [];
        foreach ($urls as $value) {
            foreach ($users as $user) {
                if ($user->id == $value->id_user) {
                    if ($status == $value->status_code) {

                        $message[] = [
                            'success ' => 'Success',
                            'user_name' => $user->name,
                            'id_user' => $user->id,
                            'url' => $value->url,
                            'code' => $value->status_code,
                        ];
                    } else {
                        $message[] = [
                            'success ' => 'Success',
                            'user_name' => $user->name,
                            'id_user' => $user->id,
                            'url' => $value->url,
                            'code' => $value->status_code,
                        ];
                    }
                }
            }
        }

        return response()->json(['status' => $status, 'message' => $message]);
    }

    public function ping1()
    {

        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');

        $urls = DB::table("urls")
            ->whereRaw("'$current.'>=DATE_ADD(urls.last_ping,INTERVAL urls.time_out MINUTE)")
            ->get();

        foreach ($urls as $url) {
            $update = DB::table('urls')
                ->where('id', '=',$url->id)
                ->update([
                    'last_ping' => $current
                ]);

        }
//        dump($update);
        dump($urls);

//        $update =  $this->update();


    }
}
