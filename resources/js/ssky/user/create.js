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
            userCreateForm: new SSky.Form({
                first_name: this.old.first_name || '',
                last_name: this.old.last_name || '',
                email: this.old.email || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if(this.errors && (typeof this.errors === 'object')) {
            this.userCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateUserCreateForm: function (event) {

            this.userCreateForm.startProcessing();
            
            if(!this.userCreateForm.validate({
                'first_name': 'required|string|max:255',
                'last_name': 'required|string|max:255',
                'email': 'required|string|email|max:255',
            })) {
                event.preventDefault();
                this.userCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};