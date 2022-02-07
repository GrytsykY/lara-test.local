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
                                PingRepository $pingRepository
    )
    {
        $this->urlRepository = $urlRepository;
        $this->projectRepository = $projectRepository;
        $this->alertRepository = $alertRepository;
        $this->pingRepository = $pingRepository;
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
            'urls' => $this->urlRepository->getUrlProjectIdOneAll(),
            'projects' => $this->projectRepository->getProjectAll(),
            'alerts' => $this->alertRepository->getAlertAll()
        ];

    }

    /**
     * @param UrlRequest $request
     * @return array
     */
    public function storeUrl(UrlRequest $request): array
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
     * @param UrlRequest $request
     * @param int $id
     * @return bool
     */
    public function updateUrl(UrlRequest $request, int $id): bool
    {
        return $this->urlRepository->update($request, $id);
    }

    /**
     * @param int $id
     * @return array
     */
    public function deleteUrl(int $id): array
    {
        return $this->urlRepository->delete($id);
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
}
