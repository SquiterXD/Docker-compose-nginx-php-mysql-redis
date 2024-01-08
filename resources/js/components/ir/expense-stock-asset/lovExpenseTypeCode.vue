<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                placeholder="ประเภทของประกันภัย"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                @change="change"
                @focus="focus"
                :popper-append-to-body="popperBody"
                :size="size">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.description"
                    :value="data.lookup_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-expense-stock-asset-lov-expense-type-code',
  data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: [
    'value',
    'name',
    'index',
    'size',
    'popperBody'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        lookup_code: '',
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/exp-asset-stock-type`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      this.getDataRows({
        lookup_code: '',
        keyword: ''
      })
    },
    change (value) {
      let find = this.rows.find(item => {
        return item.lookup_code === value;
      });
      if(find){
        this.$emit('change-lov', find)
      }else {
        this.$emit('change-lov', null)
      }
    },
  },
  mounted() {
    this.getDataRows({
      lookup_code: '',
      keyword: ''
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  }
};
</script>

