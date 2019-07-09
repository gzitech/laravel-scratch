module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            user: {},
            users: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            userCreateFormDialog = $('#user-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            userEditFormDialog = $('#user-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/user/' + id;
        },
        showUserCreateForm: function () {
            var url = '/user/create';
            history.pushState({}, "", url);
            userCreateFormDialog.modal('show');
        },
        showUserEditForm: function (user) {
            var url = '/user/' + user.id + '/edit';
            history.pushState({}, "", url);
            this.user = user;
            userEditFormDialog.modal('show');
        },
        showUserDestroyConfirm: function (user) {
            var url = '/user/' + user.id + '/';
            this.user = user;
            userDestroyConfirm = $('#user-destroy-confirm');
            userDestroyConfirm.find('form').attr('action', url);
            userDestroyConfirm.modal('show');
        },
        updatedUser: function (user) {
            u = this.users.find(u => u.id === user.id);
            if (u) {
                u.first_name = user.first_name;
                u.last_name = user.last_name;
                u.email = user.email;
            }

            userEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};