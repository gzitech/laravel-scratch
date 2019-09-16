<?php

namespace App\Contracts\Repositories;

interface ClientRepository
{
    public function get($url);
    public function post($url, Array $data);
    public function put($url, Array $data);
    public function patch($url, Array $data);
    public function delete($url, Array $data);
}
