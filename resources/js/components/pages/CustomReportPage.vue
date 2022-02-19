<template>
    <div>
        <button v-if="requestSent" class="btn btn-sm btn-primary" @click="changeParameters">Изменить исходные
            параметры
        </button>
        <report-page v-if="requestSent" :is-custom="true" :full-data="fullData"></report-page>
        <div v-else class="container-fluid">
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">Выберите исходные данные для составления отчёта</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <form class="form-inline">
                                <div class="form-group mb-2">
                                    <div class="input-group mr-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">С</span>
                                        </div>
                                        <input type="date" class="form-control" v-model="data.from">
                                    </div>
                                    <div class="input-group mr-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">По</span>
                                        </div>
                                        <input type="date" class="form-control" v-model="data.to">
                                    </div>
                                </div>
                            </form>
                            <div v-for="list in lists" :key="list.link">
                                <h6>{{ list.name }}</h6>
                                <div class="d-flex">
                                    <div class="col-9" v-if="routes.includes(list.link)">
                                        <div v-for="routePoint in routesData" :key="routePoint.index">
                                            <div class="d-flex p-1">
                                                <div class="col-3">{{ routePoint.text }}</div>
                                                <v-select
                                                    class="col-6"
                                                    :ref="list.link"
                                                    multiple
                                                    append-to-body
                                                    label="name"
                                                    :options="elements[list.link]"
                                                    :reduce="variant => variant.id"
                                                    v-model="data[list.link][routePoint.index]"
                                                >
                                                    <div slot="no-options">Ничего не найдено</div>
                                                </v-select>
                                                <div class="d-flex align-items-center mr-1">
                                                    <button class="btn btn-sm btn-success"
                                                            @click="selectAll_point(list.link, routePoint.index)">Выбрать все
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <v-select
                                        class="col-9"
                                        :ref="list.link"
                                        v-else
                                        multiple
                                        append-to-body
                                        label="name"
                                        :options="elements[list.link]"
                                        :reduce="variant => variant.id"
                                        v-model="data[list.link]"
                                    >
                                        <div slot="no-options">Ничего не найдено</div>
                                    </v-select>
                                    <div class="d-flex align-items-center mr-1">
                                        <button class="btn btn-sm btn-success" v-if="!routes.includes(list.link)"
                                                @click="selectAll(list.link)">Выбрать все
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-2" @click="send">Сформировать отчёт</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import setDates from "../../mixins/setDates";
import ReportPage from "./ReportPage";

export default {
    name: "CustomReportPage",
    components: {ReportPage},
    mixins: [setDates],
    data() {
        return {
            data: {
                from: '',
                to: '',
                airports: {},
                ports: {},
                stations: {},
            },
            lists: [{name: 'Сотрудники', link: 'users'}, {name: 'Типы перевозок', link: 'types'}],
            elements: {},
            requestSent: false,
            fullData: [],
            routes: ['airports', 'ports', 'stations'],
            routesData: [
                {index: 'send', text: 'Отправления'},
                {index: 'arrival', text: 'Прибытия'},
                {index: 'any', text: 'Любой'},
            ]
        }
    },
    methods: {
        send(ref) {
            axios.post('/app/reports/custom', this.data)
                .then(response => {
                    if (response.status === 200) {
                        this.fullData = response.data;
                        this.requestSent = true;
                    }
                })
        },

        selectAll(name) {
            this.$refs[name][0].options.forEach(options => {
                this.$refs[name][0].select(options);
                this.$refs[name][0].open = false;
            })
        },

        selectAll_point(name, point) {
            if (point === 'send') {
                let index = 0;
                this.$refs[name][index].options.forEach(options => {
                    this.$refs[name][index].select(options);
                    this.$refs[name][index].open = false;
                })
            }
            if (point === 'arrival') {
                let index = 1;
                this.$refs[name][index].options.forEach(options => {
                    this.$refs[name][index].select(options);
                    this.$refs[name][index].open = false;
                })
            }
            if (point === 'any') {
                let index = 2;
                this.$refs[name][index].options.forEach(options => {
                    this.$refs[name][index].select(options);
                    this.$refs[name][index].open = false;
                })
            }
        },

        changeParameters() {
            this.requestSent = false;
            this.fullData = [];
        }
    },
    created() {
        this.$set(this.data, 'from', this.monthsAgo(1));
        this.$set(this.data, 'to', this.today());

        axios.get('/app/lists')
            .then(response => {
                if (response.status === 200) {
                    this.lists = this.lists.concat(response.data);
                    let requests = [];
                    this.lists.forEach(list => {
                        requests.push(axios.get('/app/' + list.link));
                    });
                    axios.all(requests).then(axios.spread((...responses) => {
                        this.lists.forEach((list, index) => {
                            this.$set(this.elements, list.link, responses[index].data);
                        });
                    }));
                }
            });
    }
}
</script>

<style scoped>

</style>
