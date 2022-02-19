<template>
    <div class="mb-1">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   type="text"
                   v-model.lazy="data"
            >
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterTransportDocNumberSmall",
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
            this.data = this.editShipment.transport_doc_number;
        }
    },
}
</script>

<style scoped>

</style>
