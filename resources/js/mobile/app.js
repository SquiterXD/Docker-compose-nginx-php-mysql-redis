/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// alert('=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> MMMMM')
window.mbHelperAlert = require('./helpers/alert.js');
require('./bootstrap');
import ElementUI from "element-ui";

import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";

window.Vue = require("vue").default;

import numeral from "numeral";
import Vue from "vue";
Vue.filter("numberFormat", function(value) {
    if (!value) return "0.000";
    return numeral(value).format("0,0.000");
});


Vue.filter("number4Digit", function(value) {
    if (!value) return "0.0000";
    return numeral(value).format("0,0.0000");
});

Vue.filter("number3Digit", function(value) {
    if (!value) return "0.000";
    return numeral(value).format("0,0.000");
});

Vue.filter("number2Digit", function(value) {
    if (!value) return "0.00";
    return numeral(value).format("0,00");
});

Vue.use(ElementUI)

locale.use(lang);


Vue.component('mb-side-menu', require('./components/SideMenu.vue'));
Vue.component('mb-datepicker', require('./components/DatepickerTh.vue'));

Vue.component('mb-qrcode-check-mtls-index', require('./pm/qrcode-check-mtls/Index'));
Vue.component('mb-qrcode-transfer-mtls-index', require('./pm/qrcode-transfer-mtls/Index'));
Vue.component('mb-qrcode-rcv-transfer-mtls-index', require('./pm/qrcode-rcv-transfer-mtls/Index'));
Vue.component('mb-qrcode-return-mtls-index', require('./pm/qrcode-return-mtls/Index'));



const app = new Vue({
    el: '#app-mobile',
});
