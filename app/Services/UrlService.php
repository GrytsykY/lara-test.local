<?php

namespace App\Services;

use App\Interfaces\UrlRepositoryInterface;
use App\Repositories\UrlRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class UrlService extends BaseService
{
    protected UrlRepositoryInterface $urlRepository;

    /**
     * @param UrlRepositoryInterface $urlRepository
     */
    public function __construct(UrlRepositoryInterface $urlRepository)
    {
        $this->urlRepository = $urlRepository;
    }


    /**
     * @return array
     */
    #[ArrayShape(['urls' => "array", 'projects' => "array", 'alerts' => "array"])]
    public function initialData(): array
    {
        $user = \Auth::user();

        if ($user->role == 0) return [
                'urls' => $this->urlRepository->getUrlByIdProject($user->id_project),
                'projects' => $this->urlRepository->getProjectByIdProject($user->id_project),
                'alerts' => $this->urlRepository->getAlertAll()
            ];

        return [
            'urls' => $this->urlRepository->getUrlByIdProject($user->id_project),
            'projects' => $this->urlRepository->getProjectAll(),
            'alerts' => $this->urlRepository->getAlertAll()
        ];

    }



//    private $urlRepository;
//
//    public function __construct(UrlRepository $urlRepository)
//    {
//        $this->urlRepository = $urlRepository;
//    }
//
//    public function ping1(){
//        $current = Carbon::now();
//        $current->format('Y-m-d H:i:s');
//
//        $urls = $this->urlRepository->selectUrlOutTimeAndLastPing($current);
//
//        dump($urls);
//        foreach ($urls as $url) {
//
//            $status = $this->curl($url->url);
//            dump($url->url . ' ' . $status);
//            if ($status == $url->status_code) {
//                // отправляем сообщение
//
//                $this->urlRepository->updatePingNull($url->id);
//
//            } else {
//
//                if ($url->max_count_ping == 1) {
//                    $status = $this->curl($url->url);
//
//
//                    if ($status == $url->status_code) {
//
//                        $this->urlRepository->updatePingNull($url->id);
//                    } else {
//
//                        $alert = $this->urlRepository->selectAlertId($url);
//                        $project = $this->urlRepository->selectProjectId($url);
//
//                        if ($project)
//                            $this->tel_curl($project[0]->chat_id, $url->name . ' ' . $alert[0]->name .
//                                ' ' . $alert[0]->description);
//
//                        $this->urlRepository->updatePingCounterFieldOneSentAlertOne($url);
//                    }
//                } else {
//
//                    $this->urlRepository->updatePingCounterFieldOne($url);
//                }
//            }
//
//        }
//    }
//
//    public function ping2()
//    {
//        $urls = $this->urlRepository->selectLastPingAndOneMinute();
//
//        if (!empty($urls ))
//        foreach ($urls as $url) {
//
//            $status = $this->curl($url->url);
//            dump($status);
//            if ($status == $url->status_code) {
//                // отправляем сообщение
//
//                $this->urlRepository->updatePingNull($url->id);
//
//            } else {
//
//                if ($url->max_count_ping >= 1) {
//                    $status = $this->curl($url->url);
//
//
//                    if ($status == $url->status_code) {
//
//                        $project = $this->urlRepository->selectProjectId($url);
//                        if ($project)
//                            $this->tel_curl($project[0]->chat_id, 'Сайт работает');
//
//                        $this->urlRepository->updatePingNull($url->id);
//
//                    } else {
//
//                        $this->urlRepository->updatePingCounterFieldOne($url);
//
//                        if ($url->max_count_ping == $url->ping_counter + 1) {
//                            $alert = $this->urlRepository->selectAlertId($url);
//                            $project = $this->urlRepository->selectProjectId($url);
//                            if ($project)
//                                $this->tel_curl($project[0]->chat_id, $url->name . ' ' . $alert[0]->name .
//                                    ' ' . $alert[0]->description);
//
//                            $this->urlRepository->updatePingCounterFieldOneSentAlertOne($url);
//                        }
//                    }
//                }
//            }
//
//        }
//
//        dump($urls);
//    }
//
//    public function ping3()
//    {
//
//        $urls = $this->urlRepository->selectUrlOutTimeAndLastPingFieldOneSentAlertOne();
//        dump($urls);
//        foreach ($urls as $url) {
//
//            $status = $this->curl($url->url);
//
//            if ($status == $url->status_code) {
//                $project = $this->urlRepository->selectProjectId($url);
//                if ($project)
//                    $this->tel_curl($project[0]->chat_id, 'Сайт работает');
//
//                $this->urlRepository->updatePingNull($url->id);
//
//            }
//
//        }
//
//    }
//
//    protected function curl($url)
//    {
//
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
//        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
//        $response = curl_exec($ch);
//        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//        curl_close($ch);
//
//
//        return $status;
//    }
//
//    protected function tel_curl($id, $message)
//    {
//        $botToken = '5243206235:AAEsYTDkugFDDt6pGq8iw1CeivhNwVRP3ck';
//        $website = "https://api.telegram.org/bot" . $botToken;
//        $params = [
//            'chat_id' => $id,
//            'text' => $message,
//        ];
//        $ch = curl_init($website . '/sendMessage');
//        curl_setopt($ch, CURLOPT_HEADER, false);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        $result = curl_exec($ch);
//        curl_close($ch);
//    }
}
