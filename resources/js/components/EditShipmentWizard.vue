<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h3 class="mb-1 mt-0">
                    {{
                        isEditOnly
                            ? 'Редактировать перевозку № ' +
                            (editShipment.position_number ? editShipment.position_number : 'Нет номера')
                            : 'Новая перевозка'
                    }}
                    <button v-if="isEditOnly" class="btn btn-sm btn-primary"
                            data-toggle="modal" data-target="#copy-fields-selection"
                    ><i data-feather="copy"></i>
                    </button>
                </h3>
                <div class="card">
                    <div class="card-body">
                        <h4>Тип перевозки</h4>
                        <select
                            v-model="selectedType"
                            id="shipment_type_select"
                            class="custom-select custom-select-lg mb-2"
                        >
                            <option value="0">Выберите тип перевозки</option>
                            <option v-for="type in types" :value="type.id" :key="type.id">{{ type.name }}</option>
                        </select>
                        <div :class="{'d-none': !typeRetrieved}" id="main-form">
                            <h4 id="data_header">Данные</h4>
                            <form-wizard
                                @on-change="change"
                                @on-complete="complete"
                                ref="formWizard"
                                v-if="typeRetrieved"
                                title=""
                                subtitle=""
                                nextButtonText="Далее"
                                backButtonText="Назад"
                                finishButtonText="В начало"
                                color="#5369f8"
                                shape="square"
                                stepSize="xs"
                                :startIndex="isEdit ? type.parameters.length + 1 : 0"
                            >
                                <tab-content
                                    v-for="parameter in type.parameters"
                                    :key="parameter.id"
                                    :title="parameter.short"
                                >
                                    <div class="py-3">
                                        <component
                                            :is="getComponentName(parameter.table)"
                                            :isEdit="isEdit"
                                            :type_id="type.id"
                                        ></component>
                                    </div>
                                </tab-content>
                                <tab-content title="Даты">
                                    <edit-parameter-dates :isEdit="isEdit"></edit-parameter-dates>
                                </tab-content>
                                <tab-content title="Коммент">
                                    <edit-parameter-comment :isEdit="isEdit"></edit-parameter-comment>
                                </tab-content>
                            </form-wizard>
                            <div class="d-flex flex-row-reverse">
                                <div>
                                    <button class="btn btn-lg my-3" @click="saveShipment"
                                            :class="saved ? 'btn-soft-success' : (unfilledRequired ? 'btn-warning' : 'btn-success')">
                                        <span v-if="saved">Изменения сохранены</span>
                                        <span v-else-if="unfilledRequired">Не заполнены обязательные поля</span>
                                        <span v-else>Сохранить {{ isEditOnly ? 'изменения' : 'перевозку' }}</span>
                                    </button>
                                </div>

                                <div v-if="unfilledRequired" class="d-flex align-items-center mr-1">
                                    <div class="text-danger">
                                        <span v-for="field in unfilledFields">
                                            {{ allFields.find(value => value.id === field).singular_name }};
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="isEditOnly" class="modal fade" id="copy-fields-selection" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Выберите поля для копирования</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-for="parameter in allFields" :key="parameter.id"
                             class="custom-control custom-checkbox mb-1">
                            <input type="checkbox" class="custom-control-input"
                                   :id="'parameter-' + parameter.id"
                                   v-model="copyFields"
                                   :value="parameter.table"
                                   checked
                            >
                            <label class="custom-control-label" :for="'parameter-' + parameter.id">
                                {{
                                    parameter.table.charAt(parameter.table.length - 1) === 's' ? parameter.plural_name : parameter.singular_name
                                }}
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="copy">Копировать</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {FormWizard, TabContent} from 'vue-form-wizard'
import EditParameterAirports from "./EditParameterAirports";
import EditParameterBatchSize from "./EditParameterBatchSize";
import EditParameterBookingNumber from "./EditParameterBookingNumber";
import EditParameterBatchWeight from "./EditParameterBatchWeight";
import EditParameterCar from "./EditParameterCar";
import EditParameterCarriageNumber from "./EditParameterCarriageNumber";
import EditParameterClient from "./EditParameterClient";
import EditParameterComment from "./EditParameterComment";
import EditParameterContainer from "./EditParameterContainer";
import EditParameterContainerNumber from "./EditParameterContainerNumber";
import EditParameterContractors from "./EditParameterContractors";
import EditParameterDates from "./EditParameterDates";
import EditParameterDeliveryCondition from "./EditParameterDeliveryCondition";
import EditParameterDeliveryPlaces from "./EditParameterDeliveryPlaces";
import EditParameterHAWBNumber from "./EditParameterHAWBNumber";
import EditParameterLoadPlaces from "./EditParameterLoadPlaces";
import EditParameterMAWBNumber from "./EditParameterMAWBNumber";
import EditParameterPorts from "./EditParameterPorts";
import EditParameterPositionNumber from "./EditParameterPositionNumber";
import EditParameterSpotQuantity from "./EditParameterSpotQuantity";
import EditParameterStations from "./EditParameterStations";
import EditParameterTransportDocNumber from "./EditParameterTransportDocNumber";
import EditParameterReceivers from "./EditParameterReceivers";
import EditParameterSenders from "./EditParameterSenders";
import EditParameterMultipleSelectionList from './EditParameterMultipleSelectionList';

import {mapMutations, mapState} from "vuex";

export default {
    name: "EditShipmentWizard",
    components: {
        FormWizard,
        TabContent,
        EditParameterAirports,
        EditParameterBatchSize,
        EditParameterBookingNumber,
        EditParameterBatchWeight,
        EditParameterCar,
        EditParameterCarriageNumber,
        EditParameterClient,
        EditParameterComment,
        EditParameterContainer,
        EditParameterContainerNumber,
        EditParameterContractors,
        EditParameterDates,
        EditParameterDeliveryCondition,
        EditParameterDeliveryPlaces,
        EditParameterHAWBNumber,
        EditParameterLoadPlaces,
        EditParameterMAWBNumber,
        EditParameterPorts,
        EditParameterPositionNumber,
        EditParameterSpotQuantity,
        EditParameterStations,
        EditParameterTransportDocNumber,
        EditParameterReceivers,
        EditParameterSenders,
        EditParameterMultipleSelectionList
    },
    props: ['isEdit', 'isCopy'],
    data() {
        return {
            allFields: [],
            type: {},
            types: {},
            typeRetrieved: false,
            selectedType: 0,
            isWithStations: false,
            saved: false,
            requiredParameters: [],
            unfilledRequired: false,
            unfilledFields: [],
            copyFields: [],
        }
    },
    computed: {
        ...mapState(['editShipment', 'newShipment']),
        isEditOnly: function () {
            return this.isEdit && !this.isCopy;
        }
    },
    methods: {
        ...mapMutations(['cleanNewShipment', 'setNewShipment', 'updateNewShipment', 'setEditShipment', 'setTypeId']),
        copy() {
            $('#copy-fields-selection').modal('hide');
            let allFieldsNames = this.allFields.map(value => value.table);
            let notIncludedParameters = allFieldsNames.filter(value => !this.copyFields.includes(value));
            notIncludedParameters.forEach(parameter => this.editShipment[parameter] = null);
            this.$router.push({name: 'CreateCopy'});
        },
        filterType(type) {
            let dates = type.parameters.filter(value => value.table.includes('_date'));
            let comment = type.parameters.filter(value => value.table === 'comment');
            type.parameters = type.parameters.filter(value => !value.table.includes('_date'));
            type.parameters = type.parameters.filter(value => value.table !== 'comment');
            type.dates = dates;
            type.comment = comment[0];
            return type;
        },
        getComponentName(name) {
            return 'edit-parameter-' + _.kebabCase(name);
        },
        saveShipment() {
            let hasUnfilledRequired = false;
            this.unfilledFields = [];
            this.requiredParameters.forEach(parameter => {
                let stateShipment = this.newShipment;
                let isUnfilled = false;
                if (!stateShipment[parameter.table]) {
                    isUnfilled = true;
                } else if (Array.isArray(stateShipment[parameter.table])) {
                    let isUnfilled = true;
                    stateShipment[parameter.table].forEach(array_element => {
                        let index = parameter.table.slice(0, -1) + '_id';
                        if (array_element[index]) {
                            isUnfilled = false;
                        }
                    });
                }

                if (isUnfilled) {
                    hasUnfilledRequired = true;
                    this.unfilledFields.push(parameter.id);
                }
            });

            if (hasUnfilledRequired) {
                this.unfilledRequired = true;
                setTimeout(() => this.unfilledRequired = false, 5000);
                return;
            }

            if (this.isEditOnly) {
                axios.patch('/app/shipments/' + this.editShipment.id, this.newShipment)
                    .then(response => {
                        if (response.data === 'Success') {
                            this.saved = true;
                            setTimeout(() => this.saved = false, 1000);
                        }
                    });
            } else {
                axios.post('/app/shipments', this.newShipment)
                    .then(response => {
                        this.$router.push({name: 'Edit', params: {id: response.data}});
                    });
            }
        },
        complete() {
            this.$refs.formWizard.changeTab(0, 0);
        },

        change(prevIndex, nextIndex) {
            if (this.$refs.formWizard.tabs[nextIndex].title === 'Даты') {
                this.$nextTick(() => {
                    document.getElementById('load_date').focus();
                })
            }
        }
    },
    created() {
        axios.get('/app/types')
            .then(response => {
                if (response.status === 200) {
                    this.types = response.data
                }
            })
        if (this.isEditOnly) {
            axios.get('/app/shipments/' + this.$route.params.id)
                .then(response => {
                    if (response.status === 200) {
                        this.setEditShipment(response.data)
                        this.selectedType = this.editShipment.type_id
                    }
                })
        } else if (this.isCopy) {
            this.selectedType = this.editShipment.type_id
        }
    },
    mounted() {
        feather.replace()
        window.addEventListener('keyup', event => {
            if (event.code === 'Tab') {
                this.$refs.formWizard.nextTab()
            }

            if (event.code === 'Escape') {
                this.$refs.formWizard.prevTab()
            }
        })
    },
    watch: {
        selectedType: function (newSelectedType) {
            this.typeRetrieved = false
            if (this.isEdit && newSelectedType !== this.editShipment.type_id) {
                this.changeTypeShipment = confirm('Вы действительно хотите поменять тип перевозки?')
                this.selectedType = this.changeTypeShipment ? newSelectedType : this.editShipment.type_id
                newSelectedType = this.selectedType
            }
            if (newSelectedType > 0) {
                axios.get('/app/types/' + newSelectedType)
                    .then(response => {
                        if (response.status === 200) {
                            this.allFields = response.data.parameters
                            this.type = this.filterType(response.data)
                            this.typeRetrieved = true
                            const deepCloneNewShipment = JSON.parse(JSON.stringify(this.newShipment))
                            this.cleanNewShipment()
                            this.updateNewShipment({parameter: 'type_id', value: this.type.id})
                            this.setTypeId(this.type.id)

                            let required = this.allFields.filter(value => !!value.required)
                            this.requiredParameters = required.map(value => {
                                return {id: value.id, table: value.table}
                            })
                            this.allFields.forEach(parameter => {
                                if (parameter.table !== 'comment') {
                                    this.copyFields.push(parameter.table)
                                }
                            })

                            if (this.changeTypeShipment) {
                                axios.get('/app/parameters/' + newSelectedType + '/type')
                                    .then(response => {
                                        if (response.status === 200) {
                                            response.data.forEach(element => {
                                                this.newShipment[element.table] = deepCloneNewShipment[element.table]
                                                    ? deepCloneNewShipment[element.table]
                                                    : (element.table.slice(-1) === 's' ? [] : null);
                                            })
                                            axios.post('/app/shipments', this.newShipment)
                                                .then(response => {
                                                    if (response.status === 200) {
                                                        axios.delete('/app/shipments/' + this.editShipment.id)
                                                            .then(response => {
                                                                if (response.data === 'Success') {
                                                                    this.saved = true
                                                                    setTimeout(() => this.saved = false, 1000)
                                                                }
                                                            })
                                                        this.$router.push({name: 'Edit', params: {id: response.data}})
                                                    }
                                                })
                                        }
                                    })
                            }
                        }
                    })
            }
        }
    },
}
</script>

<style>
@import '~vue-form-wizard/dist/vue-form-wizard.min.css';
</style>
