<template>
    <div class="mb-0">
        <button class="btn btn-outline-primary btn-rounded btn-sm mb-1"
                data-toggle="tooltip"
                data-placement="right" title=""
                data-original-title="Добавить"
                @click="addElement"
        >
            <plus-circle-icon></plus-circle-icon>
        </button>
        <div class="mb-1 d-flex align-items-center"
             v-for="(element, index) in data"
             :key="index"
        >
            <div class="p-0 col-10">
                <v-select
                    v-model="element[list + '_id']"
                    append-to-body
                    label="name"
                    :options="variants"
                    :reduce="variants => variants.id"
                >
                    <div slot="no-options">Таких значений не найдено</div>
                </v-select>
            </div>
            <div class="col-2 text-right p-0">
                <button class="btn btn-outline-danger btn-rounded btn-sm"
                        v-if="data.length > 1"
                        type="button"
                        @click="deleteElement(element)"
                >
                    <minus-circle-icon></minus-circle-icon>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {PlusCircleIcon, MinusCircleIcon} from 'vue-feather-icons';

export default {
    name: "EditParameterMultipleSelectionListSmall",
    components: {PlusCircleIcon, MinusCircleIcon},
    mixins: [editParameter],
    data() {
        return {
            isValidationRequired: false,
            variants: [],
            isList: true,
            isMultipleList: true,
            data: []
        }
    },
    props: {
        header: {
            type: String,
            required: true,
        },
        elementName: {
            type: String,
            required: false,
            default: '',
        },
        list: {
            type: String,
            required: true,
        },
        isEdit: {
            required: false,
        },
        isRoute: {
            required: false,
            default: false
        },
        isPlace: {
            default: true
        },
        type_id: {
            required: false
        },
        clientDependent: {
            default: false
        }
    },
    methods: {
        addElement() {
            let nullElement = {};
            nullElement[this.list + '_id'] = null;
            this.data.push(nullElement);
        },
        deleteElement(value) {
            const index = this.data.indexOf(value);
            if (index > -1) {
                this.data.splice(index, 1);
            }
        },
    },
    created() {
        let request = this.request;
        if (this.type_id) {
            request += `/${this.type_id}/type`
        }
        axios.get(request)
            .then(response => {
                if (response.status === 200) {
                    this.variants = response.data;
                }
            });
        if (this.isEdit) {
            this.data = this.editShipment[this.list + 's'].map(value => {
                let new_element = {}
                let index = this.list + '_id'
                new_element[index] = value.id
                return new_element
            })
        }
    },
    mounted() {
        if (!this.isEdit || this.data.length === 0) {
            this.addElement();
            if (this.isRoute) {
                this.addElement();
            }
        }
    }
}
</script>

<style scoped>

</style>
