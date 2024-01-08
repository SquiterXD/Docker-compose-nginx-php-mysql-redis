// PPP0001
Vue.component('SearchMachineYearlyComponent', () => import('./components/Planning/Machine-Yearly/SearchComponent.vue'));
Vue.component('CreateMachineYearlyComponent', () => import('./components/Planning/Machine-Yearly/CreateComponent.vue'));
Vue.component('LinesMachineYearlyComponent', () => import('./components/Planning/Machine-Yearly/LinesComponent.vue'));

// PPP0002
Vue.component('planning-production-yearly-show', () => import('./components/Planning/Production-Yearly/ShowComponent.vue'));
// Vue.component('CreateProductionPlanComponent', () => import('./components/Planning/Production-Biweekly/CreateComponent.vue'));

// PPP0003
Vue.component('SearchMachineBiweeklyComponent', () => import('./components/Planning/Machine-Biweekly/SearchComponent.vue'));
Vue.component('CreateMachineBiweeklyComponent', () => import('./components/Planning/Machine-Biweekly/CreateComponent.vue'));
Vue.component('LinesMachineBiweeklyComponent', () => import('./components/Planning/Machine-Biweekly/LinesComponent.vue'));

// ---Commons Machine
// Res plan date
Vue.component('WorkingHourComponent', () => import('./components/Planning/Commons/Machine/WorkingHourComponent.vue'));
// Summary product by plan date
Vue.component('EfficiencyProductComponent', () => import('./components/Planning/Commons/Machine/EfficiencyProductComponent.vue'));
// Summary product by Group
Vue.component('SummaryEfficiencyProductByGroup', () => import('./components/Planning/Commons/Machine/SummaryEfficiencyProductByGroup.vue'));

// PPP0004 New
Vue.component('CreateProductionPlanComponent', () => import('./components/Planning/Production-Biweekly/CreateComponent.vue'));
Vue.component('planning-production-biweekly-show', () => import('./components/Planning/Production-Biweekly/ShowComponent.vue'));

// PPP0005
Vue.component('planning-adjust-show', () => import('./components/Planning/Adjusts/ShowComponent.vue'));
// PPP0006
Vue.component('planning-follow-ups-show', () => import('./components/Planning/Follow-Ups/ShowComponent.vue'));


// PPP0007
Vue.component('planning-production-daily-create', () => import('./components/Planning/Production-Daily/ModalCreate.vue'));
Vue.component('planning-production-daily-show', () => import('./components/Planning/Production-Daily/ShowComponent.vue'));

// PPP0008
Vue.component('planning-stamp-monthly', () => import('./components/Planning/Stamp-Monthly/IndexComponent.vue'));

// PPP0009
Vue.component('planning-stamp-follow', () => import('./components/Planning/Stamp-follow/ShowComponent.vue'));

// PPP0010
Vue.component('planning-overtimes-plan', () => import('./components/Planning/OverTimes-Plan/PlanComponent.vue'));
Vue.component('planning-overtimes-plan-create', () => import('./components/Planning/OverTimes-Plan/CreateComponent.vue'));
