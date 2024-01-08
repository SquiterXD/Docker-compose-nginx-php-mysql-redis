<template>
  <div class="el_select">
    <el-select  v-model="receivable_name"
                :placeholder="'เรียกเก็บ'"
                :name="attrName"
                :remote-method="remoteMethodReceivable"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                size="small"
                @change="changeReceivable"
                @focus="focusReceivable">
      <el-option  v-for="(data, index) in receivables"
                  :key="index"
                  :label="data.description"
                  :value="data.description">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-increase-lov-receivable',
    data () {
      return {
        receivables: [],
        loading: false,
        receivable_name: this.receivable
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'receivable',
      'row',
      'headerRow'
    ],
    methods: {
      remoteMethodReceivable (query) {
        this.getReceivables({
          value: '',
          // policy_set_header_id: this.headerRow.policy_set_header_id,
          keyword: query,
          // start_date: this.headerRow.from_protection_date,
          // end_date: this.headerRow.to_protection_date
        });
      },
      getReceivables (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/receivable-charge`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.receivables = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusReceivable (event) {
        this.getReceivables({
          value: '',
          // policy_set_header_id: this.headerRow.policy_set_header_id,
          keyword: '',
          // start_date: this.headerRow.from_protection_date,
          // end_date: this.headerRow.to_protection_date
        });
      },
      changeReceivable (value) {
        if (value) {
          for (let i in this.receivables) {
            let receivable = this.receivables[i]
            if (receivable.description === value) {
              this.row.receivable_name = value
              // this.row.department_location_desc = row.description
            }
          }
        } else {
          this.row.receivable_name = ''
        }
      }
    },
    mounted() {
      this.getReceivables({
        value: '',
        // policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: '',
        // start_date: this.headerRow.from_protection_date,
        // end_date: this.headerRow.to_protection_date
      })
    },
    watch: {
      'receivable' (newVal, oldVal) {
        this.receivable_name = newVal;
      }
    }
  }
</script>

