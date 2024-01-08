<template>
  <div class="el_select">
    <el-select  v-model="result"
                :placeholder="'กลุ่มของทรัพย์สิน'"
                :name="attrName"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                @focus="focus"
                filterable
                @change="change"
                style="width: 100%"
                :size="size">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-stock-yearly-lov-asset-group',
    data () {
      return {
        rows: [],
        loading: false,
        result: this.value
      }
    },
    props: [
      'attrName',
      'value',
      'isTable',
      'index',
      'size',
      'headerRow'
    ],
    methods: {
      remoteMethod (query) {
         this.getDataRows({ 
          policy_set_header_id: this.headerRow.policy_set_header_id,
          keyword: query 
        })
      },
      getDataRows (params) {
        this.loading = true;
        // axios.get(`/ir/ajax/lov/asset-group`, { params })
        axios.get(`/ir/ajax/lov/asset-group-by-product`, { params })
        .then(({data}) => {
          this.loading = false;
          this.rows = data.data
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focus (event) {
        this.getDataRows({ 
          policy_set_header_id: this.headerRow.policy_set_header_id,
          keyword: ''
        })
      },
      change (value) {
        let param = {
          code: '',
          desc: '',
          id: '',
          index: this.index
        }
        if (value) {
          for (let i in this.rows) {
            let data = this.rows[i]
            if (data.meaning === value) {
              param.code = value,
              param.desc = data.description
            }
          }
        } else {
          param.code = ''
          param.desc = ''
        }
        this.$emit('change-value-asset-group', param)
      }
        // if (this.isTable) {
        //   for (let i in this.assetGroup) {
        //     let data = this.assetGroup[i]
        //     if (data.meaning === value) {
        //       let param = {
        //         asset_group: value,
        //         rowId: this.indexTable,
        //         asset_group_name: data.description,
        //         id: data.value
        //       }
        //       this.$emit('change-value-asset-group', param)
        //     }
        //   }
        // } else {
        //   this.$emit('change-value-asset-group', value)
        // }
      
    },
    mounted() {
      this.getDataRows({ 
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: ''
      })
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
      }
    }
  }
</script>

