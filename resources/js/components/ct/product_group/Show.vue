<template>
  <div class="list-product-groups">
    <div class="col-lg-12 mt-2">
      <el-card
      class="box-card my-2"
    >
      <div slot="header" class="ct-header clearfix">
        ศูนย์ต้นทุน {{product_group.cost_code}} {{product_group.cost_description}} 
      </div>
      <div class="px-4 py-2" v-loading="form.loading_data">
        <div class="row">
          <div class="col-6">
            <div>
              กลุ่มผลิตภัณฑ์: {{product_group.product_group}} - {{product_group.description}}
            </div>
            <div class="mt-5">
              <!-- <div class="ct-table">
                <div class="ct-table__header">
                  ผลิตภัณฑ์
                </div>
                <div v-if="tableData.length <= 0">
                  ไม่พบข้อมูล
                </div>
                <div v-for="(item, index) in tableData" :key="index">
                  {{item.product_item_number}} - {{item.product_item_desc}}
                </div>
              </div> -->
              <div class="slimScroll">
                  <table class="table table table-bordered">
                      <thead>
                        <tr>
                          <th width="10px;">
                          </th>
                          <th width="">
                              ผลิตภัณฑ์
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                          <tr v-if="tableData.length == 0">
                              <td colspan="2" class="text-center">ไม่พบข้อมูล</td>
                          </tr>
                          <tr v-else v-for="(item, index) in tableData" :key="index">
                              <td class="align-middle text-center">
                                  <input type="checkbox" v-model="item.is_delete" @change="delLine(item)">
                              </td>
                              <td>{{item.product_item_number}} - {{item.product_item_desc}}</td>
                          </tr>
                      </tbody>
                  </table>
              </div>
            </div>
          </div>
          <div class="col-6 text text-right" v-loading="form.loading">
              <!-- <el-button
                  :disabled="tableData.length > 0"
                  @click="store()"
                  class="btn btn-success m-px__5"
                  type="success"
              >
                  เพิ่มผลิตภัณฑ์ใหม่
              </el-button>
              <a :href="`/ct/product_group`">
                <el-button
                    class="btn btn-danger m-px__5"
                    type="danger"
                >
                    ย้อนกลับ
                </el-button>
              </a> -->
              <div class="text-right">
                  <button v-if="Object.keys(form.delItems).length > 0" class="btn btn-danger btn-lg ml-2 tw-w-34" @click="del()" type="button" >
                    ลบผลิตภัณฑ์
                  </button>
                  <button class="btn btn-primary btn-lg ml-2 tw-w-34" type="button" @click="form.show = true" >
                      เพิ่มผลิตภัณฑ์ใหม่
                  </button>
                  <button :disabled="form.items.length == 0" class="btn btn-success btn-lg ml-2 tw-w-24" @click="save()" type="button" >
                    บันทึก
                  </button>
                  <a :href="`/ct/product_group`" class="btn btn-danger ml-2 btn-lg tw-w-24" >
                    ย้อนกลับ
                  </a>
              </div>


              <transition enter-active-class="animated fadeIn" leave-active-class="animated fadeOut">
                <div class="row text-left" v-if="form.show">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
                        <label class="text-left text-muted tw-font-bold tw-uppercase mb-0" >ผลิตภัณฑ์ :</label>
                        <div class="input-group ">
                            <el-select v-model="form.items" filterable clearable multiple placeholder=""
                                  remote
                                  :remote-method="remoteMethod"
                                  :loading="loading" style="width: 100%;">
                                <el-option
                                  v-for="item in itemCostingV"
                                  :key="item.value"
                                  :label="item.label"
                                  :value="item.value"
                                  :debounce="3000"
                                  
                                  >
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <div class="text-center form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-3">
                        <button  class="btn btn-white btn-lg  tw-w-24" @click="cancel()" type="button" >
                            ยกเลิก
                        </button>
                    </div>

                </div>
              </transition>
          </div>
        </div>
      </div>
    </el-card>
    </div>
  </div>
</template>

<script>
export default {
  props:['product_group', 'product', 'new_products', 'p_cost_code', 'p_product_group'],
  data() {
    return {
      tableData: [],
      loading: false,
      itemCostingV: [],
      form : {
        loading_data: false,
        show: false,
        loading: false,
        items: [],
        delItems: {},
      }
    };
  },
  mounted() {
    this.itemCostingV = this.new_products
    this.tableData = this.product
    $('.slimScroll').slimScroll({
        height: '650px',
        // width: '100%'
    });
  },
  methods: {
    remoteMethod(query) {
      if (query) {
        console.log("query", query)
        this.loading = true
        axios.get(`/ct/ajax/product_group/item_costing?search=${query}`)
        .then((res) => {
          //  console.log(res.data)
           const {data} = res.data
           console.log(data)
           this.itemCostingV = data
        }).catch(err => {
  
        }).then(() => {
          this.loading = false
        })
      }
    },
    store(){
       axios.post(`/ct/ajax/product_group/product-item`, this.product_group).then((res) => {
         const {data} = res.data
         this.$message({
            showClose: true,
            message: data,
            type: "success"
        });
      }).catch(err => {
        const {data} = err.response.data
        this.$message({
            showClose: true,
            message: data,
            type: "error"
        });
      });
    },
    async delLine(item) {
        let vm = this;
        let row = Object.keys(vm.form.delItems).length;
        if (item.is_delete == true) {
            vm.$set(vm.form.delItems, item.inventory_item_id, item.inventory_item_id);
        } else {
            // vm.delete( vm.form.delItems, item.inventory_item_id);
            Vue.delete(vm.form.delItems, item.inventory_item_id)
        }

    },
    async cancel() {
        this.form.show = false;
        this.form.items = [];
    },
    async save() {
        let vm = this;
        let alertRes;
        let input = {
            cost_code: vm.p_cost_code,
            product_group: vm.p_product_group,
            items: vm.form.items,
        };

        vm.form.loading = true;
        axios.post(`/ct/ajax/product_group/store-product-item`, {input : input})
            .then(async (res) => {
                let data = res.data;
                if (data.status == 'S') {
                    await swal({
                        title: '&nbsp;',
                        text: 'บันทึกข้อมูลสำเร็จ',
                        type: "success",
                        html: true
                    });

                    vm.form.items = [];
                    location.reload();
                    // vm.fetchData();
                }

                if (data.status != 'S') {
                    alertRes = swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                    location.reload();
                }
                vm.form.loading = false;
            })
    },
    async del() {
        let vm = this;
        let alertRes;
        let confirm = false;
        let input = {
            cost_code: vm.p_cost_code,
            product_group: vm.p_product_group,
            del_items: vm.form.delItems,
        };

        confirm = await helperAlert.showProgressConfirm('กรุณายืนยันลบข้อมูล');
        if (confirm) {
            vm.form.loading_data = true;
            axios.post(`/ct/ajax/product_group/del-product-item`, {input : input})
                .then(async (res) => {
                    let data = res.data;
                    if (data.status == 'S') {
                        await swal({
                            title: '&nbsp;',
                            text: 'บันทึกข้อมูลสำเร็จ',
                            type: "success",
                            html: true
                        });

                        vm.form.delItems = {};
                        location.reload();
                        // vm.fetchData();
                    }

                    if (data.status != 'S') {
                        alertRes = swal({
                            title: "Error !",
                            text: data.message,
                            type: "error",
                            showConfirmButton: true
                        });
                        location.reload();
                    }
                    vm.form.loading_data = false;
                })
        }

    },
  },
};``
</script>
<style lang="scss" scoped>
.ct-header {
  font-size: 1.1rem;
  font-weight: bold;
}
.ct-table {
  border: 1px solid #ddd;
  div {
    padding: 10px;
    &:not(:last-child){
      border-bottom: 1px solid #ddd;
    }
  }
}
.ct-table__header {
  background: #ddd;
  font-weight: bold;
  
}
.el-table .warning-row {
    background-color: oldlace !important;
}
.side_list {
    height: 500px;
    border-radius: 5px;
    padding: 20px;
    border: 2px solid #eee;
    .title {
        font-size: 14px;
        font-weight: bold;
        color: #909399;
    }
    .show_list {
        max-height: 400px;
        overflow: scroll;
        &-item {
            width: 100%;
            justify-content: space-between;
        }
    }
}
.m-px__5 {
    margin: 5px;
}
.flex {
    display: flex;
}
.text-title {
    font-size: 16px;
    font-weight: 600;
}
.btn-info {
    background-color: #02b0ef;
    border-color: #02b0ef;
}

.btn-cancel {
    background-color: #ec4958;
    border-color: #ec4958;
    color: white;
}
.text-refresh {
    color: #ec4958;
}
.show_list {
    display: flex;
    flex-wrap: wrap;
    &-item {
        cursor: pointer;
        display: flex;
        margin: 5px;
        background-color: #f4f4f5;
        padding: 3px 10px;
        color: #909399;
        border-color: #e9e9eb;
        border-radius: 3px;
        text-align: left;
        align-items: center;
        &:hover {
            background-color: #ededf0;
        }
        &__close {
            margin-left: 10px;
        }
    }
}
</style>
