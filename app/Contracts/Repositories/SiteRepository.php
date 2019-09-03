<?php

namespace App\Contracts\Repositories;

interface SiteRepository
{
    public function getSites($key);
    public function getSitesByUserId($user_id, $key);
    public function find($id);
    public function create($user_id, array $data);
    public function update($id, array $data);
    public function destroy($id);
}
