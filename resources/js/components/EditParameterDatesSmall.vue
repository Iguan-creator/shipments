<template>
    <div>
        <div>
            <div class="row  mb-1">
                <div class="col-6">
                    <div class="form-group">
                        <label for="load_date">Дата затарки</label>
                        <input class="form-control form-control-sm" id="load_date" type="date" v-model="load_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-6">
                    <div class="form-group">
                        <label for="send_planned_date">Дата отправления плановая</label>
                        <input class="form-control form-control-sm" id="send_planned_date" type="date"
                               v-model="send_planned_date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="send_actual_date">Дата отправления фактическая</label>
                        <input class="form-control form-control-sm" id="send_actual_date" type="date"
                               v-model="send_actual_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-6">
                    <div class="form-group">
                        <label for="arrival_plan_date">Дата прибытия плановая</label>
                        <input class="form-control form-control-sm" id="arrival_plan_date" type="date"
                               v-model="arrival_plan_date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="arrival_actual_date">Дата прибытия фактическая</label>
                        <input class="form-control form-control-sm" id="arrival_actual_date" type="date"
                               v-model="arrival_actual_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1" v-if="type_id == 2 || type_id == 3">
                <div class="col-6">
                    <div class="form-group">
                        <label for="arrival_port_date">Дата Порт прибытия плановая</label>
                        <input class="form-control form-control-sm" id="arrival_port_date" type="date"
                               v-model="arrival_port_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1" v-if="type_id == 2 || type_id == 3">
                <div class="col-6">
                    <div class="form-group">
                        <label for="arrival_plan_date">Дата отправления (станция)</label>
                        <input class="form-control form-control-sm" id="send_station_date" type="date"
                               v-model="send_station_date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="arrival_actual_date">Дата прибытия (станция)</label>
                        <input class="form-control form-control-sm" id="arrival_station_date" type="date"
                               v-model="arrival_station_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-6">
                    <div class="form-group">
                        <label for="delivery_end_date">Дата закрытия доставки</label>
                        <input class="form-control form-control-sm" id="delivery_end_date" type="date"
                               v-model="delivery_end_date">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="release_date">Дата выпуска</label>
                        <input class="form-control form-control-sm" id="release_date" type="date"
                               v-model="release_date">
                    </div>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-6">
                    <div class="form-group">
                        <label for="delivery_actual_date">Дата доставки фактическая</label>
                        <input class="form-control form-control-sm" id="delivery_actual_date" type="date"
                               v-model="delivery_actual_date">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import setDates from "../mixins/setDates";
import {mapMutations, mapState} from 'vuex';
import formatData from "../mixins/formatData";


export default {
    mixins: [formatData, setDates],
    name: "EditParameterDatesSmall",
    props: ['isEdit'],
    computed: {...mapState(['editShipment', 'type_id', 'newShipment', 'daysToAdd'])},
    data() {

        return {
            load_date: null,
            arrival_port_date: null,
            send_planned_date: null,
            send_actual_date: null,
            arrival_plan_date: null,
            arrival_actual_date: null,
            delivery_end_date: null,
            release_date: null,
            delivery_actual_date: null,
            send_station_date: null,
            arrival_station_date: null,

        }
    },
    methods: {
        ...mapMutations(['updateNewShipment']),

    },
    watch: {

        load_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'load_date', value: this.load_date});

        },

        send_planned_date: function () {

            let addDays = this.daysToAdd.find(value => value.type_id === this.type_id);
            this.$store.commit('updateNewShipment', {parameter: 'send_planned_date', value: this.send_planned_date});
            let parse_send_planned_date = new Date(Date.parse(this.send_planned_date));
            parse_send_planned_date.setDate(parse_send_planned_date.getDate() + addDays.days);
            this.result_arrival_actual_date = parse_send_planned_date.toISOString().slice(0, 10);
            this.arrival_plan_date = this.result_arrival_actual_date;

        },
        send_actual_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'send_actual_date', value: this.send_actual_date});
        },
        arrival_plan_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'arrival_plan_date', value: this.arrival_plan_date});
        },
        arrival_actual_date: function () {
            this.$store.commit('updateNewShipment', {
                parameter: 'arrival_actual_date',
                value: this.arrival_actual_date
            });
        },
        delivery_end_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'delivery_end_date', value: this.delivery_end_date});
        },
        release_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'release_date', value: this.release_date});
        },
        delivery_actual_date: function () {
            this.$store.commit('updateNewShipment', {
                parameter: 'delivery_actual_date',
                value: this.delivery_actual_date
            });
        },
        send_station_date: function () {
            this.$store.commit('updateNewShipment', {parameter: 'send_station_date', value: this.send_station_date});
        },
        arrival_station_date: function () {
            this.$store.commit('updateNewShipment', {
                parameter: 'arrival_station_date',
                value: this.arrival_station_date
            });
        },
        arrival_port_date: function () {
            this.$store.commit('updateNewShipment', {
                parameter: 'arrival_port_date',
                value: this.arrival_port_date
            });
        }
    },
    created() {

        if (this.type_id === 2 || this.type_id === 3) {
            addEventListener("keyup", function (event) {
                let curElement = document.activeElement;

                if (event.keyCode === 13) {
                    event.preventDefault();
                    if (curElement.id === 'load_date') {
                        this.send_planned_date.focus();
                    } else if (curElement.id === 'send_planned_date' ) {
                        this.arrival_plan_date.focus();
                    } else if (curElement.id === 'arrival_plan_date' ) {
                        this.arrival_port_date.focus();
                    } else if (curElement.id === 'arrival_port_date') {
                        this.send_station_date.focus();
                    } else if (curElement.id === 'send_station_date') {
                        this.delivery_end_date.focus();
                    } else if (curElement.id === 'delivery_end_date') {
                        this.send_actual_date.focus();
                    } else if (curElement.id === 'send_actual_date') {
                        this.arrival_actual_date.focus();
                    } else if (curElement.id === 'arrival_actual_date') {
                        this.arrival_station_date.focus();
                    } else if (curElement.id === 'arrival_station_date') {
                        this.release_date.focus();
                    } else if (curElement.id === 'release_date') {
                        this.delivery_actual_date.focus();
                    } else {
                        this.load_date.focus();
                    }
                }
            });
        }

        else if (this.type_id !== 2 || this.type_id !== 3) {

            addEventListener("keyup", function (event) {
                let curElement = document.activeElement;
                if (event.keyCode === 13) {
                    event.preventDefault();
                    if (curElement.id === 'load_date') {
                        this.send_planned_date.focus();
                    } else if (curElement.id === 'send_planned_date' ) {
                        this.arrival_plan_date.focus();
                    } else if (curElement.id === 'arrival_plan_date' ) {
                        this.delivery_end_date.focus();
                    } else if (curElement.id === 'delivery_end_date') {
                        this.send_actual_date.focus();
                    } else if (curElement.id === 'send_actual_date') {
                        this.arrival_actual_date.focus();
                    } else if (curElement.id === 'arrival_actual_date') {
                        this.release_date.focus();
                    } else if (curElement.id === 'release_date') {
                        this.delivery_actual_date.focus();
                    }  else {
                        this.load_date.focus();
                    }
                }
            });
        }

        if (this.isEdit) {
            this.load_date = this.editShipment.load_date;
            this.arrival_port_date = this.editShipment.arrival_port_date;
            this.send_planned_date = this.editShipment.send_planned_date;
            this.send_actual_date = this.editShipment.send_actual_date;
            this.arrival_plan_date = this.editShipment.arrival_plan_date;
            this.arrival_actual_date = this.editShipment.arrival_actual_date;
            this.delivery_end_date = this.editShipment.delivery_end_date;
            this.release_date = this.editShipment.release_date;
            this.delivery_actual_date = this.editShipment.delivery_actual_date;
            this.send_station_date = this.editShipment.send_station_date;
            this.arrival_station_date = this.editShipment.arrival_station_date;
        }

    }
}
</script>

<style scoped>

</style>
