<template>
    <div class="media user-profile mt-2 mb-2">
        <div v-if="user.id" class="media-body">
            <h6 class="pro-user-name mt-0 mb-0">{{ user.last_name }} {{ user.first_name }}</h6>
            <span class="pro-user-desc">{{ roles[user.role - 1] }}</span>
        </div>
        <div v-else class="media-body">
            <h6 class="pro-user-name mt-0 mb-0">Гость</h6>
            <span class="pro-user-desc">Не авторизирован</span>
        </div>
        <div class="dropdown align-self-center profile-dropdown-menu">
            <a class="dropdown-toggle mr-0" data-toggle="dropdown" href="#" role="button"
               aria-expanded="false">
                <span data-feather="chevron-down"></span>
            </a>
            <div class="dropdown-menu profile-dropdown">
                <a v-if="user.id" href="/logout" class="dropdown-item notify-item">
                    <i data-feather="log-out" class="icon-dual icon-xs mr-2"></i>
                    <span>Сменить пользователя</span>
                </a>
                <a v-else href="/login" class="dropdown-item notify-item">
                    <i data-feather="log-in" class="icon-dual icon-xs mr-2"></i>
                    <span>Войти</span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    name: "AppUserInfo",
    computed: {...mapState(['user', 'roles'])},
    mounted() {
        feather.replace();
    }
}
</script>

<style scoped>

</style>
