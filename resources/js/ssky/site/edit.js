module.exports = {

    props: {
        site: {
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
            siteEditForm: new SSky.Form({
                name: this.old.name || this.site.name || '',
            }),
        };
    },


    watch: {
        site: function (site) {
            this.siteEditForm.resetStatus();
            this.siteEditForm.name = site.name;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.siteEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSiteEditForm: function (event) {
            event.preventDefault();

            this.siteEditForm.startProcessing();

            if (this.siteEditForm.validate({
                'name': 'required|string|max:255',
            })) {
                var url = '/site/' + this.site.id + '/';

                SSky.put(url, this.siteEditForm)
                    .then(response => {
                        var data = this.siteEditForm.getData();
                        data.id = this.site.id;
                        this.$emit('site-updated', data);
                        this.siteEditForm.finishProcessing();
                    });
            } else {
                this.siteEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
