<template>
    <edit-parameter-multiple-selection-list-small
        :is-edit="isEdit"
        header="Отправитель"
        list="sender"
        :clientDependent="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list-small>
</template>

<script>
import EditParameterMultipleSelectionListSmall from "./EditParameterMultipleSelectionListSmall";
export default {
    name: "EditParameterSendersSmall",
    components: {EditParameterMultipleSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

