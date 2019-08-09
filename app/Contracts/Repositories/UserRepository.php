<?php

namespace App\Contracts\Repositories;

interface UserRepository
{
    public function current();
    public function paginate();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateRight($id);
    public function updateRights();
    public function updateRightsByRoleId($role_id);
    public function destroy($id);
    public function checkRight($right);
    public function authorize($right);
}
