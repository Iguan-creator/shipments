<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Списки исходных данных</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table v-if="asyncDataStatus_ready" class="table col-xl-4 col-lg-8 col-md-10">
                            <tbody>
                            <tr v-for="list in lists" :key="list.link">
                                <td class="align-middle h4">
                                    {{ list.name }}
                                </td>
                                <td class="align-middle">
                                    <router-link :to="'/lists/' + list.link" class="btn btn-primary">
                                        Редактировать
                                    </router-link>
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
    name: "ListsPage",
    components: {AppDataLoader},
    mixins: [asyncDataStatus],
    data() {
        return {
            lists: []
        }
    },
    created() {
        axios
            .get('/app/lists')
            .then(response => {
                this.lists = response.data;
                this.asyncDataStatus_fetched();
            });
    }
}
</script>

<style scoped>

</style>
