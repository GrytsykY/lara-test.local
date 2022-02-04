<?php

namespace App\Http\Controllers;

use App\Services\UrlService;
use Illuminate\Http\Request;

class PingController extends Controller
{
    private UrlService $urlService;

    /**
     * @param UrlService $urlService
     */
    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
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
