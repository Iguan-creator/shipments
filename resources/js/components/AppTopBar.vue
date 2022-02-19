<template>
    <div class="navbar navbar-expand flex-column flex-md-row navbar-custom">
        <div class="container-fluid">
            <!-- LOGO -->
            <router-link :to="{name: 'Main'}" class="navbar-brand mr-0 mr-md-2 logo">
                <span class="logo-lg">
                    <span class="d-inline h5 ml-1 text-logo">SHIPMENTS ONLINE</span>
                </span>
            </router-link>

            <ul class="navbar-nav bd-navbar-nav flex-row list-unstyled menu-left mb-0">
                <li class="">
                    <button class="button-menu-mobile open-left disable-btn">
                        <i data-feather="menu" class="menu-icon"></i>
                        <i data-feather="x" class="close-icon"></i>
                    </button>
                </li>
            </ul>

            <app-notifications v-show="user.role"></app-notifications>
        </div>

    </div>
</template>

<script>
import AppNotifications from "./AppNotifications";
import {mapState} from 'vuex';

export default {
    name: "AppTopBar",
    components: {AppNotifications},
    computed: {...mapState(['user'])},
}
</script>

<style scoped>

</style>
