<template>
    <div class="col-md-12">
        <hr class="lg">
            <div class="col-xl-12 tw-mb-3 tw-text-right">
                <button :class="btnTrans.save.class" 
                        type="button" v-on:click="saveData()">
                    <i :class="btnTrans.save.icon"></i> 
                    {{ btnTrans.save.text }}
                </button>
            </div>
        <div class="hr-line-dashed"></div>
        <div class="table-responsive" v-loading="loadingTable">
            <table class="table table-bordered text-center" id="datatable"> 
                <thead>
                    <tr class="align-middle"> 
                        <th style="min-width: 200px;">สถานะ</th>
                        <th style="min-width: 270px;">รายละเอียด</th>
                        <th style="min-width: 500px;">อนุมัติการเคลม</th> 
                        <th style="min-width: 120px;">ใบแจ้งเคลม</th>
                        <th style="min-width: 200px;">วิธีการเคลม</th> 
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle" v-for="(data, index) in lineList" :key="index">
                        <td class="text-center text-danger" style="vertical-align: middle; width: 10%;">
                            <div
                                class="tw-m-auto tw-text-center tw-my-4 tw-px-3 tw-py-4"
                                :style="
                                'color:#fff; font-weight:bold; background-color: ' +
                                status_color_template[data.status_claim].color
                                "
                            >
                                {{ data.status_claim }} <br>
                                <div><span style="font-size:18px padding-top: 10px;">{{ data.status_claim_code }}</span></div>
                            </div>
                        </td>
                        <td class="text-left" style="vertical-align: middle; width: 30%;">
                            <!-- รหัสลูกค้า : {{ data.customers.customer_number }} - {{ data.customers.customer_name }}<br>
                            เลขที่ใบแจ้งเคลมสินค้า : {{ data.claim_number }}<br>
                            วันที่แจ้งเคลมสินค้า : {{ data.claim_date_converThDate }}<br>
                            อ้างอิง Invoice เลขที่ : {{ data.invoice_number_collect.invoice_number }}<br>
                            วันที่ Invoice : {{ data.invoice_date_converThDate }}<br>
                            อาการเสีย : {{ data.symptom_description }}<br>
                            จำนวนสินค้าส่งเคลม : -->
                            <div class="row">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    เลขที่ใบแจ้งเคลมสินค้า: 
                                </div>
                                <div class="col-7">
                                    {{ data.claim_number }}<br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    วันที่แจ้งเคลมสินค้า: 
                                </div>
                                <div class="col-7">
                                    {{ data.claim_date_converThDate }}<br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    อ้างอิง Invoice เลขที่: 
                                </div>
                                <div class="col-7">
                                    {{ data.ref_invoice_number ? data.ref_invoice_number : '' }}<br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    วันที่ Invoice: 
                                </div>
                                <div class="col-7">
                                    {{ data.invoice_date_converThDate }}<br>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    อาการเสีย: 
                                </div>
                                <div class="col-7">
                                    {{ data.symptom_description }}<br>
                                </div>
                            </div>

                            <div class="row" v-if="data.credit_note_number">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    ใบลดหนี้เลขที่: 
                                </div>
                                <div class="col-7">
                                    {{ data.credit_note_number }}<br>
                                </div>
                            </div>

                            <div class="row" v-if="data.rma_number">
                                <div class="col-5" style="font-weight: bold; vertical-align: middle;">
                                    ใบคืนสินค้าเลขที่: 
                                </div>
                                <div class="col-7">
                                    {{ data.rma_number }}<br>
                                </div>
                            </div>

                            <div style="font-weight: bold; vertical-align: middle;">
                                จำนวนสินค้าส่งเคลม:
                            </div>
                            <ul>
                                <li
                                    v-for="(line,index) in data.claim_lines"
                                    :key="index"
                                >
                                    <div v-if="line.claim_quantity_cbb || line.claim_quantity_carton || line.claim_quantity_pack">
                                        {{ line.item_description }}
                                        <div v-if="line.claim_quantity_cbb">
                                            {{ line.claim_quantity_cbb }}
                                            {{ data.uom_claim_quantity_cbb ? data.uom_claim_quantity_cbb.unit_of_measure : '' }}
                                        </div>
                                        <div v-if="line.claim_quantity_carton">
                                            {{ line.claim_quantity_carton }}
                                            {{ data.uom_claim_quantity_carton ? data.uom_claim_quantity_carton.unit_of_measure : '' }}
                                        </div>
                                        <div v-if="line.claim_quantity_pack">
                                            {{ line.claim_quantity_pack }}
                                            {{ data.uom_claim_quantity_pack ? data.uom_claim_quantity_pack.unit_of_measure : '' }}
                                        </div>
                                    </div>
                                    <div v-if="line.enter_claim_quantity">
                                        {{ line.enter_claim_quantity }}
                                        {{ data.uomEnterClaim[index].unit_of_measure }}
                                    </div>
                                </li>
                            </ul><br>

                            <button type="button" class="btn btn-primary" data-toggle="modal" :data-target="'#exampleModalCenter'+data.claim_header_id">
                                ดูไฟล์ที่แนบ
                            </button>

                            <div class="modal fade" :id="'exampleModalCenter'+data.claim_header_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">ไฟล์แนบ</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul>
                                            <li v-for="(line,index) in data.claim_lines"
                                                :key="index">
                                                <div v-if="line.claim_quantity_cbb || line.claim_quantity_carton || line.claim_quantity_pack">
                                                    {{ line.item_description }}
                                                </div>
                                                <div style="padding-left: 15px;">
                                                    <div v-for="(attach, indexAttachment) in data.attachment"
                                                        :key="attach.attachment_id">
                                                        <div v-if="(index+1) == attach.line_id">
                                                            <li>
                                                                <div>
                                                                    {{ 'รายการที่ ' + (indexAttachment+1)  }}
                                                                    <a target="_blank" :href="'attachments/'+ attach.attachment_id +'/image'">
                                                                        {{ attachmentBind(attach.attribute1) }}
                                                                    </a>
                                                                </div>                                                                                                          
                                                            </li>
                                                        </div>
                                                    </div>                                                    
                                                </div>                                                
                                            </li>                                            
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-left">
                            <div class="form-group mt-2">
                                <div class="row">
                                    <div class="col-4"> 
                                        <label><input   type="radio" 
                                                        value="Y" 
                                                        :name="'approve'+data.claim_header_id" 
                                                        v-model="data.approve" 
                                                        @click="checkDate('Y', $event, data)"
                                                        :disabled="disenable.approve
                                                        ||(data.status_approve_claim ? true : false)
                                                        ||(data.status_claim_code == '7' 
                                                        || data.status_claim_code == '8' 
                                                        || data.status_claim_code == '9' 
                                                        || data.status_claim_code == '6'
                                                        || data.status_claim_code == '5'
                                                        || data.status_claim_code == '3'
                                                        || data.status_claim_code == '4'
                                                        || data.status_claim_code == '10'
                                                        || data.status_claim_code == '11' ? true : false)" 
                                                        :checked="data.approve == 'Y' ? true : false"
                                                        ><span style="padding-left: 10px;">อนุมัติ</span></label>
                                    </div>
                                    <div class="col-4"> 
                                        <label><input   type="radio" 
                                                        value="N" 
                                                        :name="'approve'+data.claim_header_id" 
                                                        v-model="data.approve" 
                                                        @click="checkDate('N', $event, data)"
                                                        :disabled="disenable.approve 
                                                        ||(data.status_approve_claim ? true : false)
                                                        ||(data.status_claim_code == '7' 
                                                        || data.status_claim_code == '8' 
                                                        || data.status_claim_code == '9' 
                                                        || data.status_claim_code == '6'
                                                        || data.status_claim_code == '5'
                                                        || data.status_claim_code == '3'
                                                        || data.status_claim_code == '4'
                                                        || data.status_claim_code == '10'
                                                        || data.status_claim_code == '11' ? true : false)"
                                                        :checked="data.approve == 'N' ? true : false" 
                                                        ><span style="padding-left: 10px;">ไม่อนุมัติ</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="d-block">เนื่องจาก</label>
                                <textarea
                                    type="textarea"
                                    :class="'form-control ' + (data.validateRemarkApprove ? 'is-invalid' : '')"
                                    :rows="3"
                                    placeholder="เนื่องจาก"
                                    v-model="data.remark_approve"
                                    :disabled=" disenable.approve
                                                ||(data.status_approve_claim ? true : false)
                                                ||(data.status_claim_code == '7' 
                                                || data.status_claim_code == '8' 
                                                || data.status_claim_code == '9' 
                                                || data.status_claim_code == '6'
                                                || data.status_claim_code == '5'
                                                || data.status_claim_code == '3'
                                                || data.status_claim_code == '4'
                                                || data.status_claim_code == '10'
                                                || data.status_claim_code == '11' ? true : false)">
                                </textarea>
                            </div>
                            
                            <div class="form-group">                        
                                <div class="row space-5 align-items-center">
                                    <div class="col-6">
                                        <label class="d-block m-0">จำนวนที่สามารถ Rework ได้ :</label>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex text-center">
                                            <div class="form-group m-1">
                                                <label class="d-block">หีบ</label>
                                                <vue-numeric 
                                                    separator="," 
                                                    v-bind:minus="false"
                                                    class="form-control text-right" 
                                                    placeholder="จำนวนหีบ"
                                                    v-model="data.cardboard_box_quantity"
                                                    :disabled="disenable.approve
                                                            ||(data.status_approve_claim ? true : false)
                                                            ||(data.status_claim_code == '7' 
                                                            || data.status_claim_code == '8' 
                                                            || data.status_claim_code == '9' 
                                                            || data.status_claim_code == '6'
                                                            || data.status_claim_code == '5'
                                                            || data.status_claim_code == '3'
                                                            || data.status_claim_code == '4'
                                                            || data.status_claim_code == '10'
                                                            || data.status_claim_code == '11' ? true : false)"
                                                ></vue-numeric>
                                            </div>

                                            <div class="form-group m-1">
                                                <label class="d-block">ห่อ</label>
                                                <vue-numeric 
                                                    separator="," 
                                                    v-bind:minus="false"
                                                    class="form-control text-right" 
                                                    placeholder="จำนวนห่อ"
                                                    v-model="data.cartons_quantity"
                                                    :disabled="disenable.approve
                                                            ||(data.status_approve_claim ? true : false)
                                                            ||(data.status_claim_code == '7' 
                                                            || data.status_claim_code == '8' 
                                                            || data.status_claim_code == '9' 
                                                            || data.status_claim_code == '6'
                                                            || data.status_claim_code == '5'
                                                            || data.status_claim_code == '3'
                                                            || data.status_claim_code == '4'
                                                            || data.status_claim_code == '10'
                                                            || data.status_claim_code == '11' ? true : false)"
                                                ></vue-numeric>
                                            </div>

                                            <div class="form-group m-1">
                                                <label class="d-block">ซอง</label>
                                                <vue-numeric 
                                                    separator="," 
                                                    v-bind:minus="false"
                                                    class="form-control text-right" 
                                                    placeholder="จำนวนซอง"
                                                    v-model="data.pack_quantity"
                                                    :disabled="disenable.approve
                                                            ||(data.status_approve_claim ? true : false)
                                                            ||(data.status_claim_code == '7' 
                                                            || data.status_claim_code == '8' 
                                                            || data.status_claim_code == '9' 
                                                            || data.status_claim_code == '6'
                                                            || data.status_claim_code == '5'
                                                            || data.status_claim_code == '3'
                                                            || data.status_claim_code == '4'
                                                            || data.status_claim_code == '10'
                                                            || data.status_claim_code == '11' ? true : false)"
                                                ></vue-numeric>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </td> 
                        <td style="vertical-align: middle; width: 10%;">
                            <div>
                                <button type="button" 
                                        :class="btnTrans.print.class"
                                        @click="handlePrintBtn(data.claim_header_id)">
                                    <i :class="btnTrans.print.icon">&nbsp;</i>
                                </button>
                            </div>
                            <div style="padding-top: 30px;">
                                <button :class="btnTrans.closedClaimTH.class" 
                                    type="button" 
                                    :disabled="data.status_claim_code == '8' ? true : false"
                                    v-on:click="closedClaim(data.claim_header_id)">
                                <i :class="btnTrans.closedClaimTH.icon"></i> 
                                {{ btnTrans.closedClaimTH.text }}
                                </button>
                            </div>
                        </td>
                        <td class="text-left" style="vertical-align: middle; width: 20%;">
                            <div class="text-left">
                                <label><input   type="radio" 
                                                value="replacement" 
                                                :name="'claimMethod'+data.claim_header_id" 
                                                v-model="data.replacement" 
                                                :disabled="data.status_approve_claim == null ? true : false
                                                ||(data.status_claim_code == '7' 
                                                || data.status_claim_code == '8' 
                                                || data.status_claim_code == '9' 
                                                || data.status_claim_code == '6'
                                                || data.status_claim_code == '5'
                                                || data.status_claim_code == '3'
                                                || data.status_claim_code == '4'
                                                || data.status_claim_code == '10'
                                                || data.status_claim_code == '11' ? true : false)"
                                                :checked="data.replacement == 'Y' ? data.replacement = 'replacement' : false"
                                                @change="checkSelectReplacement(data.replacement, data.creditNote, data.cashBack, data)"
                                                ><span style="padding-left: 10px;">ส่งสินค้าทดแทน</span></label>
                            </div>
                            <div class="text-left">
                                <label><input   type="radio" 
                                                value="creditNote" 
                                                :name="'claimMethod'+data.claim_header_id" 
                                                v-model="data.creditNote" 
                                                :disabled="data.status_approve_claim == null ? true : false
                                                ||(data.status_claim_code == '7' 
                                                || data.status_claim_code == '8' 
                                                || data.status_claim_code == '9' 
                                                || data.status_claim_code == '6'
                                                || data.status_claim_code == '5'
                                                || data.status_claim_code == '3'
                                                || data.status_claim_code == '4'
                                                || data.status_claim_code == '10'
                                                || data.status_claim_code == '11' ? true : false)"
                                                :checked="data.creditNote == 'N' ? data.creditNote = 'creditNote' : false" 
                                                @change="checkSelectCreditNote(data.replacement, data.creditNote, data.cashBack, data)"                                            
                                                ><span  style="padding-left: 10px;">ออกใบลดหนี้</span></label>
                            </div>
                            <div class="text-left">
                                <label><input   type="radio" 
                                                value="cashBack" 
                                                :name="'claimMethod'+data.claim_header_id" 
                                                v-model="data.cashBack" 
                                                :disabled="data.status_approve_claim == null ? true : false
                                                ||(data.status_claim_code == '7' 
                                                || data.status_claim_code == '8' 
                                                || data.status_claim_code == '9' 
                                                || data.status_claim_code == '6'
                                                || data.status_claim_code == '5'
                                                || data.status_claim_code == '3'
                                                || data.status_claim_code == '4'
                                                || data.status_claim_code == '10'
                                                || data.status_claim_code == '11' ? true : false)"
                                                :checked="data.replacement == 'C' ? data.cashBack : false" 
                                                @change="checkSelectCashBack(data.replacement, data.creditNote, data.cashBack, data)"                                            
                                                ><span  style="padding-left: 10px;">จ่ายเงินสดคืน</span></label>
                            </div>
                            <div class="text-left">
                                <label><input   type="checkbox" 
                                                value="notSendBack" 
                                                v-model="data.notSendBack"
                                                :name="'notSendBack'+data.claim_header_id"  
                                                :disabled="data.status_approve_claim == null ? true : false
                                                ||(data.status_claim_code == '7' 
                                                || data.status_claim_code == '8' 
                                                || data.status_claim_code == '9' 
                                                || data.status_claim_code == '6'
                                                || data.status_claim_code == '5'
                                                || data.status_claim_code == '3'
                                                || data.status_claim_code == '4'
                                                || data.status_claim_code == '10'
                                                || data.status_claim_code == '11' ? true : false)"   
                                                ><span style="padding-left: 10px;">รับสินค้าคืนจากลูกค้า</span></label>
                            </div>

                            <div class="form-group text-left mt-4">
                                <label class="d-block">หมายเหตุ</label>
                                <el-input
                                    type="textarea"
                                    :rows="3"
                                    placeholder="หมายเหตุ"
                                    v-model="data.note"
                                    :disabled="data.status_approve_claim == null ? true : false
                                    || (data.status_claim_code == '7' 
                                    || data.status_claim_code == '8' 
                                    || data.status_claim_code == '9' 
                                    || data.status_claim_code == '6'
                                    || data.status_claim_code == '5'
                                    || data.status_claim_code == '3'
                                    || data.status_claim_code == '4'
                                    || data.status_claim_code == '10'
                                    || data.status_claim_code == '11' ? true : false)">
                                </el-input>
                            </div>
                        </td>
                    </tr>      
                </tbody>
            </table>
        </div>
    </div>
</template>

<script type="text/javascript">
    import VueNumeric from 'vue-numeric'
    export default {
        props: [
            'lineList',
            'checkStatus',
            'btnTrans',
        ],
        components: {
            VueNumeric
        },
        data() {
            return {
                uomNotTobaco: '',
                loadingTable: false,
                disenable: {
                    approve: false
                },
                resultClick: [],
                status_color_template: {
                    "อยู่ระหว่างการตรวจสอบ": {color: "#f90"},
                    "อยู่ระหว่างการส่งสินค้า": {color: "#00f"},
                    "อยู่ระหว่างการออกใบลดหนี้": {color: "#f0f"},
                    "ปฏิเสธการเคลม": {color:"#f00" },
                    "ลูกค้าได้รับสินค้าแล้ว": {color: "#00b050"},
                    "ออกใบลดหนี้แล้ว": {color: "#f1c232"},
                    "ปิดการเคลม": {color:"#676a6c"},
                    "ยกเลิกการเคลม": {color:"#ff0000"},
                    "อยู่ระหว่างการจ่ายเงินสดคืน": {color:"#00c0ff"},
                    "รับเงินแล้ว": {color:"#9900ff"},
                },
            }
        },
        mounted() {
            
        },
        methods: { 
            checkSelectReplacement(replacement, creditNote, cashBack, arrayData){
                if(replacement){
                    arrayData.creditNote = '';
                    arrayData.cashBack = '';
                    arrayData.replacement = replacement;
                }    
            }, 
            checkSelectCreditNote(replacement, creditNote, cashBack, arrayData){
                if(creditNote){
                    arrayData.replacement = '';
                    arrayData.cashBack = '';
                    arrayData.creditNote = creditNote;
                }
            },
            checkSelectCashBack(replacement, creditNote, cashBack, arrayData){
                if(cashBack){
                    arrayData.replacement = '';
                    arrayData.creditNote = '';
                    arrayData.cashBack = cashBack;
                }
            },
            checkDate(value, event, data){
                this.resultClick.push(value);
                var valObjApprove = this.resultClick.filter(function (value) {
                    if(value == "Y"){
                        return value;
                    }
                })

                var valObjDisApproved = this.resultClick.filter(function (value) {
                    if(value == "N"){
                        return value;
                    }
                })

                if((valObjApprove.length == 2 && valObjApprove[0] == "Y") || (valObjDisApproved.length == 2 && valObjDisApproved[0] == "N")){
                    data.approve = '';
                    this.resultClick = [];
                    valObjApprove = '';
                    valObjDisApproved = '';
                }else{
                    return;
                }
            },  
            async saveData() {
                var vm = this;
                const lineList =  this.lineList.filter((data) =>{      
                    return      (data.approve == 'Y' && data.status_approve_claim == null) 
                            ||  (data.approve == 'N' && data.status_approve_claim == null) 
                            ||  (data.replacement == 'replacement' &&  data.replacement_flag == null)
                            ||  (data.creditNote == 'creditNote' &&  data.replacement_flag == null)
                            ||  (data.cashBack == 'cashBack' &&  data.replacement_flag == null);
                })
                if(lineList.length != 0){
                    lineList.forEach(element => {
                        if(element.status_claim_code == '2'){
                            if(element.remark_approve){
                                element.validateRemarkApprove = false;
                                if(element.approve == 'N' && element.status_approve_claim == null){
                                    this.loadingTable = true;
                                    axios
                                        .post('ajax/approval-claim/update-approval-claim', {
                                            lineList
                                        })
                                        .then(res => {
                                            if(res.data.status == "ERROR"){
                                                swal({
                                                    title: "error !",
                                                    text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก "+res.data.err_msg,
                                                    type: "error",
                                                    showConfirmButton: true
                                                });
                                            }else if(res.data.result == "success"){
                                                swal({
                                                    title: "success !",
                                                    text: "บันทึกอนุมัติการเคลม สำเร็จ!",
                                                    type: "success",
                                                    showConfirmButton: true
                                                });
                                                this.disenable.approve = true;
                                                vm.$parent.getSearch(vm.$parent.form_search);
                                                this.loadingTable = false;
                                            }
                                        })
                                }
                                if(element.approve == 'Y' && element.status_approve_claim == null){
                                    this.loadingTable = true;
                                    axios
                                        .post('ajax/approval-claim/update-approval-claim', {
                                            lineList
                                        })
                                        .then(res => {
                                            if(res.data.status == "ERROR"){
                                                swal({
                                                    title: "error !",
                                                    text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก "+res.data.err_msg,
                                                    type: "error",
                                                    showConfirmButton: true
                                                });
                                            }else if(res.data.result == "success"){
                                                swal({
                                                    title: "success !",
                                                    text: "บันทึกอนุมัติการเคลม สำเร็จ!",
                                                    type: "success",
                                                    showConfirmButton: true
                                                });
                                                this.disenable.approve = true;
                                                vm.$parent.getSearch(vm.$parent.form_search);
                                                this.loadingTable = false;
                                            }
                                        })
                                }
                                if( (element.replacement == 'replacement' && element.replacement_flag == null) || 
                                    (element.creditNote == 'creditNote' && element.replacement_flag == null) ||
                                    (element.cashBack == 'cashBack' && element.replacement_flag == null) ){
                                    this.loadingTable = true;
                                    axios   .post('ajax/approval-claim/update-replacement', {
                                                lineList    
                                            })
                                            .then(res =>{ 
                                                if(res.data.result == "success"){
                                                    swal({
                                                        title: "success !",
                                                        text: "บันทึก สำเร็จ!",
                                                        type: "success",
                                                        showConfirmButton: true
                                                    });
                                                    vm.$parent.getSearch(vm.$parent.form_search);
                                                    this.loadingTable = false;
                                                }else if(res.data.result == "disapproved"){
                                                    swal({
                                                        title: "error !",
                                                        text: "ไม่สามารถเลือกวิธีการส่งสินค้าทดแทน หรือออกใบลดหนี้ได้ เนื่องจากไม่อนุมัติการเคลม",
                                                        type: "error",
                                                        showConfirmButton: true
                                                    });
                                                    this.loadingTable = false;
                                                }
                                            });
                                }
                            }else{
                                swal({
                                    title: "คำเตือน !",
                                    text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากกรอกข้อมูลไม่ครบถ้วน",
                                    type: "warning",
                                    showConfirmButton: true
                                });
                                element.validateRemarkApprove = true;
                                return;
                            }
                        }
                    });
                }else{
                    swal({
                        title: "คำเตือน !",
                        text: "กรุณาเลือกรายการที่จะทำการ",
                        type: "warning",
                        showConfirmButton: true
                    });
                    return;
                }        
            },

            attachmentBind(att) {
                switch (att) {
                    case "1":
                    return "รูปถ่ายหน้าหีบ";
                    break;
                    case "2":
                    return "รูปวันผลิตข้างซอง";
                    break;
                    case "3":
                    return "รูปสินค้าที่เสียหาย";
                    break;
                    default:
                    break;
                }
            },

            async closedClaim(value) {
                var vm = this;
                swal({
                    title: "คุณแน่ใจ?",
                    text: "คุณต้องการปิดการเคลมสินค้าใช่ไหม ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        axios   .post('ajax/approval-claim/closed-claim', {
                                    params: {
                                        claim_header_id: value,
                                    } 
                                })
                                .then(res =>{ 
                                    if(res.data.result == "success"){
                                        swal({
                                            title: "success !",
                                            text: "บันทึก สำเร็จ!",
                                            type: "success",
                                            showConfirmButton: true
                                        });
                                        vm.$parent.getSearch(vm.$parent.form_search);
                                        this.loadingTable = false;
                                    } 
                                });   
                    }
                });  
            },

            handlePrintBtn(id) {
                window.open(
                    '/om/ajax/approval-claim/report-claim' + "?claim_header_id=" + id
                );
            },
        }
    }
</script>
