<template>
    <div>
        <el-form  
			:model="search"
            :rules="rules" 
            ref="search_expense_stock_asset" 
            label-width="120px" 
            class="demo-ruleForm"
		>
			<div class="row">
				<div class="col-lg-6">
					<div class="row">
						<label class="col-md-5 col-form-label lable_align">
							<strong>เดือนปิดบัญชี *</strong>
						</label>
						<div class="col-xl-6 col-lg-5 col-md-6 el_field">
							<el-form-item prop="period_name">
								<datepicker-th  
									style="width: 100%;"
									class="el-input__inner"
									:name="`period_name`"
									p-type="month"
									placeholder="เดือนปิดบัญชี"
									:value="search.period_name"
									:format="vars.formatMonth"
									@dateWasSelected="getValuePeriodFrom"/>
							</el-form-item>
						</div>
					</div>
					<div class="row">
						<label class="col-md-5 col-form-label lable_align">
							<strong>กรมธรรม์ชุดที่</strong>
						</label>
						<div class="col-xl-6 col-lg-5 col-md-6 el_field">
							<el-form-item>
								<lov-policy-set-header-id 
									v-model="search.policy_set_header_id"
									name="policy_set_header_id"
									size=""
									@change-lov="getPolicySetHeaderId"
									placeholder="กรมธรรม์ชุดที่"
									:check="this.search.expense_type_meaning"
									fixTypeFr="10"
									fixTypeSc="20"/>
							</el-form-item>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<label class="col-md-4 col-form-label lable_align">
							<strong>ประเภทของประกันภัย *</strong>
						</label>
						<div class="col-xl-6 col-lg-5 col-md-6 el_field">
							<el-form-item prop="expense_type_code">
								<lov-expense-type-code  
									v-model="search.expense_type_code"
									name="expense_type_code"
									size=""
									@change-lov="getValueExpenseTypeCode"/>
							</el-form-item>
						</div>
					</div>
					<div class="row">
						<label class="col-md-4 col-form-label lable_align">
							<strong>สถานะ</strong>
						</label>
						<div class="col-xl-6 col-lg-5 col-md-6 el_field">
							<el-form-item>
								<lov-status-ir  
									v-model="search.status"
									name="status"
									size=""
									@change-lov="getValueStatus"/>
							</el-form-item>
						</div>
					</div>
				</div>
			</div>
			<div class="text-right el_field">
				<el-form-item>
					<button type="button" class="btn btn-default" @click="clickSearch()">
						<i class="fa fa-search"></i> ค้นหา
					</button>
					<button type="button" 
						class="btn btn-success"
						data-toggle="modal"
						:data-target="`#modal_expense_stock_asset`"
						@click="clickFetch()">
						<i class="fa fa-database"></i> ดึงข้อมูล
					</button>
					<button type="button" class="btn btn-warning" @click="clickClear()">
						<i class="fa fa-repeat"></i> รีเซต
					</button>
				</el-form-item>
			</div>
        </el-form>
        <modal-fetch 
			ref="modal_fetch"
			:setYearCE="setYearCE"
			:vars="vars"
			@fetch-table-header="fetchTableHeader" 
		/>
    </div>
</template>

<script>
	import modalFetch from './modalFetch'
	import lovMonthBudgetYear from '../components/lov/monthBudgetYear'
	import yearInput from '../components/calendar/yearInput'
	import lovStatusIr from '../components/lov/statusIr'
	import lovExpenseTypeCode from './lovExpenseTypeCode'
	import lovPolicySetHeaderId from '../components/lov/policySetHeaderId'
	import moment from 'moment'
	export default {
		name: 'ir-expense-stock-asset-search',
		data () {
			return {
				rules: {
					year: [
						{required: true, message: 'กรุณาระบุปี', trigger: 'change'}
					],
					period_name: [
						{required: true, message: 'กรุณาระบุเดือน', trigger: 'change'}
					],
					expense_type_code: [
						{required: true, message: 'กรุณาระบุประเภทประกันภัย', trigger: 'change'}
					]
				},
				period_name: [],
				budget_period_year: [],
				months: [],
				years: []
			}
		},
		props: [
			'search',
			'showYearBE',
			'setYearCE',
			'vars',
		],
		methods: {
			changeYear (value) {
				this.search.year = value
				if (value) {
					this.months = this.budget_period_year.filter((row) => {
						if (value === row.period_year) {
							return row
						}
					})
				} else {
					this.months = []
					this.search.month = ''
				}
				this.search.month = ''
			},
			clickSearch () {
				this.$refs.search_expense_stock_asset.validate((valid) => {
					if (valid) {
						this.$emit('click-search', this.search)
					} else {
						return false;
					}
				})
			},
			clickFetch () {
				this.$refs.modal_fetch.resetFields();
				this.$refs.modal_fetch.fetch.policy_set_header_id = '';
			},
			clickClear () {
				window.location.href = '/ir/expense-stock-asset'
				// this.search.year = ''
				// this.search.month = ''
				// this.search.expense_type_code = ''
				// this.search.policy_set_header_id = ''
				// this.search.status = ''
			},
			getValueStatus (value) {
				this.search.status = value
			},
			getValueMonth (value) {
				this.search.month = value
				this.$emit('get-value-month', value)
			},
			getDataBudgetPeriodYear () {
				axios.get(`/ir/ajax/lov/budget-period-year`)
				.then(({data}) => {
					this.budget_period_year = this.setPropertyPeriodYear(data.data)
				})
				.catch((error) => {
					swal("Error", error, "error");
				})
			},
			setPropertyPeriodYear (array) {
				return array.filter((row) => {
					return row
				})
			},
			onlyUnique(value, index, self) {
				return self.indexOf(value) === index;
			},
			unique () {
				var result = [];
				$.each(this.budget_period_year, function(i, e) {
					if ($.inArray(e.period_year, result) == -1) result.push(e.period_year);
				});
				return result;
			},
			getValueExpenseTypeCode (obj) {
				if(obj){
					this.search.expense_type_code = obj.lookup_code;
					this.search.expense_type_meaning = obj.meaning;
				}else {
					this.search.expense_type_code = '';
					this.search.expense_type_meaning = '';
					this.search.policy_set_header_id = '';
				}
			},
			getPolicySetHeaderId (value) {
				this.search.policy_set_header_id = value
			},
			getValuePeriodFrom (date) {
				let formatMonth = this.vars.formatMonth
				if (date) {
					this.search.period_name = moment(date).format(formatMonth); 
				} else {
					this.search.period_name = '';
				}
			},
			fetchTableHeader (dataRows) {
				this.$refs.search_expense_stock_asset.resetFields();
				this.$emit('fetch-show-table-header', dataRows)
			},
		},
		components: {
			modalFetch,
			lovMonthBudgetYear,
			yearInput,
			lovStatusIr,
			lovExpenseTypeCode,
			lovPolicySetHeaderId
		},
		watch: {
			'budget_period_year' (newVal, oldVal) {
				if (newVal.length > 0) {
					this.years = this.unique()
				}
			}
		},
		created () {
			this.getDataBudgetPeriodYear()
		}
	}
</script>