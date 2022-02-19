<template>
    <ul class="navbar-nav flex-row ml-auto d-flex list-unstyled topnav-menu float-right mb-0">


        <li class="dropdown notification-list" data-toggle="tooltip" data-placement="left"
            :title="'Новых Оповещений - ' + notifications.length">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button">
                <i data-feather="bell"></i>

                <!-- blink -->
                <span v-if="notifications.length" class="noti-icon-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                <!-- item-->
                <div class="dropdown-item noti-title border-bottom">
                    <h5 class="m-0 font-size-16">
                                <span class="float-right">
                                    <a href="" @click.prevent.stop="clearAll" class="text-dark">
                                        <small class="text-success" v-if="cleared">Очищено</small>
                                        <small v-else>Очистить всё</small>
                                    </a>
                                </span>
                        Оповещения
                    </h5>
                </div>

                <div class="slimscroll noti-scroll">
                    <router-link v-for="(notification, index) in notifications"
                                 :key="index"
                                 :to="{name: 'Edit', params: {id: notification.id}}"
                                 class="dropdown-item notify-item border-bottom">
                        <div
                            :class="notification.type === 'unfilled' ? 'bg-warning' : 'bg-danger'"
                            class="notify-icon">
                            <i class="uil"
                               :class="notification.type === 'unfilled' ? 'uil-grid' : 'uil-calendar-alt'"
                            ></i>
                        </div>
                        <p class="notify-details">
                            {{ getMessage(notification) }} №{{ notification.position_number }}
                            <small class="text-muted">
                                Перейти к перевозке
                            </small>
                        </p>
                    </router-link>
                </div>

            </div>
        </li>
    </ul>
</template>

<script>
export default {
    name: "AppNotifications",
    data() {
        return {
            notifications: [],
            cleared: false,
            slimscrollOptions: {
                height: 'auto',
                position: 'right',
                size: "4px",
                color: '#9ea5ab',
                touchScrollStep: 20
            }
        }
    },
    methods: {
        clearAll() {
            axios.post('/app/info/clear')
                .then(response => {
                    if (response.status === 200) {
                        this.updateNotifications();
                        this.cleared = true;
                        setTimeout(() => this.cleared = false, 3000);
                    }
                });
        },
        getMessage(notification) {
            if (notification.type === 'unfilled') {
                return 'Не заполнены поля';
            } else if (notification.type === 'arrivalOutdated') {
                return 'Превышен срок прибытия';
            } else if (notification.type === 'sendOutdated') {
                return 'Превышен срок отправки';
            } else {
                return '';
            }
        },
        updateNotifications() {
            axios.get('/app/info')
                .then(response => {
                    if (response.status === 200) {
                        this.notifications = response.data;
                        this.$nextTick(() => {
                            $('.noti-scroll').slimScroll(this.slimscrollOptions);
                        });
                    }
                })
        }
    },
    created() {
        this.updateNotifications();
    }
}
</script>

<style scoped>

</style>
