Vue.component('customer-form', () => import('./components/om/CustomerComponent.vue'));
Vue.component('country-form', () => import('./components/om/CountryComponent.vue'));
Vue.component('payment-term-form', () => import('./components/om/PaymentTermComponent.vue'));
Vue.component('payment-term-export-form', () => import('./components/om/PaymentTermExportComponent.vue'));

Vue.component('om-promotion-product', () => import('./components/om/PromotionProduct.vue'));
Vue.component('postpone-delivery', () => import('./components/om/PostponeDelivery.vue'));

// Vue.component('sequence-ecom-form', () => import('./components/om/SequenceEcomComponent.vue'));
Vue.component('sequence-ecom-form', () => import('./components/om/SequenceEcomComponent.vue'));
Vue.component('quota-credit-group-form', () => import('./components/om/QuotaCreditGroupComponent.vue'));
Vue.component('grant-spacial-case-form', () => import('./components/om/GrantSpacialCaseComponent.vue'));
Vue.component('authority-list-form', () => import('./components/om/AuthoRityListComponent.vue'));
// Vue.component('price-list-form', () => import('./components/om/PriceListComponent.vue'));
Vue.component('price-list-form', () => import('./components/om/PriceList.vue'));
Vue.component('price-list-export-form', () => import('./components/om/PriceListExportComponent.vue'));
Vue.component('grant-spacial-case-form', () => import('./components/om/GrantSpacialCaseComponent.vue'));
Vue.component('over-quota-approval-form', () => import('./components/om/OverQuotaApprovalComponent.vue'));
Vue.component('item-weight-form', () => import('./components/om/ItemWeightComponent.vue'));
Vue.component('direct-debit-domestic-form', () => import('./components/om/DirectDebitDomesticComponent.vue'));
Vue.component('direct-debit-export-form', () => import('./components/om/DirectDebitExportComponent.vue'));
Vue.component('not-auto-release-form', () => import('./components/om/NotAutoReleaseComponent.vue'));
Vue.component('approver-order-form', () => import('./components/om/ApproverOrderComponent.vue'));

//Account Mapping
// Vue.component('create-account-mapping', () => import('./components/om/account-mapping/AccountComponent.vue'));
Vue.component('create-account-mapping', () => import('./components/om/account-mapping/Account.vue'));
Vue.component('account-mapping-form', () => import('./components/om/account-mapping/AccountAliasesComponent.vue'));
Vue.component('om-input-segment', () => import('./components/om/account-mapping/InputSegmentComponent.vue'));
Vue.component('om-search-account', () => import('./components/om/account-mapping/SearchAccountComponent.vue'));
Vue.component('edit-account-mapping', () => import('./components/om/account-mapping/EditAccountComponent.vue'));

//Date TH
Vue.component('date-om', () => import('./components/om/DateCompoment.vue'));
Vue.component('price-list-date', () => import('./components/om/PriceListDateComponent.vue'));

Vue.component('transport-owner-form', () => import('./components/om/TransportOwnerComponent.vue'));
Vue.component('delete-item', () => import('./components/om/DeleteItem.vue'));
Vue.component('transport-toute-form', () => import('./components/om/TransportationRouteComponent.vue'));
Vue.component('search-order-period', () => import('./components/om/SearchOrderPeriodComponent.vue'));
Vue.component('order-period-form', () => import('./components/om/OrderPeriodComponent.vue'));

//OMP0006
Vue.component('outstanding-search', () => import('./components/om/OutstandingComponent.vue'));


Vue.component('search-grant-spacial', () => import('./components/om/SearchGrantSpacialComponent.vue'));

//OMP0023
Vue.component('improve-fine-form', () => import('./components/om/ImproveFineComponent.vue'));

//approval-claim
Vue.component('approval-claim-index', () => import('./components/om/approval-claim/indexComponent.vue'));
Vue.component('approval-claim-table', () => import('./components/om/approval-claim/tableComponent.vue'));
Vue.component('approver-order-export-form', () => import('./components/om/ApproverOrderExportComponent.vue'));

//OMP0089
Vue.component('poa-tax-mt', () => import('./components/om/PaoTaxMt.vue'));
Vue.component('transfer-txt-to-bank', () => import('./components/om/TransferTxtToBank.vue'));
Vue.component('close-daily-sale', () => import('./components/om/CloseDailySale.vue'));
Vue.component('close-daily-payoff', () => import('./components/om/CloseDailyPayoff.vue'));
Vue.component('consignment-bkk', () => import('./components/om/ConsignmentBkk.vue'));

// Vue.component('approver-order-export-form', () => import('./components/om/ApproverOrderExportComponent.vue'));
Vue.component('search-sequence-ecom', () => import('./components/om/SearchSequenceEcomComponent.vue'));

//tax-adjustments
Vue.component('tax-adjustments-bkk-search', () => import('./components/om/tax-adjustments-bkk/SearchComponent.vue'));
Vue.component('tax-adjustments-bkk-table', () => import('./components/om/tax-adjustments-bkk/tableComponent.vue'));
//OMP0071
Vue.component('improve-fine-exp-form', () => import('./components/om/ImproveFineExpComponent.vue'));
Vue.component('search-improve-fine-exp', () => import('./components/om/SearchImproveFineExpComponent.vue'));

Vue.component('cut-stock-inventory', () => import('./components/om/CutStockInventory.vue'));
Vue.component('product-return', () => import('./components/om/product_return/ProductReturn.vue'));
Vue.component('pao-percent', require('./components/om/PaoPercent.vue').default);
// Vue.component('search-sequence-ecom', require('./components/om/SearchSequenceEcomComponent.vue').default);

Vue.component('node-province-table', () => import('./components/om/NodeProvinceTable.vue'));

// OMS0019
Vue.component('search-direct-debit', () => import('./components/om/SearchDirectDebitComponent.vue'));