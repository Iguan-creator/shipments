<template>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{ year }} &copy; Shipments Online
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "AppFooter",
    data() {
        return {
            year: ''
        }
    },
    created() {
        let date = new Date();
        this.year = date.getFullYear();
    }
}
</script>

<style scoped>

</style>
