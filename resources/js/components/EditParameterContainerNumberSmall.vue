<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   :class="validation"
                   onKeyPress="if (this.value.length == 11) return false;"
                   type="text"
                   placeholder="AAAA0000000"
                   maxlength="11"
                   v-model="data"
            >
            <div class="invalid-tooltip">
                Это поле должно состоять из 4-х букв и 7-и цифр.
            </div>
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterContainerNumberSmall",
    mixins: [editParameter],
    props: ['isEdit'],
    computed: {...mapState(['editShipment'])},
    data() {
        return {
            isValidationRequired: true,
            validationPattern: '^[a-zA-Zа-яА-Я]{4}\\d{7}$'
        }
    },
    created() {
        if (this.isEdit) {
            this.data = this.editShipment.container_number;
        }
    },
    watch: {
        data: function() {
            if (this.data) {
                this.data = this.data.toUpperCase();
            }
        }
    }
}
</script>

<style scoped>

.invalid-tooltip {
    font-size: 11px;
}

</style>

