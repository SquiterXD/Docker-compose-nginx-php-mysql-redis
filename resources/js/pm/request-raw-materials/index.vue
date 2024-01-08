 
<template>
    <div class="row">
        <div class="col-lg-12">
            
            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="pb-3">
                        {{title}}
                        <div class="pull-right">
                            <button :class="transbtn.create.class" @click="onClickCreate"><i class="fa fa-plus"></i> สร้าง</button>
                           <!-- <button :class="transbtn.save.class" :disabled="checkDisableBtn">
                              <i class="fa fa-save"></i>  
                            แผนประจำปักษ์</button>-->
                            <button :class="transbtn.save.class" @click.prevent="onClickSave" :disabled="checkDisableBtn"><i class="fa fa-save"></i> ประมาณการเบิก</button>
                        </div>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6 b-r">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ปีงบประมาณ: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="thai_year" filterable remote placeholder="เลือกปี" @change="onChangeYear">
                                        <el-option v-for="year in yearLists" :key="year" :label="year" :value="year"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">แผนการผลิตประจำเดือน: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="thai_month" filterable remote placeholder="เลือกเดือน" @change="onChangeMonth">
                                        <el-option v-for="month in monthLists" :key="month" :label="month" :value="month"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ปักษ์ที่: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="biweekly" filterable remote placeholder="เลือกปักษ์" @change="onChangeBiweekly">
                                        <el-option v-for="biweekly in biweeklyLists" :key="biweekly" :label="biweekly" :value="biweekly"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">วันที่ขอเบิก: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่ขอเบิก" :not-before-date="current_date" :not-after-date="maxSelectedDate" :value="req_date" :format="transdate['js-format']" @dateWasSelected="(dateObject) => req_date = dateObject"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ประเภทวัตถุดิบ: <span style="color: red;">*</span></label>
                                <div class="col-lg-8">
                                    <el-select v-model="item_code" filterable remote placeholder="เลือกประเภทวัตถุดิบ" :disabled="dep_code != 'M02' && dep_code != 'M03'">
                                        <el-option v-for="item in items" :key="item.item_classification_code" :label="item.item_classification" :value="item.item_classification_code"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row" v-if="dep_code != 'M02' && dep_code != 'M03'">
                                <label class="col-lg-4 col-form-label">วันที่ผลิต<span style="color:red">*</span></label>
                                <!-- <label class="col-lg-1 col-form-label">ตั้งแต่</label> -->
                                <div class="col-lg-4">
                                    <!-- <datepicker-th class="form-control" placeholder="เลือกวันที่" :not-before-date="min_date" :not-after-date="max_date" :value="start_date" :format="transdate['js-format']" @dateWasSelected="(dateObject) => start_date = dateObject"/> -->
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่" :disabled-date-to="min_date"  :value="start_date" :format="transdate['js-format']"
                                        @dateWasSelected="setdate(...arguments, 'start_date')"
                                        />
                                </div>
                                <label class="col-lg-1 col-form-label text-center pt-2">ถึง</label>
                                <div class="col-lg-3">
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่" :not-before-date="min_date" :not-after-date="max_date" :value="end_date" :format="transdate['js-format']"
                                        @dateWasSelected="setdate(...arguments, 'end_date')"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ขั่นตอนการทำงาน<span style="color:red">*</span></label>
                                <div class="col-lg-8">
                                    <div class="form-check form-check-inline">
                                        <input name="oprn_name" class="form-check-input" type="radio" value="all" v-model="oprnValue" id="checkAllOprn" >
                                        <label class="form-check-label" for="checkAllOprn">
                                            All
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline" v-for="(oprn, index) in oprn_rows" :key="index">
                                        <input name="oprn_name" class="form-check-input" type="radio" :value="oprn.oprn_class_desc" v-model="oprnValue" :id="index">
                                        <label class="form-check-label" :for="index">
                                             {{oprn.oprn_desc}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">หน่วยงานที่ขอเบิก:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="orgfullname" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">ผู้ขอเบิก:</label>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" v-model="req_by" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label">วันที่นำส่ง ยสท.<span style="color:red">*</span>:</label>
                                <div class="col-lg-8">
                                    <!-- <datepicker-th class="form-control" placeholder="เลือกวันที่นำส่ง ยสท." :not-before-date="req_date" :not-after-date="maxSelectedDate"  :value="send_date"  :format="transdate['js-format']" @dateWasSelected="(dateObject) => send_date = dateObject" /> -->
                                    <datepicker-th class="form-control" placeholder="เลือกวันที่นำส่ง ยสท." :not-before-date="req_date" :not-after-date="maxSelectedDate"  :value="send_date"  :format="transdate['js-format']"
                                        @dateWasSelected="setdate(...arguments, 'send_date')" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox">
                <div class="ibox-title">
                    <h5 class="pb-3">
                        รายการวัตถุดิบ
                        <button type="button" :class="transbtn.create.class + ' pull-right'" @click.prevent="onClickSaveLines" :disabled="checked.length == 0"><i class="fa fa-plus"></i> สร้างรายการขอเบิก</button>
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        <label>
                                            <input style="transform: scale(1.5)" class="align-middle" type="checkbox" @click="checkedAll" v-model="isCheckedAll">
                                        </label>
                                    </th>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th>รายละเอียด</th>
                                    <th>ปริมาณที่ต้องใช้+สูญเสีย</th>
                                    <th>หน่วยนับ</th>
                                    <!-- <th>ปริมาณคงคลังฝ่ายจัดหา</th>
                                    <th>ปริมาณที่คงคลังฝ่ายผลิต</th>
                                    <th>ปริมาณจัดเก็บต่ำสุด</th>
                                    <th>ปริมาณจัดเก็บสูงสุด</th>
                                    <th>ปริมาณเต็มแป้น</th>-->
                                    <th>ปริมาณเบิกหลัก</th>
                                    <th>หน่วยเบิกหลัก</th>
                                    <th>ปริมาณเบิก</th>
                                    <th>หน่วยเบิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(line, index) in lines" :key="index">
                                    <td>
                                        <label>
                                            <input style="transform: scale(1.5)" class="align-middle" type="checkbox" v-model="checked" :disabled="!line.qty" :value="line.bi_request_line_id" @change="updateChecked">
                                        </label>
                                    </td>
                                   
                                 
                                    <td class="col-readonly">{{ line.item_code }}</td>
                                    <td class="col-readonly text-left">{{ line.description }}</td>
                                    <td class="col-readonly text-right">
                                        <!-- {{ line.total_qty }} -->
                                        <template v-if="dep_code == 'M02' || dep_code == 'M03'">
                                            {{ Number(line.total_qty ? parseFloat(line.total_qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                        </template>
                                        <template v-else>
                                            {{ Number(line.total_qty ? parseFloat(line.total_qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 5, maximumFractionDigits: 5 }) }}
                                        </template>
                                    </td>
                                    <td class="col-readonly">{{ line.uom_thai }}</td>
                                     <!-- <td class="col-readonly">{{ line.request_onhand }}</td>
                                    <td class="col-readonly">{{ line.product_onhand }}</td>
                                    <td class="col-readonly">{{ line.min_qty }}</td>
                                    <td class="col-readonly">{{ line.max_qty }}</td>
                                    <td class="col-readonly">{{ line.machine_max }}</td>-->
                                    <td class="col-readonly text-right">
                                        <!-- <input disabled type="text" class="form-control text-right" v-model.number="line.qty" @keypress="isNumber($event); line.request_qty = ''; checked[index] = line.bi_request_line_id;" min="0" > -->
                                        <!-- <vue-numeric
                                            placeholder="จำนวน Layout"
                                            separator=","
                                            v-bind:precision="0"
                                            v-bind:minus="false"
                                            :class="'form-control text-right '"
                                            v-model="line.line"
                                        ></vue-numeric> -->
                                        <div :title="line.conversion_rate">
                                            <strong >
                                                <!-- {{ line.qty ? (line.qty ? Number(line.qty).toLocaleString(undefined, { minimumFractionDigits: 0, maximumFractionDigits: 0 }) : "-") : "-" }} -->
                                                <template v-if="dep_code == 'M02' || dep_code == 'M03'">
                                                    {{ Number(line.qty ? parseFloat(line.qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                                </template>
                                                <template v-else>
                                                    {{ Number(line.qty ? parseFloat(line.qty) : 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                                                </template>
                                            </strong>
                                        </div>
                                    </td>
                                    <td class="col-readonly">{{line.uom_thai}}</td>
                                    <td>
                                        <!-- <input type="text" class="form-control text-right" v-model.number="line.request_qty" @keypress="onChangeRequestQty2($event, line)" @keyup="onChangeRequestQty2($event, line); checked[index] = line.bi_request_line_id;" min="0">
 -->
                                        <vue-numeric
                                            placeholder=""
                                            separator=","
                                            v-bind:precision="2"
                                            v-bind:minus="false"
                                            @change="onChangeRequestQty2(index, line)"
                                            :class="'form-control text-right '"
                                            v-model="line.request_qty"
                                        ></vue-numeric>

                                    </td>
                                    <td class="col-readonly">
                                    <el-select v-model="line.uom2" value-key="from_unit_of_measure" filterable remote placeholder="เลือกหน่วยนับ" @change="onChangeUom2($event, line, index)">
                                        <!-- <el-option v-for="item in listUom2" :key="item.from_unit_of_measure" :label="item.from_unit_of_measure" :value="item" ></el-option> -->
                                        <el-option v-for="item in line.list_uom2" :key="item.from_unit_of_measure" :label="item.from_unit_of_measure" :value="item" ></el-option>
                                    </el-select>
                                    <!--<i class="fa fa-search cursor-pointer" @click="chooseRequestUom2(line, index)"></i>-->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueNumeric from 'vue-numeric';
import moment from "moment";
import {
    showLoadingDialog,
    showValidationFailedDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
    showRemoveLineConfirmationDialog
} from "../../commonDialogs"

export default {
    props: ['lookups', 'items', 'dep_code', 'orgname','oprn_rows','orgfullname','req_by','title','transdate', 'transbtn', 'def_period_year', 'profile'],
    components: {
       VueNumeric
    },
    async mounted() {

        try{
            this.thai_month = this.months[new Date().getMonth()]
        }catch(err){

        }
        // To do
    },
    data() {
        return {
            months : ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม", "พฤศจิกายน","ธันวาคม"],
            current_date: this.getCurrentDate(),
            header_id: '',
            oprnValue: 'all',
            thai_year: this.def_period_year,
            thai_month: "",
            biweekly: '',
            biweekly_id: '',
            req_date: this.getCurrentDate(),
            item_code: '',
            start_date: '',
            end_date: '',
            min_date: '',
            max_date: '',
            send_date: this.getCurrentDate(),
            lines: [],
            listUom2: [],
            isCheckedAll: false,
            checked: [],
            // listUom2: [],
            valueUom2: '',
        }
    },
    computed: {
        maxSelectedDate() {
            let today = new Date()
            let max = new Date()
            max.setDate(today.getDate() + 365)
            let thaiYear = max.getFullYear() + 543
            let month = max.getMonth() + 1
            let day = max.getDate()
            return thaiYear + '-' + month + '-' + day
        },
        checkDisableBtn() {
            if(this.dep_code != "M02" && this.dep_code != "M03"){
                return ! (this.thai_year && this.thai_month && this.biweekly)
            }else{
                return ! (this.thai_year && this.thai_month && this.biweekly && this.item_code)
            }
            
        },
        yearLists() {
            return [...new Set(Array.from(this.lookups, (lookup) => lookup.thai_year))]
        },
        monthLists() {
            let lookups = this.lookups.filter(lookup => lookup.thai_year == this.thai_year)
            const result = [...new Set(Array.from(lookups, (lookup) => lookup.thai_month))]
            
            return result
        },
        biweeklyLists() {
            let lookups = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month == this.thai_month
            })
            return [...new Set(Array.from(lookups, (lookup) => lookup.biweekly))]
        },
    },
    methods: {
        async setdate(date, input = '') {
            let vm = this;
            if (input == '') {
                // vm.transactionDateFormat = await moment(date).format(vm.transdate['js-format']);
            } else {
                let data = await moment(date).format(vm.transdate['js-format']);
                if (data == 'Invalid date') {
                    data = '';
                }
                vm[input] = data;
            }
        },
        // getListItemUomv(params){
        //     return axios.post('/pm/ajax/get-list-item-conv-uomv', params).then(response => {
        //         if (response.status == 200) {
        //             return response.data
        //         }else{
        //             return []
        //         }
        //     }).catch(error => {
        //         console.log(error)
        //         return []
        //     })
        // },
        // popupUom2(selectData){
        //     return new Promise((resolve, reject) => {
        //         Vue.swal({
        //             title: 'เลือกหน่วยเบิก (2)',
        //             input: 'select',
        //             inputOptions: selectData,
        //             inputPlaceholder: 'Select',
        //             showCancelButton: true,
        //             inputValidator: (value) => {
        //                 console.log(value)
        //                 Vue.swal.close();
        //                 resolve(value)
        //             }
        //         });
        //     })
        // },
        // async chooseRequestUom2(row, index){
        //     const params = {
        //         "inventory_item_id" : row.inventory_item_id,
        //         "organization_id" : row.organization_id,
        //         "to_uom_code" : row.uom2
        //     }
        //     const res = await this.getListItemUomv(params);
        //     if(res){
        //         const uom2 = res.listUom2
        //         let i = 0;
        //         const selectData = uom2.reduce((a, c) => {
        //             a[i] = c.from_unit_of_measure
        //             i++
        //             return a
        //         }, {})

        //         const valueSelected = await this.popupUom2(selectData)
        //         console.log("valueSelected", valueSelected)
        //         const item = uom2[valueSelected];
        //         console.log("item", item)
        //         this.$set(this.lines, index, { 
        //             ...this.lines[index], 
        //             'qty' : parseFloat((this.lines[index].request_qty ? this.lines[index].request_qty : 0)) * parseFloat((item.conversion_rate ? item.conversion_rate : 1)),
        //             'request_uom' : item.from_unit_of_measure,
        //             'conversion_rate' : item.conversion_rate
        //         })
        //     }
            
            
            
        // },
        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            console.log("charCode", charCode)
            if(charCode == 190 || charCode == 46){ //dot
                evt.preventDefault();
                return false;
            }
            if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode != 9)) {
                evt.preventDefault();
                return false;
            } else {
                return true;
            }
        },
        onChangeRequestQty2(index, row) {
            console.log('1111-------------------------->', this.checked, row, row.request_qty);
            if (row.request_qty == '' || row.request_qty == 0) {
                row.request_qty = '';
                row.qty = '';
                // let lineIdIdx = this.checked.findIndex(item => item == row.bi_request_line_id);
                // this.$delete(this.checked, lineIdIdx);
                // Vue.delete( this.checked, lineIdIdx )
                Vue.set( this.checked, index, '')
            } else {
                row.qty = parseFloat((row.request_qty ? row.request_qty : 0)) * parseFloat((row.conversion_rate ? row.conversion_rate : 1))
                Vue.set( this.checked, index, row.bi_request_line_id)
            }
            console.log('2222-------------------------->', this.checked, row, row.request_qty);
        },
        onClickCreate() {
            // To do
            this.thai_year = this.def_period_year,
            this.thai_month = ''
            this.biweekly = ''
            this.biweekly_id = ''
            this.req_date = this.getCurrentDate()
            this.item_code = ''
            this.start_date = ''
            this.end_date = ''
            this.send_date = this.getCurrentDate(),
            this.lines = ''
        },
        async onClickSave() {

            let oprnClassDesc = this.oprnValue
            if(this.oprnValue == 'all'){
                oprnClassDesc = this.oprn_rows.map(item => item.oprn_class_desc).join('-')
            }
            
            let params = {
                biweekly_id: this.biweekly_id,
                department_code: this.dep_code,
                request_date: this.convertFormatDate(this.req_date),
                tobacco_group: this.item_code,
                product_date_from: this.convertFormatDate(this.start_date),
                product_date_to: this.convertFormatDate(this.end_date),
                request_by: this.req_by,
                send_date: this.convertFormatDate(this.send_date),
                wip: oprnClassDesc
            }
            showLoadingDialog()
            await axios.post('/pm/ajax/request-raw-materials', params).then(response => {
                if (response.status == 200) {
                    console.log(response)
                    showSaveSuccessDialog()
                    this.lines = response.data.lines;
                    this.header_id = response.data.header.bi_request_header_id
                    
                    this.listUom2 = [...new Set(Array.from(response.data.listUom2))]

                    if (this.profile.organization_code != 'M02') {
                        this.lines.forEach((row, idx)  => {
                            if (parseFloat(row.request_qty) > 0) {
                                Vue.set( this.checked, idx, row.bi_request_line_id)
                                row.qty = parseFloat((row.request_qty ? row.request_qty : 0)) * parseFloat((row.conversion_rate ? row.conversion_rate : 1))
                            }
                        });
                    }
                }
            }).catch(error => {
                console.log(error)
            })
        },
        getCurrentDate() {
            let y = new Date().getFullYear() + 543
            let m = new Date().getMonth() + 1
            let d = new Date().getDate()
            return d + '-' + m + '-' + y
        },
        convertToThaiDate(d) {
            let yearThai = parseInt(d.split('-')[0]) + 543
            const result = d.split('-')[2] + '-' + d.split('-')[1] + '-' +  yearThai
            return result
        },
        convertFormatDate(d) {
            console.log("d", d)
            return d;
            // let yyyy = new Date(d).getFullYear() - 543
            // let mm = new Date(d).getMonth() + 1
            // let dd = new Date(d).getDate()
            // return yyyy + '-' + mm + '-' + dd
        },
        async onChangeUom2(item, line, index){
            if (this.profile.organization_code != 'M02') {
                line.request_qty = '';
                line.qty = '';
                Vue.set( this.checked, index, '')
            } else {
                line['qty'] = parseFloat((line.request_qty ? line.request_qty : 0)) * parseFloat((item.conversion_rate ? item.conversion_rate : 1));
            }
            line['request_uom'] = item.from_unit_of_measure
            line['conversion_rate'] = item.conversion_rate
            console.log('2 => onChangeUom2', item, line, index);

        },
        onChangeYear() {
            // To do
            // this.thai_month = ''
            // this.biweekly = ''
            // this.display_date = ''
        },
        onChangeMonth() {
            // To do
            // this.biweekly = ''
            // this.display_date = ''
        },
        onChangeBiweekly() {
            // To do
            let lookup = this.lookups.filter(lookup => {
                return lookup.thai_year == this.thai_year && lookup.thai_month ==this.thai_month && lookup.biweekly == this.biweekly
            })[0]
            this.biweekly_id = lookup.biweekly_id
            this.start_date = this.convertToThaiDate(lookup.start_date)
            this.min_date = this.convertToThaiDate(lookup.start_date)
            this.end_date = this.convertToThaiDate(lookup.end_date)
            this.max_date = this.convertToThaiDate(lookup.end_date)
        },
        validate() {
            let errors = []

            
            if(this.checked.length > 0) {
                this.checked.forEach(lineId => {
                    let line = this.lines.filter(line => { return line.bi_request_line_id == lineId })[0]
                   
                    if (!line.qty) {
                        errors.push('ปริมาณเบิกหลัก')
                    }
                    // if (!line.request_qty) {
                    //     errors.push('ปริมาณเบิก')
                    // }
                })
            }


            if(errors.length > 0) {
                showValidationFailedDialog([...new Set(errors)])
                return false
            }
            return true
        },
        onClickSaveLines() {
            if(!this.validate()) {
                return;
            }

            const params = {
                lines: this.lines,
                checked: this.checked
            }
            showLoadingDialog()
            axios.put(`/pm/ajax/request-raw-materials/${this.header_id}`, params).then(response => {
                if (response.status == 200) {
                    swal.close()
                    if(response.data.reqHeaderIds.length > 0){
                        showLoadingDialog()
                        window.location.href = '/pm/material-requests?request_header_id=' + response.data.reqHeaderIds[0]
                    } else {
                        showValidationFailedDialog(response.data.errors);
                    }
                }
            }).catch(error => {
                swal.close()
                console.log(error)
            })
        },
        checkedAll() {
            this.checked = []
            this.isCheckedAll = !this.isCheckedAll
            if (this.isCheckedAll) {
                this.lines.forEach(line => {
                    if(line.request_qty) {
                        this.checked.push(line.bi_request_line_id)
                    }
                })
            }
        },
        updateChecked() {
            this.isCheckedAll = (this.checked.length === this.lines.length)
        },
    }
}
</script>
<style scoped>
    th, td {
        vertical-align: middle !important;
        text-align: center;
    }
    .cursor-pointer{ cursor:pointer; }
    input.form-control.input-field { border: 0px; }
    .mx-datepicker { width: inherit !important; }
    .col-readonly { background: #e9ecef42 !important; }
</style>
