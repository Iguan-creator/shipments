<template>
    <edit-parameter-selection-list
        :is-edit="isEdit"
        header="Тип контейнера"
        list="container"
        :type_id="type_id"
    ></edit-parameter-selection-list>
</template>

<script>
import EditParameterSelectionList from "./EditParameterSelectionList";
export default {
    name: "EditParameterContainer",
    components: {EditParameterSelectionList},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>

