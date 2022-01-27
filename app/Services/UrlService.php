<?php

namespace App\Services;

use App\Repositories\UrlRepository;

class UrlService extends BaseService
{
    private $urlRepository;

    public function __construct(UrlRepository $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }
}
