<?php

namespace App\Contracts\Repositories;

interface CodeRepository
{
    public function all();
    public function find($modelName);
    // public function create(array $data);
    // public function update($id, array $data);
    // public function destroy($id);
}
