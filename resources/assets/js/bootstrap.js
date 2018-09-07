window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
window.Tether = require('tether');
require('bootstrap');


window.Vue = require('vue');

require('chart.js');
import Chart from "chart.js";

require('pusher-js');

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};

require('./jquery.qrcode.min.js');
import qrcode from './jquery.qrcode.min.js';
Vue.use(qrcode);

import AmCharts from 'amcharts3';
import AmSerial from 'amcharts3/amcharts/serial';
Vue.use(AmCharts);

import Echo from "laravel-echo";
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import bModal from 'bootstrap-vue/es/components/modal/modal';
import bModalDirective from 'bootstrap-vue/es/directives/modal/modal';
Vue.component('b-modal', bModal);
Vue.directive('b-modal', bModalDirective);
import { Modal } from 'bootstrap-vue/es/components';
Vue.use(Modal);


import VueSweetAlert from 'vue-sweetalert'
 
Vue.use(VueSweetAlert);

// import VueModels from 'vue-models';
 
// Vue.use(VueModels);

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a69285a13f71df42c822',
    cluster: 'us2',
    encrypted: true,
    /*authEndpoint: '/broadcasting/auth',*/
});