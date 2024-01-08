// Vue.component('index-stock-yearly', () => import('./components/ir/stock-yearly/index.vue'));
// Vue.component('edit-table-stock-yearly', () => import('./components/ir/stock-yearly/editTable.vue'));
// policy
Vue.component('index-policy', () => import('./components/ir/settings/policy/index.vue'))
Vue.component('create-policy', () => import('./components/ir/settings/policy/create-policy.vue'))
Vue.component('edit-policy', () => import('./components/ir/settings/policy/edit-policy.vue'))
Vue.component('search-policy', () => import('./components/ir/settings/policy/_search.vue'))
Vue.component('policy-active-flag', () => import('./components/ir/settings/policy/ActiveFlag.vue'))

// policy-group
Vue.component('index-policy-group', () => import('./components/ir/settings/policy-group/index.vue'))
Vue.component('edit-policy-group', () => import('./components/ir/settings/policy-group/edit-policy-group.vue'))

// confirm to ap (ap-oracle)
Vue.component('confirm-to-ap-index', () => import('./components/ir/confirm-to-ap/index.vue'))

// confirm to ar (ar-oracle)
Vue.component('confirm-to-ar-index', () => import('./components/ir/confirm-to-ar/index.vue'))

// confirm-to-gl (gl-oracle)
Vue.component('confirm-to-gl-index', () => import('./components/ir/confirm-to-gl/index.vue'))

//irp-0008
Vue.component('expense-stock-asset-index', () => import('./components/ir/expense-stock-asset/index.vue'))

//irp-0009
Vue.component('expense-car-gas-index', () => import('./components/ir/expense-car-gas/index.vue'))

//irp-0012
Vue.component('calculate-insurance', () => import('./components/ir/calculate-insurance/index.vue'))

//company
Vue.component('company-index', () => import('./components/ir/settings/company/index.vue'))
Vue.component('company-search', () => import('./components/ir/settings/company/search.vue'))
Vue.component('company-create', () => import('./components/ir/settings/company/create.vue'))
Vue.component('company-edit', () => import('./components/ir/settings/company/edit.vue'))
Vue.component('company-search-test', () => import('./components/ir/settings/company/_search.vue'))
Vue.component('company-active-flag', () => import('./components/ir/settings/company/ActiveFlag.vue'))

//vehicle
Vue.component('vehicle-index', () => import('./components/ir/settings/vehicle/index.vue'))
Vue.component('vehicle-create', () => import('./components/ir/settings/vehicle/create.vue'))
Vue.component('vehicle-edit', () => import('./components/ir/settings/vehicle/edit.vue'))
Vue.component('vehicle-search', () => import('./components/ir/settings/vehicle/_search.vue'))
Vue.component('vehicle-active-flag', () => import('./components/ir/settings/vehicle/ActiveFlag.vue'))
Vue.component('vehicle-fetch', () => import('./components/ir/settings/vehicle/fetch.vue'))


// setting/gas-station
Vue.component('gas-station-index', () => import('./components/ir/settings/gas-station/index.vue'))
Vue.component('gas-station-create', () => import('./components/ir/settings/gas-station/create.vue'))
Vue.component('gas-station-edit', () => import('./components/ir/settings/gas-station/edit.vue'))
Vue.component('gas-station-search', () => import('./components/ir/settings/gas-station/_search.vue'))
Vue.component('gas-station-active-flag', () => import('./components/ir/settings/gas-station/ActiveFlag.vue'))
Vue.component('gas-station-return-flag', () => import('./components/ir/settings/gas-station/ReturnFlag.vue'))

// stock

// Vue.component('stock-yearly-index', () => import('./components/ir/dev-yearly/index.vue'))


// Vue.component('select-option', () => import('./components/ir/selectOption.vue'));
// Vue.component('select-option-customer', () => import('./components/ir/selectOptionCustomer.vue'));
// Vue.component('search-componies', () => import('./components/ir/searchComponies.vue'));
// Vue.component('search-vehicles', () => import('./components/ir/vehicles/searchVehicles.vue'));

// Vue.component('select-option', () => import('./components/ir/selectOption.vue'));
// Vue.component('select-option-customer', () => import('./components/ir/selectOptionCustomer.vue'));
// Vue.component('search-componies', () => import('./components/ir/searchComponies.vue'));
// Vue.component('search-gas-stations', () => import('./components/ir/gas-stations/searchGasStations.vue'));
// Vue.component('select-gas-stations-type-code', () => import('./components/ir/gas-stations/selectTypeCost.vue'));

Vue.component('stock-monthly', () => import('./components/ir/stock-monthly/index.vue'))
    // Vue.component('stock-yearly-edit', () => import('./components/ir/dev-yearly/edit-year.vue'))
Vue.component('stock-yearly-index', () => import('./components/ir/stock-yearly/index.vue'))
Vue.component('stock-yearly-edit', () => import('./components/ir/stock-yearly/edit-year.vue'))

Vue.component('stock-monthly-index', () => import('./components/ir/stock-monthly/index.vue'))
Vue.component('stock-monthly-edit', () => import('./components/ir/stock-monthly/edit-month.vue'))

// asset
Vue.component('asset-plan-index', () => import('./components/ir/asset-plan/index.vue'))
Vue.component('asset-plan-edit', () => import('./components/ir/asset-plan/edit-plan.vue'))

Vue.component('asset-increase-index', () => import('./components/ir/asset-increase/index.vue'))
Vue.component('asset-increase-edit', () => import('./components/ir/asset-increase/edit-increase.vue'))

//gas-station
Vue.component('gas-station', () => import('./components/ir/gas-station/index.vue'))

//cars
Vue.component('cars', () => import('./components/ir/cars/index.vue'))

//governor
Vue.component('governors', () => import('./components/ir/governor/index.vue'))

//mcr
Vue.component('group-products-create-componies', () => import('./components/ir/groupProducts/createComponies.vue'));
Vue.component('group-products-search-componies', () => import('./components/ir/groupProducts/searchComponies.vue'));
Vue.component('group-products-edit-componies', () => import('./components/ir/groupProducts/editComponies.vue'));
Vue.component('group-products-table-componies', () => import('./components/ir/groupProducts/tableComponies.vue'));

Vue.component('search-product', () => import('./components/ir/product-inv/searchProductComponent.vue'));
Vue.component('create-product-inv', () => import('./components/ir/product-inv/ProductInvComponent.vue'));
Vue.component('edit-componies', () => import('./components/ir/product-inv/EditComponies.vue'));

Vue.component('sub-groups-search-component', () => import('./components/ir/sub-groups/searchComponent.vue'));
Vue.component('sub-groups-create-component', () => import('./components/ir/sub-groups/createComponent.vue'));
Vue.component('sub-groups-edit-component', () => import('./components/ir/sub-groups/editComponent.vue'));

Vue.component('product-inv-search-componies', () => import('./components/ir/product-inv/searchProductComponent.vue'));
Vue.component('product-inv-create-componies', () => import('./components/ir/product-inv/ProductInvComponent.vue'));
Vue.component('product-inv-edit-componies', () => import('./components/ir/product-inv/EditComponies.vue'));
Vue.component('product-inv-table-componies', () => import('./components/ir/product-inv/TableComponies.vue'));

//Account Mapping
Vue.component('create-account-mapping', () => import('./components/ir/account-mapping/AccountComponent.vue'));
Vue.component('input-segment', () => import('./components/ir/account-mapping/InputSegmentComponent.vue'));
Vue.component('search-account', () => import('./components/ir/account-mapping/SearchAccountComponent.vue'));
Vue.component('edit-account-mapping', () => import('./components/ir/account-mapping/EditAccountComponent.vue'));

//report list
Vue.component('report-search', () => import('./components/ir/reports/ReportSearch.vue'))
// Vue.component('input-segment-coa', () => import('./components/ir/account-mapping/InputCOAComponent.vue'));
// Vue.component('table-account-mapping', () => import('./components/ir/account-mapping/TableComponent.vue'));
Vue.component('table-account-mapping', () => import('./components/ir/account-mapping/TaComponent.vue'));

Vue.component('active-flag-account-mapping', () => import('./components/ir/account-mapping/ActiveFlagComponent.vue'));

//report index
Vue.component('ir-report', () => import('./components/ir/reports/Report.vue'))

Vue.component('setting-ir-report', () => import('./components/ir/settings/report-info/index.vue'))
    //Test Copy
Vue.component('account-mapping-component', () => import('./components/ir/account-mapping/AccountCodeComponent.vue'));

Vue.component('input-segment-coa', () => import('./components/ir/account-mapping/InputCOAComponent.vue'));

//IRM0010
Vue.component('search-email', require('./components/ir/email/SearchComponent.vue').default);
Vue.component('form-email', require('./components/ir/email/FormComponent.vue').default);
Vue.component('active-flag-email', require('./components/ir/email/ActiveFlagComponent.vue').default);
Vue.component('index-email', require('./components/ir/email/IndexComponent.vue').default);

// Claim
Vue.component('claim-index-table-irp0010', require('./components/ir/claim-insurance/TableIRP0010Component.vue').default)
Vue.component('claim-index-table-irp0011', require('./components/ir/claim-insurance/TableIRP0011Component.vue').default)
Vue.component('claim-insurance-search', require('./components/ir/claim-insurance/SearchComponent.vue').default)
Vue.component('claim-insurance-form', require('./components/ir/claim-insurance/FormComponent.vue').default)
Vue.component('claim-accounting-form', require('./components/ir/claim-insurance/accounting/FormComponent.vue').default)

//------------
Vue.component('claim-insurance-index', require('./components/ir/claim-insurance/index.vue').default)
Vue.component('claim-insurance-create', require('./components/ir/claim-insurance/create.vue').default)
Vue.component('claim-insurance-edit', require('./components/ir/claim-insurance/edit.vue').default)


// IRM0012
// Vue.component('search-rounding-asset', require('./components/ir/settings/rounding-asset/SearchComponent.vue').default);
Vue.component('fetch-inventory-not-insurance', () => import('./components/ir/settings/inventory-not-insurance/FetchComponent.vue'));
// Vue.component('index-inventory-not-insurance', () => import('./components/ir/settings/inventory-not-insurance/Index.vue'));
Vue.component('index-inventory-not-insurance', () => import('./components/ir/settings/inventory-not-insurance/IndexComponent.vue'));
Vue.component('search-rounding-asset', () => import('./components/ir/settings/rounding-asset/SearchComponent.vue'));
Vue.component('form-rounding-asset', () => import('./components/ir/settings/rounding-asset/FormComponent.vue'));