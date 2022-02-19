<template>
    <div class="mb-5">
        <h2>{{ header }}</h2>
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 p-0">
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
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";

export default {
    name: "EditParameterSelectionList",
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

