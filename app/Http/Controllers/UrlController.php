<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $urls = Url::all();
        $projects = Project::all();
//        dd($projects);
        return view('urls.index', compact('urls', 'projects'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = new Url;
//        file_put_contents(__DIR__."/STORE.txt", print_r(['data' => date("H:i:s"),'url' => $request], FILE_APPEND));
        $validate = $this->validate($request,[
           'url' => 'required|max:2048',
           'time' => 'required',
           'choice' => 'required',
       ]);

        $url->url = $request->url;
        $url->name = $request->name;
        $url->time = $request->time;
        $url->count_inquiry = 45;//$request->project;
        $url->count_query_url = 23;//$request->count_query_url;
        $url->choice = $request->choice;
        $url->id_user = $request->id_user;

        $url->save();

        return response()->json(['data' => $url, 'validate'=>$validate]);
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

    public function ajaxCheckUrl(Request $request)
    {

        $url = $request->url_check;

//        file_put_contents(__DIR__."/AJAX.txt", print_r(['data' => date("H:i:s"),'url' => $request], FILE_APPEND));
//        $url = 'https://www.olx.ua/';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return response()->json(['status' => $status]);
    }
}
