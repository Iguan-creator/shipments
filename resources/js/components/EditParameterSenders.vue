<template>
    <edit-parameter-multiple-selection-list
        :is-edit="isEdit"
        header="Отправитель"
        list="sender"
        :clientDependent="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list>
</template>

<script>
import EditParameterMultipleSelectionList from "./EditParameterMultipleSelectionList";
export default {
    name: "EditParameterSenders",
    components: {EditParameterMultipleSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

