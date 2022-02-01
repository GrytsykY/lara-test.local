<?php

namespace App\Services;


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
     */
    public function __construct(UrlRepository     $urlRepository,
                                ProjectRepository $projectRepository,
                                AlertRepository   $alertRepository,
                                PingRepository    $pingRepository
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

    public function storeUrl($request): array
    {
        return $this->urlRepository->store($request);
    }

    #[ArrayShape(['urls' => "array", 'projects' => "array", 'alerts' => "array"])]
    public function editUrl($id): array
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

    public function updateUrl($request, $id)
    {
        return $this->urlRepository->update($request, $id);
    }

    public function deleteUrl($id): array
    {
        return $this->urlRepository->delete($id);
    }

    public function ajaxCheckUrl($id): array
    {
        return $this->urlRepository->ajaxUrlShowTable($id);
    }

    public function curl($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        return $status;
    }

    protected function tel_curl($id, $message)
    {
        $botToken = '5243206235:AAEsYTDkugFDDt6pGq8iw1CeivhNwVRP3ck';
        $website = "https://api.telegram.org/bot" . $botToken;
        $params = [
            'chat_id' => $id,
            'text' => $message,
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    protected function dateNow(): Carbon
    {
        $current = Carbon::now();
        $current->format('Y-m-d H:i:s');
        return $current;
    }

    public function ping1()
    {
        $urls = $this->pingRepository->getTimeOutAndLastPing($this->dateNow());

        if (!empty($urls))
        foreach ($urls as $url) {

            $status = $this->curl($url['url']);
            dump($url['url'] . ' ' . $status);
            if ($status == $url['status_code']) {
                // отправляем сообщение

                $this->pingRepository->updatePingNull($url['id'], $this->dateNow());

            } else {

                if ($url['max_count_ping'] == 1) {
                    $status = $this->curl($url['url']);

                    if ($status == $url['status_code']) {

                        $this->pingRepository->updatePingNull($url['id'], $this->dateNow());
                    } else {

                        $alert = $this->alertRepository->getByIdAlert($url['id_alert']);

                        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);

                        if ($project)
                            $this->tel_curl($project[0]['chat_id'], $url['name'] . ' ' . $alert[0]['name'] .
                                ' ' . $alert[0]['description']);

                        $this->pingRepository->updatePingCounterFieldOneSentAlertOne($url, $this->dateNow());
                    }
                } else {

                    $this->pingRepository->updatePingCounterFieldOne($url, $this->dateNow());
                }
            }

        }
    }

    public function ping2()
    {
        $urls = $this->pingRepository->selectLastPingAndOneMinute($this->dateNow());

        if (!empty($urls ))
        foreach ($urls as $url) {

            $status = $this->curl($url['url']);
            dump($status);
            if ($status == $url['status_code']) {
                // отправляем сообщение

                $this->pingRepository->updatePingNull($url['id'], $this->dateNow());

            } else {

                if ($url['max_count_ping'] >= 1) {
                    $status = $this->curl($url['url']);


                    if ($status == $url['status_code']) {

                        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
                        if ($project)
                            $this->tel_curl($project[0]['chat_id'], 'Сайт работает');

                        $this->pingRepository->updatePingNull($url['id'], $this->dateNow());

                    } else {

                        $this->pingRepository->updatePingCounterFieldOne($url, $this->dateNow());

                        if ($url['max_count_ping'] == $url['ping_counter'] + 1) {
                            $alert = $this->alertRepository->getByIdAlert($url['id_alert']);
                            $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
                            if ($project)
                                $this->tel_curl($project[0]['chat_id'], $url['name'] . ' ' . $alert[0]['name'] .
                                    ' ' . $alert[0]['description']);

                            $this->pingRepository->updatePingCounterFieldOneSentAlertOne($url, $this->dateNow());
                        }
                    }
                }
            }

        }

        dump($urls);
    }

    public function ping3()
    {

        $urls = $this->pingRepository->getUrlOutTimeAndLastPingFieldOneSentAlertOne($this->dateNow());
        dump($urls);
        foreach ($urls as $url) {

            $status = $this->curl($url['url']);

            if ($status == $url['status_code']) {
                $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
                if ($project)
                    $this->tel_curl($project[0]['chat_id'], 'Сайт работает');

                $this->pingRepository->updatePingNull($url['id'], $this->dateNow());

            }

        }

    }


}
