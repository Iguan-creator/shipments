<template>
    <div id="wrapper">
        <app-top-bar></app-top-bar>

        <app-side-menu></app-side-menu>

        <div class="content-page">
            <div class="content">
                <router-view></router-view>
            </div>
            <app-footer></app-footer>
        </div>
    </div>
</template>

<script>
import MetisMenu from 'metismenujs';
import AppFooter from "./AppFooter";
import AppTopBar from "./AppTopBar";
import AppUserInfo from "./AppUserInfo";
import AppSideMenu from "./AppSideMenu";

export default {
    name: "App",
    components: {AppSideMenu, AppUserInfo, AppTopBar, AppFooter},
    data() {
        return {
            optionsSlimscroll: {
                menu: {
                    height: 'auto',
                    position: 'right',
                    size: "4px",
                    color: '#9ea5ab',
                    wheelStep: 5,
                    touchScrollStep: 20
                },
                notifications: {
                    height: 'auto',
                    position: 'right',
                    size: "4px",
                    color: '#9ea5ab',
                    touchScrollStep: 20
                },
            }
        }
    },
    mounted() {
        this.initLayout();
        this.initMenu();

        // Enable slimscrolls
        $(".slimscroll").slimScroll({
            height: 'auto',
            position: 'right',
            size: "4px",
            touchScrollStep: 20,
            color: '#9ea5ab'
        });

        this.resetSidebarScroll();
        feather.replace();

        $(window).on('resize', e => {
            e.preventDefault();
            this.initLayout();
            this.resetSidebarScroll();
        });
    },
    methods: {
        resetSidebarScroll() {
            $('.slimscroll-menu').slimscroll({
                height: 'auto',
                position: 'right',
                size: "4px",
                color: '#9ea5ab',
                wheelStep: 5,
                touchScrollStep: 20
            });
        },
        initLayout() {
            if ($(window).width() >= 768 && $(window).width() <= 1024) {
                $('body').addClass('left-side-menu-condensed');
            } else {
                if ($('body').data('left-keep-condensed') != true) {
                    $('body').removeClass('left-side-menu-condensed');
                }
            }
        },
        initMenu() {
            $('.button-menu-mobile').on('click', function (event) {
                event.preventDefault();
                $('body').toggleClass('sidebar-enable');
                if ($(window).width() >= 768) {
                    $('body').toggleClass('left-side-menu-condensed');
                } else {
                    $('body').removeClass('left-side-menu-condensed');
                }
            });

            new MetisMenu('#menu-bar');

            this.resetSidebarScroll();

            $(document).on('click', 'body', function (e) {
                if ($(e.target).closest('.left-side-menu, .side-nav').length > 0 || $(e.target).hasClass('button-menu-mobile')
                    || $(e.target).closest('.button-menu-mobile').length > 0) {
                    return;
                }
                $('body').removeClass('sidebar-enable');
            });
        }
    },
}
</script>

<style>
@import '../../css/bootstrap.css';
@import '../../css/icons.css';
@import '../../css/app.css';
@import '~datatables.net-bs4/css/dataTables.bootstrap4.css';
@import '~datatables.net-buttons-bs4/css/buttons.bootstrap4.css';
@import '~datatables.net-responsive-bs4/css/responsive.bootstrap4.css';
@import '~datatables.net-select-bs4/css/select.bootstrap4.css';
@import '~vue-select/dist/vue-select.css';
</style>
