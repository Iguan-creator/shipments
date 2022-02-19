<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   type="text"
                   v-model="data"
                   maxlength="50"
            >
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterHAWBNumberSmall",
    mixins: [editParameter],
    props: ['isEdit'],
    computed: {...mapState(['editShipment'])},
    data() {
        return {
            isValidationRequired: false
        }
    },
    created() {
        if (this.isEdit) {
            this.data = this.editShipment.h_a_w_b_number;
        }
    },
}
</script>

<style scoped>

</style>

