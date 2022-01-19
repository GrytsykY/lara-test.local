<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){

////        $user = new User();
//        $users = User::all();
//        $projects = Project::all();
//
////        $this->authorize('index',$projects);
//
////        dd($user);
//        return view('test', compact('users','projects'));
        $projects=Project::select('id')->get()->toArray();
//        dump($projects, $projects[rand(0,count($projects)-1)]);
    }

    public function ajaxCheckUrl(Request $request)
    {
        $url = $request->url_check;

        file_put_contents(__DIR__."/AJAX.txt", print_r(['data' => date("H:i:s"),'url' => $request], FILE_APPEND));

//        return view('urls.index');
//        return response()->json(['urls' => $url]);
    }


    public function tr(){
        dd("sdf");
}


}
