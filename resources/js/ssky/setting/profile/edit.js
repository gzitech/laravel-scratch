module.exports = {

    props: {
        setting_profile: {
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
            settingProfileEditForm: new SSky.Form({
                name: this.old.name || this.setting_profile.name || '',

                description: this.old.description || this.setting_profile.description || '',
            }),
        };
    },


    watch: {
        setting_profile: function (settingProfile) {
            this.settingProfileEditForm.resetStatus();
            this.settingProfileEditForm.name = settingProfile.name;

            this.settingProfileEditForm.description = settingProfile.description;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.settingProfileEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSettingProfileEditForm: function (event) {
            event.preventDefault();

            this.settingProfileEditForm.startProcessing();

            if (this.settingProfileEditForm.validate({
                'name': 'required|string|max:255',
                'description': 'required|string|max:255',
            })) {
                var url = '/setting/profile/' + this.setting_profile.id + '/';

                SSky.put(url, this.settingProfileEditForm)
                    .then(response => {
                        var data = this.settingProfileEditForm.getData();
                        data.id = this.setting_profile.id;
                        this.$emit('setting-profile-updated', data);
                        this.settingProfileEditForm.finishProcessing();
                    });
            } else {
                this.settingProfileEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
