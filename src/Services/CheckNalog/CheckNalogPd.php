<?php


namespace Kirshin\Services\CheckNalog;


use JsonException;

class CheckNalogPd
{
    private $fields;

    private const URL = 'https://statusnpd.nalog.ru/api/v1/tracker/taxpayer_status';

    /**
     * CheckNalogPd constructor.
     * @param string $inn
     * @param string|null $date
     * @throws JsonException
     */
    public function __construct(string $inn, string $date = null) {
        $this->setFields($inn, $date);
    }

    /**
     * @return array
     */
    public function check(): array
    {
        $response = $this->httpPost(self::URL, $this->fields);

        try {
            return json_decode($response, true, 2, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            // :TODO
        }
    }

    /**
     * @param $url
     * @param $data
     * @return bool|string
     */
    private function httpPost($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Content-Length: ' . strlen($data)
        ]);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    /**
     * @param $inn
     * @param $date
     * @throws JsonException
     */
    private function setFields($inn, $date): void
    {
        $this->fields = json_encode([
            'inn' => $inn,
            'requestDate' => $date ?? date("Y-m-d", strtotime("yesterday"))
        ], JSON_THROW_ON_ERROR);
    }
}