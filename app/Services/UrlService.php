<?php

namespace App\Services;


use App\Http\Requests\UrlRequest;
use App\Repositories\AlertRepository;
use App\Repositories\PingRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UrlRepository;
use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class UrlService extends BaseService
{
    protected UrlRepository $urlRepository;
    protected PingService $pingService;
    protected ProjectRepository $projectRepository;
    protected AlertRepository $alertRepository;
    protected PingRepository $pingRepository;

    /**
     * @param UrlRepository $urlRepository
     * @param ProjectRepository $projectRepository
     * @param AlertRepository $alertRepository
     * @param PingRepository $pingRepository
     */
    public function __construct(UrlRepository     $urlRepository,
                                ProjectRepository $projectRepository,
                                AlertRepository   $alertRepository,
                                PingRepository $pingRepository,
                                PingService $pingService
    )
    {
        $this->urlRepository = $urlRepository;
        $this->projectRepository = $projectRepository;
        $this->alertRepository = $alertRepository;
        $this->pingRepository = $pingRepository;
        $this->pingService = $pingService;
    }


    /**
     * @return array
     */
    #[ArrayShape(['urls' => "array", 'projects' => "array", 'alerts' => "array"])]
    public function initialData(): array
    {
        $user = \Auth::user();

        if ($user->role == 0)
            return [
                'urls' => $this->urlRepository->getUrlByIdProject($user->id_project),
                'projects' => $this->projectRepository->getProjectByIdProject($user->id_project),
                'alerts' => $this->alertRepository->getAlertAll()
            ];

        return [
            'urls' => $this->urlRepository->getUrlByIdProject(1),
            'projects' => $this->projectRepository->getProjectAll(),
            'alerts' => $this->alertRepository->getAlertAll()
        ];

    }

    /**
     * @param array $request
     * @return array
     */
    public function storeUrl(array $request): array
    {
        return $this->urlRepository->store($request);
    }

    /**
     * @param int $id
     * @return array
     */
    #[ArrayShape(['urls' => "array", 'projects' => "array", 'alerts' => "array"])]
    public function editUrl(int $id): array
    {
        $user = \Auth::user();

        if ($user->role == 0)
            return [
                'urls' => $this->urlRepository->edit($id),
                'projects' => $this->projectRepository->getProjectByIdProject($user->id),
                'alerts' => $this->alertRepository->getAlertAll()
            ];
        else
            return [
                'urls' => $this->urlRepository->edit($id),
                'projects' => $this->projectRepository->getProjectAll(),
                'alerts' => $this->alertRepository->getAlertAll()
            ];

    }

    /**
     * @param array $request
     * @param int $id
     * @return bool
     */
    public function updateUrl(array $request, int $id): bool
    {
        return $this->urlRepository->update($request, $id);
    }

    /**
     * @param int $id
     * @return array
     */
    #[ArrayShape(['urls' => "array", 'projects' => "array", 'alerts' => "array"])]
    public function deleteUrl(int $id): array
    {
        $this->urlRepository->delete($id);
        return $this->initialData();
    }

    /**
     * @param int $id
     * @return array
     */
    public function ajaxCheckUrl(int $id): array
    {
        return $this->urlRepository->ajaxUrlShowTable($id);
    }

    /**
     * @return array
     */
    public function basket(): array
    {
        return $this->urlRepository->basket();
    }

    /**
     * @param int $id
     */
    public function restore(int $id): void
    {
        $this->urlRepository->restore($id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteTrash(int $id): array
    {
        return $this->urlRepository->deleteTrash($id);
    }

    #[ArrayShape(['status' => "mixed", 'error' => "string"])]
    public function validatedUrl($url): array
    {
        $status = [];
        $error = '';
        $re = '/^(https?:\/\/www\.)?((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|((\d{1,3}\.){3}\d{1,3}))(\:\d+)?(\/[-a-z\d%_.~+]*)*(\?[;&a-z\d%_.~+=-]*)?(\#[-a-z\d_]*)?$/iu';
        $preg = preg_match($re, $url);

        if ($preg) {
            $data = $this->pingService->curl($url);
            $status = $data['status'];
        }
        else $error = 'Invalid URL';
        $data = ['status' => $status, 'error' => $error];

        return $data;
    }

}
