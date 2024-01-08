<template>
    <div class="ibox-content">
<!-- --------------------------------------------------- วัตถุดิบที่ใช้ --------------------------------------------------- -->
        <div>
            <div class="row mb-2">
                <div class="col-3">
                    <h4 class="no-margins"> กำหนดวัตถุดิบ </h4>
                </div>
                <div class="col-9 text-right" v-if="this.wipStep">
                     <!-- :disabled="this.check_add_line" -->
                    <!-- <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button> -->
                    <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine" :disabled="this.check_add_line"> <i class="fa fa-plus"></i> เพิ่ม </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table text-nowrap table-bordered  table-hover">
                    <thead>
                        <tr>
                            <th> ลำดับวัตถุดิบ </th>
                            <th v-if="this.check_org_multi_wip">ขั้นตอนการทำงาน</th>
                            <th style="min-width: 150px;"> รหัสวัตถุดิบ <span class="text-danger">*</span> </th>
                            <th> รายละเอียด </th>
                            <th> จำนวนตามสูตร <span class="text-danger">*</span> </th>
                            <th width="120px;"> % สูญเสีย </th>
                            <th> ปริมาณที่ต้องใช้ </th>
                            <th> หน่วยนับ </th>
                            <th> สถานะการใช้งาน </th>
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in lines"  :key="index" :row="row">
                            <input type="hidden" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_item_id]'"  :value="row.ingredient_item_id">
                            <input type="hidden" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'"  :value="row.ingredient_folmula_qty">
                            <input type="hidden" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][ingredient_loss]'"  :value="row.ingredient_loss">
                            <input type="hidden" :name="'dataGroupAll['+row.oprn_id+']['+row.id+'][active_flag]'"  :value="row.active_flag">
                            <template v-if="wipStep == row.oprn_id">
                                <td class="text-center">
                                    {{ row.ingredient_line }}
                                </td>
                                <td v-if="row.multi_wip">{{ row.oprn_desc }}</td>
                                <td >
                                    <div>
                                        <input type="hidden" :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_item_id]'"  :value="row.ingredient_item_id" autocomplete="off">
                                        <el-select  v-model="row.ingredient_item_id"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        class="w-100" 
                                                        size="medium"
                                                        :remote-method="getItemList"
                                                        @change="getItemData(row); getItemList(); checkDuplicate(row, index);"
                                                        ref="inventory_item"
                                                        placeholder="">              
                                            <el-option  v-for="item in itemLists"
                                                        :key="item.inventory_item_id"
                                                        :label="item.item_number"
                                                        :value="item.inventory_item_id">
                                                        <span>{{ item.item_number + ' : ' + item.item_desc }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>
                                </td>
                                <td> {{ row.description }} </td>
                                <td>
                                    <!-- <el-input :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'" v-model="row.ingredient_folmula_qty" size="medium" @input="onlyNumeric(row)"></el-input> -->
                                    <vue-numeric 
                                        separator="," 
                                        v-bind:precision="5" 
                                        v-bind:minus="false"
                                        :id="`input_ingredient_folmula_qty_${index}`"
                                        class="form-control input-sm text-right"
                                        :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_folmula_qty]'"
                                        v-model="row.ingredient_folmula_qty"
                                        @change="getIngredientQty(row, index)"
                                        :disabled="row.itemLoading"
                                    ></vue-numeric>
                                        <!-- @input="setFocus(row, index)" -->
                                        <!-- @change="getIngredientQty(row, index)" -->
                                </td>
                                <td>
                                    <!-- <el-input :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_loss]'" v-model="row.ingredient_loss" size="medium"  @input="onlyNumeric(row)"></el-input> -->
                                    <vue-numeric 
                                        separator="," 
                                        v-bind:precision="5" 
                                        v-bind:minus="false"
                                        :id="`input_ingredient_loss_${index}`"
                                        class="form-control input-sm text-right"
                                        :name="'dataGroup['+row.oprn_id+']['+row.id+'][ingredient_loss]'"
                                        v-model="row.ingredient_loss"
                                        @change="getIngredientQty(row, index)"
                                        :disabled="row.itemLoading"
                                    ></vue-numeric>
                                </td>
                                <td> {{ row.ingredient_qty | number5Digit }}</td>
                                <td class="text-center"> {{ row.ingredient_uom }} </td>
                                <td class="text-center"><input type="checkbox" :name="'dataGroup['+row.oprn_id+']['+row.id+'][active_flag]'" v-model="row.active_flag"></td>
                                <td>
                                    <div v-if="!row.disabledRow">
                                        <button @click.prevent="removeRow(row, index)" class="btn btn-sm btn-danger">
                                        X
                                        </button>
                                    </div>
                                </td>
                            </template>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
import VueNumeric from 'vue-numeric';
export default {
    props:['routings', 'defaultStep', 'defaultItems', 'wipSteps', 'wipStep', 'defaultSteps', 'defaultRoutingId', 'orgId', 'items', 'routingDesc', 'orgCode', 'folmulaTypeDesc'],
    
    components: {
        VueNumeric
    },

    data() {
        return {
            //
            routing_desc:  this.routingDesc ? this.routingDesc : '',
            wipStepList: [],
            oprns_id:    [],
            oprn_id:     '',
            step_no:     '',
            numberTest:  '',
            wip_step_id: '',

            routing_id: this.defaultRoutingId ? this.defaultRoutingId : '',
            org_id:     this.orgId            ? this.orgId            : '',
            org_code:   this.orgCode          ? this.orgCode          : '',
            //
            lines: [],
            itemLists: [],
            test_oprn: 1,
            desc: '',
            firstLoad: true,

            check_org_multi_wip: false,
            oprn_desc: '',
            folmula_type_desc: this.folmulaTypeDesc ? this.folmulaTypeDesc : '',
            listRows: [],
            check_add_line: false,
            focus_input: '',
        };
    }, 
    mounted() {
        console.log('Process Multi');

        this.getItemList();

        if (this.routing_id) {
            this.selectedData = this.wipSteps.find( i => {
                if (i.routing_id == this.routing_id) {
                    this.routing_desc = i.routing_desc;
                }
            });
            
            this.getWipStepList();
        }

        if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06') {
            this.check_org_multi_wip = true;
        }

    },
    watch: {
        wipStep : async function () {
            if (this.wipStep) {
                this.oprn_id = this.wipStep;

                this.selectedData = this.wipSteps.find( i => {
                    if (i.oprn_id == this.oprn_id) {
                        this.oprn_desc = i.oprn_desc;
                    }
                });

                this.oprn_id = this.wipStep;
                    
                if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06') {
                    
                } else {
                    if (this.folmula_type_desc == 'สูตรมาตรฐาน') {
                        
                    } else {
                        this.lines = [];
                    }
                } 
            }        
        },
        
        routingDesc : async function () {
            this.routing_desc = this.routingDesc;
            // if (this.routing_desc) {
                this.getWipStepList();
            // }           
        },

        lines : async function () {
            if (this.lines.length > 0) {
                this.check = this.lines.find(i => {
                    return i.ingredient_item_id == '';
                });
                if (this.check) {
                    this.check_add_line = true;
                } else {
                    this.check_add_line = false;
                }
            } else {
                this.check_add_line = false;
            } 
            
            this.$emit('lines', this.lines);         
        },

        folmulaTypeDesc : async function () {
            this.folmula_type_desc = this.folmulaTypeDesc;      
        },
    },
    methods:{
        // updateGlobalForm() {
        //     this.$emit(
        //         this.routing_no
        //     );
        // },
        addLine() {
            var number = this.lines.length + 1;
            var seq_raw_material = number + '0';
            var today = new Date();
            var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

            var row_no = 0;
            this.oprn_id = this.wipStep;

            if (this.lines.length > 0) {
                this.listRows = [];
                
                this.testXX = this.lines.find(i => {
                    if (i.oprn_id == this.oprn_id) {
                        this.listRows.push({
                            oprn_id : this.oprn_id,
                        });
                    }
                    
                });               
                row_no = this.listRows.length += 1;
                
            } else {
                row_no += 1;
            }
            
            this.lines.push({
                id                     : time,
                ingredient_step_line   : this.step_no,
                // ingredient_line        : seq_raw_material,
                ingredient_line        : row_no,
                ingredient_item_id     : '',
                description            : '',
                ingredient_folmula_qty : 0,
                ingredient_loss        : 0,
                ingredient_qty         : '',
                ingredient_uom         : '',
                active_flag            : true,
                disabledRow            : false,
                oprn_id                : this.oprn_id,
                multi_wip              : this.check_org_multi_wip,
                oprn_desc              : this.oprn_desc,
                itemLoading            : true,   
            });
            
        },
        // sortArrays(arrays) {
        //     return _.orderBy(arrays, 'ingredient_line', 'desc');
        // },
        removeRow: function (row, index) {
            this.lines.splice(index, 1);
        },
        async getItemList(query) {

            this.itemLists = [];
            let defIngredientItemId = [];
            if (this.firstLoad && this.defaultItems != undefined && this.defaultItems.length > 0) {
                // defIngredientItemId = (JSON.stringify(this.defaultItems))
                defIngredientItemId = this.defaultItems.map((number, x) => {
                    number = {
                        ingredient_item_id: number.ingredient_item_id
                    }
                    return number;

                  // return number*2
                })
                this.firstLoad = false
            }
            // console.log('aaaaaa', this.firstLoad, this.defaultItems, defIngredientItemId);

            axios.get("/pm/ajax/get-item", {
                params: {
                    org_id: this.org_id,
                    query:  query,
                    def_ingredient_item_id: defIngredientItemId,
                }
            })
            .then(res => {
                this.itemLists = res.data;
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getWipStepList(query) {

            this.wipStepList =  [],

            axios.get("/pm/ajax/get-wip-step", {
                params: {
                    routing_desc: this.routing_desc,
                    org_id:       this.org_id,
                    query:        query,
                }
            })
            .then(res => {
                this.wipStepList = res.data;
                

                if (this.defaultItems) {
                    var seq_raw_material = 1;
                    let itemDesc = '';
                    let uomDesc = '';                    
                    
                    this.defaultItems.forEach(line => {  
                    // this.listRows = [];
                        this.selectedData = this.wipStepList.find( i => {
                            return i.routingstep_no == line.ingredient_step_line;
                        }); 

                        this.selectedItem = this.items.find( i => {
                            if (i.inventory_item_id == line.ingredient_item_id) {
                                itemDesc = i.item_desc;
                                uomDesc  = i.primary_unit_of_measure;
                            }
                        });

                        this.step_no = line.ingredient_step_line;  
                        this.oprn_id = this.selectedData.oprn_id;   
                        
                        
                        if (this.oprns_id.length < 1) {
                            this.oprns_id.push(this.selectedData.oprn_id);
                        } else {
                            this.checkOprn = this.oprns_id.find(i => {
                                return  i == this.selectedData.oprn_id;
                            });
                            
                            if (!this.checkOprn) {
                                this.oprns_id.push(this.selectedData.oprn_id);
                            } 
                        }

                        var row_no = 0;
                        this.listRows = [];

                        if (this.lines.length > 0) {
                            this.selectedRow = this.lines.find(i => {
                                if (this.oprn_id == i.oprn_id) {
                                    this.listRows.push({
                                        oprn_id : this.oprn_id,
                                    });
                                }
                            });
                            
                                
                            row_no = this.listRows.length + 1;
                        } else {
                            row_no += 1; 
                        }
                        

                        let loss = '';

                        // let folmula_qty = line.ingredient_folmula_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        // let ingredient_qty = line.ingredient_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                        loss = (Number(line.ingredient_qty)/Number(line.ingredient_folmula_qty) * 100)-100;

                        //
                        this.lines.push({
                            id                     : line.line_no,
                            ingredient_step_line   : line.ingredient_step_line,
                            ingredient_line        : row_no,
                            ingredient_item_id     : line.ingredient_item_id,
                            description            : itemDesc,

                            ingredient_folmula_qty : line.ingredient_folmula_qty,
                            ingredient_loss        : line.scrap_factor,
                            ingredient_qty         : Number(line.ingredient_qty),

                            // ingredient_folmula_qty : Number(folmula_qty),
                            // ingredient_loss        : line.scrap_factor,
                            // ingredient_qty         : Number(ingredient_qty),

                            ingredient_uom         : uomDesc,
                            active_flag            : line.enable_flag == 'Y' ? true : false,
                            oprn_id                : this.selectedData.oprn_id,
                            disabledRow            : false,
                            multi_wip              : this.check_org_multi_wip,
                            oprn_desc              : this.selectedData.oprn_desc,
                            itemLoading            : false,
                        });  

                        seq_raw_material += 1;
                    }); 
                }
            })
            .catch(err => {
                console.log(err)
            });
        },
        newTableLine (routingstep_no, oprn_id, oprn_class_desc) {
            if (this.wipStep) {

                this.checkOprn = this.oprns_id.find(i => {
                    if (i != this.wipStep) {
                        this.lines = [];
                        this.oprns_id = [];
                    }
                });

                if (this.wipStep == oprn_id) {
                    this.step_no = routingstep_no;
                    this.oprn_id = oprn_id;
                    this.test_oprn = this.oprn_id;

                    if (this.oprns_id.length < 1) {
                        this.oprns_id.push(oprn_id);
                    } else {
                        this.checkOprn = this.oprns_id.find(i => {
                            return  i == oprn_id;
                        });
                        
                        if (!this.checkOprn) {
                            this.oprns_id.push(oprn_id);
                        } 
                    }

                    var number = this.lines.length + 1;
                    var seq_raw_material = number + '0';

                    var today = new Date();
                    var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

                    
                    this.lines.push({
                        id                   : time,
                        ingredient_step_line : this.step_no,
                        ingredient_line      : seq_raw_material,
                        ingredient_item_id   : '',
                        description          : '',
                        number_folmula       : '',
                        ingredient_loss      : 0,
                        ingredient_qty       : '',
                        ingredient_uom       : '',
                        active_flag          : true,
                        disabledRow          : false,
                        oprn_id              : this.oprn_id,
                        multi_wip            : this.check_org_multi_wip,
                        oprn_desc            : this.oprn_desc,
                        itemLoading          : true,
                    });
                }

            } else {
                if (this.oprns_id.length < 1) {
                    this.oprns_id.push(oprn_id);
                } else {
                    this.checkOprn = this.oprns_id.find(i => {
                        return  i == oprn_id;
                    });

                    if (!this.checkOprn) {
                        this.oprns_id.push(oprn_id);
                    } 
                }
                this.step_no = routingstep_no;
                this.oprn_id = oprn_id;

                var number = this.lines.length + 1;
                var seq_raw_material = number + '0';

                var today = new Date();
                var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

                this.lines.push({
                    id                   : time,
                    ingredient_step_line : this.step_no,
                    ingredient_line      : seq_raw_material,
                    ingredient_item_id   : '',
                    description          : '',
                    number_folmula       : '',
                    ingredient_loss      : 0,
                    ingredient_qty       : '',
                    ingredient_uom       : '',
                    active_flag          : true,
                    disabledRow          : false,
                    oprn_id              : oprn_id,
                    multi_wip            : this.check_org_multi_wip,
                    oprn_desc            : this.oprn_desc,
                    itemLoading          : true,
                });
            }
        },
        getItemData(row) {
            if (row.ingredient_item_id) {
                row.itemLoading = false;
                this.selectedData = this.itemLists.find( i => {
                    if (i.inventory_item_id == row.ingredient_item_id) {
                        row.description    = i.item_desc;
                        row.ingredient_uom = i.primary_unit_of_measure;
                    }
                });
                this.check_add_line = false;
            } else {
                row.itemLoading    = true;
                row.description    = '';
                row.ingredient_uom = '';
            }
        },
        onlyNumeric(row) {
            
            row.ingredient_folmula_qty = row.ingredient_folmula_qty.replace(/[^0-9 .]/g, '');
            //  if (row.ingredient_loss) {
            //     row.ingredient_loss        = row.ingredient_loss.replace(/[^0-9 .]/g, '');
            //  }
            row.ingredient_qty         = Number(row.ingredient_folmula_qty) * Number(row.ingredient_loss) / 100 + Number(row.ingredient_folmula_qty);
            // row.ingredient_qty         = Number(row.ingredient_folmula_qty) + (Number(row.ingredient_loss) * Number(row.ingredient_folmula_qty));
            row.ingredient_folmula_qty = row.ingredient_folmula_qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // if (row.ingredient_loss) {
            //     row.ingredient_loss        = row.ingredient_loss.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            // }

            // row.ingredient_qty         = row.ingredient_qty.toLocaleString()

        },
        checkDuplicate(row, index) {
            if (row.ingredient_item_id) {
                if (index > 0) {
                    var idx = this.lines.find(line => {
                        if (line.id != row.id) {
                            if (row.ingredient_item_id == line.ingredient_item_id) {
                                row.ingredient_item_id = '';
                                swal({
                                    title: "มีข้อผิดพลาด",
                                    text: 'ไม่สามารถเลือกรหัสวัตถุดิบซ้ำกันได้',
                                    timer: 3000,
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        }
                    });
                }
            }
        },
        getIngredientQty(row, index){
            // if (!row.ingredient_item_id) {
            //     this.setFocus(row, index);
            // }
            row.ingredient_qty  = Number(row.ingredient_folmula_qty) * Number(row.ingredient_loss) / 100 + Number(row.ingredient_folmula_qty);
        },

        setFocus(row, index) {
            if (!row.ingredient_item_id) {

                row.ingredient_folmula_qty = 0;
                row.ingredient_loss = 0;

                var barcodes = document.createElement('tr');

                const nbBarcodes = this.$refs.inventory_item.length;
                this.$refs.inventory_item[nbBarcodes - 1].focus();

            }            
        },
    },
}
</script>

<style scoped>
.border_table{
    border: 1px solid #DCDFE6 !important;

}
</style>
