import './bootstrap';
import Vue from 'vue';
import Vuetify from 'vuetify';
import Routes from '@/js/routes.js';
import Vuex from 'vuex';
import App from '@/js/views/App';
import Store from './store';
import {initialize} from './helpers/actions';

Vue.use(Vuetify);
Vue.use(Vuex);

const vuetify = new Vuetify();

const store = new Vuex.Store(Store)

initialize(store, Routes);

const app = new Vue({
    el: '#app',
    router: Routes,
    vuetify,
    store,
    render: h => h(App),
});

export default app;