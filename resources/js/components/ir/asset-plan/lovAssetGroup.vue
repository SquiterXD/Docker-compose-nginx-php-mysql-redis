<template>
  <div class="el_select">
    <el-select  v-model="asset_group_code"
                :placeholder="'กลุ่มของทรัพย์สิน'"
                :name="attrName"
                :remote-method="remoteMethodAssetGroup"
                :loading="loading"
                remote
                :clearable="true"
                @focus="focusAssetGroup"
                filterable
                :size="size"
                @change="changeAssetGroup">
      <el-option  v-for="(data, index) in assetGroup"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-plan-lov-asset-group',
    data () {
      return {
        assetGroup: [],
        loading: false,
        asset_group_code: this.value
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'value',
      'isTable',
      'row',
      'size'
    ],
    methods: {
      remoteMethodAssetGroup (query) {
        this.getAssetGroup({ meaning: '', keyword: query });
      },
      getAssetGroup (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/location`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.assetGroup = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusAssetGroup (event) {
        this.getAssetGroup({ meaning: '', keyword: '' });
      },
      changeAssetGroup (value) {
        let param = {
          asset_group: '',
          row: '',
          asset_group_name: '',
          id: ''
        }
        if (this.isTable && value) {
          for (let i in this.assetGroup) {
            let data = this.assetGroup[i]
            if (data.meaning === value) {
              param.asset_group = value,
              param.row = this.row,
              param.asset_group_name = data.description,
              param.id = data.value
              this.$emit('change-value-asset-group', param)
            }
          }
        } else if (this.isTable && !value) {
          this.$emit('change-value-asset-group', param)
        } else {
          this.$emit('change-value-asset-group', value)
        }
      }
    },
    mounted() {
      this.getAssetGroup({ meaning: '', keyword: '' })
    },
    watch: {
      'value' (newVal, oldVal) {
        this.asset_group_code = newVal;
      }
    }
  }
</script>

