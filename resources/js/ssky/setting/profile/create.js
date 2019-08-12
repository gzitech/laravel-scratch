module.exports = {

    props: {
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
            settingProfileCreateForm: new SSky.Form({
                name: this.old.name || '',
                description: this.old.description || '',
            }),
        };
    },


    watch: {

    },

    created() {
        
        if (this.errors && (typeof this.errors === 'object')) {
            this.settingProfileCreateForm.setErrors(this.errors);
        }
    },


    methods: {

        validateSettingProfileCreateForm: function (event) {

            this.settingProfileCreateForm.startProcessing();
            
            if(!this.settingProfileCreateForm.validate({
                'name': 'required|string|max:255',
                'description': 'required|string|max:255',
            })) {
                event.preventDefault();
                this.settingProfileCreateForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
