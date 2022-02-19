<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Типы перевозки</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table v-if="asyncDataStatus_ready" class="table col-xl-8 col-lg-10 col-md-12">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Название</th>
                                <th scope="col">Нормативные сроки (дней)</th>
                                <th scope="col">Настройки</th>
                                <th scope="col" class="text-danger">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="type in types" :key="type.id">
                                <th class="align-middle" scope="row">{{ type.id }}</th>
                                <td class="align-middle">
                                    <input class="form-control" type="text" v-model="type.name">
                                </td>
                                <td class="align-middle">
                                    <input class="form-control" type="number" v-model="type.days">
                                </td>
                                <td class="align-middle">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-soft-primary dropdown-toggle"
                                                data-toggle="dropdown">
                                            Зависимости
                                        </button>
                                        <div class="dropdown-menu">
                                            <div v-for="dependency in dependencies" :key="dependency.link">
                                                <div v-if="dependency.link === 'parameter'" class="dropdown-divider"></div>
                                                <router-link
                                                             class="dropdown-item"
                                                             :to="`/dependencies/${dependency.link}/type/${type.id}`">
                                                    {{ dependency.name }}
                                                </router-link>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <button type="button"
                                            class="dangerous-rename btn btn-sm"
                                            :class="type.updated ? 'btn-success' : 'btn-warning'"
                                            @click="update(type)">
                                        {{ type.updated ? 'Изменено' : 'Отредактировать' }}
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
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

export default {
    name: "TypesPage",
    components: {AppDataLoader},
    mixins: [asyncDataStatus],
    data() {
        return {
            dependencies: [
                {name: 'Продавец', link: 'seller'},
                {name: 'Подрядчик', link: 'contractor'},
                {name: 'Тип машины', link: 'car'},
                {name: 'Тип контейнера', link: 'container'},
                {name: 'Порт', link: 'port'},
                {name: 'Аэропорт', link: 'airport'},
                {name: 'Станция', link: 'station'},
                {name: 'Параметры', link: 'parameter'},
            ],
            types: []
        }
    },
    created() {
        axios
            .get('/app/types')
            .then(response => {
                this.types = response.data;
                this.asyncDataStatus_fetched();
            });
    },
    methods: {
        update(type) {
            if (!confirm('Вы уверены, что хотите отредактировать этот тип перевозки?')) {
                return;
            }

            axios.patch('app/types/' + type.id, type).
                then(response => {
                    if (response.data === 'Success') {
                        this.$set(type, 'updated', true);
                        setTimeout(() => this.$set(type, 'updated', false), 3000);
                    }
            })
        }
    }
}
</script>

<style scoped>

</style>
