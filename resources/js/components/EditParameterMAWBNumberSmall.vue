<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   :class="validation"
                   onKeyPress="if (this.value.length == 12) return false;"
                   type="text"
                   placeholder="000-00000000"
                   v-model="data"
            >
            <div class="invalid-tooltip">
                Это поле должно состоять из 3-х цифр, затем 8-и цифр.
            </div>
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterMAWBNumberSmall",
    mixins: [editParameter],
    props: ['isEdit'],
    computed: {...mapState(['editShipment'])},
    data() {
        return {
            isValidationRequired: true,
            validationPattern: '^\\d{3}-\\d{8}$'
        }
    },
    created() {
        if (this.isEdit) {
            this.data = this.editShipment.m_a_w_b_number;
        }
    },
    watch: {
        data: function () {
            if (this.data) {
                if (this.data.length === 4) {
                    if (this.data.charAt(3) !== '-') {
                        let first_part = this.data.slice(0, 3);
                        let second_part = this.data.slice(3);
                        this.data = first_part + '-' + second_part;
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
