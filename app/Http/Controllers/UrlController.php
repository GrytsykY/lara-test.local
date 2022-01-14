<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

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
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = new Url;

        $url->url = $request->url;
        $url->time = $request->time;
        $url->count_inquiry = 45;//$request->count_inquiry;
        $url->count_query_url = 23;$request->count_query_url;
        $url->choice = $request->choice;
        $url->id_user = 1;

        $url->save();

        return response()->json(['success'=>'Form is successfully submitted!']);
//        return redirect()->route('url.index')->with('success','Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Url  $urls
     * @return \Illuminate\Http\Response
     */
    public function show(Url $urls)
    {
//        return view('urls.show',compact('urls'));
        return redirect('index', $urls);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Url  $urls
     * @return \Illuminate\Http\Response
     */
    public function edit(Url $urls)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Url  $urls
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Url $urls)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Url  $urls
     * @return \Illuminate\Http\Response
     */
    public function destroy(Url $urls)
    {
        //
    }
}
