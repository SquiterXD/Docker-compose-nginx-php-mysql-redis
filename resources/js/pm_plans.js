import Vue from "vue";

Vue.component('pm-el-select', () => import('./components/pm/ElSelect.vue'));

// PM PLANS - YEARS
Vue.component('pm-plans-yearly-index', () => import('./components/pm/plans/yearly/Index'));
Vue.component('pm-plans-approvals-yearly-index', () => import('./components/pm/plans/approvals/yearly/Index'));

// PM PLANS - MONTHS
Vue.component('pm-plans-monthly-index', () => import('./components/pm/plans/monthly/Index'));

// PM PLANS - BIWEEKLY
Vue.component('pm-plans-biweekly-index', () => import('./components/pm/plans/biweekly/Index'));
Vue.component('pm-plans-approvals-biweekly-index', () => import('./components/pm/plans/approvals/biweekly/Index'));

// PM PLANS - DAILY
Vue.component('pm-plans-daily-index', () => import('./components/pm/plans/daily/Index'));