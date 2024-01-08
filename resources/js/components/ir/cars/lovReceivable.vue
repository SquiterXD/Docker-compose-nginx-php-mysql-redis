<template>
  <div class="el_select">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethodReceivable"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                :size="size"
                @change="changeReceivable"
                @focus="focusReceivable"
                :disabled="disabled"
                :popper-append-to-body="popperBody">
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
    name: 'ir-components-lov-receivable',
    data () {
      return {
        receivables: [],
        loading: false,
        result: this.value
      }
    },
    props: [
      'placeholder',
      'name',
      'value',
      'disabled',
      'size',
      'popperBody'
    ],
    methods: {
      remoteMethodReceivable (query) {
        this.getReceivables({
          value: '',
          keyword: query
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
          keyword: ''
        });
      },
      changeReceivable (value) {
        let obj = {
          code: '',
          id: '',
          desc: ''
        }
        if (value) {
          for (let i in this.receivables) {
            let row = this.receivables[i]
            if (row.description === value) {
              obj.desc = value;
              obj.code = row.meaning;
              obj.id = '';
            }
          }
        } else {
          obj.code = '';
          obj.id = '';
          obj.desc = '';
        }
        this.$emit('change-lov', obj)
      }
    },
    mounted() {
      // this.getReceivables({
      //   value: '',
      //   keyword: ''
      // })
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
      }
    }
  }
</script>

