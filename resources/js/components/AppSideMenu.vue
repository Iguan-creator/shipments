<template>
    <div class="left-side-menu">
        <app-user-info></app-user-info>
        <div class="sidebar-content">
            <div id="sidebar-menu" class="slimscroll-menu">
                <ul class="metismenu" id="menu-bar">
                    <li class="menu-title">Меню</li>

                    <li>
                        <router-link :to="{name: 'ShipmentsAll'}">
                            <i data-feather="book-open"></i>
                            <span>Перевозки</span>
                        </router-link>
                    </li>

                    <li v-show="user.role <= 3">
                        <router-link :to="{name: 'ShipmentsMy'}">
                            <i data-feather="bookmark"></i>
                            <span>Мои перевозки</span>
                        </router-link>
                    </li>

                    <li v-show="user.role <= 3">
                        <router-link :to="{name: [switch_create_shipments === 0 ? 'Create' :'EditShipmentPage']}">
                            <i class="text-success" data-feather="check-square"></i>
                            <span class="text-success">Новая перевозка *</span>
                        </router-link>
                    </li>

                    <li class="menu-title">Отчёты</li>

                    <li>
                        <router-link :to="{name: 'ReportOverall', params: {listName: 'overall'}}">
                            <i data-feather="layers"></i>
                            <span>Сводный</span>
                        </router-link>
                    </li>

                    <li>
                        <a href="javascript: void(0);">
                            <i data-feather="calendar"></i>
                            <span>За период</span>
                            <span class="menu-arrow"></span>
                        </a>

                        <ul class="nav-second-level" aria-expanded="false">
                            <li>
                                <router-link :to="{name: 'ReportsSelector', params: {listName: 'employees'}}">По
                                    сотруднику
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'ReportsSelector', params: {listName: 'sellers'}}">По
                                    продавцу
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'ReportsSelector', params: {listName: 'clients'}}">По клиенту
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <router-link :to="{name: 'CustomReport'}">
                            <i data-feather="paperclip"></i>
                            <span>Пользовательский</span>
                        </router-link>
                    </li>

                    <li class="menu-title">Настройки</li>

                    <li v-show="user.role <= 3">
                        <router-link :to="{name: 'Settings'}">
                            <i class="feather feather-settings" data-feather="settings"></i>
                            <span>Настройки</span>
                        </router-link>
                    </li>


                    <li v-show="user.role < 3" class="menu-title text-danger">Администратор</li>

                    <li v-show="user.role < 2">
                        <router-link :to="{name: 'Users'}">
                            <i data-feather="users"></i>
                            <span>Сотрудники</span>
                        </router-link>
                    </li>

                    <li v-show="user.role < 3">
                        <router-link :to="{name: 'ShipmentsUser'}">
                            <i data-feather="list"></i>
                            <span>Перевозки</span>
                        </router-link>
                    </li>

                    <li v-show="user.role < 3">
                        <router-link :to="{name: 'Types'}">
                            <i data-feather="check-circle"></i>
                            <span>Типы перевозки</span>
                        </router-link>
                    </li>

                    <li v-show="user.role < 3">
                        <router-link :to="{name: 'Lists'}">
                            <i data-feather="server"></i>
                            <span>Списки</span>
                        </router-link>
                    </li>

                </ul>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
</template>

<script>
import AppUserInfo from './AppUserInfo';
import {mapState} from 'vuex';

export default {
    name: "AppSideMenu",
    components: {AppUserInfo},
    computed: {...mapState(['user'])},
    data() {

        return {
            switch_create_shipments: 0,
        }

    },
    created() {
        this.switch_create_shipments = parseInt(localStorage.switch_create_shipments);

        this.$eventBus.$on('switch_create_shipments_null', () => {
            this.switch_create_shipments = 0;
        });

        this.$eventBus.$on('switch_create_shipments_one', () => {
            this.switch_create_shipments = 1;
        });

    },
    methods: {
        highLightActiveLink() {
            let path = this.$route.path;
            $("#menu-bar a").each(function (element) {
                $(this).removeClass("active");
                $(this).parent().removeClass("mm-active"); // add active to li of the current link
                $(this).parent().parent().removeClass("mm-show");
                $(this).parent().parent().prev().removeClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().removeClass("mm-active");
                $(this).parent().parent().parent().parent().removeClass("mm-show"); // add active to li of the current link
                $(this).parent().parent().parent().parent().parent().removeClass("mm-active");
                if ($(this).attr('href') === path) {
                    $(this).addClass("active");
                    $(this).parent().addClass("mm-active"); // add active to li of the current link
                    $(this).parent().parent().addClass("mm-show");
                    $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
                    $(this).parent().parent().parent().addClass("mm-active");
                    $(this).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
                    $(this).parent().parent().parent().parent().parent().addClass("mm-active");
                }
            });
        }
    },
    mounted() {
        feather.replace();
        this.highLightActiveLink();
    },
    watch: {
        $route(to, from) {
            this.highLightActiveLink();
        },

    },

}
</script>

<style scoped>

</style>
