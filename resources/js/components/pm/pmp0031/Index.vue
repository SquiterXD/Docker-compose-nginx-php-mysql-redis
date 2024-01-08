<template>
    <div class="row">
        <div class="col-lg-12" v-loading="loading.form">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="text-right">
                        <button
                            :class="transBtn.createJob.class"
                            @click.prevent="process"
                        >
                            <strong> คำนวณปริมาณการผลิต </strong>
                        </button>
                        <button
                            :class="
                                transBtn.createJob.class
                            "
                            @click.prevent="openJob"
                            :disabled="disableOpenJob"

                        >
                            <i :class="transBtn.createJob.icon"></i>
                            {{ transBtn.createJob.text }}
                        </button>
                    </div>
                    <div class="form-group">
                        <div class="row m-2">
                            <div class="col-lg-2">ปีงบประมาณ</div>
                            <div class="col-lg-2">
                                <datepicker-th
                                    placeholder="เลือกวันที่ขอเบิก"
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    pType="year"
                                    v-model="yearTh"
                                    @dateWasSelected="getYear"
                                    :format="transDate['js-year-format']"
                                />
                            </div>
                            <div class="col-lg-2">หน่วยงาน</div>
                            <div class="col-lg-2">
                                <el-input
                                    placeholder="0000000"
                                    size="small"
                                    class="w-100"
                                    :value="userProfile.department.description"
                                    readonly
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">
                                ประมาณการขายยาเส้นประจำเดือน
                            </div>
                            <div class="col-lg-2">
                                <datepicker-th
                                    placeholder="เลือกวันที่"
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="input_date"
                                    id="input_date"
                                    pType="month"
                                    v-loading="loading.month"
                                    :disabled="year == '' ? true : false"
                                    v-model="monthTh"
                                    @dateWasSelected="getMonth"
                                    format="MMMM"
                                />
                            </div>
                            <div class="col-lg-2">วันที่ผลิต</div>
                            <div class="col-lg-2">
                                <el-input
                                    :disabled="true"
                                    size="small"
                                    class="w-100"
                                    v-model="dateFirsTofMonth"
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-2">ครั้งที่</div>
                            <div class="col-lg-2">
                                <el-input
                                    :disabled="true"
                                    placeholder="0"
                                    size="small"
                                    class="w-100"
                                    v-model="version"
                                ></el-input>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-lg-12 text-right">

                            </div>
                        </div>
                    </div>
                    <div v-if="loading.table">
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
                    <TableRow
                        v-loading="loading.table"
                        v-if="productPlanLines.length > 0 & userProfile.organization_code == 'MPG'"
                        @input="onClickChild"
                        :product-plan-lines="productPlanLines">
                    </TableRow>
                    <TableRowMP2
                        v-loading="loading.table"
                        v-if="productPlanLines.length > 0 & userProfile.organization_code == 'MP2'"
                        @input="onClickChild"
                        :product-plan-lines="productPlanLines">
                    </TableRowMP2>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import TableRow from "./Table";
import TableRowMP2 from "./TableMp2";

export default {
    components: {
        TableRow,
        TableRowMP2
    },
    props: [
        "user-profile",
        "trans-date",
        "url",
        "trans-btn",
        "sys-date",
        "program-code",
        "token",
    ],
    data() {
        return {
            sysDateTh: moment(this.sysDate)
                        .add(543, "years")
                        .format(this.transDate["js-format"]),
            yearTh: moment(this.sysDate)
                        .add(543, "years")
                        .format(this.transDate["js-year-format"]),
            year: moment(this.sysDate)
                    .format(this.transDate["js-year-format"]),
            month: moment(this.sysDate)
                    .format("MM"),
            monthTh: moment(this.sysDate)
                    .format("MMMM"),
            monthThDes: moment(this.sysDate)
                    .format("MMMM"),
            dateFirsTofMonth: moment(this.sysDate)
                        .add(543, "years")
                        .format("01/MM/YYYY"),
            create_date: "",
            fortnightly: "",
            time: "",
            version: "",
            start_date: "",
            end_date: "",
            saleForecasts: "",
            saleForecast: "",
            biweekly: "",
            biweeklies: [],
            form_header: {
                program_code: this.programCode,
                version: "",
                period: "",
                source_version: "",
                attribute1: "",
                attribute2: "",
                year: "",
                lines: [],
                pMonth:"",
                pYear:"",

            },

            loading: {
                form: false,
                month: false,
                biweekly:false,
                dateFormTo:false,
                table:false,

            },
            disable:{
                form: false,
                month: true,
                biweekly:true,
                dateFormTo:false,
            },
            productPlanLines:[],
            urlTest: 'http://web-service-report.test/ir/ajax/ir-report-get-info-attribute?program_code=IRR0001',
        };
    },
    mounted() {
        this.getSaleForecast();
    },
    methods: {
        getSaleForecast() {
            // this.loading.month = true;
            this.loading.biweekly =true;
            console.log("xxx");
            axios
                .get(this.url.getSaleForecast +
                    "?year=" +
                    this.year+
                    "&month="+
                    this.month
                    )
                .then(res => {
                    let saleForecasts = res.data.salesForecasts;
                    this.saleForecasts = saleForecasts;
                    this.version = this.saleForecasts[0].version;
                    // this.loading.month = false;
                    this.loading.biweekly =false;
                    this.disable.month = false;
                    this.disable.biweekly = false;
                })
                .catch(err => {
                    // this.loading.month = false;
                    this.loading.biweekly =false;
                    this.disable.month = false;
                    this.disable.biweekly = false;
                });
        },
        // process() {

        // },
        getYear(value) {
            this.yearTh = value;
            this.year = moment(this.yearTh)
                .add(-543, "years")
                .format(this.transDate["js-year-format"]);

        },
        getMonth(value) {
            this.productPlanLines = [];
            this.monthTh = value;
            this.month = moment(this.monthTh)
                .add(-543, "years")
                .format("MM");

            this.monthThDes = moment(this.month)
                .add(-543, "years")
                .format("MMMM");



            this.form_header.pMonth = moment(this.monthTh)
                .add(-543, "years")
                .format("MMM");

            this.getSaleForecast();
            this.dateFirsTofMonth =  moment(this.monthTh)
                .add(543, "years")
                .format("01/MM/YYYY");
        },
        createDate(value) {
            this.create_date = moment(value)
                .add(-543, "years")
                .format(this.transDate["js-datatime-format"]);
        },
        startDate(value) {
            this.start_date = moment(value)
                .add(-543, "years")
                .format(this.transDate["js-datatime-format"]);
        },
        endDate(value) {
            this.end_date = moment(value)
                .add(-543, "years")
                .format(this.transDate["js-datatime-format"]);
        },
        findBiweekly() {
            let saleForecast = this.saleForecasts[this.fortnightly].find(item => {
                return item.biweekly_no == this.fortnightly;
            });

            this.saleForecast = saleForecast;
            this.version = saleForecast.version;

            this.getBiweeklies();
        },
        getBiweeklies() {
            axios
                .get(
                    this.url.getBiweeklies +
                        "?year=" +
                        this.year +
                        "&month=" +
                        this.month +
                        "&biweekly_no=" +
                        this.version +
                        "&biweekly_id=" +
                        this.saleForecast.biweekly_id
                )
                .then(res => {
                    let biweekly = res.data.biweekly;
                    this.biweekly = biweekly;
                    this.start_date = moment(biweekly.start_date)
                        .add(543, "years")
                        .format(this.transDate["js-format"]);
                    biweekly.start_date;

                    this.end_date = moment(biweekly.end_date)
                        .add(543, "years")
                        .format(this.transDate["js-format"]);
                });
        },
        async updateFormHeader() {
            this.form_header.program_code = this.programCode;
            this.form_header.version = this.version;
            this.form_header.biweekly = this.fortnightly;
            this.form_header.period = this.biweekly.period_name;
            this.form_header.source_version = this.biweekly.biweekly;
            this.form_header.attribute1 = this.biweekly.start_date;
            this.form_header.attribute2 = this.biweekly.end_date;
            this.form_header.year = this.year;
            this.form_header.month = this.month;
        },
        process() {
            this.loading.table = true;
            this.productPlanLines = [];
            this.form_header.lines = [];

            this.updateFormHeader();
            axios
                .post(
                    this.url.process,
                    {
                        ...this.form_header
                    }
                )
                .then(res => {
                    this.productPlanLines = res.data.productPlanLines;
                    this.loading.table = false;
                    this.form_header.lines = this.productPlanLines;

                })
                .catch(err => {
                    this.loading.table = false;
                });
        },

        openJob(){

                let canOpen = false;
                const unChecks = this.form_header.lines.filter(item => {
                    return item.attribute15 == null;
                })

                if(unChecks.length == this.form_header.lines.length){
                        return  swal({
                            title: "Error !",
                            text: 'กรุณาเลือกรายการที่ต้องการเปิดคำสั่งการผลิต',
                            type: "error",
                            showConfirmButton: true
                        });
                }

                // this.form_header.lines.some(item=>{
                //     return item.attribute15 =
                // })
                this.form_header.lines.forEach(item => {
                    if(item.request_number == null){
                        canOpen = true;
                    }

                });

                if(canOpen == false){
                    return  swal({
                                title: "Error !",
                                text: 'ไม่สามารถเปิดคำสั่งผลิตได้',
                                type: "error",
                                showConfirmButton: true
                            });
                }

                this.updateFormHeader();
                this.loading.table = true;
                // this.form_header.lines = [];
                this.productPlanLines = [];
                axios
                .post(
                    this.url.openJob,
                    {
                        ...this.form_header
                    }
                )
                .then(res => {
                    this.productPlanLines =[];
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
                            title: "Error !",
                            text: result.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                        console.log(result.msg);
                    }
                    this.productPlanLines = res.data.productPlanLines;
                    this.form_header.lines  = res.data.productPlanLines;
                    this.loading.table = false;
                }).catch(err => {
                    this.loading.table = false;
                    console.log(err);
                    console.log('log error');
                    swal({
                        title: "Error !",
                        text: 'Error',
                        type: "error",
                        showConfirmButton: true
                    });
                    // this.productPlanLines = err.data.productPlanLines;
                    // this.form_header.lines  = err.data.productPlanLines;
                });
        },
        onClickChild(value) {
            this.form_header.lines = value;
            console.log(value);
        },
    },

    computed:{
        disableOpenJob(){
            if (this.productPlanLines.length == 0) {
                return true
            }

            // this.productPlanLines.forEach(item => {
            //     if(item.request_number != ""){
            //         return true;
            //     }else{
            //         return false;
            //     }
            // });

        }
    },
};
</script>
