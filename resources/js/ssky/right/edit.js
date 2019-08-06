module.exports = {

    props: {
        right: {
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
            rightEditForm: new SSky.Form({
                right_name: this.old.right_name || this.right.right_name || '',

                right_value: this.old.right_value || this.right.right_value || '',

                right_path: this.old.right_path || this.right.right_path || '',
            }),
        };
    },


    watch: {
        right: function (right) {
            this.rightEditForm.resetStatus();
            this.rightEditForm.right_name = right.right_name;

            this.rightEditForm.right_value = right.right_value;

            this.rightEditForm.right_path = right.right_path;
        }
    },

    created() {

        if (typeof this.errors === 'object') {
            this.rightEditForm.setErrors(this.errors);
        }
    },


    methods: {

        validateRightEditForm: function (event) {
            event.preventDefault();

            this.rightEditForm.startProcessing();

            if (this.rightEditForm.validate({
                'right_name': 'required|string|max:255',
                'right_value': 'required|string|max:255',
                'right_path': 'required|string|max:255',
            })) {
                var url = '/right/' + this.right.id + '/';

                SSky.put(url, this.rightEditForm)
                    .then(response => {
                        var data = this.rightEditForm.getData();
                        data.id = this.right.id;
                        this.$emit('right-updated', data);
                        this.rightEditForm.finishProcessing();
                    });
            } else {
                this.rightEditForm.finishProcessing();
            }
        },
    },


    computed: {

    }
};
