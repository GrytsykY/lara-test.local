<?php

namespace App\Services;

use App\Repositories\AlertRepository;
use App\Repositories\PingRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UrlRepository;
use Carbon\Carbon;
use mysql_xdevapi\Exception;

class PingService
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
                                PingRepository    $pingRepository
    )
    {
        $this->urlRepository = $urlRepository;
        $this->projectRepository = $projectRepository;
        $this->alertRepository = $alertRepository;
        $this->pingRepository = $pingRepository;
    }

    public function ping1()
    {
        $start = $this->pingRepository->start(1);
        if ($start[0]['flag'] == 1) {

            $this->pingRepository->startUpdate(1,0);

            $urls = $this->urlRepository->getTimeOutAndLastPing($this->dateNow());

            if (!empty($urls)) {

                try {
                    foreach ($urls as $url) {
                        sleep(3);
                        $searchTeam = false;
                        if ($url['search_term'] != null) $searchTeam = true;
                        $status = $this->curl($url['url']);

                        if ($status == $url['status_code']) {

                            $this->answerAlertIsOk($url, $searchTeam);
                            $this->urlRepository->updatePingNull($url['id'], $this->dateNow());

                        } else {

                            if ($url['max_count_ping'] == 1) {

                                $this->answerAlertIsNot($url);

                            } else {

                                $this->urlRepository->updatePingCounterFieldOne($url, $this->dateNow());
                            }
                        }

                    }

                } catch (Exception $e) {
                } finally {
                    $this->pingRepository->startUpdate(1,1);
                }


            }
        }
    }

    public function ping2()
    {
        $start = $this->pingRepository->start(2);
        if ($start[0]['flag'] == 1) {

            $this->pingRepository->startUpdate(2,0);


            $urls = $this->urlRepository->selectLastPingAndOneMinute($this->dateNow());

            if (!empty($urls))
                try {

                    foreach ($urls as $url) {
                        $searchTeam = false;
                        if ($url['search_term'] != null) $searchTeam = true;

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
                } catch (Exception $e) {
                } finally {
                    $this->pingRepository->startUpdate(2,1);
                }
        }

    }

    public function ping3()
    {
        $start = $this->pingRepository->start(3);
        if ($start[0]['flag'] == 1) {

            $this->pingRepository->startUpdate(3,0);

            $urls = $this->urlRepository->getUrlOutTimeAndLastPingFieldOneSentAlertOne($this->dateNow());
            try {

                foreach ($urls as $url) {
                    $searchTeam = false;
                    if ($url['search_term'] != null) $searchTeam = true;

                    $status = $this->curl($url['url']);

                    if ($status == $url['status_code']) {

                        $this->answerAlertIsOk($url, $searchTeam);

                    }

                }
            } catch (Exception $e) {
            } finally {
                $this->pingRepository->startUpdate(3,1);
            }
        }
    }

    /**
     * @param string $url
     * @param array $params
     * @return int
     */
    public function curl(string $url, array $params = []): int
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
        $botToken = env('TELEGRAM_BOT_TOKEN');
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
     * @param array $url
     * @param bool $searchTeam
     */
    public function answerAlertIsOk(array $url, bool $searchTeam): void
    {
        $text = '';
        if ($searchTeam) {
            if (strpos(file_get_contents($url['url']), $url['search_term']))
                $text = htmlspecialchars("Есть такое слово: " . $url['search_term']);
            else
                $text = htmlspecialchars("Нет такого слова (или текста): " . $url['search_term']);
        }
        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
        if ($project)
            $this->tel_curl($project[0]['chat_id'], 'Сайт "'. $url['title'] . '" работает! ' . $text);

        $this->urlRepository->updatePingNull($url['id'], $this->dateNow());

    }

    /**
     * @param array $url
     */
    public function answerAlertIsNot(array $url): void
    {
        $alert = $this->alertRepository->getByIdAlert($url['id_alert']);
        $project = $this->projectRepository->getProjectByIdProject($url['id_project']);
        if ($project)
            $this->tel_curl($project[0]['chat_id'], 'Сайт "'. $url['title'] . '" не  работает!!! '. $alert[0]['name'] .
                ' ' . $alert[0]['description']);

        $this->urlRepository->updatePingCounterFieldOneSentAlertOne($url, $this->dateNow());
    }
}
