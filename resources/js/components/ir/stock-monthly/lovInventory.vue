<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                placeholder="รหัสคลังสินค้า"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                @change="change"
                @focus="focus"
                @click.native = "click()"
                size="small">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.subinventory_code + ': ' + data.subinventory_desc"
                    :value="data.subinventory_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-inventory',
  data() {
    return {
      rows: [],
      loading: false,
      result: this.value,
      organization_id: this.org_id
    };
  },
  props: [
    'value',
    'name',
    'index',
    'org_id',
    'org_desc'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        organization_id: this.org_id,
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/sub-inventory`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
        if (this.rows.length === 0 && this.org_desc) {
          swal('Warning', `${this.org_desc} ไม่มีคลังสินค้าในระบบ`, 'warning')
        }
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      // this.getDataRows({
      //   organization_id: this.org_id,
      //   keyword: ''
      // })
    },
     click () {
       
        this.getDataRows({
        organization_id: this.org_id,
        keyword: ''
      })
    },
    change (value) {
      let params = {
        code: '',
        desc: '',
        index: this.index
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.subinventory_code === value) {
            params.code = value
            params.desc = row.subinventory_desc
          }
        }
      } else {
        params.code = ''
        params.desc = ''
      }
      this.$emit('change-lov', params)
    },
  },
  mounted() {
    this.getDataRows({
      organization_id: this.org_id,
      keyword: ''
    })
  },
  watch: {
    // 'org_id' (newVal, oldVal) {
    //   this.organization_id = newVal
    //   this.getDataRows({
    //     organization_id: newVal,
    //     keyword: ''
    //   })
    // },
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  }
};
</script>

