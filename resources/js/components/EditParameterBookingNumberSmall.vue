<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   onKeyPress="if (this.value.length == 10) return false;"
                   type="text"
                   maxlength="10"
                   v-model.lazy="data"
            >
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from 'vuex';

export default {
    name: "EditParameterBookingNumberSmall",
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
            this.data = this.editShipment.booking_number;
        }
    }
}
</script>

<style scoped>

</style>
