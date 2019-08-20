module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            site: {},
            sites: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            siteCreateFormDialog = $('#site-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            siteEditFormDialog = $('#site-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/site/' + id;
        },
        siteUrl: function (site, domain) {
            return '//' + site.name + '.' + domain;
        },
        showSiteCreateForm: function () {
            var url = '/site/create';
            history.pushState({}, "", url);
            siteCreateFormDialog.modal('show');
        },
        showSiteDestroyConfirm: function (site) {
            var url = '/site/' + site.id + '/';
            this.site = site;
            siteDestroyConfirm = $('#site-destroy-confirm');
            siteDestroyConfirm.find('form').attr('action', url);
            siteDestroyConfirm.modal('show');
        },
    },


    computed: {

    }
};
