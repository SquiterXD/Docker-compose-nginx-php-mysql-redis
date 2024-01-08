import Vue from "vue";

Vue.component('simu-form', () => import('./components/pd/SimuMaterialComponent.vue'));
// Vue.component('simu-additive-form', () => import('./pd/SimuAdditiveForm.vue'));
Vue.component('pd-component', () => import('./pd/PdComponent.vue'));
Vue.component('ct-lookup', () => import('./pd/components/Lookup'));
Vue.component('textarea-count', () => import('./pd/components/TextareaCount.vue'));
Vue.component('input-count', () => import('./pd/components/InputCount.vue'));

// pages
//0001
Vue.component('pd0001', () => import('./pd/pages/PD0001.vue'));
//P002
Vue.component('pd0002', () => import('./pd/pages/PD0002.vue'));
//0003
Vue.component('pd0003', () => import('./pd/pages/PD0003.vue'));
//004
Vue.component('pd0004', () => import('./pd/pages/PD0004.vue'));
//005
Vue.component('pd0005', () => import('./pd/pages/PD0005.vue'));
//0009
Vue.component('pd0009', () => import('./pd/pages/PD0009.vue'));
//0010
Vue.component('pd0010', () => import('./pd/pages/PD0010.vue'));

//006
Vue.component('pd0006', () => import('./pd/pages/PD0006.vue'));

//0007
Vue.component('pd0007', () => import('./pd/pages/PD0007.vue'));

//0008
Vue.component('pd0008', () => import('./pd/pages/PD0008.vue'));

//0010
Vue.component('pd0010', () => import('./pd/pages/PD0010.vue'));

//0011
Vue.component('pd0011', () => import('./pd/pages/PD0011.vue'));

//0012
Vue.component('pd0012', () => import('./pd/pages/PD0012.vue'));

//0013
Vue.component('pd0013', () => import('./pd/pages/PD0013.vue'));

//PD-0014
Vue.component('pd-0014', () => import('./pd/pages/PD0014.vue'));

Vue.component('inv-material-item', () => import('./pd/pages/InvMaterialItem.vue'));
// Vue.component('expanded-tobacco', () => import('./pd/pages/ExpandedTobacco.vue'));

Vue.component('simu-search', () => import('./components/pd/SearchSimuMaterialComponent.vue'));

Vue.component('ohhand-tobacco-forewarn-search', () => import('./components/pd/OhhandTobaccoForewarn/SearchComponent'));
Vue.component('ohhandTobaccoForewarnTable', () => import('./components/pd/OhhandTobaccoForewarn/TableComponent'));

Vue.component('history-instead-grades-header', () => import('./components/pd/HistoryInsteadGrades/HeaderComponent'));
Vue.component('history-instead-grades-table', () => import('./components/pd/HistoryInsteadGrades/TableComponent'));
Vue.component('pd-0015', require('./pd/pages/PD0015.vue').default);

// Vue.component('inv-material-item', require('./pd/pages/InvMaterialItem.vue').default);
