<?php

namespace App\Contracts\Repositories;

interface SiteRepository
{
    public function paginate();
    public function paginateByUserId($user_id);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function destroy($id);
}
