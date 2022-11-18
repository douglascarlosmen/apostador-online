<?php

namespace App\Services;

class LoteriasService
{

    protected $urls;

    public function __construct()
    {
        $this->urls = config('loterias.urls');
    }

    /**
     * Obtém a lista dos nomes das loterias
     * disponíveis para consulta na api
     */
    public function listLotosNames(): array
    {
        foreach ($this->urls as $base_url) {
            $url = $base_url;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                continue;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($resultStatus == 200) {
                    return json_decode($response, true);
                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Obtém o resultado mais recente de
     * determinada loteria
     */
    public function getLatestLotoResult(string $lotoName): array
    {
        foreach ($this->urls as $base_url) {
            $url = $base_url . "$lotoName/latest";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                continue;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($resultStatus == 200) {
                    return json_decode($response, true);
                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Obtém o resultado de um concurso específico
     * de determinada loteria
     */
    public function getSpecificContestLotoResult(string $lotoName, string|int $contestNumber): array
    {
        foreach ($this->urls as $base_url) {
            $url = $base_url . "$lotoName/$contestNumber";

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                continue;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($resultStatus == 200) {
                    return json_decode($response, true);
                } else {
                    continue;
                }
            }
        }
    }

    /**
     * Obtém todos os resultados de
     * uma determinada loteria
     */
    public function getAllLotoResults(string $lotoName): array
    {
        foreach ($this->urls as $base_url) {
            $url = $base_url . $lotoName;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                continue;
            } else {
                $resultStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                if ($resultStatus == 200) {
                    return json_decode($response, true);
                } else {
                    continue;
                }
            }
        }
    }
}
