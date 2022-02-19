<template>
    <edit-parameter-multiple-selection-list
        :is-edit="isEdit"
        header="Место доставки"
        list="delivery_place"
        :clientDependent="true"
        :isRoute="true"
        :isPlace="false"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list>
</template>

<script>
import EditParameterMultipleSelectionList from "./EditParameterMultipleSelectionList";
export default {
    name: "EditParameterDeliveryPlaces",
    components: {EditParameterMultipleSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

