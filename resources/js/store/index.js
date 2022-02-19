import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {},
        roles: ['Администратор', 'Модератор', 'Сотрудник', 'Гость'],
        newShipment: {},
        editShipment: {},
        type_id: null,

        daysToAdd: [
            {type_id: 1, days: 45},
            {type_id: 2, days: 35},
            {type_id: 3, days: 40},
            {type_id: 4, days: 55},
            {type_id: 5, days: 2},
            {type_id: 6, days: 4},
            {type_id: 7, days: 30},
            {type_id: 8, days: 20},
            {type_id: 9, days: 20},
            {type_id: 10, days: 25},
            {type_id: 11, days: 7},
        ]
    },

    actions: {
        async getUser({commit}) {
            await axios.get('/app/user')
                .then(response => commit('setUser', response.data));
        }
    },

    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        cleanNewShipment(state) {
            state.newShipment = {};
        },
        setNewShipment(state, data) {
            state.newShipment = data;
        },
        updateNewShipment(state, {parameter, value}) {
            state.newShipment[parameter] = value;
        },
        setEditShipment(state, shipment) {
            state.editShipment = shipment;
        },
        setTypeId(state, type_id) {
            state.type_id = type_id;
        }
    }
})
