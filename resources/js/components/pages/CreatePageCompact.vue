<template>
    <edit-shipment-page :isCopy="isCopy" :isEdit="isCopy"></edit-shipment-page>
</template>

<script>
import EditShipmentPage from "./EditShipmentPage";

export default {
    name: "CreatePage",
    components: {EditShipmentPage},
    computed: {
        isCopy: function () {
            return this.$route.name === 'CreateCopyCompact';
        }
    }
}
</script>

<style scoped>

</style>

