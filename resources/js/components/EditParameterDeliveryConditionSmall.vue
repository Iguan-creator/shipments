<template>
    <edit-parameter-selection-list-small
        :is-edit="isEdit"
        header="Условие поставки"
        list="delivery_condition"
        :type_id="type_id"
    ></edit-parameter-selection-list-small>
</template>

<script>
import EditParameterSelectionListSmall from "./EditParameterSelectionListSmall";
export default {
    name: "EditParameterDeliveryConditionSmall",
    components: {EditParameterSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>


