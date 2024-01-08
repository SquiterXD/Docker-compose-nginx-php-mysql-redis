<template>
  <div class="el_select">
    <el-select  v-model="category_code"
                :placeholder="'รหัสหมวด'"
                :name="attrName"
                :remote-method="remoteMethodCategory"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                size="small"
                @change="changeCategory"
                @focus="focusCategory">
      <el-option  v-for="(data, index) in categories"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-increase-lov-category',
    data () {
      return {
        categories: [],
        loading: false,
        category_code: this.categoryId
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'categoryId',
      'row'
    ],
    methods: {
      remoteMethodCategory (query) {
        this.getCategories({ value: '', keyword: query });
      },
      getCategories (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/category-seg4`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.categories = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusCategory (event) {
        this.getCategories({ value: '', keyword: '' });
      },
      changeCategory (value) {
        if (value) {
          for (let i in this.categories) {
            let cate = this.categories[i]
            if (cate.meaning === value) {
              this.row.category_code = value
              this.row.category_description = cate.description
              this.row.category_id = cate.value
            }
          }
        } else {
          this.row.category_code = ''
          this.row.category_description = ''
          this.row.category_id = ''
        }
      }
    },
    mounted() {
      this.getCategories({ value: '', keyword: '' })
    },
    watch: {
      'categoryId' (newVal, oldVal) {
        this.category_code = newVal;
      }
    }
  }
</script>

