<template>
    <edit-parameter-multiple-selection-list-small
        :is-edit="isEdit"
        header="Аэропорты"
        element-name="Аэропорт"
        list="airport"
        :isRoute="true"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list-small>
</template>

<script>

import EditParameterMultipleSelectionListSmall from "./EditParameterMultipleSelectionListSmall";

export default {
    name: "EditParameterAirportsSmall",
    components: {EditParameterMultipleSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

