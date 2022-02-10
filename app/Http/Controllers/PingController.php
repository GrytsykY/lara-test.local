<?php

namespace App\Http\Controllers;

use App\Services\PingService;
use Database\Seeders\EmploymentSeeder;

class PingController extends Controller
{
    private PingService $pingService;

    /**
     * @param PingService $pingService
     */
    public function __construct(PingService $pingService)
    {
        $this->pingService = $pingService;
    }

    public function ping1()
    {
        $this->pingService->ping1();
    }

    public function ping2()
    {
         $this->pingService->ping2();
    }

    public function ping3()
    {
       $this->pingService->ping3();
    }
}
