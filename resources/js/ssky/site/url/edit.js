module.exports = {

    props: {
        site_url: {
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
            siteUrlEditForm: new SSky.Form({
                site_id: this.old.site_id || this.site_url.site_id || '',

                domain: this.old.domain || this.site_url.domain || '',
            }),
        };
    },


    watch: {
        site_url: function (siteUrl) {
            this.siteUrlEditForm.resetStatus();
            this.siteUrlEditForm.site_id = siteUrl.site_id;

            this.siteUrlEditForm.domain = siteUrl.domain;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.siteUrlEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSiteUrlEditForm: function (event) {
            event.preventDefault();

            this.siteUrlEditForm.startProcessing();

            if (this.siteUrlEditForm.validate({
                'site_id': 'required|string|max:255',
                'domain': 'required|string|max:255',
            })) {
                var url = '/site/url/' + this.site_url.id + '/';

                SSky.put(url, this.siteUrlEditForm)
                    .then(response => {
                        var data = this.siteUrlEditForm.getData();
                        data.id = this.site_url.id;
                        this.$emit('site-url-updated', data);
                        this.siteUrlEditForm.finishProcessing();
                    });
            } else {
                this.siteUrlEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
