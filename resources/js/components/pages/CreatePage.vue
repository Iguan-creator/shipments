<template>
    <edit-shipment-wizard :isCopy="isCopy" :isEdit="isCopy"></edit-shipment-wizard>
</template>

<script>
import EditShipmentWizard from "../EditShipmentWizard";

export default {
    name: "CreatePage",
    components: {EditShipmentWizard},
    computed: {
        isCopy: function () {
            return this.$route.name === 'CreateCopy';
        }
    }
}
</script>

<style scoped>

</style>
