<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Выберите {{ word }} для формирования отчета</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <reports-selection-list
                            v-if="fetched"
                            :list-name="listName"
                        ></reports-selection-list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ReportsSelectionList from "../ReportsSelectionList";
export default {
    name: "ReportsSelectorPage",
    components: {ReportsSelectionList},
    data() {
        return {
            names: {
                clients: 'клиента',
                employees: 'сотрудника',
                sellers: 'продавца'
            },
            fetched: true,
        }
    },
    computed: {
        word: function () {
            return this.names[this.listName];
        },
        listName: function () {
            return this.$route.params.listName;
        }
    },
    watch: {
        listName() {
            this.fetched = false;
            this.$nextTick(() => {
                this.fetched = true;
            });
        }
    }
}
</script>

<style scoped>

</style>
