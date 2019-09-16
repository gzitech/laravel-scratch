<?php

namespace App\Contracts\Repositories;

use App\User;
use App\Role;
use App\Site;

interface UserRepository
{
    public function id();
    public function user();
    public function getUsers($key);
    public function getUsersBySiteId($site_id, $key);
    public function getUsersByRoleId($role_id, $key);
    public function getUsersByRole(Role $role, $key);
    public function getRight();
    public function getRightByUserId($id);
    public function getRightByUser(User $user);
    public function getConfigRights();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateProfile(array $data);
    public function updatePassword($password);
    public function clearRightByRoleId($role_id);
    public function destroy($id);
    public function checkRight($right);
    public function checkRights($rights);
    public function authorize($rights);
}
