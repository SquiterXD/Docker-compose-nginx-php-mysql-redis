<template>
  <div class="el_select">
    <input type="hidden" name="group_code" :value="group_code" autocomplete="off">
    <el-select  v-model="group_code"
                filterable
                remote
                :remote-method="remoteMethod"
                :loading="loading"
                @change="change"
                :clearable="true"
                placeholder="กลุ่ม">
      <el-option  v-for="(data, index) in groups"
                  :key="index"
                  :label="`${data.meaning}`"
                  :value="data.group_code"
      ></el-option>
    </el-select>
  </div>
</template>

<script>
export default {
    name: 'ir-select-group',
    data() {
      return {
        groups: [],
        loading: false,
        group_code: this.valueTypeCost,
        account_id: ''
      }
    },
    props: [
      'valueTypeCost'
    ],
    mounted() {
      this.getGroupCode({ account_id: '', keyword: '' });
    },
    methods: {
      remoteMethod() {
        this.getGroupCode();
      },
      getGroupCode() {
        this.loading = true;
        axios.get(`/ir/ajax/lov/group-code`)
        .then(({data: response}) => {
          this.loading = false
          this.groups = response.data
        });
      },
      change (value) {
        if (value) {
          this.callbackGroupCode(value)
        } else {
          this.callbackGroupCode('')
        }
      },
      callbackGroupCode (value) {
        this.$emit('group', value)
      }
    },
    updated () {
      this.$nextTick(function () {
        let data = window.localStorage.getItem('data')
        let result = JSON.parse(data)
        this.account_id = location.href.split("/")[7]
      })
    },
    watch: {
      'valueTypeCost' (newVal, oldVal) {
        this.group_code = newVal
      }
    }
};
</script>

<style>
  .el_select .el-select {
    width: 100%;
  }
</style>
