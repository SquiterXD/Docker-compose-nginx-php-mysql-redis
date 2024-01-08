<template>
    <div>
        <div class="ibox" v-loading="is_loading">
            <div class="ibox-title">
                <h5> บันทึก Layout สิ่งพิมพ์ </h5>
                <button
                    class="btn btn-sm btn-primary pull-right"
                    @click.prevent="addItem">
                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ
                </button>
            </div>
            <div class="ibox-content table-responsive">
                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th width="10%" class="text-center" style="font-size: small;">
                                <div>รหัสสิ่งพิมพ์</div>
                            </th>
                            <th  class="left-center" style="font-size: small;">
                                <div>รายละเอียด</div>
                            </th>
                            <th width="340px;" class="text-center" style="font-size: small;">
                                <div> </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-for="(item, index) in itemNumberShowDataList" :key="index">
                        <tr>
                            <td class="text-center">
                                <template v-if="item.is_new_row">
                                    <input type="text" class="form-control" v-if="!item.is_edit_item" value=""
                                        @click="clickSelcet(item, index, 'item_list')" >
                                    <el-select  v-if="item.is_edit_item" v-loading="item.loading"
                                        :ref="'item_list_'+ index"
                                        v-model="item.inventory_item_id"
                                        filterable
                                        placeholder=""
                                        @change="selectItem(item)"
                                        :loading="item.loading"  >
                                        <el-option
                                            v-for="(line, index) in item.item_list"
                                            :key="line.value"
                                            :label="line.label"
                                            :value="String(line.value)"
                                        >
                                            <span style="float: left">{{ line.label }}</span>
                                        </el-option>
                                    </el-select>
                                </template>
                                <template v-else>
                                    {{ item.item_number }}
                                </template>
                            </td>
                            <td class="left-center">
                                {{ item.item_desc }}
                            </td>
                            <td class="text-center">
                                <button
                                    class="btn btn-sm btn-default"
                                    @click.prevent="getTableResults(item.item_number)"
                                >
                                    <i class="fa fa-edit"></i> กำหนด Layout
                                </button>
                                <button
                                    class="btn btn-sm btn-default"
                                    @click.prevent="item.conversion_rate_showed = !item.conversion_rate_showed"
                                >
                                    <i class="fa fa-edit"></i> กำหนด เครื่องเขีบนแบบพิมพ์
                                </button>
                                <conversion-rate v-if="item.conversion_rate_showed" :item="item" :url="url" @closwShowRate="closwShowRate(...arguments, item)" />
                            </td>
                        </tr>
                        <tr v-if="item.specification_showed">
                            <td colspan="3">
                                <save-publication-layout-table-results  :resultsTable = "resultsTable"
                                                                        :primaryUomCode = "primaryUomCode"
                                                                        :primaryUnitOfMeasure = "primaryUnitOfMeasure"
                                                                        :itemNumber = "itemNumber"
                                                                        :customUomList="customUomList"
                                                                        @reload="reloadResult">
                                </save-publication-layout-table-results>
                            </td>
                        </tr>
                        <!-- <tr v-if="item.conversion_rate_showed">
                            <td colspan="3">
                                <conversion-rate :item="item" :url="url"  />
                            </td>
                        </tr> -->
                    </tbody>             
                </table>
            </div>
        </div>
    </div>        
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import moment from "moment";

    import ConversionRate from './ConversionRate';
    export default {
    components: {
        ConversionRate
    },
    props: ["itemNumberList", "url", "newItem"],
        data() {
            return {
                resultsTable: '',
                primaryUomCode: '',
                primaryUnitOfMeasure: '',
                customUomList: [],
                is_loading: false,
                itemNumber: '',
                itemNumberShowDataList: Object.keys(this.itemNumberList.data).map(key => {
                    return Number(key), this.itemNumberList.data[key];
                }),
            };
        },
        mounted() { 
            // this.getTableResults('11030AGD102')
        },
        methods: {
            async closwShowRate(res, item) {
                item.conversion_rate_showed = false;
            },
            async addItem() {
                let vm = this;
                let row = vm.itemNumberShowDataList.length;
                let newLine = await _.clone(vm.newItem);
                // vm.$set(vm.itemNumberShowDataList, row, newLine);
                vm.itemNumberShowDataList = [newLine , ...vm.itemNumberShowDataList]
            },
            async selectItem(item) {
                let vm = this;
                item.item_number            = '';
                item.item_desc              = '';
                item.tobacco_group_code     = '';
                item.tobacco_type_code      = '';

                let data = item.item_list.findIndex(o => o.value == item.inventory_item_id);
                    data = item.item_list[data];
                if (data) {
                    item.item_number        = data.item_number;
                    item.item_desc          = data.item_desc;
                    item.tobacco_group_code = data.tobacco_group_code;
                    item.tobacco_type_code  = data.tobacco_type_code;
                }
            },
            async reloadResult(resInput) {
                console.log('reloadResult', resInput);
                this.getTableResults(resInput, true)
            },
            getTableResults(value, reload = false) {
                console.log('getTableResults', value);
                this.itemNumberShowDataList.forEach(async (element, i)  => {
                    if(element.item_number == value){
                        if (!this.itemNumberShowDataList[i].specification_showed || reload) {
                            this.is_loading = true;
                            var params = {
                                itemNumber: value
                            };
                            return await axios
                                .get('/pm/ajax/save-publication-layout/get-table-results',{ params })
                                .then(res => {
                                    this.itemNumber = res.data.itemNumber;
                                    this.resultsTable = res.data.setupLayout.data;
                                    this.primaryUomCode = res.data.primaryUomCode;
                                    this.primaryUnitOfMeasure = res.data.primaryUnitOfMeasure;
                                    this.customUomList = res.data.customUomList;
                                    this.itemNumberShowDataList[i].specification_showed = true;
                                    this.is_loading = false;
                                });
                        }
                        this.itemNumberShowDataList[i].specification_showed = !this.itemNumberShowDataList[i].specification_showed;
                    }else{
                        this.itemNumberShowDataList[i].specification_showed = false;
                    }
                });
            },  
            async clickSelcet(line, i, type) {
                let vm = this;
                let remoteMethodRes = new Promise(async (resolve, reject) => {
                    line.is_edit_item = true
                    line.loading = true;
                    await vm.remoteMethod(' ', line, type)
                    line.loading = false;
                    vm.$nextTick(() => {
                        const input = vm.$refs[type + '_' + i][0];
                        input.focus();
                    });
                    resolve(true);
                });
                let resultRemoteMethod = await remoteMethodRes;
            },
            async remoteMethod(query, row, inputName) {
                row[inputName] = [];
                let vm = this;
                let lines = vm.itemNumberShowDataList.filter(o => {
                        return o.is_deleted == false && o.is_new_row;
                    });
                let except  = [... new Set(lines.map(o => o.inventory_item_id)) ];

                if (query !== "") {
                    await this.getData({
                        action: 'get-items',
                        number: query,
                        type: inputName,
                        except: except,
                    }, row, inputName);
                }
            },
            async getData(params, row, inputName) {
                let vm = this;
                row.loading = true;
                await axios.get(vm.url.save_publication_layout_idx, { params }).then(res => {
                    let response = res.data
                    row.loading = false;
                    row[inputName] = response;
                });
            }
        }
    };
</script>