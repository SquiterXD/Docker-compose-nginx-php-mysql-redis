Vue.component('requisition-stationery-create-component', () => import('./components/inv/requisition_stationery/Create.vue'));
Vue.component('requisition-stationery-approve-component', () => import('./components/inv/requisition_stationery/Approve.vue'));
Vue.component('requisition-stationery-cancel-component', () => import('./components/inv/requisition_stationery/Cancel.vue'));
Vue.component('requisition-stationery-return-component', () => import('./components/inv/requisition_stationery/Return.vue'));

Vue.component('disbursement-fuel-list-component', () => import('./components/inv/disbursement_fuel/List.vue'));
Vue.component('disbursement-fuel-create-component', () => import('./components/inv/disbursement_fuel/Create.vue'));
Vue.component('disbursement-fuel-add-component', () => import('./components/inv/disbursement_fuel/Add.vue'));
Vue.component('disbursement-fuel-add-non-fa-component', () => import('./components/inv/disbursement_fuel/AddNonFA.vue'));
Vue.component('disbursement-fuel-report-component', () => import('./components/inv/disbursement_fuel/Report.vue'));
Vue.component('disbursement-fuel-cancel-component', () => import('./components/inv/disbursement_fuel/Cancel.vue'));
Vue.component('disbursement-fuel-search-car-component', () => import('./components/inv/disbursement_fuel/SearchCarLicense.vue'));

Vue.component('date-range-picker-component', () => import('./components/inv/DateRangePicker.vue'));
Vue.component('date-picker-component', () => import('./components/inv/DatePicker.vue'));

Vue.prototype.$formatErrorMessage = (errorResponse) => {
	let data = errorResponse.response.data;
	let ul = document.createElement("ul");
	ul.setAttribute("class", "pl-2 text-left mb-0");
  
	if (data && data.errors) {
	  let errors = Object.values(data.errors).flat();
	  errors.map((e) => {
		var li = document.createElement("li");
		li.innerHTML = e;
		ul.appendChild(li);
	  });
	} else if (data && data.message) {
	  var li = document.createElement("li");
	  li.innerHTML = data.message;
	  ul.appendChild(li);
	}
  
	return ul;
}
