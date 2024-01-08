<template>
  <div class="el_select">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                @focus="focus"
                filterable
                :size="size"
                @change="change"
                :popper-append-to-body="popperBody">
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
    name: 'ir-components-lov-asset-group',
    data () {
      return {
        rows: [],
        loading: false,
        result: this.value
      }
    },
    props: [
      'placeholder',
      'name',
      'value',
      'size',
      'popperBody'
    ],
    methods: {
      remoteMethod (query) {
        this.getDataRows({ meaning: '', keyword: query });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/location`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.rows = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focus (event) {
        this.getDataRows({ meaning: '', keyword: '' });
      },
      change (value) {
        let params = {
          id: '',
          code: '',
          desc: ''
        }
        if (value) {
          for (let i in this.rows) {
            let data = this.rows[i]
            if (data.meaning === value) {
              params.code = value,
              params.desc = data.description,
              params.id = data.meaning
            }
          }
        } else {
          params.id = ''
          params.code = ''
          params.desc = ''
        }
        this.$emit('change-lov', params)
      }
    },
    mounted() {
      this.getDataRows({ meaning: '', keyword: '' })
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal
      }
    }
  }
</script>

