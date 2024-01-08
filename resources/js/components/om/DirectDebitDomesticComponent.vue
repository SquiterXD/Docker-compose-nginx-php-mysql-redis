<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> รหัสลูกค้า <span class="text-danger">*</span></label>            
                <input type="hidden" name="customer_id"  :value="customer_id" autocomplete="off">
                <el-select  v-model="customer_id"
                                filterable
                                remote
                                @change="setCustomerName"
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="customer in customers"
                                :key="customer.customer_id"
                                :label="customer.customer_number + ' : ' + customer.customer_name"
                                :value="customer.customer_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ชื่อลูกค้า </label>            
                <el-input name="customer_name" v-model="customer_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> ธนาคาร <span class="text-danger">*</span></label>            
                <input type="hidden" name="bank_id"  :value="bank_id" autocomplete="off">
                <el-select  v-model="bank_id"
                                filterable
                                remote
                                @change="setBankName(); getBankBranchs();"
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="bank in banks"
                                :key="bank.bank_party_id"
                                :label="bank.bank_number + ' : ' + bank.bank_name"
                                :value="bank.bank_party_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ชื่อธนาคาร </label>            
                <el-input name="bank_name" v-model="bank_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5" v-loading="this.branchLoading">
                <label> รหัสสาขา </label>
                <input type="hidden" name="branch_id"  :value="branch_id" autocomplete="off">
                <el-select  v-model="branch_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                @change="setBranchName"
                                :disabled="this.branchLists.length < 1">              
                    <el-option  v-for="branch in branchLists"
                                :key="branch.branch_party_id"
                                :label="branch.branch_number + ' : ' + branch.bank_branch_name"
                                :value="branch.branch_party_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ชื่อสาขา </label>            
                <el-input name="branch_name" v-model="branch_name" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> หมายเลขบัญชี <span class="text-danger">*</span> </label>            
                <el-input name="account_num" v-model="account_num" @input="onlyNumeric"></el-input>
            </div>
            <div class="col-md-5">
                <label> ประเภทบัญชี </label>            
                <!-- <el-input name="account_type_id" v-model="account_type_id" size="medium"></el-input> -->
                <input type="hidden" name="account_type_id"  :value="account_type_id" autocomplete="off">
                <el-select  v-model="account_type_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                >              
                    <el-option  v-for="bankAccountType in bankAccountTypes"
                                :key="bankAccountType.lookup_code"
                                :label="bankAccountType.description"
                                :value="bankAccountType.lookup_code">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> วันที่เริ่มต้น </label>
                 <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="start_date"
                    placeholder="โปรดเลือกวันที่"
                    v-model="start_date"
                    format="DD-MM-YYYY"
                    @dateWasSelected="fromDateWasSelected"
                    >
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด </label>
                <datepicker-th
                    style="width: 100%;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="end_date"
                    placeholder="โปรดเลือกวันที่"
                    v-model="end_date"
                    format="DD-MM-YYYY"
                    :disabled-date-to="disabledDateTo"
                    >
                </datepicker-th>
                <!-- <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="datetime"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
export default {
    props: ['customer', 'customers', 'bankAccount', 'bankAccounts', 'bankAccountTypes', 'defaultValue', 'old', 'bankUniques', 'banks', 'branchs'],

    data(){
        return {
            customerResult: '',
            bankResult: '',
            customer_id:       this.old.customer_id      ? Number(this.old.customer_id) : this.defaultValue ? Number(this.defaultValue.customer_id)  : '',
            customer_name:     this.old.customer_name    ? this.old.customer_name       : this.defaultValue ? this.customer.customer_name            : '',
            bank_id:           this.old.bank_id          ? this.old.bank_id             : this.defaultValue ? this.defaultValue.bank_id              : '',
            bank_name:         this.old.bank_name        ? this.old.bank_name           : this.defaultValue ? this.bank_name             : '',
            account_num:       this.old.account_number   ? this.old.account_number      : this.defaultValue ? this.defaultValue.account_number      : '',
            account_type_id:   this.old.account_type_id  ? this.old.account_type_id     : this.defaultValue ? this.defaultValue.account_type_id      : '',
            disabledEdit:      this.defaultValue         ? true                         : false,
            start_date:        this.defaultValue         ? this.defaultValue.start_date : '',
            end_date:          this.defaultValue         ? this.defaultValue.end_date   : '',

            // สำหรับ เช็ค วันที่
            disabledDateTo:    this.start_date ? this.start_date : null,

            branchLoading:     false,
            branch_id:         this.old.branch_id ?  Number(this.old.branch_id) : this.defaultValue ?  Number(this.defaultValue.branch_id) : '',
            branch_name:       '',
            branchLists:       [],

        }
    },
    mounted(){
        if (!this.old.start_date || !this.old.end_date) {
            this.showDate();
        }

        if (this.bank_id) {
            this.setBankName();

            this.getBankBranchs();

            if (this.branch_id) {
                this.setBranchName();
            }
        }  

    },
    methods: {
        async setCustomerName() {
            if (this.customer_id) {
                let customerFilter = this.customers.filter(customerData => {

                    return customerData.customer_id == this.customer_id;
                });
                this.customerResult = customerFilter[0];
                this.customer_name = this.customerResult.customer_name;
            } else {
                this.customerResult = null;
            }
        },
        async setBankName() {
            if (this.bank_id) {
                let bankFilter = this.banks.filter(bankData => {

                    return bankData.bank_party_id == this.bank_id;
                });
                this.bankResult = bankFilter[0];
                // console.log('bankResult --> ' + this.bankResult);
                this.bank_name = this.bankResult.bank_name;
                // this.account_num = this.bankResult.bank_account_num;
            } else {
                this.bankResult = null;
            }
        },
        onlyNumeric() {
            this.account_num = this.account_num.replace(/[^0-9 .]/g, '');
        },
        async showDate() {
            if (this.start_date) {
                var date1 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
                this.start_date = date1;
            }
            if (this.end_date) {
                var date2 = await helperDate.parseToDateTh(this.end_date, 'yyyy-MM-DD');
                this.end_date = date2;
            }
        },
        fromDateWasSelected(date) {
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
        },
        async getBankBranchs() {
            if (!this.bank_id) {
                this.branchLoading = true;
                this.branch_id = "";
                this.branchLists = [];
            }

            axios.get("/om/ajax/get-bank-branchs", {
                params: {
                    bank_id: this.bank_id,
                }
            })
            .then(res => {
                this.branchLoading = false;
                
                this.branchLists = res.data;
            });
        },
        async setBranchName() {
            // console.log('xxx  ---> ' + this.bank_branch);
            if (this.branch_id) {
                // if (this.branchs) {
                    let bankFilter = this.branchs.filter(bankData => {

                        return bankData.branch_party_id == this.branch_id;
                    });
                    
                    this.bankResult = bankFilter[0];
                    
                    this.branch_name = this.bankResult.bank_branch_name;
                // }
                // this.account_num = this.bankResult.bank_account_num;
            } else {
                this.bankResult = null;
            }
        },
    }
}
</script>