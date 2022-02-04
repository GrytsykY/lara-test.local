<?php

namespace App\Http\Controllers;

use App\Services\UrlService;

class BasketController extends Controller
{
    private UrlService $urlService;


    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
     */
    public function basket(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $urls = $this->urlService->basket();
        return view('baskets.basket', compact('urls'));
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(int $id): \Illuminate\Http\RedirectResponse
    {
        $this->urlService->restore($id);
        return redirect()->route('basket');
    }

    /**
     * @param int $id
     * @return string
     */
    public function deleteTrash(int $id): string
    {
       $urls = $this->urlService->deleteTrash($id);
        return view('ajax.ajaxBasketShow', ['urls' => $urls])->render();
    }
}
