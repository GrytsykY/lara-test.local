<?php

namespace App\Http\Controllers;

use App\Http\Requests\UrlRequest;
use App\Services\PingService;
use App\Services\UrlService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UrlController extends Controller
{
    private UrlService $urlService;
    private PingService $pingService;

    /**
     * @param UrlService $urlService
     * @param PingService $pingService
     */
    public function __construct(UrlService $urlService, PingService $pingService)
    {
        $this->urlService = $urlService;
        $this->pingService = $pingService;
    }

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('urls.index', ['urls' => $this->urlService->initialData()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(UrlRequest $request): JsonResponse
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
     * @return JsonResponse
     */
    public function ajaxCheckUrl(Request $request): JsonResponse
    {
        $status = $this->pingService->curl($request->url_check);

        return response()->json(['status' => $status]);
    }



}
//https://habr.com/ru/post/350778/
