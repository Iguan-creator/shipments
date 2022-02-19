<template>
    <edit-parameter-selection-list
        :is-edit="isEdit"
        header="Условие поставки"
        list="delivery_condition"
        :type_id="type_id"
    ></edit-parameter-selection-list>
</template>

<script>
import EditParameterSelectionList from "./EditParameterSelectionList";
export default {
    name: "EditParameterDeliveryCondition",
    components: {EditParameterSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

