<template>
    <edit-parameter-multiple-selection-list
        :is-edit="isEdit"
        header="Порты"
        element-name="Порт"
        list="port"
        :isRoute="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list>
</template>

<script>

import EditParameterMultipleSelectionList from "./EditParameterMultipleSelectionList";

export default {
    name: "EditParameterPorts",
    components: {EditParameterMultipleSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>
