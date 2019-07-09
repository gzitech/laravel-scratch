module.exports = {
    
    post(uri, form) {
        return SSky.sendForm('post', uri, form);
    },

    put(uri, form) {
        return SSky.sendForm('put', uri, form);
    },

    patch(uri, form) {
        return SSky.sendForm('patch', uri, form);
    },

    delete(uri, form) {
        return SSky.sendForm('delete', uri, form);
    },

    sendForm(method, uri, form) {
        return new Promise((resolve, reject) => {
            form.startProcessing();

            axios[method](uri, form.getData())
                .then(response => {
                    form.finishProcessing();

                    resolve(response.data);
                })
                .catch(errors => {
                    form.setErrors(errors.response.data.errors);

                    reject(errors.response.data);
                });
        });
    }
};
