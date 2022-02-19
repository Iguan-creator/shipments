<template>
    <div>
        <v-select
            append-to-body
            v-model="data"
            label="name"
            :options="variants"
            :reduce="variant => variant.id"
        >
            <div slot="no-options">Ничего не найдено</div>
        </v-select>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";

export default {
    name: "EditParameterSelectionListSmall",
    mixins: [editParameter],
    data() {
        return {
            isValidationRequired: false,
            variants: [],
            isList: true
        }
    },
    props: {
        header: {
            type: String,
            required: true
        },
        list: {
            type: String,
            required: true
        },
        isEdit: {
            required: false
        },
        type_id: {
            required: false
        },
        clientDependent: {
            default: false
        }
    },
    methods: {
        variantsUpdate(request) {
            axios.get(request)
                .then(response => {
                    if (response.status === 200) {
                        let response_data = response.data;
                        if (this.type_id === 9 && this.list === 'container') {
                            response_data.unshift({id: '', name: 'Нет'});
                        }
                        this.variants = response_data;
                    }
                })
        }
    },
    created() {
        this.$eventBus.$on('clientChanged', (client_id) => {
            if (this.clientDependent) {
                this.variantsUpdate(`${this.request}/${client_id}/client`);
            }
        });
        let request = this.request;

        if (this.type_id) {
            request += `/${this.type_id}/type`
        }
        this.variantsUpdate(request);

        if (this.isEdit) {
            this.data = this.editShipment[this.list] ? this.editShipment[this.list].id : null;
        }

    },
    updated() {
        if (this.data) {
            this.$eventBus.$emit('validatedInput');

        }
    },
    watch: {
        data() {
            if (this.list === 'client') {
                this.$eventBus.$emit('clientChanged', this.data);
            }

        }
    }
}
</script>

<style scoped>
.vs__search, .vs__search:focus {
    line-height: 2;
}
</style>

