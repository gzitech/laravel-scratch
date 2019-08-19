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
            siteCreateForm: new SSky.Form({
                name: this.old.name || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.siteCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSiteCreateForm: function (event) {

            this.siteCreateForm.startProcessing();
            
            if(!this.siteCreateForm.validate({
                'name': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.siteCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
