<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">{{ isCustom ? 'Пользовательский отчёт' : 'Отчет по срокам' }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <apexchart
                            type="pie"
                            height="200"
                            :options="chartOptions"
                            :series="[onTime, outdated]"
                        ></apexchart>
                        <p class="dataLength badge badge-success float-right"> Перевозок всего: {{ dataLength }} </p>
                        <form class="form-inline" v-if="!isCustom">
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
                                <button @click.prevent="updateData" class="btn btn-primary">Обновить</button>
                            </div>
                        </form>
                        <div v-if="asyncDataStatus_ready">
                            <table class="table table-striped table-sm" id="report">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Тип перевозки</th>
                                    <th scope="col">Номер позиционника</th>
                                    <th scope="col">Сотрудник</th>
                                    <th scope="col">Дата отпр. план</th>
                                    <th scope="col">Дата отпр. факт</th>
                                    <th scope="col">Дата приб. план</th>
                                    <th scope="col">Дата приб. факт</th>
                                    <th scope="col">Не в срок</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="record in data" :key="record.id">
                                    <td class="align-middle">{{ types[record.type_id - 1].name }}</td>
                                    <td class="align-middle">
                                        <router-link :to="{name: 'Shipment', params: {id: record.id}}">
                                            {{ record.position_number }}
                                        </router-link>
                                    </td>
                                    <td class="align-middle">
                                        {{ record.last_name }}
                                    </td>
                                    <td class="align-middle">
                                        {{ formatData(record.send_planned_date, 'send_planned_date') }}
                                    </td>
                                    <td class="align-middle">
                                        {{ formatData(record.send_actual_date, 'send_actual_date') }}
                                    </td>
                                    <td class="align-middle">
                                        {{ formatData(record.arrival_plan_date, 'arrival_plan_date') }}
                                    </td>
                                    <td class="align-middle">
                                        {{ formatData(record.arrival_actual_date, 'arrival_actual_date') }}
                                    </td>
                                    <td class="align-middle"
                                        :class="isOutdated(record) ? 'text-danger' : 'text-success'"
                                    >
                                        {{ isOutdated(record) ? 'Да' : 'Нет' }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <app-data-loader v-else></app-data-loader>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import formatData from "../../mixins/formatData";
import asyncDataStatus from "../../mixins/asyncDataStatus"
import AppDataLoader from "../AppDataLoader";
import dataTablesSettings from "../../data/datatables_standard_settings";
import setDates from "../../mixins/setDates";

export default {
    name: "ReportPage",
    components: {AppDataLoader},
    mixins: [formatData, asyncDataStatus, setDates],
    props: ['isCustom', 'fullData'],
    data() {
        return {
            data: [],
            users: [],
            types: [],
            from: '',
            to: '',
            chartOptions: {
                colors: ['#45E676', '#F44336'],
                labels: ['В срок', 'Не в срок'],
                legend: {
                    position: 'left',
                    verticalAlign: 'middle',
                    fontSize: '14px',
                },

            }
        }
    },
    computed: {
        outdated: function () {
            let outdated = 0;
            this.data.forEach((record) => {
                if (this.isOutdated(record)) {
                    outdated++;
                }
            });
            return outdated;
        },
        onTime: function () {
            return this.data.length - this.outdated;
        },

        dataLength: function () {
            return this.data.length;
        }
    },
    methods: {
        isOutdated(record) {
            let send_planned_date = new Date(record.send_planned_date);
            let arrival_actual_date = new Date(record.arrival_actual_date);
            let diffTime = Math.abs(arrival_actual_date - send_planned_date);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            return this.types[record.type_id - 1].days < diffDays;

        },
        updateData(post = true) {
            this.asyncDataStatus_ready = false;
            let types_request = '/app/types';
            let users_request = '/app/users';
            let reports_request = '';
            if (!this.isCustom) {
                reports_request = '/app/reports/' + this.$route.params.listName;
                if (this.$route.params.listName !== 'overall') {
                    reports_request += '/' + this.$route.params.id
                }
            }

            let requests = [];
            requests[0] = axios.get(types_request);
            requests[1] = axios.get(users_request);

            if (!this.isCustom) {
                requests[2] = post
                    ? axios.post(reports_request, {from: this.from, to: this.to})
                    : axios.get(reports_request);
            }

            axios.all(requests).then(axios.spread((...responses) => {
                this.types = responses[0].data;
                this.users = responses[1].data;


                if (!this.isCustom) {
                    this.data = responses[2].data;
                } else {
                    this.data = this.fullData;
                }

                this.data.map(record => {
                    let user = this.users.find(user => user.id == record.user_id);
                    if (user !== undefined) {
                        record.last_name = user.last_name;
                    }
                    return record;
                });
                this.asyncDataStatus_fetched();

            }));
        },
    },
    created() {

        this.updateData(false);
        this.from = this.monthsAgo(1);
        this.to = this.today();
    },
    watch: {
        asyncDataStatus_ready(newValue) {
            if (newValue) {
                this.$nextTick(() => {
                    $('#report').DataTable({
                        ...dataTablesSettings,
                        pageLength: 100,
                        autoWidth: false,
                        buttons: [
                            'excelHtml5',
                        ],
                        dom: 'Bfrtip',
                    });
                });
            }
        },
        $route(to, from) {
            this.updateData();
        }
    }
}
</script>

<style scoped>

.dataLength {
    font-size: 15px;
}

</style>
