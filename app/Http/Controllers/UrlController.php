<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Models\Alert;
use App\Models\Url;
use App\Models\User;
use App\Services\UrlService;
use Illuminate\Http\Request;



class UrlController extends Controller
{
    private $urlService;


    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
         $urls = $this->urlService->initialData();

        return view('urls.index', ['urls'=>$urls['urls'],'projects'=>$urls['projects'],'alerts'=>$urls['alerts']]);
//        return view('urls.index', compact('urls','projects','alerts'));

//       $urls = $this->urlRepository->userProjectAll();
//
//        $projects = $urls['project'];
//        $urls = $urls['urls'];
//        $alerts = Alert::all();
//
//        return view('urls.index', compact('urls', 'projects', 'alerts'));
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
        $projects = $this->urlRepository->edit();
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

        $urls = $this->urlRepository->deleteUrl($url);

        return view('ajax.ajaxUrlShow', compact('urls'))->render();

    }

    /**
     * @param $id
     * @return string
     */
    protected function ajaxUrlProdForm(Request $request, $id): string
    {

        $urls = $this->urlRepository->ajaxUrlProdForm($id);

        if ($request->ajax()) {
            return view('ajax.ajaxUrlShow', compact('urls'))->render();
        }
    }


    public function ajaxCheckUrl(Request $request): \Illuminate\Http\JsonResponse
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



    public function ping1()
    {
       $this->urlService->ping1();
    }

    public function ping2()
    {
        $this->urlService->ping2();
    }

    public function ping3()
    {
        $this->urlService->ping3();
    }

}
//https://habr.com/ru/post/350778/
