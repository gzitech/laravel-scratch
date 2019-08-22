<?php

namespace App\Contracts\Repositories;

use App\User;

interface RoleRepository
{
    public function getRoles($site_id, $key);
    public function getRolesByUserId($user_id, $key);
    public function getRolesByUser(User $user, $key);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateRight($id, array $rights);
    public function destroy($id);
}
