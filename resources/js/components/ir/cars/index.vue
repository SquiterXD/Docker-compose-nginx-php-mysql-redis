<template>
  <div v-loading="showLoading">
    <index-header @dataSearch='receivedDataSearchf'
                  @fetch-show-table-header='receivedDataSearcht'
                  :paramsQueryLicensePlate="paramsQueryLicensePlate"
                  @set-params-license-plate="getValueParamsLicensePlate"
                  @loading="loading" />

    <index-table  :dataTable='data'
                  :default-value-set-name="defaultValueSetName"
                  :setLabelExpenseFlag="funcs.setLabelExpenseFlag"
                  :formatCurrency="funcs.formatCurrency"
                  :isNullOrUndefined="funcs.isNullOrUndefined"
                  :checkStatusConfirmed="funcs.checkStatusConfirmed"
                  :setLabelStatusAsset="funcs.setLabelStatusAsset"
                  :policyCarTypes="policyCarTypes"
                  @loading="loading"
                  ref="indextable"
                  :urlExport="urlExport"
                  />
  </div>
</template>

<script>
  import uuid from 'uuid/v1';
  import IndexHeader from './indexHeader'
  import IndexTable from './indexTable.vue'
  import * as scripts from '../scripts'
  export default {
    props: [
      'defaultValueSetName',
      'policyCarTypes',
      'urlExport',
    ], 
    data() {
      return {
        data: {
          rows: []
        },
        funcs: scripts.funcs,
        paramsQueryLicensePlate: {
          renew_type: null,
          license_plate: null,
          group: null,
        },
        showLoading: false,
      }
    },
    components: {
      IndexHeader,
      IndexTable
    },
    methods: {
      loading(value){
        this.showLoading = value;
      },
      updateLock(tf){
        this.$refs.indextable.updateLock(tf);
      },
      financial(x) {
        return isNaN(x)?0:Number(parseFloat(x).toFixed(2))
      },
      receivedDataSearchf(data){ //search
        const lock = data.some((row)=>{
          return !row.document_number;
        });
        this.updateLock(lock);
        this.receivedDataSearch(data)
      },
      receivedDataSearcht(data){ //ดึงข้อมูล
        this.updateLock(true);
        this.receivedDataSearch(data)
      },
      receivedDataSearch(datax) {
        this.data.rows = datax.map((data, index) => {
          data.renew_typex = data.renew_type_code+':'+data.renew_type;
          if( data.renew_typex.includes('null') ) {
              // data.renew_typex = 'ประเภทการต่ออายุ';
              data.renew_typex = '';
          }
          // Add split 15042022 Piyawut A.
          let description = data.expense_account_desc.split('.');
          if(description.length == 12){
            let desc_coa = description[2]+'.'+description[8]+'.'+description[9];
            data.expense_account_desc = desc_coa
          }
          let carTypeSplit = '';
          if (data.car_type) {
            carTypeSplit = data.car_type.split('(');
          }

          data.insurance_amount === null ? data.insurance_amount = '' : +data.insurance_amount
          data.discount === null ? data.discount = '' : +data.discount
          data.vat_refund === 'Y' ? data.vat_refund = 'Yes' : data.vat_refund = 'No'
          data.duty_amount ? data.duty_amount = this.financial(data.duty_amount) : ''
          data.vat_amount ? data.vat_amount = this.financial(data.vat_amount) : ''
          data.net_amount ? data.net_amount = this.financial(data.net_amount) : ''
          data.return_vat_flag === 'Y' ? data.return_vat_flag = 'Yes' : 'No'
          data.vat_flag = data.tag
          data.year = +data.year
          data.program_code = 'IRP0005';
          data.row_id = uuid();
          data.car_type = carTypeSplit ? carTypeSplit[0] : data.car_type;
          return data
        })
        this.data.rows.filter ( row => {
          row.year = row.year.toString()
          return row
        })
        this.$refs.indextable.columnSelected = [];
        this.$refs.indextable.columnSelectedId = [];
      },
      getValueParamsLicensePlate (obj) {
        this.paramsQueryLicensePlate = obj;
      }
    }
  }
</script>