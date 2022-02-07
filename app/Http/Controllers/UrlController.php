<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Services\UrlService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UrlController extends Controller
{
    private UrlService $urlService;

    /**
     * @param UrlService $urlService
     */
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
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
     * @param int
     * @return string
     */
    public function edit(int $id): string
    {
        return view('urls.edit', ['urls' => $this->urlService->editUrl($id)])->render();
    }

    /**
     * @param UrlRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UrlRequest $request, int $id): RedirectResponse
    {
        $this->urlService->updateUrl($request, $id);

        return redirect()->route('url.edit', $id)->with('success', 'Successfully updated.');
    }

    /**
     * @param int $id
     * @return string
     */
    public function destroy(int $id): string
    {
        return view('ajax.ajaxUrlShow', ['urls' => $this->urlService->deleteUrl($id)])->render();
    }

    /**
     * @param Request $request
     * @param int $id
     * @return string|void
     */
    protected function ajaxUrlProdForm(Request $request, int $id)
    {
        $urls = $this->urlService->ajaxCheckUrl($id);

        if ($request->ajax()) {
            return view('ajax.ajaxUrlShow', compact('urls'))->render();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxCheckUrl(Request $request): \Illuminate\Http\JsonResponse
    {
        $status = $this->urlService->curl($request->url_check);

        return response()->json(['status' => $status]);
    }



}
//https://habr.com/ru/post/350778/
