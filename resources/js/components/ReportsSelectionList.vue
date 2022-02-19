<template>
    <div class="col-xl-6 col-lg-8 col-md-10">
        <table class="table table-striped table-sm" id="report_selector">
            <thead>
            <tr>
                <th>Имя</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="element in list" :key="element.id">
                <td><router-link :to="{name: 'Report', params: {listName, id: element.id}}">{{ element.name }}</router-link></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import dataTablesSettings from "../data/datatables_standard_settings";

export default {
    name: "ReportsSelectionList",
    props: {
        listName: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            list: []
        }
    },
    created() {
        axios.get('/app/reports/' + this.listName)
            .then(response => {
                if (response.status === 200) {
                    this.list = response.data;
                }
            })
    },
    updated() {
        this.$nextTick(() => {
            $('#report_selector').DataTable({
                ...dataTablesSettings,
                pageLength: 50,
                autoWidth: false,
            });
        });
    }
}
</script>

<style scoped>

</style>
