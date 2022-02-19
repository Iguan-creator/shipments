<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <nav class="float-right mt-1">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{name: 'Lists'}">Списки</router-link>
                        </li>
                        <li class="breadcrumb-item">{{ pluralName }}</li>
                    </ol>
                </nav>
                <h4 class="mb-1 mt-0">{{ pluralName }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Добавить</h4>
                        <div class="form-inline mt-3 mb-5">
                            <div class="form-group mr-3">
                                <input type="text" class="form-control"
                                       v-model.lazy="newElement.name"
                                       placeholder="Напишите название">
                            </div>
                            <button @click="createElement" class="btn">
                                <div class="btn"
                                     :class="{
                                    'btn-soft-success': created && !exists,
                                    'btn-success': !created && !exists,
                                    'btn-danger': !created && exists
                                }"
                                >{{ created ? 'Добавлено' : (exists ? 'Уже существует' : 'Добавить') }}</div>
                            </button>
                        </div>
                        <h4>Список "{{ pluralName }}"</h4>
                        <div class="col-xl-8 col-lg-10 col-md-12" v-if="asyncDataStatus_ready">
                            <table id="list" class="table table-sm dt-responsive nowrap">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Название</th>
                                    <th v-if="listName === 'clients'" scope="col">Настройки</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="element in list" :key="element.id">
                                    <td class="align-middle">
                                        <span class="d-none">{{ element.name }}</span>
                                        <input class="form-control" type="text" v-model.lazy="element.name">
                                    </td>
                                    <td class="align-middle" v-if="listName === 'clients'">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-soft-primary dropdown-toggle"
                                                    data-toggle="dropdown">
                                                Зависимости
                                            </button>
                                            <div class="dropdown-menu">
                                                <div v-for="dependency in clientDependencies" :key="dependency.link">
                                                    <div v-if="dependency.link === 'parameter'"
                                                         class="dropdown-divider"></div>
                                                    <router-link
                                                        class="dropdown-item"
                                                        :to="`/dependencies/${dependency.link}/client/${element.id}`">
                                                        {{ dependency.name }}
                                                    </router-link>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="dangerous-rename btn btn-sm"
                                                :class="element.updated ? 'btn-success' : 'btn-warning'"
                                                @click="updateElement(element)">
                                            {{ element.updated ? 'Переименовано' : 'Переименовать' }}
                                        </button>
                                        <button type="button" class="dangerous-delete btn btn-sm btn-danger"
                                                @click="deleteElement(element)">
                                            Удалить
                                        </button>
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
import AppDataLoader from "../AppDataLoader";
import asyncDataStatus from "../../mixins/asyncDataStatus";
import dataTablesSettings from "../../data/datatables_standard_settings";

export default {
    name: "ListPage",
    components: {AppDataLoader},
    mixins: [asyncDataStatus],
    data() {
        return {
            pluralName: '',
            list: [],
            newElement: {
                name: '',
            },
            created: false,
            exists: false,
            dataTable: false,
            clientDependencies: [
                {name: 'Продавец', link: 'seller'},
                {name: 'Место загрузки', link: 'load_place'},
                {name: 'Место доставки', link: 'delivery_place'},
                {name: 'Отправитель', link: 'sender'},
                {name: 'Получатель', link: 'receiver'},
            ]
        }
    },
    computed: {
        listName: function () {
            return this.$route.params.list
        }
    },
    methods: {
        updateElement(element) {
            axios.patch(`/app/${this.listName}/${element.id}`, element)
                .then(response => {
                    if (response.data === 'Success') {
                        this.$set(element, 'updated', true);
                        setTimeout(() => this.$set(element, 'updated', false), 3000);
                    }
                });
        },
        deleteElement(element) {
            if (!confirm('Вы уверены, что хотите удалить этого продавца?')) {
                return;
            }

            axios.delete(`/app/${this.listName}/${element.id}`)
                .then(response => {
                    if (response.data === 'Success') {
                        this.list.splice(this.list.indexOf(element), 1);
                    }
                })

        },
        createElement() {
            axios.post('/app/' + this.listName, this.newElement)
                .then(response => {
                    if (response.status === 200) {
                        this.list.push(response.data);
                        this.created = true;
                        setTimeout(() => this.created = false, 3000);
                    }
                })
                .catch(error => {
                    if (error.response.status === 409 && error.response.data === 'Already exists') {
                        this.exists = true;
                        setTimeout(() => this.exists = false, 3000);
                    }
                });
        },
    },
    created() {
        axios.get('/app/parameters/' + this.listName)
            .then(response => this.pluralName = response.data.plural_name);
        axios.get('/app/' + this.listName)
            .then(response => {
                this.list = response.data;
                this.asyncDataStatus_fetched();
            });
    },
    watch: {
        list: function () {
            if (this.dataTable) {
                this.dataTable.destroy();
            }
            this.$nextTick(() => {
                let columns = this.listName === 'clients'
                    ? [null, {orderable: false}, {orderable: false}]
                    : [null, {orderable: false}];
                this.dataTable = $('#list').DataTable({
                    ...dataTablesSettings,
                    pageLength: 50,
                    autoWidth: false,
                    columns: columns
                });
            });
        }
    }
}
</script>

<style scoped>

</style>
