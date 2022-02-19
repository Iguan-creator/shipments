import {mapMutations, mapState} from 'vuex';

export default {
    data() {
        return {
            data: null,
            validation: '',
            isList: false,
            isMultipleList: false,
            wasValidated: false
        }
    },
    computed: {
        ...mapState(['editShipment']),
        request: function () {
            return `/app/${this.list}s`;
        }
    },
    methods: {
        ...mapMutations(['updateNewShipment']),
        updateData(empty = false) {
            let parameter = this.isList
                ? (this.isMultipleList ? this.list + 's' : this.list)
                : _.snakeCase(this.$options.name.slice(13));
            if (parameter.substr(parameter.length - 5) === 'small') {
                parameter = parameter.slice(0, -6);
            }
            if (parameter === 'hawb_number') {
                parameter = 'h_a_w_b_number';
            }
            if (parameter === 'mawb_number') {
                parameter = 'm_a_w_b_number';
            }
            let value = empty ? null : this.data;
            this.$store.commit('updateNewShipment', {parameter, value});
        },

    },
    updated() {
        this.updateData();
    },

    watch: {
        data: function () {
            if (this.isValidationRequired) {
                let match = String(this.data).match(this.validationPattern);
                this.validation = match ? 'is-valid' : 'is-invalid';
                if (match) {
                    if (!this.wasValidated) {
                        this.wasValidated = true;
                        this.$eventBus.$emit('validatedInput');
                    }
                    this.updateData();
                } else {
                    this.updateData(true);
                }
            } else {
                this.updateData();
            }
        }
    }
}
