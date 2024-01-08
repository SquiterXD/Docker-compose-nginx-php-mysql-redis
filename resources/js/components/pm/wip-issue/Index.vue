
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
                                {{  transBtn.search.text  }}
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
                            :disabled="disabledSave"
                            @click.prevent="saveData"
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
                            :disabled="disabledCancel
                            "
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
                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal5">
                        Large Modal
                    </button> -->

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
                                    :value="userProfile.organization_code =='M02'
                                            ? userProfile.department.description
                                            :userProfile.organization_name"
                                ></el-input>
                            </div> -->
                            <div class="col-lg-2">
                                วันที่ตัดใช้<span class="tw-text-red-500">*</span>
                            </div>
                            <div class="col-lg-4">
                                <datepicker-th
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
                                    size="small"
                                    class="w-100"
                                    suffix-icon="el-icon-search"
                                    readonly
                                    disabled
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">{{ userProfile.organization_code == 'M03' ? 'สินค้าที่จะผลิต' : 'Blend No.' }} <span class="tw-text-red-500">*</span></div>
                            <div class="col-lg-4" v-if="userProfile.organization_code != 'M03'">
                                <el-select
                                    v-model="blendSelected"
                                    filterable
                                    size="small"
                                    class="w-100"
                                    v-loading="loading.blend_no"
                                    :disabled="
                                        blends.length == 0  ? true : false || disabledForm
                                    "
                                    @change="getOpt()"

                                >
                                    <el-option
                                        v-for="blend in blends"
                                        :key="blend.batch_id"
                                        :label="blend.blend_no+ ' : '+ blend.batch_no"
                                        :value=" userProfile.organization_code == 'MP2'? blend.batch_id : blend.batch_id"

                                    >
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-lg-2" v-if="userProfile.organization_code == 'M03'">
                                <el-select
                                    v-if="userProfile.organization_code == 'M03'"
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
                                        :key="blend.item_number"
                                        :label="blend.item_number"
                                        :value="blend.item_number"
                                    >
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-lg-2" v-if="userProfile.organization_code == 'M03'">
                                <el-input
                                    readonly
                                    size="small"
                                    class="w-100"
                                    :value="
                                        productByBlend
                                            ? productByBlend.product_item_desc
                                            : ''
                                    "
                                ></el-input>
                            </div>
                            <div class="col-lg-2">สถานะตัดใช้</div>
                            <div class="col-lg-4">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :disabled="disabledSubmit"
                                    :value="headerStatus"
                                    readonly
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">
                                OPT <span class="tw-text-red-500">*</span>
                            </div>
                            <div class="col-lg-4">
                                <el-select
                                    v-model="optSelected"
                                    placeholder="ALL"
                                    filterable
                                    size="small"
                                    @change="findOpt()"
                                    class="w-100"
                                    clearable
                                    v-loading="loading.opt"
                                    :disabled="
                                        (opts.length == 0 && opt != '') || (userProfile.organization_code==='MP2'
                                            ? true
                                            : false) || disabledForm
                                    "
                                    >
                                        <el-option
                                            v-for="(groupByOpt) in groupByOpts"
                                            :key="groupByOpt[0].opt"
                                            :label="groupByOpt[0].opt"
                                            :value="groupByOpt[0].opt"
                                        >
                                        </el-option>
                                    </el-select>
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
                                        :key="oprn.oprn_no"
                                        :label="oprn.oprn_no"
                                        :value="oprn.oprn_no"
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
                            <div class="col-lg-2">
                                เลขที่คำสั่งผลิต
                            </div>
                            <div class="col-lg-4">
                                <el-input
                                    :value="blend ? blend.batch_no : ''"
                                    size="small"
                                    class="w-100"
                                    readonly
                                    disabled
                                ></el-input>
                            </div>
                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'" >สินค้าที่จะผลิต</div>
                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'">
                                <el-input
                                    placeholder="0000000"
                                    size="small"
                                    class="w-100"
                                    disabled
                                    :value="
                                        productByBlend
                                            ? productByBlend.product_item_number
                                            : ''
                                    "
                                ></el-input>
                            </div>
                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    disabled
                                    :value="
                                        productByBlend
                                            ? productByBlend.product_item_desc
                                            : ''
                                    "
                                ></el-input>
                            </div>

                            <div class="col-lg-2" v-if="userProfile.organization_code == 'M03'">คลังจัดเก็บ</div>
                            <div class="col-lg-2" v-if="userProfile.organization_code == 'M03'">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="inventory"
                                    readonly
                                ></el-input>
                            </div>

                            <div class="col-lg-2" v-if="userProfile.organization_code == 'M03'">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="location"
                                    readonly
                                ></el-input>
                            </div>

                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">ผลผลิตที่ได้</div>
                            <div class="col-lg-4">
                                <el-input
                                    placeholder="0000000"
                                    size="small"
                                    class="w-100"
                                    disabled
                                    :value="totalOptQuantity"
                                >
                                    <template slot="append">{{
                                        totalOptQuantityUom
                                    }}</template>
                                </el-input>
                            </div>
                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'">คลังจัดเก็บ</div>
                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="inventory"
                                    disabled
                                    readonly
                                ></el-input>
                            </div>

                            <div class="col-lg-2" v-if="userProfile.organization_code != 'M03'">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="location"
                                    readonly
                                    disabled
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">

                            
                        </div>
                        <div class="row m-2">
                            <!-- <div class="col-lg-2">ผลผลิตที่ได้</div>
                            <div class="col-lg-4">
                                <el-input
                                    placeholder="0000000"
                                    size="small"
                                    class="w-100"
                                    :value="totalOptQuantity"
                                >
                                    <template slot="append">{{
                                        totalOptQuantityUom
                                    }}</template>
                                </el-input>
                            </div> -->
                            <!-- <div class="col-lg-2">คลังจัดเก็บ</div>
                            <div class="col-lg-4">
                                <el-input
                                    size="small"
                                    class="w-100"
                                    :value="inventory"
                                    readonly
                                ></el-input>
                            </div> -->
                        </div>
                        <div class="row m-2">
                        <div class="col-lg-6"></div>
                            <div class="col-lg-6 text-right">
                                <button
                                    :class="transBtn.search.class"
                                    @click.prevent="fitterFormula()"
                                    :disabled="disabledForm"
                                >
                                    <i
                                        :class="
                                            transBtn.search.icon + ' btn-lg'
                                        "
                                    ></i>
                                    <strong>ดึงข้อมูลจากสูตร</strong>
                                </button>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-6"></div>
                            <!-- <div class="col-lg-6 text-right">
                                <button
                                    :class="transBtn.search.class"
                                    @click.prevent="fitterFormula()"
                                >
                                    <i
                                        :class="
                                            transBtn.search.icon + ' btn-lg'
                                        "
                                    ></i>
                                    <strong>{{ transBtn.search.text }}</strong>
                                </button>
                            </div> -->
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
                        <!-- <div v-if="action == 'show'" >
                            <TableHeader
                                :headers="mesReviewIssueHeaders"
                                :trans-btn="transBtn"
                                @click="onClickChild"
                            >
                            </TableHeader>
                        </div> -->
                        <div
                            v-if="
                                formulas.length > 0 && action === 'show-lines'
                            "
                        >
                            <!-- <TableRow
                            v-if="classClassificationCode == '01'"
                                :formulas="formulas"
                                :opt-quantity="totalOptQuantity"
                                :action="action"
                                @input="onClickChild"
                            ></TableRow> -->
                            <TableLot
                                v-if="classClassificationCode == '01'"
                                    :formulas="formulas"
                                    :opt-quantity="totalOptQuantity"
                                    :action="action"
                                    :p-disabled-input="showFreezeMsg"
                                    @input="onClickChild"
                                ></TableLot>
                            <TableCasingFlavor
                                v-if="classClassificationCode == '02'"
                                :formulas="formulas"
                                :opt-quantity="totalOptQuantity"
                                :action="action"
                                :p-disabled-input="showFreezeMsg"
                                @input="onClickChild">
                            </TableCasingFlavor>
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
                                        :headers="mesReviewIssueHeaders"
                                        :program-code="programCode"
                                        :trans-btn="transBtn"
                                        :trans-date="transDate"
                                        :class-classification-code="classClassificationCode"
                                        :url="url"
                                        :sysDate="date_issue"
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
import TableLot from "./TableLot";

export default {
    components: {
        TableRow,
        TableHeader,
        Search,
        TableCasingFlavor,
        TableAll,
        TableLot
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
        "program-code",
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
                job_no:'',
                delRaw: [],
            },
            can: {
                submit: false,
            },

            form_lines: [],

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
                form: false,

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
            batch_id: "",
            tranQty: "",
            reportDate: "",
            headerStatus:"",
            issueAll : this.programCode === 'PMP0049',
            urlTestOpt: 'http://web-service.test/pm/ajax/get-opt-from-blend-no?blend_no=98&date=07/06/2564',
            wipIssueHeader: "",
            canSave: false,
            testUrl: 'http://web-service-report.test/pm/ajax/get-formulas?request_line=1&issue_header_id=1157&total_opt_quantity=20000&program_code=PMP0007'
        };
    },
    mounted() {
        this.findItemClassification();
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
            this.mesReviewIssueV = [];
            this.blends = [];
            this.job_type = "";
            axios
                .get(
                    this.url.urlGetMesReviewIssuesV +
                        "?date=" +
                        this.date +
                        "&set_header=" +
                        this.setHeader +
                        "&classification_code="+
                        this.classClassificationCode+
                        "&program_code="+
                        this.programCode+
                        "&issue_header_id="+
                        this.form_header.issue_header_id
                )
                .then(res => {
                    let result = res.data.result;
                    if (result.status != "S") {
                        if(this.setHeader !== true){
                            swal({
                                title: "Error !",
                                text: result.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                        this.loading.blend_no = false;
                    } else {
                        let mesReviewIssueV     = res.data.mesReviewIssueV;
                        let blends              = res.data.blends;
                        let job_type            = res.data.jobType;
                        this.mesReviewIssueV    = mesReviewIssueV;
                        this.blends             = blends;
                        this.job_type           = job_type;

                        this.loading.blend_no = false;
                        if (this.blendSelected && this.setHeader !== true) {
                            this.findBlend();

                        }
                    }
                })
                .catch(err => {
                    let result = err.data.result;
                    this.loading.blend_no = false;
                });
        },

        async getOpt() {
            this.loading.opt = true;
            this.loading.oprn = true;
            this.opts = [];
            this.optSelected = "";
            this.opt = "";
            this.groupByOpts = [];
            this.oprnSeletected = "";
            this.oprns = [];
            this.oprnDescription = "";

            this.items = "";
            this.itemSelected = "";
            this.formulas = [];
            let batch = this.userProfile.organization_code == 'MP2' ? this.blendSelected : "";
            axios
                .get(
                    this.url.urlOpt +
                        "?blend_no=" +
                        this.blendSelected +
                        "&date=" +
                        this.date+
                        "&classification_code="+
                        this.classClassificationCode+
                        "&program_code="+
                        this.programCode + 
                        '&batch_id='+
                        this.batch_id
                    
                )
                .then(res => {
                    let opts = res.data.opts;
                    let productByBlend = res.data.productByBlend;
                    let groupByOpts = res.data.groupByOpts;

                    this.groupByOpts = groupByOpts;
                    this.opts = opts;
                    this.productByBlend = productByBlend;
                    this.loading.opt = false;
                    if(this.wipIssueHeader){
                        this.optSelected =  this.wipIssueHeader.all_opt == true ? "" :  this.wipIssueHeader.opt;
                    }

                })
                .then(() => {
                    if (this.optSelected) {
                        this.optQuantity = this.opts;
                    }
                    if (this.setHeader !== true) {
                        ("find blend by opt");
                        if(this.userProfile.organization_code == 'M03'){
                            let blend = this.mesReviewIssueV.find(item => {
                                return item.item_number === this.blendSelected;
                            });
                            this.blend = blend;
                        }else {
                            let blend = this.mesReviewIssueV.find(item => {
                                    return item.batch_id === this.blendSelected;
                                });
                            this.blend = blend;
                        }
                    }
                })
                .then(() => {
                    this.getOprn();
                    this.loading.opt = false;
                    this.loading.oprn = false;
                });
        },
        async getOprn() {
            axios
                .get(
                    this.url.urlGetOprnByItem +
                        "?item_id=" +
                        this.blend.inventory_item_id+
                        "&program_code="+
                        this.programCode
                )
                .then(res => {
                    let oprns = res.data.listOprnByItems;
                    let defaultOprn = res.data.defaultOprn;
                    this.oprns = oprns;
                    this.defaultOprn = defaultOprn;
                    this.loading.oprn = false;
                })
                .then(() => {
                    this.oprnSeletected = this.defaultOprn.oprn_no;
                    this.oprnDescription = this.defaultOprn.oprn_desc;
                    this.loading.oprn = false;
                });
        },
        findOprn() {
            let oprn = this.oprns.find(item => {
                return item.oprn_no === this.oprnSeletected;
            });

            this.oprn = oprn;

            this.oprnDescription = this.oprn.oprn_desc;
        },

        findBlend() {
            if(this.userProfile.organization_code == 'MP2'){
                let blend = this.mesReviewIssueV.find(item => {
                    return item.batch_id === this.blendSelected;
                });
                return this.blend = blend;
            }

            if(this.userProfile.organization_code != 'M03'){
                let blend = this.mesReviewIssueV.find(item => {
                    return item.blend_no === this.blendSelected;
                });
                this.blend = blend;

           }else{
                let blend =this.mesReviewIssueV.find(item => {
                    return item.batch_id === this.blendSelected;
                });
                this.blend = blend;
            }
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
            let vm = this;
            swal({
                    title: "คุณแน่ใจ?",
                    text: "คุณต้องการดึงข้อมูลมาจากสูตรใหม่ใช่ไหม ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                },                    
            function (isConfirm) {
                if(isConfirm){
                    vm.postTYpe = vm.postTYpe == 'create' ? 'create' : 'NewData';
                    vm.action = "show-lines";
                    vm.validateFormHeader();
                    vm.updateFormHeader();
                    vm.getFormula();
                    swal.close();
                }
            });  
        },

        validateFormHeader() {
            return;
        },
        async updateFormHeader() {
            this.form_header.date = this.date;
            this.form_header.blend_no = this.blendSelected;
            this.form_header.opt = this.optSelected;
            this.form_header.oprn = this.oprnSeletected;
            this.form_header.item_id = this.blend.item_number;
            this.form_header.issue_date = this.issue_date;
            this.form_header.opts = this.optSelected ? [] : this.opts;
            this.form_header.job_no = this.blend ? this.blend.batch_no : '';
        },

        updateFormLine() {
            this.form_header.date = this.date;
            this.form_header.blend_no = this.blendSelected;
            this.form_header.opt_no = this.optSelected;
            this.form_header.oprn_no = this.oprnSeletected;
            this.form_header.item_id = this.blend.inventory_item_id;
        },

        getFormula() {
            // console.log('xxxxx =');
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
                    this.blend.product_item_number+
                    "&blend_batch_no="+
                    this.blend.batch_no +
                    "&program_code="+
                    this.programCode;
                axios
                    .get(this.url.urlFormulas + this.request_form)
                    // .get(this.testUrl)
                    .then(res => {
                        let formulas = res.data.formulas;
                        this.formulas = formulas;

                        this.form.table_line = false;
                    });
            }
        },

        getLines() {
            this.formulas = [];
            this.action = "show-lines";
            axios
                .get(
                    this.url.urlFormulas +
                        "?request_line=1" +
                        "&issue_header_id=" +
                        this.form_header.issue_header_id +
                        "&total_opt_quantity=" +
                        this.totalOptQuantityFromHeader+
                        "&program_code="+
                        this.programCode
                )
                .then(res => {
                    let formulas = res.data.formulas;
                    this.formulas = formulas;
                    this.updateFormHeader();
                    this.form_header.lines = this.formulas;

                }).then(() => {

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
            if (this.validateForm() === false) {
                swal({
                    title: "Validation !",
                    text: "โปรดระบุข้อมูลให้ครับ",
                    type: "error",
                    showConfirmButton: true
                });
            } else {
                this.loading.form = true;
                this.form_header.lines                      = this.formulas;
                this.form_header.item_classification_code   = this.classClassificationCode;
                this.form_header.total_opt_quantity         = this.totalOptQuantity;
                this.form_header.program_code               = this.programCode;
                this.form_header.job_no                     = this.blend ? this.blend.batch_no : '';
                this.form_header.postTYpe                   = this.postTYpe;
                this.updateFormHeader();
                if (this.postTYpe == "update" || this.postTYpe == "NewData") {
                    console.log('Update')
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
                            this.loading.form   = false;
                            let result          = res.data.result;
                            let data            = res.data;
                            if (result.status === "S") {
                                swal({
                                    title: "Success !",
                                    text: result.msg,
                                    type: "success",
                                    showConfirmButton: true
                                });
                            } else {
                                this.loading.form = false;
                                swal({
                                    title: "Error !",
                                    text: result.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                            }

                            let textId = 'onClickButtonShowDetails'+data.header.issue_header_id;
                            $("#"+textId).click()

                            this.wipIssueHeader = data.header;
                            this.header_number  = data.header.request_number;
                            this.headerStatus   = data.header.issue_status.description;
                            this.can.submit     = true;
                        })
                        .catch(err => {
                            this.loading.form = false;
                            // console.log(err);
                            swal({
                                title: "Error !",
                                text:  'error xxx',
                                type: "error",
                                showConfirmButton: true
                            });
                            // console.log(err);
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


                                if(this.programCode == 'PMP0007'){
                                    // console.log('PMP0007');
                                    this.formulas = [];
                                    // this.getLines();
                                    setTimeout(() => { 
                                        // console.log("World!"); 
                                        this.formulas =   data.lines;
                                    }, 2000);
                                }

                            } else {
                                swal({
                                    title: "Error !",
                                    text: result.msg,
                                    type: "error",
                                    showConfirmButton: true
                                });

                                setTimeout(() => { 
                                    this.loading.form = false;
                                }, 3000);
                                // console.log(result.msg);
                            }
                            this.wipIssueHeader = data.header;
                            this.headerStatus  = data.header.issue_status.description;
                            this.form_header.issue_header_id =  data.header.issue_header_id;
                            this.header_number = data.header.request_number;
                            this.postTYpe = 'update';
                        }).
                        catch(()=> {
                            // console.log('finally');
                            this.loading.form =false;
                        })
                        
                        .finally(()=> {
                        // console.log('finally');
                        this.loading.form =false;
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
            this.form_header.job_no ="",
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

            const  groupB =  _.groupBy(this.formulas, "group_line");

            this.formulas.forEach(formula => {
                let quantity_summary = parseFloat(formula.input_quantity_summary );
                let onhand  = 0;
                if (formula.onhand_quantity != '') {
                    let strOnhand = formula.onhand_quantity.toString();
                    onhand  = parseFloat(strOnhand.replace(',', ""));
                }

                if(this.classClassificationCode == "02"){
                    if(groupB[formula.group_line].length > 1){
                        onhand  = groupB[formula.group_line].reduce((acc, item) =>
                                acc + parseFloat(formula.onhand_quantity.toString().replace(',', "")), 0)

                    }
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


            if(interfaced == true ){
                return swal({
                        title: "Error !",
                        text: 'ไม่สามารถตัดใช้ได้',
                        type: "error",
                        showConfirmButton: true
                    });
            }

            if(allow == false){
                let msg = "รหัสวัตถุดิบ"+ items + "<br> มีจำนวน onhand ไม่พอ ไม่สามารถตัดใช้วัตถุดิบได้";
                return swal({
                        html: true,
                        title: "Error !",
                        padding: '2em',
                        text:  "<div>"+msg,
                        type: "error",
                        showConfirmButton: true
                    });
            }


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
                    }

                    this.wipIssueHeader = data.header;
                    this.header_number  = data.header.request_number;
                    this.headerStatus   = data.header.issue_status.description;

                    this.form_header.issue_header_id    = data.header.issue_header_id;
                    this.totalOptQuantityFromHeader     = data.total_qty;
                    this.formulas = [];

                })
                .then(()=> {
                    if(this.wipIssueHeader.issue_status == 1){
                        this.can.submit = true;
                    }
                    this.getLines();
                    this.loading.form = false;
                })
                .catch(()=> {
                    this.loading.form = false;
                });
        },

        onClickChild(value, delRaws= []) {
            if (value.key == "set_header") {
                this.form_header.issue_header_id = value.issue_header_id;
                this.selectHeader(value.header);
            } else {
                this.form_header.lines = value;
                this.form_header.delRaw = delRaws;
            }
        },

        async selectHeader(header) {
            this.formulas = [];

            await this.showDate(header.complete_date);

            this.wipIssueHeader = header;
            this.headerStatus = header.status;

            this.postTYpe = "update";
            this.setHeader = true;

            this.header_number = header.request_number;
            this.blendSelected = this.userProfile.organization_code == 'M03'
                                ? header.item_number
                                : header.batch_id;

            this.form_header.issue_header_id    = header.issue_header_id;
            this.totalOptQuantityFromHeader     = header.total_qty;


            this.optSelected = header.all_opt == true
                                ? ""
                                : header.opt;
            this.blend = header.blend;

            this.can.submit = false;
            if (this.wipIssueHeader.issue_status == 1) { // 'ยังไม่ตัดใช้'
                this.can.submit = true;
            }

            await this.getMesReviewIssuesV();
            await this.getOpt();
            await this.getLines();
        },

        async showDate(date) {
            var date1 = await helperDate.parseToDateTh(date, 'DD/MM/YYYY');
            this.date = moment(date1).format(this.transDate["js-format"]);
            this.reportDate = moment(date).format("YYYY-MM-DD");
            this.date_issue = this.date;
            // console.log("show date");
            // console.log(date);

        },

        getDate(date) {

            this.reportDate = moment(date).add(-543, "years").format("YYYY-MM-DD");
            // console.log("get date");
            // console.log(date);
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
            this.wipIssueHeader = "";
            this.header_number = "";
            this.setHeader = false;
            // console.log('clear ');
            this.date = moment(date).format(this.transDate["js-format"]);
            this.getMesReviewIssuesV();
            this.form_header = [];
        },

        issueDate(date) {
            this.issue_date = moment(date).format(this.transDate["js-format"]);
        },

        modalOpen() {
            // this.loading.table_header = true;
            // this.mesReviewIssueHeader = [];
            // axios.get(this.url.getHeaders+'?item_classification_code='+this.classClassificationCode).then(res => {
            //     let mesReviewIssueHeaders = res.data.mesReviewIssueHeaders;
            //     this.mesReviewIssueHeaders = mesReviewIssueHeaders;
            //     this.loading.table_header = false;
            // });
        },

        cancel(issue_header_id) {
            // console.log(issue_header_id);
            this.loading.form = true;
            this.form_header.issue_header_id = issue_header_id;
            axios
                .post(this.url.cancelData, {
                    ...this.form_header
                })
                .then(res => {
                    this.loading.form = false;
                    let data = res.data;
                    // console.log(res);
                    let result = res.data.result;
                    if (result.status === "S") {
                        swal({
                            title: "Success !",
                            text: result.msg,
                            type: "success",
                            showConfirmButton: true
                        });
                    } else {
                        swal({
                            title: "Cancel Error !",
                            text: result.msg,
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
            // console.log(this.userProfile);
            // window.location.href = ;
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

        assignBatch(id){
            // console.log(id);
            // console.log('xxxx');
        }
    },

    computed: {
        totalOptQuantity: function() {

            if(this.userProfile.organization_code == "MP2"){
                if(this.blend){
                    return this.blend.transaction_quantity;
                }else{
                    return 0;
                }
            }

            if (this.totalOptQuantityFromHeader) {
                return parseFloat(this.totalOptQuantityFromHeader).toFixed(2).toLocaleString();
            }

            if (this.optSelected) {
                return parseFloat(this.opt.transaction_quantity).toFixed(2).toLocaleString();
            } else if (this.opts) {
                let sum = 0;
                $.each(this.groupByOpts, function(key, value){
                    sum += parseFloat(value[0].transaction_quantity);
                });
                return sum.toFixed(2).toLocaleString();
            } else {
                return 0.0;
            }

        },

        totalOptQuantityUom: function() {
            if(this.productByBlend){
                return this.productByBlend.product_unit_of_measure
            }

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
            return 0;
        },

        location: function(){
                if (this.formulas.length === 0) {
                return "";
            } else {
                return this.formulas[0].from_location_code;
            }
        },

        orderedFormulas: function() {
            if (this.formulas.length === 0) {
                return [];
            } else {
                return _.orderBy(this.formulas, "used_leaf_formula");
            }

        },
        canNotSubmit(){


        },

        lotSum(groupByFormula) {
            return groupByFormula.reduce((acc, item) => acc+ parseFloat(item.input_quantity_summary), 0)
        },


        disabledSubmit(){

            if(this.wipIssueHeader.status == 'ยังไม่ตัดใช้'){
                return false;
            }

            if(this.wipIssueHeader.issue_status){
                if(this.wipIssueHeader.issue_status.meaning == 1){
                    return false;
                }
            }
            // if(!!this.formulas){

            //     // let blend = this.formulas.find(item => {
            //     //     return item.batch_id === this.blendSelected;
            //     // });
            // }

            return true;
            if(this.wipIssueHeader.issue_status.meaning == 3){
                return  true;
            }
            if(this.wipIssueHeader.issue_status.meaning == 2){
                return  true;
            }

            if(this.formulas.length > 0){
                return false;
            }else{
                return true;
            }

            return false;

        },

        disabledSave(){
            if (this.showFreezeMsg) {
                return true;
            }
            if(this.formulas.length <= 0){
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

            return false;

        },

        disabledCancel(){
            if (this.showFreezeMsg) {
                return true;
            }
            if(this.headerStatus == 'ยกเลิก'){
                return true;
            }

            if(this.headerStatus == 'ยังไม่ตัดใช้'){
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

        showFreezeMsg() {
            if (this.blend != '' && this.blend != null && this.blend != undefined) {
                if(this.blend.freeze_flag_date =='' || this.blend.freeze_flag_date==null){
                    return false;
                }

                let tranDate        = moment(this.blend.transaction_date).format("YYYYMMDD");
                let freezeFlagDate  = moment(this.blend.freeze_flag_date).format("YYYYMMDD");
                // console.log(freezeFlagDate);
                // console.log(tranDate);
                // console.log("check freeze");
                if(tranDate < freezeFlagDate){
                    return  this.blend.freeze_msg
                }

            }
            return false;
        }


    },

};
</script>
