<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12" v-if="loaded">
                <nav class="float-right mt-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{name: 'ShipmentsAll'}">Перевозки</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            Карточка перевозки № {{ shipment.position_number }}
                        </li>
                    </ol>
                </nav>
                <h3 class="mb-1 mt-0">
                    Карточка перевозки № {{ shipment.position_number }}
                    ({{ shipment.user.last_name + ' ' + shipment.user.first_name }})
                </h3>
                <router-link :to="{params: {id:shipment.id}, name: [switch_edit_shipments === 0 ? 'Edit' :'EditPageClassic']}">
                    <button v-if="user.role <= 1 || shipment.user_id === user.id" class="btn btn-lg my-3 btn-danger">
                        Редактировать перевозку
                           </button>
                </router-link>


                <div class="button_change_user float-right">
                    <button v-if="user.role <= 1 || shipment.user_id === user.id" class="btn btn-lg my-3 btn-primary"
                            data-toggle="modal" data-target="#change-user">
                        Сменить владельца
                    </button>
                </div>

                <div v-if="user.role <= 1 || shipment.user_id === user.id" class="modal fade" id="change-user"
                     tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <div class="row page-title">
                                        <div class="col-md-12">
                                            <h4 class="mb-2 mt-0">Выберите пользователя</h4>
                                            <select
                                                v-model="selectedUserId"
                                                class="custom-select mb-2">
                                                <option v-for="user in users"
                                                        :value="user.id"
                                                        :key="user.id"
                                                >
                                                    {{ user.last_name + ' ' + user.first_name }}
                                                </option>
                                            </select>
                                            <p v-if="timeout" id="chek_user" style="color: green; font-size: 15px">
                                                Выбран другой пользователь </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <button @click="docSend" class="btn btn-lg my-3"
                        :class="[shipment.documents_sent ? 'btn-success': 'btn-warning']">Документы отправлены в
                    бухгатерию на проверку
                </button>

                <div class="card">
                    <div class="card-body">
                        <div class="col-xl-6 col-md-10">
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <th scope="row">Тип перевозки</th>
                                    <td>{{ shipment.type.name }}</td>
                                </tr>
                                <tr v-for="parameter in shipment.type.parameters" :key="parameter.id">
                                    <th scope="row">
                                        {{
                                            parameter.table.charAt(parameter.table.length - 1) === 's' ? parameter.plural_name : parameter.singular_name
                                        }}
                                    </th>
                                    <td>{{ formatData(shipment[parameter.table], parameter.table) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import formatData from "../../mixins/formatData";
import {mapState} from "vuex";
import { EditIcon} from 'vue-feather-icons';

export default {
    name: "ShipmentPage",
    components: {EditIcon},
    mixins: [formatData],
    data() {

        return {
            shipment: {},
            loaded: false,
            shipments: [],
            selectedUserId: null,
            users: [],
            timeout: false,
            switch_edit_shipments: 0,

        }

    },
    created() {

        this.switch_edit_shipments = parseInt(localStorage.switch_edit_shipments);

        axios.get('/app/users')
            .then(response => {
                if (response.status === 200) {
                    this.users = response.data;
                }
            })

        axios.get('/app/shipments/' + this.$route.params.id)
            .then(response => {
                if (response.status === 200) {
                    this.shipment = response.data;
                    this.selectedUserId = this.shipment.user_id;
                    this.loaded = true;
                }
            });
    },

    methods: {
        docSend: function () {
            axios.put(`/app/shipments/${this.shipment.id}/documents_sent`, {sent: !this.shipment.documents_sent})
                .then(response => {
                    if (response.status === 200 && response.data === 'Success') {
                        this.shipment.documents_sent = !this.shipment.documents_sent;
                    }
                });
        },

    },

    computed: {
        ...mapState(['user']),

    },

    watch: {


        selectedUserId: function (newSelectedUserId, oldSelectedUserId) {
            if (!oldSelectedUserId) {
                return;
            }

            axios.patch(`/app/shipments/${this.shipment.id}/change_user`, {user_id: this.selectedUserId})
                .then(response => {
                    if (response.status === 200 && response.data === 'Success') {
                        this.timeout = true;
                        this.shipment.user_id = this.selectedUserId;
                        this.shipment.user = this.users.find(user => user.id === this.shipment.user_id);

                        setTimeout(() => this.timeout = false, 5000);
                    }
                });
        }
    }
}
</script>

<style scoped>

</style>
