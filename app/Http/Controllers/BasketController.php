<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BasketController extends Controller
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
     * @return Factory|View|Application
     */
    public function basket(): Factory|View|Application
    {
        $urls = $this->urlService->basket();
        return view('baskets.basket', compact('urls'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
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
