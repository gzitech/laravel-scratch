<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClientRepository as Contract;

class ClientRepository implements Contract
{
    private $header;

    public function __construct()
    {
        $this->header = array(
            'Content-Type: application/json; charset=utf-8;'
        );
    }

    public function get($url) {
        return $this->sendData("GET", $url, array());
    }

    public function post($url, Array $data) {
        return $this->sendData("POST", $url, $data);
    }

    public function put($url, Array $data) {
        return $this->sendData("PUT", $url, $data);
    }

    public function patch($url, Array $data) {
        return $this->sendData("PATCH", $url, $data);
    }

    public function delete($url, Array $data) {
        return $this->sendData("DELETE", $url, $data);
    }

    private function sendData(string $method, string $url, Array $data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 6);
        // curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_2);

        $responseText = curl_exec($ch);

        curl_close($ch);

        return $responseText;
    }
}