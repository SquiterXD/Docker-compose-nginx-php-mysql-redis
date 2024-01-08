import Vue from "vue";
// pages


//0039
Vue.component('additive-inventory-alert', () => import('./pm/pages/additiveInventoryAlert/Index'));

//0040
Vue.component('raw-material-inventory-alert', () => import('./pm/pages/rawMaterialInventoryAlert/Index.vue'));

// 0020
Vue.component('raw-material-list', () => import('./pm/pages/rawMaterialList/Index.vue'));
Vue.component('pm-request-raw-material', () => import('./pm/pages/rawMaterialList/requestMaterial/Index.vue'));
Vue.component('pm-inform-raw-material', () => import('./pm/pages/rawMaterialList/informMaterial/Index.vue'));

// 0021
Vue.component('raw-material-report', () => import('./pm/pages/rawMaterialReport/Index.vue'));
Vue.component('setup-transfer-search', () => import('./components/pm/settings/setup-transfer/search.vue'));
Vue.component('machine-relation-search', () => import('./components/pm/settings/machine-relation/search.vue'));


