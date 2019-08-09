<?php

namespace App\Contracts\Repositories;

interface RoleRepository
{
    public function paginate();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateRight($id, array $rights);
    public function destroy($id);
}
