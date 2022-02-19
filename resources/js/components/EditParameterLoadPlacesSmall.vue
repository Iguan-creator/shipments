<template>
    <edit-parameter-multiple-selection-list-small
        :is-edit="isEdit"
        header="Место загрузки"
        list="load_place"
        :clientDependent="true"
        :isRoute="true"
        :isPlace="false"
        :type_id="type_id"
    ></edit-parameter-multiple-selection-list-small>
</template>

<script>
import EditParameterMultipleSelectionListSmall from "./EditParameterMultipleSelectionListSmall";
export default {
    name: "EditParameterLoadPlacesSmall",
    components: {EditParameterMultipleSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>
