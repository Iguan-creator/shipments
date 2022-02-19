<template>
    <div class="card">
        <div class="card-body">
            <div class="btn-group ml-30 float-right">
                <button type="button"
                        class="btn"
                        :class="[filter_shipments !== 0 ? 'btn btn-white' :'btn btn-warning']"
                        @click="all_true">Все
                </button>

                <button type="button"
                        class="btn"
                        :class="[filter_shipments !== 1 ? 'btn btn-white' :'btn btn-warning']"
                        @click="current_true">Текущие
                </button>

                <button type="button"
                        class="btn"
                        :class="[filter_shipments !== 2 ? 'btn btn-white' :'btn btn-warning']"
                        @click="archive_true">Архив
                </button>

            </div>
            <div class="form-row">
                <div class="form-group-row mr-2">
                    <input class="form-control" type="text" v-model.lazy="search">
                </div>
                <div class="form-group-row">
                    <button class="btn btn-primary" @click="searchAll">
                        <div v-if="searching">
                            <div class="spinner-grow" style="width: 20px; height: 20px"></div>
                            <div class="spinner-grow" style="width: 20px; height: 20px"></div>
                            <div class="spinner-grow" style="width: 20px; height: 20px"></div>
                        </div>
                        <span v-else>Глобальный поиск</span>
                    </button>
                </div>
            </div>
            <form class="form-inline mt-2">
                <div class="form-group mb-2">
                    <div class="input-group mr-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">С</span>
                        </div>
                        <input type="date" class="form-control" v-model="from">
                    </div>
                    <div class="input-group mr-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">По</span>
                        </div>
                        <input type="date" class="form-control" v-model="to">
                    </div>
                    <button @click.prevent="updateShipments" class="btn btn-primary">Обновить период</button>
                </div>
            </form>
            <ul class="nav nav-tabs" id="types-tab" role="tablist">
                <li v-for="type in types" class="nav-item">
                    <a class="nav-link"
                       :class="type.id === 1 ? 'active' : ''"
                       data-toggle="tab"
                       :href="'#type-' + type.id"
                       @click="load(type.id)"
                       role="tab">
                        {{ type.name }}
                    </a>
                </li>
            </ul>
            <div class="dataLength badge badge-success float-right"> Перевозок всего: {{ dataLength }}</div>
            <div class="tab-content" id="types">
                <div v-for="type in types" :id="'type-' + type.id" class="tab-pane fade show"
                     :class="type.id === 1 ? 'active' : ''" role="tabpanel">
                    <table :id="'shipments-datatable-' + type.id"
                           v-if="shipments[type.id] && isNotUpdating"
                           class="shipments-table table table-sm table-striped table-bordered small">
                        <thead>
                        <draggable v-model="parameters[type.id]" tag="tr">
                            <th scope="col" v-for="parameter in parameters[type.id]" :key="parameter.id"
                            >{{ parameter.short }}
                            </th>
                            <th v-if="with_name">Сотрудник</th>
                            <th v-if="with_delete"></th>
                        </draggable>
                        </thead>
                        <tbody>
                        <tr v-for="shipment in shipments[type.id]" :key="shipment.id"
                            :class="{'table-warning': shipment.documents_sent && !shipment.finished ,'table-success': shipment.finished}">
                            <td class="align-middle" v-for="parameter in parameters[type.id]" :key="parameter.id"
                            ><span v-if="parameter.table === 'position_number'" class="d-none"
                            >{{ formatData(shipment[parameter.table], parameter.table) }}</span>
                                <router-link :to="{name: to_card ? 'Shipment' : 'Edit', params: {id: shipment.id}}"
                                             v-if="parameter.table === 'position_number'"
                                >{{ formatData(shipment[parameter.table], parameter.table) }}
                                </router-link>
                                <span v-else
                                >{{ formatData(shipment[parameter.table], parameter.table) }}</span>
                            </td>
                            <td class="align-middle" v-if="with_name"
                            >{{ shipment.user.last_name + ' ' + shipment.user.first_name }}
                            </td>
                            <td v-if="with_delete" class="align-middle">
                                <span @click="deleteShipment(shipment, type.id)"
                                      class="pointer text-danger">&#10006;</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <app-data-loader v-else></app-data-loader>
                </div>
            </div>
            <div class="row justify-content-start">
                <div class="col-xl-2 col-md-6 badge py-2 px-lg-2 table-success">Акты сделаны, перевозка закрыта</div>
                <div class="col-xl-3 col-md-6 badge py-2 px-lg-2 table-warning">Закрывающие сделаны, на проверке в
                    бухгалтерии
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import dataTablesSettings from "../data/datatables_standard_settings"
import AppDataLoader from "./AppDataLoader";
import formatData from "../mixins/formatData";
import setDates from "../mixins/setDates";
import {MinusCircleIcon} from 'vue-feather-icons';

export default {
    name: "ShipmentsView",
    order: 30,
    components: {AppDataLoader, MinusCircleIcon, draggable},
    mixins: [formatData, setDates],
    props: {
        request: {default: ''},
        to_card: {default: false},
        with_name: {default: false},
        with_delete: {default: false},
    },
    data() {
        return {
            dragging: false,
            parameterSettings: [],
            dataLength: 0,
            filter_shipments: 0,
            button_archive: true,
            button_all: true,
            button_current: true,
            isNotUpdating: true,
            bookmark_type: 1,
            from: '',
            to: '',
            types: [],
            shipments: [],
            parameters: [],
            search: '',
            searching: false,
            full_load: false,
            exclude_values: [
                'comment',
                'sender',
                'receiver'
            ]
        }
    },

    methods: {

        archive_true() {
            this.filter_shipments = 2;
            this.finished = true;
            this.updateShipments();

        },

        all_true() {
            this.filter_shipments = 0;
            this.finished = null;
            this.updateShipments();
        },

        current_true() {
            this.filter_shipments = 1;
            this.finished = false;
            this.updateShipments();
        },

        updateShipments() {
            this.$nextTick(() => {
                this.dataTablesDestroyAll();
                this.shipments = [];
                this.isNotUpdating = false;
                this.load(this.bookmark_type);
                $(`#types-tab li:nth-child(${this.bookmark_type}) a`).tab('show');
            });
        },
        load(type_id) {
            this.bookmark_type = type_id;
            if (this.parameters[type_id] === undefined) {
                axios
                    .get('/app/parameters/' + type_id + '/type')
                    .then(response => {
                        let data;

                        if (this.parameterSettings.length) {
                            data = this.parameterSettings.filter(parameter => {
                                return response.data.findIndex(element => element.id === parameter.id) !== -1;
                            });
                        } else {
                            data = response.data;
                        }
                        this.$set(this.parameters, type_id, data);
                    });

            }

            if (this.shipments[type_id] === undefined) {
                let request = '/app/shipments/' + type_id + '/type' + (this.request ? '/' : '') + this.request;

                let data = {from: this.from, to: this.to};

                if (this.finished !== null) {
                    data.finished = this.finished;
                }

                axios
                    .post(request, data)
                    .then(response => {
                        this.$set(this.shipments, type_id, response.data);
                        this.dataTableIni(type_id);
                        if (!this.isNotUpdating) {
                            this.isNotUpdating = true;
                        }
                        this.dataLength = this.shipments[type_id].length;
                    });
            } else {
                this.dataLength = this.shipments[type_id].length;
            }

        },

        loadAll() {
            let unloaded_types = [];
            this.searching = true;
            this.types.forEach(type => {
                if (this.shipments[type.id] === undefined) {
                    unloaded_types.push(type.id);
                }
            });
            let requests = [];
            let type_requests = [];
            unloaded_types.forEach(type_id => {
                let current_request = '/app/shipments/' + type_id + '/type' + (this.request ? '/' : '') + this.request;

                let data = {from: this.from, to: this.to};

                if (this.finished !== null) {
                    data.finished = this.finished;
                }

                requests.push(axios.post(current_request, data));
                type_requests.push(axios.get('/app/parameters/' + type_id + '/type'));
            });
            axios.all(type_requests).then(axios.spread((...responses) => {
                let index = 0;
                unloaded_types.forEach(type_id => {
                    let parametersData = responses[index].data.filter(value => this.parameterSettings.includes(value.table));
                    this.$set(this.parameters, type_id, parametersData);
                    index++;
                });
            }));
            axios.all(requests).then(axios.spread((...responses) => {
                let index = 0;
                unloaded_types.forEach(type_id => {
                    this.$set(this.shipments, type_id, responses[index].data);
                    this.dataTableIni(type_id);
                    index++;
                });
                this.full_load = true;
                if (this.search) {
                    this.globalSearch();
                }
                this.searching = false;
            }));
        },

        dataTableIni(type_id) {
            this.$nextTick(() => {
                if (this.shipments[type_id]) {
                    let table = $('#shipments-datatable-' + type_id).DataTable({
                        ...dataTablesSettings,
                        pageLength: 100,
                        autoWidth: true,
                        buttons: [
                            'excelHtml5',
                            {
                                extend: 'searchPanes',
                                config: {
                                    cascadePanes: true,
                                    layout: 'columns-5',
                                    threshold: 0.99
                                }
                            }
                        ],
                        dom: 'Bfrtip',
                    });
                }
            });
        },
        dataTablesDestroyAll() {
            this.types.forEach(type => {
                this.$nextTick(() => {
                    $('#shipments-datatable-' + type.id).DataTable().destroy();
                });
            });
        },
        deleteShipment(shipment, type_id) {
            if (!confirm('Вы уверены, что хотите удалить эту перевозку?')) {
                return;
            }
            axios.delete('/app/shipments/' + shipment.id)
                .then(response => {
                    if (response.data === 'Success') {
                        let index = this.shipments[type_id].indexOf(shipment);
                        if (index > -1) {
                            this.shipments[type_id].splice(index, 1);
                        }
                    }
                });
        },
        globalSearch() {
            this.$nextTick(() => {
                this.searching = true;
                $('.shipments-table').DataTable().tables().search(this.search).draw();
                this.searching = false;
            });
        },
        searchAll() {
            if (this.full_load) {
                this.globalSearch();
            } else {
                this.loadAll();
            }
        }
    },
    created() {
        if (localStorage.parameterSettings) {
            let tempParameterSettings = JSON.parse(localStorage.parameterSettings);
            this.parameterSettings = tempParameterSettings.filter(parameter => parameter.isShow);
        }


        if (!localStorage.filter_shipments) {
            localStorage.filter_shipments = 0;
        }

        if (!localStorage.bookmark_type) {
            localStorage.bookmark_type = 1;
        }

        this.bookmark_type = localStorage.bookmark_type;

        this.filter_shipments = parseInt(localStorage.filter_shipments);
        this.from = localStorage.from ? localStorage.from : this.monthsAgo(6);
        this.to = localStorage.to ? localStorage.to : this.today();

        if (this.filter_shipments === 0) {
            this.finished = null;
        } else if (this.filter_shipments === 1) {
            this.finished = false;
        } else if (this.filter_shipments === 2) {
            this.finished = true;
        }

        axios
            .get('/app/types')
            .then(response => {
                this.types = response.data;
                this.updateShipments(this.bookmark_type);
                $('body').addClass('left-side-menu-condensed');
            });
    },
    watch: {
        from: function (from) {
            localStorage.from = from;
        },

        to: function (to) {
            localStorage.to = to;
        },

        filter_shipments: function (filter_shipments) {
            localStorage.filter_shipments = filter_shipments;
        },

        bookmark_type: function (bookmark_type) {
            localStorage.bookmark_type = bookmark_type;
        }

    }
}
</script>

<style scoped>
@import '~datatables.net-searchpanes-bs4/css/searchPanes.bootstrap4.css';

.table-sm th, .table-sm td {
    padding: 1px;
}

.pointer {
    cursor: pointer;
}

.dataLength {
    font-size: 15px;
    margin-top: 15px;
}

</style>
