<template>
    <edit-parameter-multiple-selection-list
        :is-edit="isEdit"
        header="Аэропорты"
        element-name="Аэропорт"
        list="airport"
        :isRoute="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list>
</template>

<script>

import EditParameterMultipleSelectionList from "./EditParameterMultipleSelectionList";

export default {
    name: "EditParameterAirports",
    components: {EditParameterMultipleSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>
