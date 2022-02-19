<template>
    <edit-parameter-selection-list-small
        :is-edit="isEdit"
        header="Тип контейнера"
        list="container"
        :type_id="type_id"
    ></edit-parameter-selection-list-small>
</template>

<script>

import EditParameterSelectionListSmall from "./EditParameterSelectionListSmall";
export default {
    name: "EditParameterContainerSmall",
    components: {EditParameterSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

