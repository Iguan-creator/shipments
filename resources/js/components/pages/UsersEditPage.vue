<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Сотрудники</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Добавить Сотрудника</h4>
                        <table class="table table-sm dt-responsive nowrap mb-4">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">Фамилия</th>
                                <th scope="col">Имя</th>
                                <th scope="col">Email</th>
                                <th scope="col">Пароль</th>
                                <th scope="col">Права</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="align-middle">
                                    <input class="form-control" type="text" v-model="new_user.last_name">
                                </td>
                                <td class="align-middle">
                                    <input class="form-control" type="text" v-model="new_user.first_name">
                                </td>
                                <td class="align-middle">
                                    <input class="form-control" type="email" v-model="new_user.email">
                                </td>
                                <td class="align-middle">
                                    <input class="form-control" type="password" v-model="new_user.password">
                                </td>
                                <td class="align-middle">
                                    <select class="custom-select" v-model="new_user.role">
                                        <option value="1">Администратор</option>
                                        <option value="2">Модератор</option>
                                        <option value="3">Сотрудник</option>
                                        <option value="4">Гость</option>
                                    </select>
                                </td>
                                <td class="align-middle">
                                    <button class="btn"
                                            :class="created ? 'btn-soft-success' : 'btn-success'"
                                            @click="createUser">
                                        Добавить
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h4>Список сотрудников</h4>
                        <div>
                            <table id="users-datatable" class="table table-sm dt-responsive nowrap" v-if="asyncDataStatus_ready">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Фамилия</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Пароль</th>
                                    <th scope="col">Права</th>
                                    <th scope="col">Действия</th>
                                    <th scope="col">Ссылки</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="user in users" :key="user.id">
                                    <td class="align-middle">
                                        <span class="d-none">{{ user.last_name }}</span>
                                        <input class="form-control" type="text" name="last_name"
                                               v-model="user.last_name">
                                    </td>
                                    <td class="align-middle">
                                        <span class="d-none">{{ user.first_name }}</span>
                                        <input class="form-control" type="text" name="first_name"
                                               v-model="user.first_name">
                                    </td>
                                    <td class="align-middle">
                                        <span class="d-none">{{ user.email }}</span>
                                        <input class="form-control" type="email" name="email" v-model="user.email">
                                    </td>
                                    <td class="align-middle">
                                        <input class="form-control" type="password" name="password"
                                               v-model="user.password">
                                    </td>
                                    <td class="align-middle">
                                        <select class="custom-select" v-model="user.role">
                                            <option value="1">Администратор</option>
                                            <option value="2">Модератор</option>
                                            <option value="3">Сотрудник</option>
                                            <option value="4">Гость</option>
                                        </select>
                                    </td>
                                    <td class="align-middle">
                                        <a href="shipments_user.html" class="btn btn-info btn-sm">Перевозки</a>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-sm"
                                                    :class="user.changed ? 'btn-success' : 'btn-primary'"
                                                    data-toggle="tooltip"
                                                    data-placement="left"
                                                    data-original-title="Изменить"
                                                    @click="editUser(user)"
                                            ><i class="uil uil-edit"></i></button>
                                            <button class="btn btn-sm btn-danger"
                                                    data-toggle="tooltip"
                                                    data-placement="left"
                                                    data-original-title="Удалить"
                                                    @click="deleteUser(user)"
                                            ><i class="uil uil-minus-circle"></i></button>
                                        </div>
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
    </div>
</template>

<script>
import AppDataLoader from "../AppDataLoader";
import asyncDataStatus from "../../mixins/asyncDataStatus";

export default {
    name: "UsersEditPage",
    components: {AppDataLoader},
    mixins: [asyncDataStatus],
    data() {
        return {
            users: [],
            new_user: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                role: 3
            },
            created: false,
        }
    },
    methods: {

        createUser() {
            axios
                .post('/app/users', this.new_user)
                .then(response => {
                    if (response.status === 200) {
                        this.users.push(response.data);
                        this.created = true;
                        setTimeout(() => this.created = false, 3000);
                    }
                });

        },
        editUser(user) {
            axios.patch('/app/users/' + user.id, user)
                .then(response => {
                    this.$set(user, 'changed', true);
                    setTimeout(() => this.$set(user, 'changed', false), 3000);
                });
        },
        deleteUser(user) {
            if (!confirm('Вы уверены, что хотите удалить этого сотрудника?')) {
                return;
            }

            axios.delete('/app/users/' + user.id)
                .then(response => {
                    if (response.data === 'Success') {
                        this.users.splice(this.users.indexOf(user), 1);
                    }
                })
        }
    },
    created() {
        axios
            .get('/app/users')
            .then(response => {
                this.users = response.data;
                this.asyncDataStatus_fetched();
            });
    },
    updated() {
        $('[data-toggle="tooltip"]').tooltip();
    }
}
</script>

<style scoped>

</style>
