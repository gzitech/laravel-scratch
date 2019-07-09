module.exports = {

    props: {
        user: {
            type: Object,
            required: true,
        },
        old: {
            type: [Object, Array],
            required: true,
        },
        errors: {
            type: [Object, Array],
            required: true,
        },
    },

    data() {
        return {
            userEditForm: new SSky.Form({
                first_name: this.old.first_name || this.user.first_name || '',
                last_name: this.old.last_name || this.user.last_name || '',
                email: this.old.email || this.user.email || '',
            }),
        };
    },


    watch: {
        user: function (user) {
            this.userEditForm.resetStatus();
            this.userEditForm.first_name = user.first_name;
            this.userEditForm.last_name = user.last_name;
            this.userEditForm.email = user.email;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.userEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateUserEditForm: function (event) {
            event.preventDefault();

            this.userEditForm.startProcessing();

            if (this.userEditForm.validate({
                'first_name': 'required|string|max:255',
                'last_name': 'required|string|max:255',
            })) {
                var url = '/user/' + this.user.id + '/';

                SSky.put(url, this.userEditForm)
                    .then(response => {
                        var data = this.userEditForm.getData();
                        data.id = this.user.id;
                        this.$emit('user-updated', data);
                        this.userEditForm.finishProcessing();
                    });
            } else {
                this.userEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};