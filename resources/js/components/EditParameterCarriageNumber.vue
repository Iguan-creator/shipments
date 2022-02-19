<template>
    <div class="mb-5">
        <h2>Номер вагона</h2>
        <div class="input-group">
            <input class="form-control form-control-lg col-xl-4 col-lg-6 col-md-8 col-sm-12"
                   type="number"
                   v-model.lazy="data"
                   :type_id="type_id"
            >
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterCarriageNumber",
    mixins: [editParameter],
    props: ['isEdit', 'type_id'],
    computed: {...mapState(['editShipment'])},
    data() {
        return {
            isValidationRequired: false
        }
    },
    created() {
        if (this.isEdit) {
            this.data = this.editShipment.carriage_number;
        }
    }
}
</script>

<style scoped>

</style>

