<?php

namespace App\Contracts\Repositories;

use App\User;

interface RoleRepository
{
    public function getRoles($site_id, $key);
    public function getRolesByUserId($site_id, $user_id, $key);
    public function getRolesByUser($site_id, User $user, $key);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateRight($id, $userRight, array $rights);
    public function destroy($id);
}
