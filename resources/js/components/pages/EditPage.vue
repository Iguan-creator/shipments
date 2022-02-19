<template>
    <edit-shipment-wizard v-if="show" :is-edit="true" :is-copy="false"></edit-shipment-wizard>
</template>

<script>
import EditShipmentWizard from "../EditShipmentWizard";

export default {
    name: "EditPage",
    components: {EditShipmentWizard},
    data() {
        return {
            show: true
        }
    },
    watch: {
        $route (to, from) {
            this.show = false;
            this.$nextTick(() => this.show = true);
        }
    }
}
</script>

<style scoped>

</style>
