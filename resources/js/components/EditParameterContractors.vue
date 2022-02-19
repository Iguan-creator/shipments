<template>
    <edit-parameter-multiple-selection-list
        :is-edit="isEdit"
        header="Подрядчики"
        list="contractor"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list>
</template>

<script>
import EditParameterMultipleSelectionList from "./EditParameterMultipleSelectionList";

export default {
    name: "EditParameterContractors",
    components: {EditParameterMultipleSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>
