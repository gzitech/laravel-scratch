module.exports = {

    props: {
        role: {
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
            roleEditForm: new SSky.Form({
                role_name: this.old.role_name || this.role.role_name || '',
                role_description: this.old.role_description || this.role.role_description || '',
            }),
        };
    },


    watch: {
        role: function (role) {
            this.roleEditForm.resetStatus();
            this.roleEditForm.role_name = role.role_name;
            this.roleEditForm.role_description = role.role_description;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.roleEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateRoleEditForm: function (event) {
            event.preventDefault();

            this.roleEditForm.startProcessing();

            if (this.roleEditForm.validate({
                'role_name': 'required|string|max:255',
                'role_description': 'required|string|max:255',
            })) {
                var url = '/role/' + this.role.id + '/';

                SSky.put(url, this.roleEditForm)
                    .then(response => {
                        var data = this.roleEditForm.getData();
                        data.id = this.role.id;
                        this.$emit('role-updated', data);
                        this.roleEditForm.finishProcessing();
                    });
            } else {
                this.roleEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};