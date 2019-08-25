SSky.FormRule = function () {
    
    /**
     * val, options
     */
    this.required = function (val) {

        if (val === undefined || val === null) {
            return false;
        }

        var str = String(val).replace(/\s/g, "");

        return str.length > 0;
    }

    /**
     * val, options
     */
    this.string = function (val) {

        if (val === undefined || val === null) {
            return true;
        }

        return isNaN(val);
    }

    /**
     * val, options
     */
    this.max = function (val, options) {

        if (val === undefined || val === null) {
            return true;
        }

        var str = String(val);

        if (options.length > 1) {
            var maxLength = parseInt(options[1], 10);
            return str.length <= maxLength;
        }

        console.error("validation rule 'max' need set length after rule name, e.g: max:255.")

        return false;
    }

    /**
     * val, options
     */
    this.between = function (val, options) {

        if (val === undefined || val === null) {
            return true;
        }

        var str = String(val);

        if (options.length > 2) {
            var minLength = parseInt(options[1], 10);
            var maxLength = parseInt(options[2], 10);
            return str.length >= minLength && str.length <= maxLength;
        }

        console.error("validation rule 'between' need set minLength and maxLength after rule name, e.g: between:1,255.")

        return false;
    }

    /**
     * val, options
     */
    this.email = function (val) {

        if (val === undefined || val === null) {
            return true;
        }

        var r = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

        return r.test(val);
    }
}