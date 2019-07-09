if (window.Vue === undefined) {
    window.Vue = require('vue');

    window.Bus = new Vue();
}

require('./form/bootstrap');