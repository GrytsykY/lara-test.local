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
}
