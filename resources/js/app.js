/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// alert('=>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> PCCCCCCCCCCCCCC')

import QrcodeVue from "qrcode.vue";

require('./bootstrap');

import ElementUI from "element-ui";

import VueToast from "vue-toast-notification";
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import "vue-toast-notification/dist/theme-sugar.css";

window.Vue = require("vue").default;

// Vue.filter("numberFormat", function(value) {
//     if (!value) return "0.00";
//     return numeral(value).format("0,0.00");
// });

import {
    DatePicker,
    Progress,
    Upload,
    Select,
    Option,
    Loading,
    Input,
    Notification,
    Checkbox,
    Pagination,
    Form,
    Autocomplete,
    Button,
    Table,
    TableColumn,
    Divider,
    Icon,
    Dropdown,
    DropdownMenu,
    DropdownItem,
    Switch,
    TimePicker,
    InputNumber,
    Tabs,
    TabPane,
    Dialog,
    Card,
    MessageBox,
    Message,
    Alert
    , Radio
    , RadioGroup
    , RadioButton
} from "element-ui";
import "element-ui/lib/theme-chalk/index.css";
import lang from "element-ui/lib/locale/lang/en";
import locale from "element-ui/lib/locale";
import Fragment from 'vue-fragment';
import VModal from 'vue-js-modal';
// import numeral from "numeral";
// import VueToast from 'vue-toast-notification';
// Import one of the available themes
//import 'vue-toast-notification/dist/theme-default.css';
import 'vue-toast-notification/dist/theme-sugar.css';
import VueNumeric from 'vue-numeric';
// Piyawut A. 03122021 -- add import and component
import { BootstrapVue, BPagination, BTable } from 'bootstrap-vue'
Vue.component('b-pagination', BPagination)
Vue.component('b-table', BTable)

window.Vue = require('vue').default;

import numeral from "numeral";
import Vue from "vue";
Vue.filter("numberFormat", function(value) {
    if (!value) return "0.00";
    return numeral(value).format("0,0.00");
});

Vue.filter("number5Digit", function(value) {
    if (!value) return "0.00000";
    return numeral(value).format("0,0.00000");
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
    return numeral(value).format("0,0.00");
});
// Vue.use(ElementUI);

Vue.filter("number0Digit", function(value) {
    if (!value) return "0";
    return numeral(value).format("0,");
});

Vue.prototype.$notify = Notification;

Vue.use(ElementUI)

// locale.use(lang);
// Vue.use(PaginationPlugin);
// locale.use(th);

window.helperDate = require('./helpers.js');
window.helperAlert = require('./helpers/alert.js');


// Vue.use(Radio);
// Vue.use(RadioGroup);
// Vue.use(RadioButton);



// Vue.use(DatePicker);
// Vue.use(Upload);
// Vue.use(Select);
// Vue.use(Option);
// Vue.use(Loading);
// Vue.use(Input);
// Vue.use(Checkbox);
// Vue.use(Pagination);
// Vue.use(Form);
// // Vue.use(FormItem);
// Vue.use(Autocomplete);
// Vue.use(Button);


Vue.use(Fragment.Plugin);
// Vue.use(Switch);
// Vue.prototype.$notify = Notification;
// Vue.use(VueToast);
// Vue.prototype.$notify = Notification;
// Vue.use(VueToast);
Vue.use(VModal);
// Vue.prototype.$notify = Notification;
// Vue.use(VueToast);
// Vue.use(VueNumeric);
// Vue.use(VModal);

locale.use(lang);
// Vue.use(Dialog);
Vue.component('qrcode-vue', QrcodeVue);

// Vue.use(Table);
// Vue.use(TableColumn);
// Vue.use(Popover);
// Vue.use(Divider);
// Vue.use(Icon);
// Vue.use(Dropdown);
// Vue.use(DropdownMenu);
// Vue.use(DropdownItem);
// Vue.use(InputNumber);
// Vue.use(TimePicker);
// Vue.prototype.$notify = Notification;
// Vue.prototype.$confirm = MessageBox.confirm;
// Vue.use(VueToast);
// Vue.use(Tabs);
// Vue.use(TabPane);
// Vue.use(Dialog);
// Vue.use(Card);

// Vue.use(Switch);
// Vue.prototype.$notify = Notification;
// Vue.prototype.$message = Message;
window.helperDate = require("./helpers.js");
window.helperAlert = require("./helpers/alert.js");

// Vue.prototype.$message = Message;
// Vue.prototype.$notify = Notification;
// Vue.prototype.$msgbox = MessageBox;
// Vue.prototype.$alert = MessageBox.alert;
// Vue.prototype.$confirm = MessageBox.confirm;
Vue.use(DatePicker);
Vue.use(Progress);
Vue.use(TimePicker);
Vue.use(Upload);
Vue.use(Select);
Vue.use(Option);
Vue.use(Loading);
Vue.use(Input);
Vue.use(InputNumber);
Vue.use(Checkbox);
Vue.use(Pagination);
Vue.use(Form);
Vue.use(Autocomplete);
Vue.use(Button);
Vue.use(Table);
Vue.use(Alert);
Vue.use(TableColumn);
Vue.use(Divider);
Vue.use(Icon);
Vue.use(Dropdown);
Vue.use(DropdownMenu);
Vue.use(DropdownItem);
Vue.use(Tabs);
Vue.use(TabPane);
Vue.use(Dialog);
Vue.use(Card);

Vue.use(Switch);
Vue.prototype.$message = Message;
Vue.prototype.$notify = Notification;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$confirm = MessageBox.confirm;

Vue.use(VueToast);
Vue.use(VueNumeric);
Vue.use(Progress);
locale.use(lang);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

require("./example.js");
require("./pd.js");
require("./pm.js");
require("./pm_plans.js");
require("./pm_products.js");
require("./pp.js");
require("./eam.js");
require("./om.js");
require("./om-nuk.js");
require("./qm.js");
require("./ecom.js");
require("./web.js");
require("./ir.js");
require("./dbLookup.js");
require("./planning.js");

// window.$ = require('jquery');
require("./inv.js");
require("./ct.js");
require("./settings/_qm.js");
require("./settings/_pm.js");
require("./pmMaterialReq.js");
require("./pmQr.js");
require("./pd-081.js");


require("./pm_planning_jobs.js");
require("./pm1.js");

require("./pm-wip-issue.js");
require("./pm-wip-confirm.js");
require("./pm-nuk.js");
require("./pm-nick.js");
require("./pm-wip-loss-quantity.js");
require("./om_pakin.js");

require("./pmp0031.js");


require("./report.js");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
//Budget-Inquiry Funds
Vue.component('inquiry-funds-component', () => import('./components/budget/InquiryFundsComponent.vue'));
Vue.component('coa-component', () => import('./components/budget/InputCOAComponent.vue'));
Vue.component('datepicker-component', () => import('./components/budget/DatepickerEnComponent.vue'));

//MCR--PROGRAM
Vue.component('program-info-component', () => import('./components/program/ProgramInfoComponent.vue'));
Vue.component('program-type-component', () => import('./components/program/ProgramTypeComponent.vue'));
Vue.component('search-component', () => import('./components/program/SearchComponent.vue'));

//Running number
Vue.component('running-number', () => import('./components/RunningComponent.vue'));
Vue.component('search-running', () => import('./components/SearchRunningComponent.vue'));

//MCR--Lookup
Vue.component('lookup-date', require('./components/lookup/DateComponent.vue').default);
Vue.component('lookup-date-th', require('./components/lookup/DateTHComponent.vue').default);
Vue.component('lookup-select', require('./components/lookup/SelectComponent.vue').default);
Vue.component('lookup-input', require('./components/lookup/InputElComponent.vue').default);
Vue.component('lookup-action', require('./components/lookup/ActionComponent.vue').default);
Vue.component('lookup-table', require('./components/lookup/TableComponent.vue').default);
Vue.component('lookup-select-qms0021', require('./components/lookup/SelectQMS0027Component.vue').default);
Vue.component('lookup-select-qms0004', require('./components/lookup/SelectQMS0004Component.vue').default);

window.helperAlert = require('./helpers/alert.js');

const app = new Vue({
    el: '#app',
});
