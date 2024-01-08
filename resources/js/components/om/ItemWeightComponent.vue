<template>
    <div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> รหัสสินค้า <span class="text-danger">*</span></label>
                <input type="hidden" name="item_id"  :value="item_id" autocomplete="off">
                <el-select  v-model="item_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getSelectedItem()"
                                :disabled="this.disabledEdit">     
                    <el-option  v-for="sequenceEcom in sequenceEcoms"
                                :key="sequenceEcom.item_id"
                                :label="sequenceEcom.item_code + ' : ' + sequenceEcom.ecom_item_description"
                                :value="sequenceEcom.item_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ชื่อผลิตภัณฑ์ </label>
                <el-input v-model="item_description" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            
            <div class="col-md-5">
                <label> UOM <span class="text-danger">*</span></label>
                <input type="hidden" name="uom_code"  :value="uom_code" autocomplete="off">
                <el-select  v-model="uom_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getSelectedUom()">     
                    <el-option  v-for="uom in uoms"
                                :key="uom.uom_code"
                                :label="uom.uom_code + ' : ' + uom.description"
                                :value="uom.uom_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> หน่วยนับ </label>
                <el-input v-model="uom_description" disabled></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> Net </label>
                <el-input name="net_weight" v-model="net_weight" @input="onlyNumeric"></el-input>
            </div>
            <div class="col-md-5">
                <label> Gross </label>
                <el-input name="net_gross" v-model="net_gross" @input="onlyNumeric"></el-input>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> Dimensions กว้าง x ยาว x สูง </label>
                <!-- <el-input name="net_weight" v-model="net_weight" @input="onlyNumeric"></el-input> -->
                <div class="input-group ">
                    <input type="text" v-model="length" name="length" @input="onlyNumeric" placeholder="กว้าง" class="form-control">
                    <div class="input-group-prepend">
                        <span class="input-group-addon" style="border: 0px;">X</span>
                    </div>
                    <input type="text" v-model="width" name="width" @input="onlyNumeric" placeholder="ยาว" class="form-control">
                    <div class="input-group-prepend">
                        <span class="input-group-addon" style="border: 0px;">X</span>
                    </div>
                    <input type="text" v-model="height" name="height" @input="onlyNumeric" placeholder="สูง" class="form-control">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> วันที่เริ่มต้น </label>
                <el-date-picker 
                    v-model="start_date_format"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd/MM/yyyy"
                    value-format="dd/MM/yyyy"
                    >
                </el-date-picker>  
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด </label>
                <el-date-picker 
                    v-model="end_date_format"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd/MM/yyyy"
                    value-format="dd/MM/yyyy"
                    >
                </el-date-picker>  
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> Active</label><br>
                <input type="checkbox" name="active_flag" v-model="active_flag">
            
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {
    props:['sequenceEcoms', 'uoms', 'defaultValue', 'old', 'transDate'],
    data() {
        return {
            item_id:          this.old.item_id     ? this.old.item_id     : this.defaultValue ? this.defaultValue.item_id     : '',
            // start_date:       this.old.start_date  ? this.old.start_date  : this.defaultValue ? this.defaultValue.start_date  : '',
            // end_date:         this.old.end_date    ? this.old.end_date    : this.defaultValue ? this.defaultValue.end_date    : '',
            uom_code:         this.old.uom         ? this.old.uom         : this.defaultValue ? this.defaultValue.uom         : '',
            net_weight:       this.old.net_weight  ? this.old.net_weight  : this.defaultValue ? this.defaultValue.net_weight  : '',
            net_gross:        this.old.net_gross   ? this.old.net_gross   : this.defaultValue ? this.defaultValue.net_gross   : '',
            item_description: '',
            uom_description:  '',
            active_flag:      this.old.active_flag == 'Y' ? true : this.defaultValue  ? this.defaultValue.active_flag == 'Y' ? true : '' : true,
            disabledEdit:     this.defaultValue ? true : false,

            start_date: '',
            end_date:   '',

            start_date_format: this.old.start_date_format  ? this.old.start_date_format  : this.defaultValue ? this.defaultValue.start_date_format  : '',
            end_date_format: this.old.end_date_format  ? this.old.end_date_format  : this.defaultValue ? this.defaultValue.end_date_format  : '',

            length:         this.old.length ? this.old.length   : this.defaultValue ? this.defaultValue.length  : '',
            width:          this.old.width  ? this.old.width    : this.defaultValue ? this.defaultValue.width   : '',
            height:         this.old.height ? this.old.height   : this.defaultValue ? this.defaultValue.height  : '',
        }
    },
    mounted(){
        if (this.item_id) {
            this.getSelectedItem();
        }

        if (this.uom_code) {
            this.getSelectedUom();
        }

        // if (this.old.start_date) {

        //     // this.start_date = moment(String((this.old.start_date)).format('yyyy-MM-DD'));
        //     this.start_date = moment(String(this.old.start_date)).format('yyyy-MM-DD');

        // } else if (this.defaultValue){
        //     if (this.defaultValue.start_date) {
        //         this.start_date = this.defaultValue.start_date;
        //     }
        // }

        // if (this.old.end_date) {

        //     this.end_date = this.old.end_date;

        // } else if (this.defaultValue){

        //     if (this.defaultValue.end_date) {
        //         this.end_date = this.defaultValue.end_date;
        //     }
        // }
        this.onlyNumeric()
    },
    methods: {
        async setdate(date, input) {
            let vm = this;
            let data = await moment(date).format(vm.transDate['js-format']);
            if (data == 'Invalid date') {
                data = '';
            }
            vm[input] = data;
        },
        getSelectedItem() {
            this.selectedItem = this.sequenceEcoms.find( i => {
                return i.item_id == this.item_id;
            });

            if (this.item_id) {
                this.item_description = this.defaultValue ? this.defaultValue.item_description : this.selectedItem.ecom_item_description;
            } else {
                this.item_description = '';
            }
        },
        getSelectedUom(){
            this.selectedUom = this.uoms.find(i => {
                return i.uom_code == this.uom_code;
            });
            
            if (this.uom_code) {
                this.uom_description = this.selectedUom.description;
            } else {
                this.uom_description = '';
            }
        },
        onlyNumeric() {

            this.net_weight = this.net_weight.replace(/[^0-9 .]/g, '');
        
            this.net_gross = this.net_gross.replace(/[^0-9 .]/g, '');

            // this.length = this.length.replace(/[^0-9 .]/g, '');
            // this.width = this.width.replace(/[^0-9 .]/g, '');
            // this.height = this.height.replace(/[^0-9 .]/g, '');

            if (this.length) {
                this.length = this.length.replace(/[^0-9 .]/g, '');
                this.length = this.length.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            if (this.width) {
                this.width = this.width.replace(/[^0-9 .]/g, '');
                this.width = this.width.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            if (this.height) {
                this.height = this.height.replace(/[^0-9 .]/g, '');
                this.height = this.height.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }
    },
}
</script>