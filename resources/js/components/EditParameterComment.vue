<template>
    <div class="mb-5">
        <h2>Комментарий</h2>
        <div class="input-group">
            <textarea
                v-model.lazy="data"
                class="form-control" rows="3" placeholder="Напишите комментарий (не обязательно)">
            </textarea>
        </div>
    </div>
</template>

<script>
import editParameter from "../mixins/editParameter";
import {mapState} from "vuex";

export default {
    name: "EditParameterComment",
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
            this.data = this.editShipment.comment;
        }
    }
}
</script>

<style scoped>

</style>

