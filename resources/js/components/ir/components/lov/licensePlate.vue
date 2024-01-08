<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                @focus="focus"
                filterable
                @change="change"
                :popper-append-to-body="popperBody"
                :size="size">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.license_plate"
                  :value="data.license_plate">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-license-plate',
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
    'size',
    'placeholder',
    'popperBody',
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        license_plate: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/license-plate`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      if(this.rows.length === 0){
        this.getDataRows({
            license_plate: ''
        })
      }
    },
    change (value) {
      this.$emit('change-lov', value)
    },
  },
  created(){
      this.getDataRows({
        license_plate: ''
      })
  },
  mounted() {
    // this.getDataRows({
    //   license_plate: ''
    // })
  }
};
</script>

