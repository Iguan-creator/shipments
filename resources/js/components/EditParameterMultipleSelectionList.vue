<template>
    <div class="mb-1">
        <h2>{{ header }}
            <button class="btn btn-primary btn-rounded"
                    data-toggle="tooltip"
                    data-placement="right" title=""
                    data-original-title="Добавить"
                    @click="addElement"
            >
                <plus-circle-icon></plus-circle-icon>
            </button>
        </h2>
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-12 p-0">
            <div class="mb-2 d-flex align-items-center"
                 v-for="(element, index) in data"
                 :key="index"
            >
                <div class="col-12 p-0">
                    <span class="small" v-if="isPlace && isRoute && index === 0 && index !== data.length - 1"> {{
                            index + 1
                        }} {{ elementName }} отправления </span>
                    <span class="small" v-if="isPlace && isRoute && index > 0 && index !== data.length - 1"> {{
                            index + 1
                        }}  {{ elementName }}  отправления </span>
                    <span class="small" v-if="!isPlace && isRoute && index === 0 && index !== data.length - 1"> {{
                            index + 1
                        }} {{ header }} {{ elementName }} </span>
                    <span class="small" v-if="!isPlace && isRoute && index > 0 && index !== data.length - 1"> {{
                            index + 1
                        }} {{ header }} {{ elementName }}</span>
                    <span class="small" v-if="!isPlace && isRoute && index === data.length - 1 "> {{
                            index + 1
                        }} {{ header }} {{ elementName }}</span>
                    <span class="small" v-if="isPlace && isRoute && index === data.length - 1 "> {{ elementName }} прибытия </span>
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
                <div class="col-12">
                    <button class="btn btn-danger btn-rounded btn-sm"
                            v-if="data.length > 1"
                            type="button"
                            @click="deleteElement(element)"
                    >
                        <minus-circle-icon></minus-circle-icon>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {PlusCircleIcon, MinusCircleIcon} from 'vue-feather-icons';

export default {
    name: "EditParameterMultipleSelectionList",
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
