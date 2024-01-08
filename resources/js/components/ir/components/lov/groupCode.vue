<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :clearable="true"
                @change="change"
                :popper-append-to-body="popperBody"
                :size="size">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.meaning"
                  :value="data.group_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-group-code',
  data() {
    return {
      rows: [],
      result: this.value
    };
  },
  props: [
    'value',
    'name',
    'size',
    'placeholder',
    'popperBody',
  ],
  methods: {
    getDataRows() {
      let params = {
        group_code: ''
      }
      axios.get(`/ir/ajax/lov/group-code`, { params })
      .then(({data}) => {
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    change (value) {
      this.$emit('change-lov', value)
    },
  },
  created () {
    this.getDataRows()
  }
};
</script>

