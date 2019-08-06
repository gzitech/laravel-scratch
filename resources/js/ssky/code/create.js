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
            codeCreateForm: new SSky.Form({
                model_name: this.old.model_name || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.codeCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateCodeCreateForm: function (event) {

            this.codeCreateForm.startProcessing();
            
            if(!this.codeCreateForm.validate({
                'model_name': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.codeCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
