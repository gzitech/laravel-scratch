module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            role: {},
            roles: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            roleCreateFormDialog = $('#role-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            roleEditFormDialog = $('#role-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/role/' + id;
        },
        showRoleCreateForm: function () {
            var url = '/role/create';
            history.pushState({}, "", url);
            roleCreateFormDialog.modal('show');
        },
        showRoleEditForm: function (role) {
            var url = '/role/' + role.id + '/edit';
            history.pushState({}, "", url);
            this.role = role;
            roleEditFormDialog.modal('show');
        },
        showRoleDestroyConfirm: function (role) {
            var url = '/role/' + role.id + '/';
            this.role = role;
            roleDestroyConfirm = $('#role-destroy-confirm');
            roleDestroyConfirm.find('form').attr('action', url);
            roleDestroyConfirm.modal('show');
        },
        updatedRole: function (role) {
            u = this.roles.find(u => u.id === role.id);
            if (u) {
                u.role_name = role.role_name;

                u.role_description = role.role_description;
            }

            roleEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};
