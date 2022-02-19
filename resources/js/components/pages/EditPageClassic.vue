<template>
    <edit-shipment-page v-if="show" :is-edit="true" :is-copy="false"></edit-shipment-page>
</template>

<script>
import EditShipmentPage from "./EditShipmentPage";
export default {
name: "EditPageClassic",
    components: {EditShipmentPage},
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
