<template>
    <div>
        <h4>สูตรการผลิต</h4>
        <div class="row">
            <div class="col-md-4">
                <label class="ml-3"> <b>รหัสสินค้า</b>  </label>
                <label class="ml-3">{{ header.product_segment1 + ' ' + header.product_description }}</label>
            </div>
            <div class="col-md-4">
                <label> <b>สถานะ</b> </label>
                <label class="ml-3">
                    {{ this.status }}
                </label>
            </div>
            <div class="col-md-3">
                <label> <b>ผู้อนุมัติ</b> </label>
                <label class="ml-3">{{ this.userName }}</label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label class="ml-3"> <b>ประเภทสูตร</b> </label>
                <label class="ml-3">{{ this.formulaType }} </label>
                <!-- <label class="ml-3">{{ $header->FormulaType ? $header->FormulaType->description : ''  }}</label> -->
            </div>
            <div class="col-md-4">
                <label> <b>Version</b> </label>
                <label class="ml-3">{{ this.header.version }} </label>
            </div>
            <div class="col-md-3">
                <label> <b>ปีงบประมาณ</b> </label>
                <label class="ml-3">{{ this.header.period_year }} </label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label class="ml-3"> <b>ประเภทสิ่งผลิต</b> </label>
                <label class="ml-3"> {{ this.header.routing_desc }} </label>
            </div>
            <div class="col-md-4">
                <label> <b>จำนวนผลผลิต</b> </label>
                <label class="ml-3"> {{ this.header.qty | number0Digit }} {{ this.uomName}}</label>
            </div>
            
            <div class="col-md-3">
                <label> <b>วันที่เริ่มใช้งาน</b> </label>
                <label class="ml-3">
                    {{ this.startDate }} 
                </label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <div class="ml-3">
                    <div>
                        <label> <b>ขั้นตอนการทำงาน</b> </label>
                        <label> {{ this.wipStep }} </label>
                    </div>
                    <template v-for="wipStepHeader in wipSteps[routing_desc]" class="ml-3">
                        <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id" @change="getTable()">
                            {{ wipStepHeader.oprn_desc }}
                        </el-radio>
                    </template>
                </div>
            </div>
            <div class="col-md-4">
                <label> <b>ประเภทเครื่องจักร</b> </label>
                <label class="ml-3">
                    {{ this.machine }}
                </label>
            </div>
            <div class="col-md-3">
                <label> <b>วันที่สิ้นสุดการใช้งาน</b> </label>
                <label class="ml-3">
                    {{ this.endDate }} 
                </label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-8">
                <label class="ml-3"> <b>หมายเหตุ</b> </label>
                <label class="ml-3">
                    {{ this.header.comments }} 
                </label>
            </div>
            <div class="col-md-3">
                <label> <b>กองบริหารต้นทุนนำไปใช้แล้ว</b> </label>
                <label class="ml-3">
                    <!-- <input type="checkbox" name="invoice_flag" v-model="invoice_flag" disabled> -->
                    <template v-if="invoice_flag">
                        <i class="fa fa-check-circle text-success"></i>
                    </template>
                    <template v-else>
                        <i class="fa fa-circle text-muted"></i>
                    </template>
                </label>
            </div>
        </div>

    <!-- ------------------------------------------- LINE ------------------------------------------- -->
        <div class="mt-5">
            <h4>วัตถุดิบที่ใช้</h4>
            <div class="ml-3">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> 
                                    <div class="text-center" style="width: 80px;">ลำดับวัตถุดิบ </div>
                                </th>
                                <th> 
                                    <div class="text-center" style="width: 80px;">รหัสวัตถุดิบ</div>
                                </th>
                                <th> 
                                    <div class="text-center" style="width: 180px;">รายละเอียด</div>
                                </th>
                                <th> <div class="text-center" style="width: 90px;">จำนวนตามสูตร</div>  </th>
                                <th> <div class="text-center" style="width: 60px;">% สูญเสีย</div>      </th>
                                <th> <div class="text-center" style="width: 100px;">ปริมาณที่ต้องใช้</div>  </th>
                                <th> <div class="text-center" style="width: 60px;">หน่วยนับ</div>       </th>
                                <th> <div class="text-center" style="width: 120px;">สถานะการใช้งาน</div> </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in datas"  :key="index" :row="row">
                                <template v-if="multi_wip_step === row.oprn_id">
                                    <td class="text-center">{{ row.ingredient_line }}</td>
                                    <td>{{ row.item_number }}</td>
                                    <td>{{ row.item_description }}</td>
                                    <td class="text-right">
                                        {{ row.ingredient_folmula_qty }}
                                    </td>
                                    <td class="text-right">
                                        {{ row.scrap_factor }}
                                    </td>
                                    <td class="text-right">
                                        {{ row.ingredient_qty }}
                                    </td>
                                    <td>
                                        {{ row.ingredient_uom }}
                                    </td>
                                    <td class="text-center">
                                        <template v-if="row.active_flag">
                                            <i class="fa fa-check-circle text-success"></i>
                                        </template>
                                        <template v-else>
                                            <i class="fa fa-circle text-muted"></i>
                                        </template>
                                            <!-- @if ($isActive)
                                                <i class="fa fa-check-circle text-success"></i>
                                            @else
                                                <i class="fa fa-circle text-muted"></i>
                                            @endif -->
                                        <!-- <el-checkbox style="padding: 1px; margin: 1px;" v-model="row.active_flag" disabled></el-checkbox> -->
                                        <!-- <el-checkbox style="padding: 1px; margin: 1px;" :checked="row.active_flag" disabled></el-checkbox> -->
                                         <!-- <input type="checkbox" name="invoice_flag" v-model="invoice_flag" disabled> -->
                                    </td>
                                </template>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['header', 'wipSteps', 'userName', 'startDate', 'endDate', 'machine', 'uomName', 'wipStep', 'lines', 'oprns', 'items', 'formulaType'],
    data(){
        return {
            routing_desc: this.header ? this.header.routing_desc : '',
            multi_wip_step: '',
            status: '',
            invoice_flag: this.header.invoice_flag == 'Y' ? true : false,
            datas: [],
            oprn_id: '',
        }
    },
    mounted(){
        this.multi_wip_step = this.header.oprn_id;
        this.getTable();

        if (this.header.status == 'Approved for General Use') {
            this.status = 'อนุมัติ';
        } else if(this.header.status == 'New') {
            this.status = 'สร้างใหม่';
        } else if(this.header.status == 'Obsolete/Archived'){
            this.status = 'ยกเลิก';
        }
    },
    methods: {
        getTable() {
            this.datas = [];
            this.lines.forEach(line => {

                var row_no = 0;
                var listRows = [];
                let uomDesc = '';

                this.selectedData = this.oprns.find( i => {
                    return i.routingstep_no == line.ingredient_step_line;
                }); 

                this.oprn_id = this.selectedData.oprn_id;


                if (this.datas.length > 0) {
                    this.selectedRow = this.datas.find(i => {
                        if (this.oprn_id == i.oprn_id) {
                            listRows.push({
                                oprn_id : this.oprn_id,
                            });
                        }
                    });
                    
                        
                    row_no = listRows.length + 1;
                } else {
                    row_no += 1; 
                }


                this.selectedItem = this.items.find( i => {
                    if (i.inventory_item_id == line.ingredient_item_id) {
                        uomDesc  = i.primary_unit_of_measure;
                    }
                });

                this.datas.push({
                    ingredient_step_line   : line.ingredient_step_line,
                    ingredient_line        : row_no,
                    ingredient_item_id     : line.ingredient_item_id,
                    item_number            : line.segment1,
                    item_description       : line.description,
                    ingredient_folmula_qty : Number(line.ingredient_folmula_qty),
                    scrap_factor           : Number(line.scrap_factor),
                    ingredient_qty         : Number(line.ingredient_qty),
                    ingredient_uom         : uomDesc,
                    active_flag            : line.enable_flag == 'Y' ? true : false,
                    oprn_id                : this.oprn_id,
                });
            });
        }
    }
}
</script>