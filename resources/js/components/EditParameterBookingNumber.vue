<template>
    <div class="mb-5">
        <h2>Номер букинга</h2>
        <div class="input-group">
            <input class="form-control form-control-lg col-xl-4 col-lg-6 col-md-8 col-sm-12"
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
    name: "EditParameterBookingNumber",
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
