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
    private UrlService $urlService;


    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('urls.index', ['urls' => $this->urlService->initialData()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(UrlRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => $this->urlService->storeUrl($request)]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return string
     */
    public function edit($id): string
    {
        return view('urls.edit', ['urls' => $this->urlService->editUrl($id)])->render();
    }

    /**
     * @param UrlRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UrlRequest $request, $id): \Illuminate\Http\RedirectResponse
    {
        $this->urlService->updateUrl($request, $id);

        return redirect()->route('url.edit', $id)->with('success', 'Успешно обновлено.');
    }

    /**
     * @param $id
     * @return string
     */
    public function destroy($id): string
    {
        return view('ajax.ajaxUrlShow', ['urls' => $this->urlService->deleteUrl($id)])->render();
    }

    /**
     * @param Request $request
     * @param $id
     * @return string|void
     */
    protected function ajaxUrlProdForm(Request $request, $id)
    {
        $urls = $this->urlService->ajaxCheckUrl($id);

        if ($request->ajax()) {
            return view('ajax.ajaxUrlShow', compact('urls'))->render();
        }
    }


    public function ajaxCheckUrl(Request $request): \Illuminate\Http\JsonResponse
    {
        $status = $this->urlService->curl($request->url_check);

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
