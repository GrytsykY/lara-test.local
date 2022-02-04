<?php

namespace App\Services;


use App\Repositories\AlertRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UrlRepository;
use Carbon\Carbon;
use JetBrains\PhpStorm\ArrayShape;

class UrlService extends BaseService
{
    protected UrlRepository $urlRepository;
    protected ProjectRepository $projectRepository;
    protected AlertRepository $alertRepository;

    /**
     * @param UrlRepository $urlRepository
     * @param ProjectRepository $projectRepository
     * @param AlertRepository $alertRepository
     */
    public function __construct(UrlRepository     $urlRepository,
                                ProjectRepository $projectRepository,
                                AlertRepository   $alertRepository,
    )
    {
        $this->urlRepository = $urlRepository;
        $this->projectRepository = $projectRepository;
        $this->alertRepository = $alertRepository;
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
     * @param object $request
     * @return array
     */
    public function storeUrl(object $request): array
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
     * @param object $request
     * @param int $id
     * @return mixed
     */
    public function updateUrl(object $request, int $id): mixed
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


    public function ping1()
    {
        set_time_limit(360);
        $urls = $this->urlRepository->getTimeOutAndLastPing($this->dateNow());

        if (!empty($urls)) {
            foreach ($urls as $url) {

                $searchTeam = false;
                if ($url['search_term'] == null) $searchTeam = true;
                $status = $this->curl($url['url']);

                if ($status == $url['status_code']) {

                    $this->urlRepository->updatePingNull($url['id'], $this->dateNow());

                } else {

                    if ($url['max_count_ping'] == 1) {
                        $status = $this->curl($url['url']);

                        if ($status == $url['status_code']) {
                            $this->answerAlertIsOk($url, $searchTeam);
                            $this->urlRepository->updatePingNull($url['id'], $this->dateNow());
                        } else {

                            $this->answerAlertIsNot($url);
                        }
                    } else {

                        $this->urlRepository->updatePingCounterFieldOne($url, $this->dateNow());
                    }
                }

            }
        }

    }

    public function ping2()
    {
        set_time_limit(360);
        $urls = $this->urlRepository->selectLastPingAndOneMinute($this->dateNow());

        if (!empty($urls))
            foreach ($urls as $url) {
                $searchTeam = false;
                if ($url['search_term'] == null) $searchTeam = true;

                $status = $this->curl($url['url']);

                if ($status == $url['status_code']) {

                    $this->answerAlertIsOk($url, $searchTeam);

                    $this->urlRepository->updatePingNull($url['id'], $this->dateNow());

                } else {

                    if ($url['max_count_ping'] >= 1) {


                        $this->urlRepository->updatePingCounterFieldOne($url, $this->dateNow());

                        if ($url['max_count_ping'] == $url['ping_counter'] + 1) {
                            $this->answerAlertIsNot($url);
                        }
                    }
                }

            }

    }

    public function ping3()
    {
        set_time_limit(360);
        $urls = $this->urlRepository->getUrlOutTimeAndLastPingFieldOneSentAlertOne($this->dateNow());

        foreach ($urls as $url) {
            $searchTeam = false;
            if ($url['search_term'] == null) $searchTeam = true;

            $status = $this->curl($url['url']);

            if ($status == $url['status_code']) {

                $this->answerAlertIsOk($url, $searchTeam);

            }

        }

    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed
     */
    public function curl(string $url, array $params = []): mixed
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        if (!empty($params)) {
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        }
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $status;
    }

    /**
     * @param int $id
     * @param string $message
     */
    protected function tel_curl(int $id, string $message)
    {
        $botToken = '5243206235:AAEsYTDkugFDDt6pGq8iw1CeivhNwVRP3ck';
        $website = "https://api.telegram.org/bot" . $botToken;
        $url = $website . '/sendMessage';
        $params = [
            'chat_id' => $id,
            'text' => $message,
        ];

        $this->curl($url, $params);
    }

    /**
     * @return Carbon
     */
    protected function dateNow(): Carbon
    {
        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');
        return $current;
    }

    /**
     * @param mixed $url
     * @param bool $searchTeam
     */
    public function answerAlertIsOk(mixed $url, bool $searchTeam): void
    {
        $text = '';
        if ($searchTeam) {
            if (strpos(file_get_contents($url['url']), $url['search_term']))
                $text = "Есть такое слово: " . $url['search_term'];
            else
                $text = "Нет такого слова (или текста): " . $url['search_term'];
        }
        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
        if ($project)
            $this->tel_curl($project[0]['chat_id'], 'Сайт работает! ' . $text);

        $this->urlRepository->updatePingNull($url['id'], $this->dateNow());

    }

    /**
     * @param mixed $url
     */
    public function answerAlertIsNot(mixed $url): void
    {
        $alert = $this->alertRepository->getByIdAlert($url['id_alert']);
        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
        if ($project)
            $this->tel_curl($project[0]['chat_id'], $url['name'] . ' ' . $alert[0]['name'] .
                ' ' . $alert[0]['description']);

        $this->urlRepository->updatePingCounterFieldOneSentAlertOne($url, $this->dateNow());
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
    public function restore(int $id)
    {
        return $this->urlRepository->restore($id);
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
