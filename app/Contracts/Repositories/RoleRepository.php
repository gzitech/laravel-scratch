<?php

namespace App\Contracts\Repositories;

use App\User;

interface RoleRepository
{
    public function getRoles($site_id);
    public function getRolesByUserId($user_id);
    public function getRolesByUser(User $user);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateRight($id, array $rights);
    public function destroy($id);
}
