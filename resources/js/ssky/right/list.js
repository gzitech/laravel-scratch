module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            right: {},
            rights: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            rightCreateFormDialog = $('#right-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            rightEditFormDialog = $('#right-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/right/' + id;
        },
        showRightCreateForm: function () {
            var url = '/right/create';
            history.pushState({}, "", url);
            rightCreateFormDialog.modal('show');
        },
        showRightEditForm: function (right) {
            var url = '/right/' + right.id + '/edit';
            history.pushState({}, "", url);
            this.right = right;
            rightEditFormDialog.modal('show');
        },
        showRightDestroyConfirm: function (right) {
            var url = '/right/' + right.id + '/';
            this.right = right;
            rightDestroyConfirm = $('#right-destroy-confirm');
            rightDestroyConfirm.find('form').attr('action', url);
            rightDestroyConfirm.modal('show');
        },
        updatedRight: function (right) {
            u = this.rights.find(u => u.id === right.id);
            if (u) {
                u.right_name = right.right_name;

                u.right_value = right.right_value;

                u.right_path = right.right_path;
            }

            rightEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};
