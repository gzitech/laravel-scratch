module.exports = {

    props: {
        paginate: {
            type: Object,
            required: true,
        }
    },

    data() {
        return {
            settingProfile: {},
            settingProfiles: this.paginate.data,
        };
    },


    watch: {

    },

    created() {
        $(function () {
            settingProfileCreateFormDialog = $('#setting-profile-create-form').on('hidden.bs.modal', function () {
                history.back();
            });

            settingProfileEditFormDialog = $('#setting-profile-edit-form').on('hidden.bs.modal', function () {
                history.back();
            });
        });
    },


    methods: {
        showUrl: function (id) {
            return '/setting/profile/' + id;
        },
        showSettingProfileCreateForm: function () {
            var url = '/setting/profile/create';
            history.pushState({}, "", url);
            settingProfileCreateFormDialog.modal('show');
        },
        showSettingProfileEditForm: function (settingProfile) {
            var url = '/setting/profile/' + settingProfile.id + '/edit';
            history.pushState({}, "", url);
            this.settingProfile = settingProfile;
            settingProfileEditFormDialog.modal('show');
        },
        showSettingProfileDestroyConfirm: function (settingProfile) {
            var url = '/setting/profile/' + settingProfile.id + '/';
            this.settingProfile = settingProfile;
            settingProfileDestroyConfirm = $('#setting-profile-destroy-confirm');
            settingProfileDestroyConfirm.find('form').attr('action', url);
            settingProfileDestroyConfirm.modal('show');
        },
        updatedSettingProfile: function (settingProfile) {
            u = this.settingProfiles.find(u => u.id === settingProfile.id);
            if (u) {
                u.name = settingProfile.name;

                u.description = settingProfile.description;
            }

            settingProfileEditFormDialog.modal('hide');
        }
    },


    computed: {

    }
};
