<?php

if (! function_exists('paginate')) {
    function paginate($query, $key) {
        if(config('app.paginate_type') == 'paginate') {
            return $query->paginate(config("app.max_page_size"))->appends(['key' => $key]);
        } else {
            return $query->simplePaginate(config("app.max_page_size"))->appends(['key' => $key]);
        }
    }
}

if (! function_exists('site')) {
    function site() {
        return app('App\Site');
    }
}

if (! function_exists('user')) {
    function user() {
        return Auth::user();
    }
}