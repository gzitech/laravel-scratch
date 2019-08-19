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
            siteUrlCreateForm: new SSky.Form({
                site_id: this.old.site_id || '',
                domain: this.old.domain || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.siteUrlCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSiteUrlCreateForm: function (event) {

            this.siteUrlCreateForm.startProcessing();
            
            if(!this.siteUrlCreateForm.validate({
                'site_id': 'required|string|max:255',
                'domain': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.siteUrlCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
