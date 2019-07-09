/*
 * Load various JavaScript modules that assist ssky.
 */
window.axios = require('axios');
window._ = require('lodash');
window.moment = require('moment');
window.Promise = require('promise');
window.Popper = require('popper.js').default;

/*
 * Define Moment locales
 */
window.moment.defineLocale('en-short', {
    parentLocale: 'en',
    relativeTime: {
        future: "in %s",
        past: "%s",
        s: "1s",
        m: "1m",
        mm: "%dm",
        h: "1h",
        hh: "%dh",
        d: "1d",
        dd: "%dd",
        M: "1 month ago",
        MM: "%d months ago",
        y: "1y",
        yy: "%dy"
    }
});
window.moment.locale('en');

/*
 * Load jQuery and Bootstrap jQuery, used for front-end interaction.
 */
if (window.$ === undefined || window.jQuery === undefined) {
    window.$ = window.jQuery = require('jquery');
}

require('bootstrap');

/**
 * Load Vue if this application is using Vue as its framework.
 */
if ($('#ssky-app').length > 0) {
    require('vue-bootstrap');
}

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {

    window.axios.defaults.headers.common = {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': token.content,
    };
    
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Intercept the incoming responses.
 *
 * Handle any unexpected HTTP errors and pop up modals, etc.
 */
window.axios.interceptors.response.use(function (response) {
    return response;
}, function (error) {
    if (error.response === undefined) {
        return Promise.reject(error);
    }

    switch (error.response.status) {
        case 401:
            window.axios.get('/logout');
            $('#modal-session-expired').modal('show');
            break;

        case 402:
            window.location = '/settings#/subscription';
            break;
    }

    return Promise.reject(error);
});
