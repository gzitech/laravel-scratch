<?php

namespace App\Contracts\Repositories;

use App\User;

interface UserRepository
{
    public function id();
    public function user();
    public function site();
    public function getUsers();
    public function getUsersBySiteId($site_id);
    public function getUsersByRoleId($role_id);
    public function getRightById($id);
    public function getRight(User $user);
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function updateProfile(array $data);
    public function updatePassword($password);
    public function destroy($id);
    public function checkRight($right);
    public function checkRights($rights);
    public function authorize($right);
}
