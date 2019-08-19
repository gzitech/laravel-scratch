module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            siteUrl: {},
            siteUrls: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            siteUrlCreateFormDialog = $('#site-url-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            siteUrlEditFormDialog = $('#site-url-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/site/url/' + id;
        },
        showSiteUrlCreateForm: function () {
            var url = '/site/url/create';
            history.pushState({}, "", url);
            siteUrlCreateFormDialog.modal('show');
        },
        showSiteUrlEditForm: function (siteUrl) {
            var url = '/site/url/' + siteUrl.id + '/edit';
            history.pushState({}, "", url);
            this.siteUrl = siteUrl;
            siteUrlEditFormDialog.modal('show');
        },
        showSiteUrlDestroyConfirm: function (siteUrl) {
            var url = '/site/url/' + siteUrl.id + '/';
            this.siteUrl = siteUrl;
            siteUrlDestroyConfirm = $('#site-url-destroy-confirm');
            siteUrlDestroyConfirm.find('form').attr('action', url);
            siteUrlDestroyConfirm.modal('show');
        },
        updatedSiteUrl: function (siteUrl) {
            u = this.siteUrls.find(u => u.id === siteUrl.id);
            if (u) {
                u.site_id = siteUrl.site_id;

                u.domain = siteUrl.domain;
            }

            siteUrlEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};
