module.exports = {

    props: {
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
            roleCreateForm: new SSky.Form({
                role_name: this.old.role_name || '',
                role_description: this.old.role_description || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.roleCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateRoleCreateForm: function (event) {

            this.roleCreateForm.startProcessing();
            
            if(!this.roleCreateForm.validate({
                'role_name': 'required|string|max:255',
                'role_description': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.roleCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};