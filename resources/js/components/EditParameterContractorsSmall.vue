<template>
    <edit-parameter-multiple-selection-list-small
        :is-edit="isEdit"
        header="Подрядчики"
        list="contractor"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list-small>
</template>

<script>
import EditParameterMultipleSelectionListSmall from "./EditParameterMultipleSelectionListSmall";

export default {
    name: "EditParameterContractorsSmall",
    components: {EditParameterMultipleSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

