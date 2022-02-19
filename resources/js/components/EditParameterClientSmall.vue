<template>
    <edit-parameter-selection-list-small
        :is-edit="isEdit"
        header="Клиент"
        list="client"
        :type_id="type_id"
    ></edit-parameter-selection-list-small>
</template>

<script>

import EditParameterSelectionListSmall from "./EditParameterSelectionListSmall";

export default {
    name: "EditParameterClientSmall",
    components: {EditParameterSelectionListSmall},
    props: ['isEdit','type_id'],
}
</script>

<style scoped>

</style>

