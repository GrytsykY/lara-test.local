<?php

namespace App\Http\Controllers;

use App\Repositories\PingRepository;
use App\Repositories\UrlRepository;
use App\Services\UrlService;

class PingController extends Controller
{
    private UrlService $urlService;
    private PingRepository $pingRepository;

    /**
     * @param UrlService $urlService
     * @param PingRepository $pingRepository
     */
    public function __construct(UrlService $urlService,PingRepository $pingRepository)
    {
        $this->urlService = $urlService;
        $this->pingRepository = $pingRepository;
    }

    public function ping1()
    {
        $start = $this->pingRepository->start();
        if ($start[0]['start1'] == 1) $this->urlService->ping1();
    }

    public function ping2()
    {
        $start = $this->pingRepository->start();
        if ($start[0]['start2'] == 1) $this->urlService->ping2();
    }

    public function ping3()
    {
        $start = $this->pingRepository->start();
        if ($start[0]['start3'] == 1) $this->urlService->ping3();
    }
}
