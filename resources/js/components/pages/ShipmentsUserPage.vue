<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Выберите сотрудника</h4>
                <select
                    v-model="selectedUser"
                    class="custom-select mb-2">
                    <option v-for="user in users" :value="user.id" :key="user.id">
                        {{ user.last_name + ' ' + user.first_name }}
                    </option>
                </select>
                <shipments-view v-if="render" :request="selectedUser" with_delete="true"></shipments-view>
            </div>
        </div>
    </div>
</template>

<script>
import ShipmentsView from "../ShipmentsView";

export default {
    name: "ShipmentsUserPage",
    components: {ShipmentsView},
    data() {
        return {
            shipments: [],
            selectedUser: null,
            users: [],
            render: false
        }
    },
    methods: {

    },
    created() {
        axios.get('/app/users')
            .then(response => {
                if (response.status === 200) {
                    this.users = response.data;
                }
            })
    },
    watch: {
        selectedUser: function () {
            this.render = false;
            this.$nextTick(() => this.render = true);
        }
    }
}
</script>

<style scoped>

</style>
