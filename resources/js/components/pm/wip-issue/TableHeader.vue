<template>
    <div class="p-2">
    <div class="shadow-sm tw-bg-white p-2" >
        <div class="row mb-2">
            <div class="col-md-1">วันที่</div>
            <div class="col-md-2">
                <datepicker-th
                    style="width: 100%; border-radius:3px;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="input_date"
                    id="input_date"
                    :value="form.start_date"
                    v-model="form.start_date"
                    :format="transDate['js-format']"
                    @dateWasSelected="startDate"

                />
            </div>
            <div class="col-md-1">ถึง</div>
            <div class="col-md-2">
                <datepicker-th
                    style="width: 100%; border-radius:3px;"
                    class="form-control md:tw-mb-0 tw-mb-2"
                    name="input_date"
                    id="input_date"
                    v-model="form.end_date"
                    :value="form.end_date"
                    :format="transDate['js-format']"
                    @dateWasSelected="endDate"
                />
            </div>
            <div class="col-md-2 text-right">สินค้าที่จะผลิต</div>
            <div class="col-md-2">
                <el-select
                    v-model="form.product"
                    filterable
                    placeholder="สินค้าที่จะผลิต"
                    class="w-100"
                    v-loading="false"
                    clearable
                    :popper-append-to-body="false"
                    @change="search"
                >
                    <el-option
                        v-for="(product, index) in products"
                        :key="index"
                        :label="index"
                        :value="product[0].item_number"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1">เลขที่คำสั่งผลิต</div>
            <div class="col-md-2">
                <el-select
                    v-model="form.job"
                    filterable
                    placeholder="เลขที่คำสั่งผลิต"
                    class="w-100"
                    v-loading="false"
                    :popper-append-to-body="false"
                    @change="search"
                    clearable
                >
                    <el-option
                        v-for="(blend, index) in blends"
                        :key="index"
                        :label="index"
                        :value="index"
                    >
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-1">เลขที่ตัดใช้</div>
            <div class="col-md-2">
                <el-select
                    v-model="form.request_number"
                    filterable
                    placeholder="เลขที่ตัดใช้"
                    class="w-100"
                    v-loading="false"
                    :popper-append-to-body="false"
                    clearable
                >
                    <el-option
                        v-for="(header, index) in dHeaders"
                        :key="index"
                        :label="header.request_number"
                        :value="header.request_number"
                    >
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-2 text-right">สถานะ</div>
            <div class="col-md-2">
                <el-select
                    v-model="form.status"
                    filterable
                    placeholder="สถานะ"
                    class="w-100"
                    v-loading="false"
                    :popper-append-to-body="false"
                    @change="search"
                    clearable
                >
                    <el-option
                        v-for="(status, index) in statuses"
                        :key="index"
                        :label="index"
                        :value="status[0].issue_status"
                    >
                    </el-option>
                </el-select>
            </div>
            <button class="text-right"
                :class="transBtn.search.class"
                @click="fitterHeaders()"
            >
                <i
                    :class="
                        transBtn.search.icon + ' btn-lg'
                    "
                ></i>

                <strong>{{ transBtn.search.text }}</strong>
            </button>
        </div>

    </div>
        <table class="table table-hover" v-loading="loading.table">
            <thead>
                <tr>
                    <th><small>สถานะ</small></th>
                    <th><small>เลขที่ตัดใช้</small></th>
                    <th><small>เลขที่คำสั่งการผลิต</small></th>
                    <th v-if="programCode == 'PMP0051'"><small>สินค้าที่จะผลิต</small></th>
                    <th><small>วันที่ตัดใช้</small></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="header in uHeaders" :key="header.issue_header_id">
                    <td>
                        <small
                            ><span :class="header.badge_status.class">
                                {{ header.badge_status.description }}
                            </span></small
                        >
                    </td>
                    <td>
                        <small>{{ header.request_number }}</small>
                    </td>
                    <td>
                        <small>{{ header.batch_no }}</small>
                    </td>
                    <td v-if="programCode == 'PMP0051'">
                        <small>{{ header.blend.item_description }}</small>
                    </td>
                    <td>
                        <small> {{ header.show_date_th }}</small>
                    </td>
                    <td>
                        <button
                            :class="transBtn.edit.class + ' btn-sm'"
                            data-dismiss="modal"
                            aria-hidden="true"
                            @click="onClickButtonShowDetails(header)"
                            :id="'onClickButtonShowDetails' + header.issue_header_id"
                        >
                            <i :class="transBtn.edit.icon"></i> รายละเอียด
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ["headers", "trans-btn", "trans-date", "url", 'class-classification-code', "program-code", 'sys-date'],
    data() {
        return {
            return_data: {
                key: "set_header",
                header: "",
                issue_header_id: "",
                uom: "",
            },
            form:{
                start_date:"",
                end_date: "",
                batch_no:"",
                status:"",
                product:"",
                blend:"",
                request_number:"",
                job:"",
            },
            loading:{
                table:false,
                list:false,
            },
            start_date:"",
            end_date:"",
            key_type:"",
            statuses:[],
            uHeaders:this.headers,
            dHeaders:this.headers,
            blends:[],
            products:[],


        };
    },
    mounted() {
        // console.log('xxxxxxxx');
        this.getHeaderFromMonth();
    },
    methods: {
        updateFormLines(key, value) {
            console.log(key, value);
        },
        onClickButtonShowDetails(header) {
            axios
                .get('/pm/ajax/find-header/'+header.issue_header_id
                )
                .then(res => {
                    let header = res.data.header;
                    this.return_data.header = header;
                    this.return_data.issue_header_id = header.issue_header_id;
                    this.$emit("click", this.return_data);
                })
                .catch(err => {
                    this.loading.table = false;
                });

        },
        startDate(value){
            this.form.start_date = value;
            this.search();
        },
        endDate(value){
            this.form.end_date = value;
            this.search();
        },
        fitterHeaders(){
            const headers = this.dHeaders.filter((item)=> {
                 return item.request_number == this.form.request_number;
            })

            this.uHeaders = headers;
        },
        search(){
            this.loading.table = true;
            this.start_date = moment(this.form.start_date).add(-543, "years").format(
                    this.transDate["js-format"]
                );
            this.end_date = moment(this.form.end_date).add(-543, "years").format(
                    this.transDate["js-format"]
                );

            axios
                .get(
                    this.url.searchHeader+
                    "?start_date="+
                    this.start_date+
                    "&end_date="+
                    this.end_date+
                    "&batch_no="+
                    this.form.batch_no+
                    '&item_classification_code='+
                    this.classClassificationCode+
                    '&program_code='+
                    this.programCode+
                    '&job='+
                    this.form.job+
                    '&status='+
                    this.form.status+
                    '&product='+
                    this.form.product
                )
                .then(res => {
                    console.log(res.data.header);
                    this.uHeaders = res.data.mesReviewIssueHeaders;
                    this.dHeaders = res.data.mesReviewIssueHeaders;
                    this.products = _.groupBy(this.uHeaders, "blend.item_description");
                    this.blends   = _.groupBy(this.uHeaders, "blend.batch_no");
                    this.statuses = _.groupBy(this.uHeaders, "status");
                    this.loading.table = false;
                })
                .catch(err => {
                    this.loading.table = false;
                });
        },

        fitterProduct(item_number){
            const headers = this.dHeaders.filter((item)=> {
                 return item.item_number == item_number;
            })

            this.uHeaders = headers;
        },
        keyType(type){
            console.log( 'xxx');
        },
        getHeaderFromMonth(){
            let startDate = this.start_date = moment(this.sysDate).add(543).format(
                    this.transDate["js-format"]
                );
            let endDate = this.start_date = moment(this.sysDate).add(543).format(
                    this.transDate["js-format"]
                );

            this.form.start_date = moment(this.sysDate).format(
                            this.transDate["js-format"]
                        );
            axios
                .get(
                    this.url.searchHeader+
                    "?start_date="+
                    startDate+
                    "&end_date="+
                    endDate+
                    '&item_classification_code='+
                    this.classClassificationCode+
                    '&program_code='+
                    this.programCode
                )
                .then(res => {
                    console.log(res.data.header);
                    this.uHeaders = res.data.mesReviewIssueHeaders;
                    this.dHeaders = res.data.mesReviewIssueHeaders;
                    this.products = _.groupBy(this.uHeaders, "item_description");
                    this.blends = _.groupBy(this.uHeaders, "batch_no");
                    this.statuses = _.groupBy(this.uHeaders, "status");
                    this.loading.table = false;

                })
                .catch(err => {
                    this.loading.table = false;
                });

        }
    }
};
</script>
