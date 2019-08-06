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
            rightCreateForm: new SSky.Form({
                right_name: this.old.right_name || '',
                right_value: this.old.right_value || '',
                right_path: this.old.right_path || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.rightCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateRightCreateForm: function (event) {

            this.rightCreateForm.startProcessing();
            
            if(!this.rightCreateForm.validate({
                'right_name': 'required|string|max:255',
                'right_value': 'required|string|max:255',
                'right_path': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.rightCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
