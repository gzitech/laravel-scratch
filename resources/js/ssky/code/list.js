module.exports = {

    props: {
        codes: {
            type: Array,
            required: true,
        }
    },

    data() {
        return {
            code: {},
        };
    },


    watch: {

    },

    created() {
        $(function () {
            codeCreateFormDialog = $('#code-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            codeEditFormDialog = $('#code-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (code) {
            return '/code/' + code.model_name;
        },
        showCodeCreateForm: function () {
            var url = '/code/create';
            history.pushState({}, "", url);
            codeCreateFormDialog.modal('show');
        },
        showCodeDestroyConfirm: function (code) {
            var url = '/code/' + code.model_name + '/';
            this.code = code;
            codeDestroyConfirm = $('#code-destroy-confirm');
            codeDestroyConfirm.find('form').attr('action', url);
            codeDestroyConfirm.modal('show');
        },
    },


    computed: {

    }
};
