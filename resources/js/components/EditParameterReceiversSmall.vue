<template>
    <edit-parameter-multiple-selection-list-small
        :is-edit="isEdit"
        header="Получатель"
        list="receiver"
        :clientDependent="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list-small>
</template>

<script>
import EditParameterMultipleSelectionListSmall from "./EditParameterMultipleSelectionListSmall";
export default {
    name: "EditParameterReceiversSmall",
    components: {EditParameterMultipleSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

