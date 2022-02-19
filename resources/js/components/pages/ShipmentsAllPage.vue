<template>
    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">Перевозки</h4>
                <shipments-view
                    to_card="true"
                    with_name="true"
                ></shipments-view>
            </div>
        </div>
    </div>
</template>

<script>
import ShipmentsView from "../ShipmentsView";

export default {
    name: "ShipmentsAllPage",
    components: {ShipmentsView}
}
</script>

<style scoped>

</style>
