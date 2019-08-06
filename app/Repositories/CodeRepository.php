<?php

namespace App\Repositories;

use App\Code;
use App\Contracts\Repositories\CodeRepository as Contract;
use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CodeRepository implements Contract
{
    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function all() {
        $models = $this->filesystem->files(base_path("app"));

        $codes = array();

        foreach ($models as $model) {
            $rel = $model->getRelativePathName();
            if(strrpos($rel, '/')) continue;

            $modelName =  rtrim($rel, '.php');

            $cat = app()->make('stdClass');
            $cat->model_name = $modelName;
            $codes[] = $cat;
        }

        return $codes;
    }

    public function find($modelName) {
        $cat = app()->make('stdClass');
        $cat->model_name = $modelName;

        $tableName = Str::plural($modelName);
        $camelTableName = Str::camel($tableName);

        $cat->columns = Schema::getColumnListing($camelTableName);

        return $cat;
    }
}
