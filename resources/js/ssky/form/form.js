
SSky.Form = function (formData) {
    var form = this;

    $.extend(this, formData);

    this.errors = new SSky.FormErrors();
    this.formRules = new SSky.FormRule();

    var _messages = {
        required: "The :attribute field is required.",
        string: "The :attribute must be a string.",
        max: "The :attribute may not be greater than :max.",
        between: "The :attribute must be between :min and :max.",
        email: "The :attribute must be a valid email address.",
    }


    this.busy = false;
    this.successful = false;

    this.startProcessing = function () {
        form.errors.forget();
        form.busy = true;
        form.successful = false;
    };

    this.finishProcessing = function () {
        form.busy = false;
        form.successful = true;
    };

    this.getData = function() {

        var data = {};

        for(attr in formData) {
            if (Object.prototype.hasOwnProperty.call(this, attr)) {
                data[attr] = this[attr];
            }
        }

        return data;
    };

    this.validate = function (rules, messages) {

        var validated = true;

        rules = rules || {};
        messages = messages || {};

        Object.assign(_messages, messages);

        errors = {};

        for (var attr in rules) { // attr
            if(formData[attr] === undefined || formData[attr] === null) continue;
            
            var attrRules = rules[attr];
            var val = _getAttrValue(this, attr);

            var validRules;

            if (attrRules instanceof Array) {
                validRules = _prepareRulesArray(attrRules);
            } else if (typeof attrRules === 'string') {
                validRules = attrRules.split('|');
            } else if (typeof attrRules === 'function') {
                validRules = [attrRules];
            }

            for (var i = 0; i < validRules.length; i++) { // rule
                var validRule = validRules[i];

                if (!_validateRule(attr, val, validRule)) {
                    validated = false;
                    errors[attr] = _createErrorMessage(attr, validRule, val);
                    break;
                }
            }
        }

        if (!validated) { form.setErrors(errors); }

        return validated;
    };

    this.resetStatus = function () {
        form.errors.forget();
        form.busy = false;
        form.successful = false;
    };

    this.setErrors = function (errors) {
        form.busy = false;
        form.errors.set(errors);
    };

    _createErrorMessage = function (attr, rule, val) {
        var str;
        var messages = _messages;

        if (typeof rule === 'string') {
            options = rule.split(/[:,]+/);
            if (options.length > 0) {
                rule = options[0];
            }
        }

        if (messages[attr + "." + rule] !== undefined && messages[attr + "." + rule] !== null) {
            str = messages[attr + "." + rule];
        } else if (messages[attr] !== undefined && messages[attr] !== null) {
            str = messages[attr];
        } else if (messages[rule] !== undefined && messages[rule] !== null) {
            str = messages[rule];
        } else {
            str = 'The :attribute given data was invalid.';
        }

        str = str.replace(new RegExp(':attribute', 'g'), _pascalCase(attr));

        if (rule === 'max' && options.length > 1) {
            str = str.replace(new RegExp(':max', 'g'), options[1]);
        } else if (rule === 'between' && options.length > 2) {
            str = str.replace(new RegExp(':min', 'g'), options[1]);
            str = str.replace(new RegExp(':max', 'g'), options[2]);
        }

        return [str];
    };

    function _pascalCase(val) {
        if (val === undefined || val === null) {
            return "";
        }

        var arr = val.split('_');

        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].slice(0, 1).toUpperCase() + arr[i].slice(1, arr[i].length);
        }

        return arr.join(' ');
    }

    _getAttrValue = function (o, propertyName) {
        if (Object.prototype.hasOwnProperty.call(o, propertyName)) {
            return o[propertyName];
        }

        // var keys = propertyName.replace(/\[(\w+)\]/g, ".$1").replace(/^\./, "").split(".");

        return null;
    };

    _prepareRulesArray = function (attrRules) {
        var rules = [];

        for (var i = 0, len = attrRules.length; i < len; i++) {
            if ((typeof attrRules[i] === 'string') || (typeof attrRules[i] === 'function')) {
                rules.push(attrRules[i]);
            }
        }

        return rules;
    };

    _validateRule = function (attr, val, rule) {
        var passed = false;

        if (typeof rule === 'string') {
            options = rule.split(/[:,]+/);
            if (options.length > 0) {
                rule = options[0];
            }

            fn = form.formRules[rule];

            if (typeof fn === 'function') {
                passed = fn.apply(form.formRules, [val, options]);
            } else {
                console.error("validation rule '" + rule + "' not exists.")
            }

        } else {
            passed = rule.apply(form.formRules, [val]);
        }

        return passed;
    };
};