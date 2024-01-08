<template>
    <div class="row">
        <div class="col-lg-12" v-loading="loading.form">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <h4 v-if="showFreezeMsg" class="text-danger pull-left pt-1">
                        {{ showFreezeMsg }}
                    </h4>
                    <div class="text-right">
                        <button
                            :class="transBtn.search.class + ' btn-sm'"
                            data-toggle="modal"
                            data-target="#myModal5"
                            @click="modalOpen"
                        >
                            <i
                                :class="
                                    transBtn.search.icon + ' btn-lg tw-w-25'
                                "
                            ></i>
                            {{ transBtn.search.text }}
                        </button>
                        <button
                            :class="transBtn.create.class + ' btn-lg tw-w-25'"
                            @click.prevent="create"
                        >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>
                        <button
                            :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            @click.prevent="saveData"
                            :disabled="disabledSave"
                        >
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
                        <button
                            class="btn btn-primary btn-lg"
                            :disabled="disabledSubmit"
                            @click="submit"
                        >
                            <strong>ตัดใช้วัตถุดิบ</strong>
                        </button>
                        <button
                            @click="cancel(form_header.issue_header_id)"
                            :disabled="disabledCancel"
                            class="btn btn-w-m btn-danger btn-lg"
                        >
                            <i class="fa fa-times"></i> ยกเลิกการตัดใช้วัตถุดิบ
                        </button>
                        <button
                            :class="transBtn.print.class + ' btn-lg tw-w-25'"
                            @click="report">
                            <i :class="transBtn.print.icon"></i>
                            {{ transBtn.print.text }}
                        </button>
                    </div>

                    <hr />
                    <div class="form-group">
                        <div class="row m-2">
                            <!-- <div class="col-lg-2">หน่วยงาน</div>
                            <div class="col-lg-4">
                                <el-input

                                    size="small"
                                    class="w-100"
                                    readonly
                                    disabled
                                    :value="userProfile.department.description"
                                ></el-input>
                            </div> -->
                            <div class="col-lg-2">
                                วันที่ตัดใช้ <span class="tw-text-red-500">*</span>
                            </div>
                            <div class="col-lg-4">
                                <datepicker-th
                                    placeholder="เลือกวันที่ขอเบิก"
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    :value="date"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="getDate"
                                />
                            </div>
                            <div class="col-lg-2">เลขที่ตัดใช้วัตถุดิบ</div>
                            <div class="col-lg-4">
                                <el-input
                                    v-model="header_number"
                                    disabled
                                    size="small"
                                    class="w-100"
                                    suffix-icon="el-icon-search"
                                    readonly
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">เลขที่คำสั่งผลิต <span class="tw-text-red-500">*</span></div>
                            <div class="col-lg-4">
                                <el-select
                                    v-model="blendSelected"
                                    filterable
                                    size="small"
                                    class="w-100"
                                    v-loading="loading.blend_no"
                                    :disabled="
                                        blends.length == 0 ? true : false || disabledForm
                                    "
                                    @change="getOpt()"
                                >
                                    <el-option
                                        v-for="blend in blends"
                                        :key="blend.batch_no"
                                        :label="blend.batch_no + ' : '+ blend.item_description"
                                        :value="blend.batch_no"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-2">สถานะตัดใช้</div>
                            <div class="col-lg-4">
                                <el-input
                                    disabled
                                    size="small"
                                    class="w-100"
                                    :value="headerStatus"
                                    readonly
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">สินค้าที่จะผลิต</div>
                            <div class="col-lg-4">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="
                                        productByBlend
                                            ? productByBlend.segment1
                                            : ''
                                    "
                                    disabled
                                ></el-input>
                            </div>
                            <div class="col-lg-2">
                                ขั้นตอนการทำงาน
                                <span class="tw-text-red-500">*</span>
                            </div>
                            <div class="col-lg-2">
                                <el-select
                                    v-model="oprnSeletected"
                                    filterable
                                    placeholder="Select"
                                    size="small"
                                    default-first-option
                                    @change="findOprn()"
                                    v-loading="loading.oprn"
                                    :disabled="oprns.length == 0 ? true : false || disabledForm" 
                                >
                                    <el-option
                                        v-for="oprn in oprns"
                                        :key="oprn.wip_step"
                                        :label="oprn.wip_step"
                                        :value="oprn.wip_step"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-2">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    v-loading="loading.oprn"
                                    :value="oprnDescription"
                                    :disabled="oprns.length == 0 ? true : false"
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">ผลผลิตที่ได้</div>
                            <div class="col-lg-4">
                                <el-input
                                    disabled
                                    size="small"
                                    class="w-100"
                                    :value="numberFormat(totalQtyFromWip)"
                                >
                                    <template slot="append">{{
                                      totalOptQuantityUom
                                    }}</template>
                                </el-input>
                            </div>

                            <div class="col-lg-2">รายละเอียดสินค้าที่จะผลิต</div>
                                <div class="col-lg-4">
                                    <el-input
                                        disabled
                                        type="textarea"
                                        :rows="1"
                                        :value="productByBlend
                                                    ? productByBlend.description
                                                    : ''">
                                    </el-input>

                                </div>
                        </div>

                        <div class="row m-2">

                        </div>
                        <div class="row m-2">

                            </div>
                        </div>
                        <div class="row m-2">
                        <div class="col-lg-6"></div>
                            <div class="col-lg-6 text-right">
                                <button
                                    :disabled="disabledSearch"
                                    :class="transBtn.search.class"
                                    @click.prevent="fitterFormula()"
                                >
                                    <i
                                        :class="
                                            transBtn.search.icon + ' btn-lg'
                                        "
                                    ></i>
                                    <strong>แสดงข้อมูล</strong>
                                </button>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-6"></div>
                        </div>
                        <hr />
                        <div v-if="form.table_line">
                            <div class="sk-spinner sk-spinner-wave mb-4">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <div
                            v-if="
                                formulas.length > 0 && action === 'show-lines'
                            "
                        >
                            <TableAll
                                :p-disabled-input="showFreezeMsg"
                                :formulas="orderedFormulas"
                                :opt-quantity="totalQtyFromWip"
                                :action="action"
                                @input="onClickChild">
                            </TableAll>
                        </div>
                    </div>
                    <div
                        class="modal inmodal fade"
                        id="myModal5"
                        tabindex="-1"
                        role="dialog"
                        aria-hidden="true"
                        style="display: none;"
                    >
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                    >
                                        <span aria-hidden="true">×</span
                                        ><span class="sr-only">Close</span>
                                    </button>
                                    <h5 class="modal-title m-0 p-0">
                                        รายการตัดใช้ วัตถุดิบ
                                    </h5>
                                    <!-- <small class="font-bold">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</small> -->
                                </div>
                                <div class="modal-body">
                                    <div v-if="loading.table_header">
                                        <div
                                            class="sk-spinner sk-spinner-wave mb-4"
                                        >
                                            <div class="sk-rect1"></div>
                                            <div class="sk-rect2"></div>
                                            <div class="sk-rect3"></div>
                                            <div class="sk-rect4"></div>
                                            <div class="sk-rect5"></div>
                                        </div>
                                    </div>
                                    <TableHeader
                                        :p-disabled-input="showFreezeMsg"
                                        :headers="mesReviewIssueHeaders"
                                        :trans-btn="transBtn"
                                        :trans-date="transDate"
                                        :sysDate="date_issue"
                                        :url="url"
                                        :program-code="programCode"
                                        @click="onClickChild"
                                    >
                                    </TableHeader>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import TableRow from "./Table";
import TableHeader from "./TableHeader";
import Search from "./SearchWipIssueHeader";
import moment from "moment";
import TableCasingFlavor from "./TableCasingFlavor";
import TableAll from "./TableAll";


export default {
    components: {
        TableRow,
        TableHeader,
        Search,
        TableCasingFlavor,
        TableAll
    },
    props: [
        "url-get-mes-review-issue-v",
        "url-opt",
        "url-get-oprn-by-item",
        "url-get-formulas",
        "user-profile",
        "trans-date",
        "url-save-data",
        "class-classification-code",
        "url",
        "trans-btn",
        "sys-date",
        "program-code"
    ],
    data() {
        return {
            form: {
                date: ""
            },
            issue_date: "",
            date_issue: moment(this.sysDate)
                .add(543, "years")
                .toDate(),
            date: "",
            action: "show",
            form_header: {
                date: "",
                blend_no: "",
                opt_no: "",
                oprn_no: "",
                item_id: "",
                org_id: "",
                lines: [],
                issue_header_id: "",
                submit: false,
                program_code: this.programCode,
                total_quantity_from_wip: "",
            },

            form_lines: [],
            waite: false,
            mesReviewIssueV: [],
            blends: [],
            blendSelected: "",
            blend: "",

            opts: [],
            optSelected: "",
            opt: "",
            groupByOpts:[],

            oprnSeletected: "",
            oprns: [],
            oprnDescription: "",

            items: [],
            itemSelected: "",

            formulas: [],

            org_id: "",
            loading: {
                blend_no: false,
                opt: false,
                oprn: false,
                table_line: false,
                table_header: false,
                form: false
            },

            classification: "",
            job_type: "",
            defaultOprn: "",

            productByBlend: "",
            wipIssueNumber: "",
            dialog: false,
            dialogVisible: false,

            header_number: "",
            totalOptQuantityFromHeader: "",
            totalOptQuantityUomFromHeader: "",

            postTYpe: "create",

            mesReviewIssueHeaders: [],
            setHeader: false,

            headerStatus:"",
            blendUom:"",
            transaction_quantity:"",

            totalQtyFromWip: "",
            reportDate:"",
            urlTestOpt: 'http://web-service.test/pm/ajax/get-opt-from-blend-no?blend_no=98&date=07/06/2564',
            wipIssueHeader: "",
            canSave: false,
            testUrl: 'http://web-service.test/pm/ajax/get-formulas?date=22/06/2564&blend_no=64MG618-009&opt_no=&oprn_no=WIP03&item_id=146010&total_opt_quantity=0&classification=03&product_item_number%20=undefined&program_code=PMP0049'
        };
    },
    mounted() {
        // this.getFormula();
    },
    methods: {
        findItemClassification() {
            axios
                .get(
                    this.url.findClassification +
                        "?classification_code=" +
                        this.classClassificationCode
                )
                .then(res => {
                    let classification = res.data.classification;
                    this.classification = classification;
                });
        },
        getMesReviewIssuesV() {
            this.loading.blend_no = true;
            axios
                .get(
                    this.url.urlGetMesReviewIssuesV +
                        "?date=" +
                        this.date +
                        "&set_header=" +
                        this.setHeader +
                        "&program_code=" +
                        this.programCode
                )
                .then(res => {
                    let result = res.data.result;
                    // console.log(result);
                    if (result.status != "S") {
                        swal({
                            title: "Error !",
                            text: result.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                        this.loading.blend_no = false;
                    } else {
                        let mesReviewIssueV = res.data.mesReviewIssueV;
                        let blends = res.data.blends;
                        let job_type = res.data.jobType;
                        // let opts = res.data.opts;
                        this.mesReviewIssueV = mesReviewIssueV;
                        this.blends = blends;
                        this.job_type = job_type;

                        //    this.opts = opts;
                        this.loading.blend_no = false;
                        if (this.blendSelected && this.setHeader !== true) {
                            this.findBlend();

                        }
                    }
                });
        },

        async getOpt() {
            this.loading.opt = true;
            this.loading.oprn = true;
            axios
                .get(
                    this.url.urlOpt +
                        "?blend_no=" +
                        this.blendSelected +
                        "&date=" +
                        this.date +
                        "&batch_no=" +
                        this.blendSelected +
                        "&program_code="+
                        this.programCode
                    // this.urlTestOpt
                )
                .then(res => {
                    let opts = res.data.opts;
                    let productByBlend = res.data.productByBlend;
                    let groupByOpts = res.data.groupByOpts;

                    this.groupByOpts = groupByOpts;
                    this.opts = opts;
                    this.productByBlend = productByBlend;
                    this.loading.opt = false;
                })
                .then(() => {
                    if (this.optSelected) {
                        this.optQuantity = this.opts;
                    }
                    if (this.setHeader !== true) {
                        console.log("find blend by opt");
                        this.findBlend();
                    }
                })
                .then(() => {
                    this.getOprn();
                });
        },
        async getOprn() {
            axios
                .get(
                    this.url.urlGetOprnByItem +
                        "?item_id=" +
                        this.blend.inventory_item_id +
                        "&program_code="+
                        this.programCode +
                        "&tran_date=" +
                        this.date+
                        "&set_header="+
                        this.setHeader +
                        "&batch_no=" +
                        this.blendSelected

                )
                .then(res => {
                    let oprns = res.data.listOprnByItems;
                    let defaultOprn = res.data.defaultOprn;
                    this.oprns = oprns;
                    // this.defaultOprn = defaultOprn;
                    this.loading.oprn = false;
                })
                .then(() => {

                    // this.oprnSeletected = this.defaultOprn.wip_step;
                    // this.oprnDescription = this.defaultOprn.wip_step_desc;
                    this.loading.oprn = false;


                })
                .then(() => {

                    // let oprn = this.oprns.find(item => {
                    //     return item.wip_step === this.oprnSeletected;
                    // });

                    // this.oprn = oprn;
                    // this.oprnDescription = this.oprn.wip_step_desc;

                    // let wip = this.mesReviewIssueV.find(item => {
                    //     return item.wip_step === this.oprnSeletected && item.batch_no === this.blendSelected;
                    // })


                    // let wip = this.mesReviewIssueV.find(item => {
                    //     console.log(item.wip_step);
                    //     console.log(this.oprnSeletected)
                    //    return item.wip_step === this.oprnSeletected && item.batch_no === this.blendSelected;
                    // });

                    // this.totalQtyFromWip = wip ? wip.transaction_quantity : 0;
                });
        },
        findOprn() {
            let oprn = this.oprns.find(item => {
                return item.wip_step === this.oprnSeletected;
            });

            this.oprn = oprn;

            this.oprnDescription = this.oprn.wip_step_desc;

            let wip = this.mesReviewIssueV.find(item => {
                return item.wip_step === this.oprnSeletected && item.batch_no === this.blendSelected ;
            })

            this.totalQtyFromWip = wip.transaction_quantity;
        },

        findBlend() {
            let blend = this.mesReviewIssueV.find(item => {
                return item.batch_no == this.blendSelected;
            });

            this.blend = blend;
        },

        findOpt() {
            let opt = this.opts.find(item => {
                return item.opt === this.optSelected;
            });

            this.opt = opt;
        },

        getItemByOprn() {
            axios.get(this.url.urlGetOprnByItem).then(res => {
                let oprns = res.data.listOprnByItems;
                this.oprns = oprns;
            });
        },

        fitterFormula() {
            this.action = "show-lines";
            this.validateFormHeader();
            this.updateFormHeader();
            this.getFormula();
        },

        validateFormHeader() {
            return;
        },
        async updateFormHeader() {
            this.form_header.date = this.date;
            this.form_header.blend_no = this.blendSelected;
            this.form_header.opt = this.optSelected;
            this.form_header.oprn = this.oprnSeletected;
            this.form_header.item_id = this.itemSelected;
            this.form_header.issue_date = this.issue_date;
            this.form_header.opts = this.optSelected ? [] : this.opts;
        },

        updateFormLine() {
            this.form_header.date = this.date;
            this.form_header.blend_no = this.blendSelected;
            this.form_header.opt_no = this.optSelected;
            this.form_header.oprn_no = this.oprnSeletected;
            this.form_header.item_id = this.blend.inventory_item_id;
        },

        getFormula() {
            this.formulas = [];
            if (this.validateForm === false) {
                swal({
                    title: "Validation !",
                    text: "โปรดระบุข้อมูลให้ครับ",
                    type: "error",
                    showConfirmButton: true
                });
            } else {
                this.form.table_line = true;
                this.updateFormHeader();
                this.action = "show-lines";
                this.request_form =
                    "?date=" +
                    this.form_header.date +
                    "&blend_no=" +
                    this.form_header.blend_no +
                    "&opt_no=" +
                    this.optSelected +
                    "&oprn_no=" +
                    this.oprnSeletected +
                    "&item_id=" +
                    this.blend.inventory_item_id +
                    "&total_opt_quantity=" +
                    this.totalOptQuantity +
                    "&classification=" +
                    this.classClassificationCode+
                    "&product_item_number ="+
                    this.blend.product_item_number
                    +
                    "&program_code="+
                    this.programCode;
                axios
                    .get(this.url.urlFormulas + this.request_form)
                    // .get(this.testUrl)
                    .then(res => {
                        let formulas = res.data.formulas;
                        let header = res.data.header;
                        this.formulas = formulas;
                        this.form.table_line = false;

                        if(header){
                            this.header_number  = header.request_number;
                            this.headerStatus   = header.issue_status.description;
                            this.form_header.issue_header_id    = header.issue_header_id;
                            this.postTYpe = 'update';
                        } else {
                            this.header_number  = null;
                            this.headerStatus   = null;
                            this.form_header.issue_header_id   =null;
                        }
                        
                    }).catch(()=> {
                        console.log('catch');
                        this.loading.form =false;
                    })
                    .finally(()=> {
                        console.log('finally');
                        this.loading.form =false;
                    });
            }
        },

        getLines() {
            this.action = "show-lines";
            axios
                .get(
                    this.url.urlFormulas +
                        "?request_line=1" +
                        "&issue_header_id=" +
                        this.form_header.issue_header_id +
                        "&total_opt_quantity=" +
                        this.totalOptQuantityFromHeader +
                        "&program_code="+
                        this.programCode
                )
                .then(res => {
                    let formulas = res.data.formulas;
                    console.log(res);
                    this.formulas = formulas;
                    this.updateFormHeader();
                    this.form_header.lines = this.formulas;
                });
        },
        validateForm() {
            if (this.date == "") {
                return false;
            }
            if (this.date_issue == "") {
                return false;
            }
            if (this.blendSelected == "") {
                return false;
            }
            if (this.oprnSeletected == "") {
                return false;
            }

            return true;
        },
        async saveData() {
            console.log(this.validateForm());
            if (this.validateForm() === false) {
                swal({
                    title: "Validation !",
                    text: "โปรดระบุข้อมูลให้ครับ",
                    type: "error",
                    showConfirmButton: true
                });
            } else {
                console.log("xxx");
                this.loading.form = true;
                // this.form_header.lines = this.formulas;
                this.form_header.item_classification_code = this.classClassificationCode;
                this.form_header.total_opt_quantity = this.totalOptQuantity;
                this.form_header.total_quantity_from_wip = this.totalQtyFromWip;
                this.form_header.program_code = this.programCode;
                this.updateFormHeader();
                if (this.postTYpe == "update") {
                    this.updateFormHeader();
                    axios
                        .post(
                            this.url.urlUpdateData +
                                "?issue_header_id=" +
                                this.form_header.issue_header_id,
                            {
                                ...this.form_header
                            }
                        )
                        .then(res => {
                            this.loading.form = false;
                            let result = res.data.result;
                            let data = res.data;

                            if (result.status === "S") {
                                swal({
                                    title: "Success !",
                                    text: result.msg,
                                    type: "success",
                                    showConfirmButton: true
                                });
                            } else {
                                swal({
                                    title: "Error !",
                                    text: result.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                                console.log(result.msg);
                            }

                            this.wipIssueHeader = data.header;
                            this.header_number = data.header.request_number;
                            this.headerStatus  = data.header.issue_status.description;
                            // this.formulas = [];

                        })
                        .then(() => {
                            // this.getLines();
                        })
                        .catch(err => {
                            swal({
                                title: "Error !",
                                text: result.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                            console.log(result.msg);
                        });
                } else {
                    axios
                        .post(this.url.urlSaveData, {
                            ...this.form_header
                        })
                        .then(res => {
                            this.loading.form = false;
                            let result = res.data.result;

                            let data = res.data;
                            if (result.status == "S") {
                                swal({
                                    title: "Success !",
                                    text: result.msg,
                                    type: "success",
                                    showConfirmButton: true
                                });
                            } else {
                                swal({
                                    title: "Error !",
                                    text: result.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });

                            }
                            this.wipIssueHeader = data.header;
                            this.headerStatus  = data.header.issue_status.description;
                            this.form_header.issue_header_id =
                                data.header.issue_header_id;
                            this.header_number = data.header.request_number;
                            this.postTYpe = 'update';
                        });
                }
            }
        },

        create() {
            location.reload();
            this.action = "create";
            this.formulas = [];
            this.blend = "";
            this.blendSelected = "";

            this.form_header.date = "";
            this.form_header.blend_no = "";
            this.form_header.opt_no = "";
            this.form_header.oprn_no = "";
            this.form_header.item_id = "";
            this.form_header.org_id = "";
            this.form_header.lines = [];
            this.form_header.issue_header_id = "";
            this.form_header.submit = false;

            this.form_lines = [];
            this.mesReviewIssueV = [];
            this.blends = [];
            this.blendSelected = "";
            this.blend = "";

            this.opts = [];
            this.optSelected = "";
            this.opt = "";

            this.oprnSeletected = "";
            this.oprns = [];
            this.oprnDescription = "";

            this.items = [];
            this.itemSelected = "";

            this.formulas = [];
            this.org_id = "";

            this.loading.blend_no = false;
            this.loading.opt = false;
            this.loading.oprn = false;
            this.loading.table_line = false;
            this.loading.table_header = false;

            this.classification = "";
            this.job_type = "";
            this.defaultOprn = "";

            this.productByBlend = "";
            this.wipIssueNumber = "";

            this.header_number = "";
            this.totalOptQuantityFromHeader = "";

            this.postTYpe = "create";

            this.mesReviewIssueHeaders = [];
            this.date_issue = "";
        },
        submit() {

            if(this.formulas.length == 0){
                return swal({
                        title: "Error !",
                        text: 'จำนวนไม่ถูกต้อง ไม่มีสูตร',
                        type: "error",
                        showConfirmButton: true
                    });
            }

            let allow = true;
            let item_no_onhands = [];
            let interfaced = false;

            const  groupB =  _.groupBy(this.formulas, "item_number");

            this.formulas.forEach(formula => {
                // console.log(groupB[formula.item_number].length);
                let quantity_summary = parseFloat(formula.input_quantity_summary);
                let onhand  = 0;
                if (formula.onhand_quantity != '') {
                    let strOnhand = formula.onhand_quantity.toString();
                    onhand  = parseFloat(strOnhand.replace(',', ""));
                }
 
                if(groupB[formula.item_number].length> 1){
                    onhand  = groupB[formula.item_number].reduce((acc, item) =>
                        acc + parseFloat(formula.onhand_quantity.toString().replace(',', "")), 0);

                }


                if (quantity_summary > onhand) {
                    allow = false;
                    item_no_onhands.push((item_no_onhands.length % 2 === 0 ? " <br> ": "") + formula.item_number);
                }

                if (formula.header_interface_status == "S") {
                    interfaced = true;
                    this.can.submit = false;
                }
            });

            const arr = item_no_onhands;
            const uniqueSetArr =  new Set(arr);
            const items = [...uniqueSetArr];


            // if(interfaced == true ){
            //     return swal({
            //             title: "Error !",
            //             text: 'ไม่สามารถตัดใช้ได้',
            //             type: "error",
            //             showConfirmButton: true
            //         });
            // }

            // if(allow == false){
            //     let msg = "รหัสวัตถุดิบ"+ items + "<br> มีจำนวน onhand ไม่พอ ไม่สามารถตัดใช้วัตถุดิบได้";
            //     return swal({
            //             html: true,
            //             title: "Error !",
            //             padding: '2em',
            //             text:  "<div>"+msg,
            //             type: "error",
            //             showConfirmButton: true
            //         });
            // }

            this.loading.form = true;
            this.form_header.lines = this.formulas;
            this.form_header.total_opt_quantity = this.totalOptQuantity;
            this.form_header.submit = true;

            axios
                .post(this.url.urlSaveData, {
                    ...this.form_header
                })
                .then(res => {
                    this.loading.form = false;
                    let result = res.data.result;
                    let data = res.data;
                    if(data.header.interface_status === 'S'){
                        swal({
                            title: "Success !!!",
                            text: result.msg,
                            type: "success",
                            showConfirmButton: true
                        });
                    }else{
                        swal({
                            title: "Error !",
                            text: data.header.interface_msg,
                            type: "error",
                            showConfirmButton: true,
                        });
                    }

                    this.wipIssueHeader = data.header;
                    this.header_number  = data.header.request_number;
                    this.headerStatus   = data.header.issue_status.description;
                    this.form_header.issue_header_id    = data.header.issue_header_id;
                    this.totalOptQuantityFromHeader     = data.total_qty;

                    this.loading.form = false;
                });
        },

        onClickChild(value) {
            console.log('emit');
            console.log(value);
            if (value.key == "set_header") {
                console.log(value);
                this.form_header.issue_header_id = value.issue_header_id;
                this.selectHeader(value.header);
            } else {
                this.form_header.lines = value;
                this.formulas = value;
            }
        },

        async selectHeader(header) {
            this.formulas = [];
            this.waite = true;
            this.date = header.complete_date;
            this.date_issue = header.issue_date;
            // this.reportDate = moment(date).format("YYYY-MM-DD");
            this.wipIssueHeader = header;
            this.headerStatus = header.status;

            // console.log(moment(header.issue_date).add(543, 'years').toDate());
            // console.log(moment(header.complete_date).add(543, 'years').toDate());

            this.postTYpe = "update";
            this.setHeader = true;
            this.header_number = header.request_number;
            this.blendSelected = header.batch_no;
            this.form_header.issue_header_id = header.issue_header_id;
            this.totalOptQuantityFromHeader = header.opt_plan_qty;

            this.optSelected = header.all_opt
                                ? ""
                                : header.opt;
            this.blend = header.blend;

            this.oprnSeletected  =  header.wip_step;
            this.blendUom = header.blend_uom;
            this.oprnDescription = header.wip.wip_step_desc;

            await this.getMesReviewIssuesV();
            await this.getOpt();
            await this.getLines();

            this.totalQtyFromWip =  header.opt_plan_qty;

            // await this.findOprn();

        },

        getDate(date) {
            console.log(date);
            this.date = moment(date).format(this.transDate["js-format"]);
            this.reportDate = moment(date).add(-543, "years").format("YYYY-MM-DD");
            this.blendSelected = "";
            this.oprnDescription = "";
            this.blend = "";
            this.productByBlend = "";
            this.opts = [];
            this.optSelected = "";
            this.opt = "";
            this.groupByOpts = [];
            this.oprnSeletected = "";
            this.oprns = [];
            this.items = "";
            this.itemSelected = "";
            this.formulas = [];
            this.headerStatus = "";
            this.header_number = "";
            this.postTYpe ="create";
            this.getMesReviewIssuesV();
        },

        issueDate(date) {
            this.issue_date = moment(date).format(this.transDate["js-format"]);
        },

        modalOpen() {
            // this.loading.table_header = true;
            // this.mesReviewIssueHeader = [];
            // axios.get(this.url.getHeaders+
            //         '?item_classification_code='+
            //         this.classClassificationCode+
            //         '&program_code='+
            //         this.programCode
            // ).then(res => {
            //     let mesReviewIssueHeaders = res.data.mesReviewIssueHeaders;
            //     this.mesReviewIssueHeaders = mesReviewIssueHeaders;
            //     this.loading.table_header = false;
            // });
        },
        cancel(issue_header_id) {

            console.log(issue_header_id);
            this.loading.form = true;
            this.form_header.issue_header_id = issue_header_id;
            axios
                .post(this.url.cancelData, {
                    ...this.form_header
                })
                .then(res => {
                    this.loading.form = false;
                    let data = res.data;
                    let result = res.data.result;
                    console.log(data);
                    if (result.status === "S") {
                        swal({
                            title: "Success !",
                            text: result.interface_status,
                            type: "success",
                            showConfirmButton: true
                        });
                    } else {
                        swal({
                            title: "Error !",
                            text: result.interface_status,
                            type: "error",
                            showConfirmButton: true
                        });
                    }

                    this.header_number  = result.request_number;
                    this.headerStatus   = result.header_status;

                    // location.reload();
                });
        },

        report(){
            let date = this.wipIssueHeader.report_date ? this.wipIssueHeader.report_date : this.wipIssueHeader.complete_date;
            let groupCode  = this.wipIssueHeader.issue_status.meaning ? this.wipIssueHeader.issue_status.meaning : this.wipIssueHeader.issue_status;
            window.open('/pm/sample-report-inventory-pdf/'
                        +this.blend.batch_no
                        +'/'
                        +this.userProfile.organization_code
                        +'/'
                        +date
                        +'?issue_header_id='
                        +this.wipIssueHeader.issue_header_id
                        +'&transaction_type_code='
                        +groupCode
                        +'&program_code='
                        +this.programCode,
                         '_blank');
        },

        numberFormat(amount){
            return  parseFloat(amount).toLocaleString(undefined, {minimumFractionDigits: 2});
        }
    },

    computed: {
        totalOptQuantity: function() {

            if(this.blend){

                return this.blend.transaction_quantity;
            }else{
                return 0;
            }
            // if (this.totalOptQuantityFromHeader) {
            //     return parseFloat(this.totalOptQuantityFromHeader).toFixed(2).toLocaleString();
            // }
            // if (this.optSelected) {
            //     return parseFloat(this.opt.transaction_quantity).toFixed(2).toLocaleString();
            // } else if (this.opts) {
            //     let sum = 0;
            //     $.each(this.groupByOpts, function(key, value){
            //         sum += parseFloat(value[0].transaction_quantity);
            //     });
            //     return sum.toFixed(2).toLocaleString();
            // } else {
            //     return 0.0;
            // }
        },

        totalOptQuantityUom: function() {
            if(this.blend){
                if(this.BlendUom){
                    return this.blendUom;
                } else {
                    return this.blend.uom
                     ?  this.blend.uom.unit_of_measure
                     :  this.blend.transaction_uom;
                }

            }
            return "";
            // if(this.optSelected) {
            //     return this.opt.formula_by_inv_item.detail_uom;
            // } else if (this.opts.length > 0) {
            //     return this.opts[0].formula_by_inv_item.detail_uom
            // } else {
            //    return  "";
            // }

        },

        isChangeHeader: function() {
            if (this.wipIssueHeader.length > 0) {
                return false;
            }
            if (
                moment(this.wipIssueHeader.complete_date).format(
                    this.transDate["js-format"]
                ) !==
                moment(this.wipIssueHeader.date).format(
                    this.transDate["js-format"]
                )
            ) {
                return true;
            }
            // if (this.wipIssueHeader.opt === ) {return false;}
        },

        inventory: function() {
            if (this.formulas.length === 0) {
                return "";
            } else {
                return this.formulas[0].from_subinventory;
            }
        },

        orderedFormulas: function() {
            if (this.formulas.length === 0) {
                return [];
            } else {
                return _.orderBy(this.formulas, "formulaline_id");
            }

        },
        canNotSubmit(){
            if (this.form_header.issue_header_id == ""){return true}
            if (this.formulas.length == 0) {return true}
        },

        disabledSubmit(){

            if(this.headerStatus == 'ยังไม่ตัดใช้'){
                return false;
            }
            if(this.wipIssueHeader.status == 'ยังไม่ตัดใช้'){
                return false;
            }

            if(this.wipIssueHeader.issue_status){
                if(this.wipIssueHeader.issue_status.meaning == 1){
                    return false;
                }
            }
            if(this.headerStatus == 'ตัดใช้แล้ว'){
                return true;
            }

            return true;

        },

        disabledSave(){

            if (this.showFreezeMsg) {
                return true;
            }
            if(this.headerStatus == 'ยังไม่ตัดใช้'){
                return false;
            }
            if(this.headerStatus== 'ยกเลิก'){
                return true;
            }
            if(this.formulas & this.formulas.length <= 0){
                return true;
            }
            if(this.wipIssueHeader.status == 'ตัดใช้แล้ว'){
                return true;
            }

            if(this.wipIssueHeader.status == 'ตัดใช้แล้ว'){
                return true;
            }
            if(this.wipIssueHeader.status == 'ยกเลิกตัดใช้'){
                return true;
            }

            if(this.wipIssueHeader.issue_status){
                if(this.wipIssueHeader.issue_status.meaning == 2){
                    return  true;
                }
                if(this.wipIssueHeader.issue_status.meaning == 3){
                    return  true;
                }
            }

            if(this.headerStatus == 'ตัดใช้แล้ว'){
                return true;
            }

            return false;

        },

        disabledCancel(){
            if (this.showFreezeMsg) {
                return true;
            }
            if(this.headerStatus == 'ยกเลิก'){
                return true;
            }
            if(this.headerStatus == 'ตัดใช้แล้ว'){
                return false;
            }
            if(this.wipIssueHeader.status == 'ตัดใช้แล้ว'){
                return false;
            }

            return true;

        },

        disabledForm(){
            if(this.headerStatus == 'ตัดใช้แล้ว'){
                return true;
            }

            if(this.headerStatus == 'ยกเลิก'){
                return true;
            }

            if(this.wipIssueHeader.status == 'ตัดใช้แล้ว'){
                return true;
            }

            return false;

        },

        disabledSearch(){
            if(this.headerStatus == 'ตัดใช้แล้ว'){
                return true;
            }

            if(this.headerStatus == 'ยกเลิก'){
                return true;
            }

            if(this.wipIssueHeader.status == 'ตัดใช้แล้ว'){
                return true;
            }

            return false;

        },

        showFreezeMsg() {
            if (this.blend != '' && this.blend != null && this.blend != undefined) {
                if(this.blend.freeze_flag_date =='' || this.blend.freeze_flag_date==null){
                    return false;
                }

                let tranDate        = moment(this.blend.transaction_date).format("YYYYMMDD");
                let freezeFlagDate  = moment(this.blend.freeze_flag_date).format("YYYYMMDD");
                console.log(freezeFlagDate);
                console.log(tranDate);

                if(tranDate < freezeFlagDate){
                    return  this.blend.freeze_msg
                }

            }
            return false;
        }

    }
};
</script>
