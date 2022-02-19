<template>
    <div class="mb-0">
        <div class="input-group">
            <input class="form-control form-control-sm"
                   :class="validation"
                   onKeyPress="if (this.value.length == 5) return false;"
                   type="number"
                   placeholder="00000"
                   max="99999"
                   maxlength="5"
                   v-model="data"
                   id="positionNumber"
            >
            <div class="invalid-tooltip">
                Это поле должно состоять из 4-х или 5-ти цифр.
            </div>

        </div>
        <div v-if="errorMessage" class="errorMessage">Такой номер позиционника уже существует</div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterPositionNumberSmall",
    mixins: [editParameter],
    props: ['isEdit'],
    computed: {...mapState(['editShipment'])},
    methods: {
        positionNumberChek() {
            this.errorMessage = false;
            axios.post('/app/shipment_exists', {position_number: this.data})
                .then(response => {
                    if (response.data) {
                        this.errorMessage = true;
                    }
                })
        },
    },
    created() {

        if (this.isEdit) {
            this.data = this.editShipment.position_number;
        }
    },
    data() {
        return {
            positionNumber: null,
            isValidationRequired: true,
            validationPattern: '^\\d{4,5}$',
            errorMessage: false
        }
    },
    watch: {
        data: function () {
            this.positionNumberChek();
        }
    }
}

</script>

<style scoped>

.errorMessage {
    margin-top: 1px;
    color: red;
    font-size: 12px;
}

.invalid-tooltip {
    font-size: 11px;
}

</style>
