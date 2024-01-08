Vue.component('material-group', () => import('./components/pm/MaterialGroupComponent.vue'));

Vue.component('relation-feeder-create', () => import('./components/pm/RelationFeeder/createComponent.vue'));
Vue.component('relation-feeder-edit', () => import('./components/pm/RelationFeeder/editComponent.vue'));

Vue.component('pd-component', () => import('./pm/PdComponent.vue'));
Vue.component('ct-lookup', () => import('./pm/components/Lookup'));
Vue.component('ct-select', () => import('./pm/components/Select'));
Vue.component('ct-date', () => import('./pm/components/DateThai'));

Vue.component('pm-timepicker', require('./components/pm/Timepicker.vue').default);

//pages

//0001
Vue.component('pm0001', () => import('./pm/pages/PM0001'));

//0002
Vue.component('pm0002', () => import('./pm/pages/PM0002.vue'));

//0003
Vue.component('pm0003', () => import('./pm/pages/PM0003.vue'));

//0004
Vue.component('pm0004', () => import('./pm/pages/PM0004.vue'));

//0005
Vue.component('pm0005', () => import('./pm/pages/PM0005.vue'));
Vue.component('pm0005_2', () => import('./pm/pages/PM0005_2.vue'));

//0006
Vue.component('pm0006', () => import('./pm/pages/PM0006.vue'));
Vue.component('pm0006-job', () => import('./pm/pages/PM0006_Job.vue'));

//0007
Vue.component('pm0007', () => import('./pm/pages/PM0007.vue'));

//0008
Vue.component('pm0008', () => import('./pm/pages/PM0008.vue'));

//0009
Vue.component('pm0009', () => import('./pm/pages/PM0009.vue'));

//0010
Vue.component('pm0010', () => import('./pm/pages/PM0010.vue'));

//0011
Vue.component('pm0011', () => import('./pm/pages/PM0011.vue'));

//0012
Vue.component('pm0012', () => import('./pm/pages/PM0012.vue'));

//0013
Vue.component('pm0013', () => import('./pm/pages/PM0013.vue'));

//0014
Vue.component('pm0014', () => import('./pm/pages/PM0014.vue'));


//0015
Vue.component('pm0015', () => import('./pm/pages/PM0015.vue'));

//0016
Vue.component('pm0016', () => import('./pm/pages/PM0016.vue'));

//0017
Vue.component('pm0017', () => import('./pm/pages/PM0017.vue'));

//0018
Vue.component('pm0018', () => import('./pm/pages/PM0018.vue'));

//0019
Vue.component('pm0019', () => import('./pm/pages/PM0019.vue'));

//0020
Vue.component('pm0020', () => import('./pm/pages/PM0020.vue'));

//0021
Vue.component('pm0021', () => import('./pm/pages/PM0021.vue'));

//0022
Vue.component('pm0022', () => import('./pm/pages/PM0022.vue'));

//0023
Vue.component('pm0023', () => import('./pm/pages/PM0023.vue'));

//0024
Vue.component('pm0024', () => import('./pm/pages/PM0024.vue'));

//0025
Vue.component('pm0025', () => import('./pm/pages/PM0025.vue'));

//0026
Vue.component('pm0026', () => import('./pm/pages/PM0026.vue'));

//0027
Vue.component('pm0027', () => import('./pm/pages/PM0027.vue'));

//0028
Vue.component('pm0028', () => import('./pm/pages/PM0028.vue'));

//0029
Vue.component('pm0029', () => import('./pm/pages/PM0029.vue'));

//0030
Vue.component('pm0030', () => import('./pm/pages/PM0030.vue'));

//0031
Vue.component('pm0031', () => import('./pm/pages/PM0031.vue'));

//0032
Vue.component('pm0032', () => import('./pm/pages/PM0032.vue'));

//0033
Vue.component('pm0033', () => import('./pm/pages/PM0033.vue'));

//0034
Vue.component('pm0034', () => import('./pm/pages/PM0034.vue'));

//0035
Vue.component('pm0035', () => import('./pm/pages/PM0035.vue'));

//0036
Vue.component('pm0036', () => import('./pm/pages/PM0036.vue'));

//0037
Vue.component('pm0037', () => import('./pm/pages/PM0037.vue'));

//0038
Vue.component('pm0038', () => import('./pm/pages/PM0038.vue'));

//0039
Vue.component('pm0039', () => import('./pm/pages/PM0039.vue'));

//0040
Vue.component('pm0040', () => import('./pm/pages/PM0040.vue'));
//0044
Vue.component('pm0044', () => import('./pm/pages/PM0044.vue'));

//0041
Vue.component('pm0041', () => import('./pm/pages/PM0041.vue'));

//0042
Vue.component('pm0042', () => import('./pm/pages/PM0042.vue'));

//0043
Vue.component('pm0043', () => import('./pm/pages/PM0043.vue'));

//0044
Vue.component('pm0044', () => import('./pm/pages/PM0044.vue'));

//0045
Vue.component('pm0045', () => import('./pm/pages/PM0045.vue'));

//Example
Vue.component('mock-db-lookup-example', () => import('./pm/pages/MockLookUpExample.vue'));

Vue.component('wip-step-form', () => import('./components/pm/WipStepComponent.vue'));
Vue.component('wip-form',      () => import('./components/pm/WipComponent.vue'));

Vue.component('production-formula-form', () => import('./components/pm/ProductionFormula/ProductionFormulaComponent.vue'));
// Vue.component('production-formula-edit', () => import('./components/pm/ProductionFormula/Formula.vue'));
Vue.component('copy-production-formula', () => import('./components/pm/ProductionFormula/CopyComponent.vue'));
Vue.component('production-formula-show', () => import('./components/pm/ProductionFormula/ShowComponent.vue'));
Vue.component('production-formula-show-content', () => import('./components/pm/ProductionFormula/ShowContentComponent.vue'));
Vue.component('production-formula-edit', () => import('./components/pm/ProductionFormula/EditProductionFormulaComponent.vue'));
//save Layout
Vue.component('save-publication-layout-el-select', () => import('./components/pm/save-publication-layout/ElSelectComponent.vue'));
Vue.component('save-publication-layout-table', () => import('./components/pm/save-publication-layout/TableComponent.vue'));
Vue.component('save-publication-layout-edit', () => import('./components/pm/save-publication-layout/EditComponent.vue'));
Vue.component('save-publication-layout-table-results', () => import('./components/pm/save-publication-layout/TableResultsComponent.vue'));

Vue.component('machine-relation-form', () => import('./components/pm/MachineRelationComponent.vue'));

//setup-min-max
Vue.component('setup-min-max-by-item-search', () => import('./components/pm/setup-min-max-by-item/SearchComponent.vue'));
Vue.component('setup-min-max-by-item-table', () => import('./components/pm/setup-min-max-by-item/TableComponent.vue'));

//PMS0032 : บันทึกคลังเบิกวัตถุดิบ
Vue.component('setup-transfer-edit', () => import('./components/pm/SetupTransfer/editComponent.vue'));
Vue.component('setup-transfer-create', () => import('./components/pm/SetupTransfer/createComponent.vue'));

Vue.component('product-type-table', () => import('./components/pm/PrintProductType/TableComponent.vue'));
Vue.component('print-conversion-table', () => import('./components/pm/PrintConversion/TableComponent.vue'));
Vue.component('print-conversion-search', () => import('./components/pm/PrintConversion/SearchComponent.vue'));


Vue.component('org-tranfer-create', () => import('./components/pm/orgTranfer/CreateComponent.vue'));
Vue.component('org-tranfer-search', () => import('./components/pm/orgTranfer/SearchComponent.vue'));
Vue.component('org-tranfer-edit', () => import('./components/pm/orgTranfer/EditComponent.vue'));

//PMP0028
// Vue.component('ingredient-preparation', () => import('./pm/IngredientPeparationComponent.vue'));
// Vue.component('ingredient-preparation', () => import('./pm/ingredient-preparation/IngredientPeparationComponent.vue'));
Vue.component('ingredient-preparation', () => import('./components/pm/IngredientPeparationComponent.vue'));

// Vue.component('ingredient-preparation', () => import('./pm/ingredient-preparation/index.vue'));
// PMS0030 กำหนดพื้นที่วางของ
Vue.component('max-storage-form', () => import('./components/pm/MaxStorageComponent.vue'));

Vue.component('machine-group-table-lookup', () => import('./components/pm/print-machine-group/TableLookupComponent.vue'));
Vue.component('machine-group-table-setup', () => import('./components/pm/print-machine-group/TableSetupComponent.vue'));
Vue.component('machine-group-edit', () => import('./components/pm/print-machine-group/EditComponent.vue'));

// PMS0050 : บันทึกกำลังผลิตรายเครื่อง
Vue.component('machine-power-temp-header', () => import('./components/pm/machine-power-temp/HeaderComponent.vue'));
Vue.component('machine-power-temp-table', () => import('./components/pm/machine-power-temp/TableComponies.vue'));
Vue.component('machine-power-temp-edit', () => import('./components/pm/machine-power-temp/EditComponent.vue'));

Vue.component('print-item-setup-table', () => import('./components/pm/print-item-setup/TableComponent.vue'));
Vue.component('print-item-setup-create', () => import('./components/pm/print-item-setup/CreateComponent.vue'));
Vue.component('print-item-setup-edit', () => import('./components/pm/print-item-setup/EditComponent.vue'));
Vue.component('print-item-setup-search', () => import('./components/pm/print-item-setup/SearchComponent.vue'));

// PMS0033.1 คัดลอกสูตรมาตราฐาน
Vue.component('search-copy-formula', () => import('./components/pm/CopyProductionFormula/Search.vue'));
