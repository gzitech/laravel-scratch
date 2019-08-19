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
        showSiteCreateForm: function () {
            var url = '/site/create';
            history.pushState({}, "", url);
            siteCreateFormDialog.modal('show');
        },
        showSiteEditForm: function (site) {
            var url = '/site/' + site.id + '/edit';
            history.pushState({}, "", url);
            this.site = site;
            siteEditFormDialog.modal('show');
        },
        showSiteDestroyConfirm: function (site) {
            var url = '/site/' + site.id + '/';
            this.site = site;
            siteDestroyConfirm = $('#site-destroy-confirm');
            siteDestroyConfirm.find('form').attr('action', url);
            siteDestroyConfirm.modal('show');
        },
        updatedSite: function (site) {
            u = this.sites.find(u => u.id === site.id);
            if (u) {
                u.name = site.name;
            }

            siteEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};
