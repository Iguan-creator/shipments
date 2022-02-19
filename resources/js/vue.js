import Vue from 'vue';
import VueRouter from 'vue-router';
import App from './components/App.vue';
import vSelect from 'vue-select';
import VueApexCharts from 'vue-apexcharts';

Vue.use(VueRouter);
Vue.component('v-select', vSelect);
Vue.component('apexchart', VueApexCharts);

import router from './router';
import store from './store';

Vue.prototype.$eventBus = new Vue();

new Vue({
    el: '#app',
    router,
    store,
    render: h => h(App),
    async created() {
        await this.$store.dispatch('getUser')
    }
});

