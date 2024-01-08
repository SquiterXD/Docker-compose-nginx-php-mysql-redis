<template>
  <div class="el_field">
    <el-select  v-model="result"
                placeholder="กรมธรรม์ชุดที่"
                :name="name"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                @change="change"
                :size="size">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="`${data.policy_set_number} : ${data.policy_set_description}`"
                  :value="data.policy_set_header_id">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-policy-set-header-id',
  data() {
    return {
      rows: [],
      loading: false,
      result: parseInt(this.value) ? parseInt(this.value) : ''
    };
  },
  props: [
    'value',
    'name',
    'size'
  ],
  methods: {
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-set-header`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    change (value) {
      this.$emit('changePolicyHeader', value)
    },
  },
  mounted() {
    this.getDataRows({
      policy_set_header_id: '',
      keyword: ''
    })
  },
  watch: {
    value(newVal) {
      this.result = parseInt(newVal) ? parseInt(newVal) : ''
    }
  }
};
</script>

