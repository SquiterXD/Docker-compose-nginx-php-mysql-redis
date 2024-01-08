<template>
    <div>
        <form
            id="app"
            action="/pm/settings/save-publication-layout"
            method="get"
        >
            <div class="ibox">
                <div class="ibox-content">
                    <div class="text-right" style="padding-top: 5px;">
                        <button class="btn btn-light" type="submit">
                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา 
                        </button>
                        <a type="button" :href="'/pm/settings/save-publication-layout'" class="btn btn-danger">
                            ล้างค่า
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label class="w-100 text-left">
                                <strong> ประเภทสิ่งพิมพ์ </strong>
                            </label>
                            <input type="hidden" name="itemcat" v-model="search.itemcat" autocomplete="off">
                            <el-select  v-model="search.itemcat" 
                                        placeholder="โปรดเลือกประเภทสิ่งพิมพ์"
                                        class="w-100"
                                        filterable
                                        remote 
                                        clearable 
                                        reserve-keyword>
                                <el-option
                                    v-for="(item,index) in itemCatList"
                                    :key="index"
                                    :label="item.tobacco_code + ' : ' + item.description"
                                    :value="item.tobacco_code">
                                </el-option>
                            </el-select>
                        </div>

                        <div class="col-6">
                            <label class="w-100 text-left">
                                <strong> รหัสสิ่งพิมพ์ </strong>
                            </label>
                            <input type="hidden" name="itemNumber" v-model="search.itemNumber" autocomplete="off">
                            <el-select  v-model="search.itemNumber" 
                                        placeholder="โปรดเลือกรหัสสิ่งพิมพ์"
                                        class="w-100"
                                        filterable
                                        remote 
                                        clearable 
                                        reserve-keyword>
                                <el-option
                                    v-for="(list,index) in itemNumberSelectList"
                                    :key="index"
                                    :label="list.item_number + ' : ' + list.item_desc"
                                    :value="list.inventory_item_id">
                                </el-option>
                            </el-select>
                        </div>
                    </div>    
                </div>
            </div>
        </form>

        <save-publication-layout-table       :item-number-list = "itemNumberList" :url="url" :new-item="newItem">
        </save-publication-layout-table>
                
    </div>        
</template>

<script>
    import layoutTable from './TableComponent.vue'
    export default {
    components: { layoutTable },
    props: ['itemNumberList', 'itemCatList', 'resultSearch', 'itemNumberSelectList', 'url', "newItem"],
        data() {
            return {
                search: {
                    itemNumber: this.resultSearch ? this.resultSearch.itemNumber : '',
                    itemcat: this.resultSearch ? this.resultSearch.itemcat : '',
                },
                itemNumberShowDataList: this.itemNumberList.data,
            };
        },
        mounted() {
            // console.log(this.itemNumberList.data)
        },
        methods: {
            // getSearch() {
            //     let params = {
            //         ...this.search
            //     }
            //     axios
            //         .get('/pm/save-publication-layout', { params })
            //         // .then(res => {
            //         //     console.log(res)
            //         // });
            // },   
        }
    };
</script>