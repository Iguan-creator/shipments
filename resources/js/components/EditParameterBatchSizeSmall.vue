<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   type="number"
                   v-model.lazy="data"
            >
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from 'vuex';

export default {
    name: "EditParameterBatchSizeSmall",
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
            this.data = this.editShipment.batch_size;
        }
    }
}
</script>

<style scoped>

</style>

