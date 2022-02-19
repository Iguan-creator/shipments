<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
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
    name: "EditParameterCarriageNumberSmall",
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

