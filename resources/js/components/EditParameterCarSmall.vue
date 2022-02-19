<template>
    <edit-parameter-selection-list-small
        :is-edit="isEdit"
        header="Тип машины"
        list="car"
        :type_id="type_id"
    ></edit-parameter-selection-list-small>
</template>

<script>
import EditParameterSelectionListSmall from "./EditParameterSelectionListSmall";
export default {
    name: "EditParameterCarSmall",
    components: {EditParameterSelectionListSmall},
    props: ['isEdit', 'type_id'],
}
</script>

<style scoped>

</style>
