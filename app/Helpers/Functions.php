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

if (! function_exists('user_id')) {
    function user_id() {
        return Auth::id();
    }
}

if (! function_exists('toSystemTimeZone')) {
    function toSystemTimeZone($date){ 
        $timezone = config('app.timezone');
        $displayTimezone = config('app.display_timezone');
        return \Carbon\Carbon::parse($date, $displayTimezone)->timezone($timezone);
    }
}

if (! function_exists('toDisplayTimeZone')) {
    function toDisplayTimeZone($date){
        $displayTimezone = config('app.display_timezone');
        return \Carbon\Carbon::parse($date)->timezone($displayTimezone)->toDateTimeString();
    }
}