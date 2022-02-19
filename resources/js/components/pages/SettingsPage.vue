<template>
    <div class="container-fluid">
        <div class="shadow p-3 mt-3 bg-white rounded">
            <div class="col-md-12">
                <h4 class="mb-3 mt-3">Вид страницы создания перевозки</h4>
            </div>
            <div class="btn-group ml-30">
                <button
                    class="btn"
                    :class="[switch_create_shipments !== 0 ? 'btn btn-white' :'btn btn-warning']"
                    @click="create_wizard">Wizard
                </button>

                <button
                    class="btn"
                    :class="[switch_create_shipments !== 1 ? 'btn btn-white' :'btn btn-warning']"
                    @click="create_compact">Compact
                </button>
            </div>
        </div>
        <div class="shadow p-3 mt-3 bg-white rounded">
            <div class="col-md-12">
                <h4 class="mb-3 mt-3">Вид страницы редактирования перевозки</h4>
            </div>
            <div class="btn-group ml-30">
                <button
                    class="btn"
                    :class="[switch_edit_shipments !== 0 ? 'btn btn-white' :'btn btn-warning']"
                    @click="switch_wizard">Wizard
                </button>

                <button
                    class="btn"
                    :class="[switch_edit_shipments !== 1 ? 'btn btn-white' :'btn btn-warning']"
                    @click="switch_compact">Compact
                </button>
            </div>
        </div>
        <div class="shadow p-3 mt-3 mb-3 bg-white rounded">
            <div class="col-md-12">
                <h4 class="mb-3 mt-3">Список полей в таблице перевозок</h4>
            </div>
                    <div class="custom-control custom-checkbox mb-1">
                <draggable v-model="tempStorage" group="people" @start="drag=true" @end="drag=false">
                    <div v-for="parameter in tempStorage" :key="parameter.id">
                        <input type="checkbox" class="custom-control-input"
                               :id="'parameter-' + parameter.id"
                               v-model="parameter.isShow"
                        >
                        <label class="custom-control-label" :for="'parameter-' + parameter.id">
                            {{ parameter.short }}
                        </label>
                    </div>
                </draggable>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from 'vuedraggable'

export default {
    name: "SettingsPage",
    components: {
        draggable
    },
    data: function () {
        return {
            switch_edit_shipments: 0,
            switch_create_shipments: 0,
            tempStorage: [],
            parameters: [],
            checkControl: [],
            moveControl: [],
            dragging: false
        }
    },

    methods: {

        switch_wizard() {
            this.switch_edit_shipments = 0;
        },

        create_wizard() {
            this.switch_create_shipments = 0;
            this.$eventBus.$emit('switch_create_shipments_null');
        },

        switch_compact() {
            this.switch_edit_shipments = 1;
        },

        create_compact() {
            this.switch_create_shipments = 1;
            this.$eventBus.$emit('switch_create_shipments_one');
        },

    },

    created() {

        if (!localStorage.switch_edit_shipments) {
            localStorage.switch_edit_shipments = 0;
        }

        if (!localStorage.switch_create_shipments) {
            localStorage.switch_create_shipments = 0;
        }

        this.switch_edit_shipments = parseInt(localStorage.switch_edit_shipments);
        this.switch_create_shipments = parseInt(localStorage.switch_create_shipments);

        axios.get('/app/parameters')
            .then(results => {
                this.parameters = results.data;

                if (!localStorage.parameterSettings) {
                    this.parameters.forEach(parameter => {
                        this.tempStorage.push({
                            id: parameter.id,
                            short: parameter.short,
                            isShow: parameter.table !== 'comment',
                            table: parameter.table
                        });
                    })
                    localStorage.parameterSettings = JSON.stringify(this.tempStorage);

                } else {
                    this.tempStorage = JSON.parse(localStorage.parameterSettings);
                    this.parameters.forEach(parameter => {
                        let index = this.tempStorage.findIndex(element => element.id === parameter.id);
                        if (index === -1) {
                            this.tempStorage.push({
                                id: parameter.id,
                                short: parameter.short,
                                isShow: true,
                                table: parameter.table
                            });
                        }
                    })
                }
                this.checkControl = localStorage.parameterSettings.split(',');
            });
    },

    watch: {
        tempStorage: {
            handler() {
                localStorage.parameterSettings = JSON.stringify(this.tempStorage);
            },
            deep: true
        },

        switch_edit_shipments: function (switch_edit_shipments) {
            localStorage.switch_edit_shipments = switch_edit_shipments;
        },

        switch_create_shipments: function (switch_create_shipments) {
            localStorage.switch_create_shipments = switch_create_shipments;
        },

    }

}
</script>

<style scoped>

.custom-control-label {
    cursor: pointer;
}

</style> */
