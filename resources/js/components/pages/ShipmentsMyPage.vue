<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Мои перевозки</h4>
                <shipments-view request="my" with_delete="true"></shipments-view>
            </div>
        </div>
    </div>
</template>

<script>
import ShipmentsView from "../ShipmentsView";

export default {
    name: "ShipmentsMyPage",
    components: {ShipmentsView}
}
</script>

<style scoped>

</style>
