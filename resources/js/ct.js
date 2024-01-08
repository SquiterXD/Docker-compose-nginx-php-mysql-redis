const { default: Vue } = require("vue");
require("xlsx");

Vue.component(
    "test-component",
    () => import("./components/ct/testComponent.vue")
);
Vue.component(
    "cost-center-index-component",
    () => import("./components/ct/cost_center/Index.vue")
);
Vue.component(
    "cost-center-create-component",
    () => import("./components/ct/cost_center/Create.vue")
);
Vue.component(
    "cost-center-new-create-component",
    require("./components/ct/cost_center/CreateNew.vue").default
);
Vue.component(
    "specify-percentage-create-component",
    () => import("./components/ct/specify_percentage/Create.vue")
);
Vue.component(
    "product-group-index-component",
    () => import("./components/ct/product_group/Index.vue")
);
Vue.component(
    "product-group-show-component",
    () => import("./components/ct/product_group/Show.vue")
);
Vue.component(
    "criterion-allocate-create-component",
    () => import("./components/ct/criterion_allocate/Index.vue")
);
Vue.component(
    "specify-agency-component",
    () => import("./components/ct/specify_agency/Index.vue")
);
Vue.component(
    "set-account-type-list-component",
    () => import("./components/ct/set_account_type/Index.vue")
);
Vue.component(
    "set-account-dept-show-component",
    () => import("./components/ct/set_account_type/set_account_dept/Show.vue")
        
);

Vue.component(
    "account-code-ledger-create-component",
    () => import("./components/ct/account_code_ledger/Create.vue")
);

Vue.component(
    "tax-medicine-list-component",
    () => import("./components/ct/tax_medicine/Index.vue")
);

Vue.component(
    "tax-medicine-create-component",
    () => import("./components/ct/tax_medicine/Create.vue")
);

Vue.component(
    "product-plan-amount-component",
    () => import("./components/ct/product_plan_amount/Index.vue")
);

Vue.component(
    "purchase-price-info-import-xlsx-component",
    () => import("./components/ct/purchase_price_info/ImportXlsx.vue")
);

Vue.component(
    "purchase-price-info-component",
    () => import("./components/ct/purchase_price_info/Index.vue")
);

Vue.component(
    "std-raw-material-cost-component",
    () => import("./components/ct/std_raw_material_cost/Index.vue")
);

// SHARED COMPONENTS

Vue.component('ct-el-select', () => import('./components/ct/ElSelect.vue'));

// CT ALLOCATE-RATIOS
Vue.component('ct-allocate-ratios-index', () => import('./components/ct/allocate-ratios/Index'));

// CT STD-COSTS
Vue.component('ct-std-costs-index', () => import('./components/ct/std-costs/Index'));

// CT STD-COST-PAPERS
Vue.component('ct-std-cost-papers-index', () => import('./components/ct/std-cost-papers/Index'));
Vue.component('ct-std-cost-papers-materials', () => import('./components/ct/std-cost-papers/Materials'));
Vue.component('ct-std-cost-papers-account-targets', () => import('./components/ct/std-cost-papers/AccountTargets'));
Vue.component('ct-std-cost-papers-summarizes', () => import('./components/ct/std-cost-papers/Summarizes'));

// CT STD-COST-INQUIRY
Vue.component('ct-std-cost-inquiries-index', require('./components/ct/std-cost-inquiries/Index').default);

// CT OEM-COSTS
Vue.component('ct-oem-costs-index', () => import('./components/ct/oem-costs/Index'));

// CT WORKORDERS/PROCESSES
Vue.component('ct-workorders-processes-index', () => import('./components/ct/workorders/processes/Index'));

// REPORTS

// CTR0019
Vue.component('ct-reports-ctr0019-form', () => import('./components/ct/reports/ctr0019/Form'));

// CTR0020
Vue.component('ct-reports-ctr0020-form', () => import('./components/ct/reports/ctr0020/Form'));

// CTR0021
Vue.component('ct-reports-ctr0021-form', () => import('./components/ct/reports/ctr0021/Form'));

// CTR0022
Vue.component('ct-reports-ctr0022-form', require('./components/ct/reports/ctr0022/Form').default);

// CTR0023
Vue.component('ct-reports-ctr0023-form', require('./components/ct/reports/ctr0023/Form').default);

// CTR0024
Vue.component('ct-reports-ctr0024-form', require('./components/ct/reports/ctr0024/Form').default);

// CTR0026
Vue.component('ct-reports-ctr0026-form', () => import('./components/ct/reports/ctr0026/Form'));

// CTR0029
Vue.component('ct-reports-ctr0029-form', require('./components/ct/reports/ctr0029/Form').default);

// CTR0030
Vue.component('ct-reports-ctr0030-form', require('./components/ct/reports/ctr0030/Form').default);

Vue.component(
    "test-import-xlsx-component",
    () => import("./components/ct/helper/ImportXlsx.vue")
);

Vue.component(
    "account-code-ledger-index-component",
    () => import("./components/ct/account_code_ledger/Index.vue")
);
Vue.component(
    "account-code-ledger-form-component",
    () => import("./components/ct/account_code_ledger/Form.vue")
);
Vue.component(
    "cost-rm-index-component",
    require("./components/ct/cost_rm/Index.vue").default
);
Vue.component(
    "ct-std-datepicker-th",
    require("./components/ct/std_raw_material_cost/DatepickerTh.vue").default
);

// CTM0011
Vue.component(
    "grouping-expense-index-component",
    require("./components/ct/grouping_expense/Index.vue").default
);
Vue.component(
    "grouping-expense-detail-component",
    require("./components/ct/grouping_expense/Detail.vue").default
);

// CTM0020
Vue.component(
    "stamp-adj-index-component",
    require("./components/ct/stamp_adj/Index.vue").default
);
Vue.component(
    "stamp-adj-form-component",
    require("./components/ct/stamp_adj/Form.vue").default
);

// CTP0002
Vue.component(
    "raw-material-information-index-component",
    require("./components/ct/raw_material_information/Index.vue").default
);

// CTP0003
Vue.component(
    "inquire-production-index-component",
    require("./components/ct/inquire_production/Index.vue").default
);

// CTP0005
Vue.component('stamp-adjust-process', () => import('./components/ct/stamp_adj/transaction/ShowComponent.vue'));
Vue.component('stamp-adjust-create', () => import('./components/ct/stamp_adj/transaction/ModalCreate.vue'));