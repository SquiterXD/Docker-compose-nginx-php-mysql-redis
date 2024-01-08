<template>
    <div>
        <!-- {!! Form::open(['route' =>
                                        ['ir.settings.report-info.store',
                                        'program' => $program->program_code],
                                        'class' => 'form-horizontal']) !!} -->
                                                    <!-- @submit="checkForm" -->
        <form
            @submit="checkForm"
            :action="methodUrl === 'create' ?url.storeInfo :url.storeInfo+'/'+info.report_info_id"
            method="POST"
            >
            <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="m-b-md">
                <div>Create Report Infomation</div>
                <div>
                    <small>สร้างข้อมูลรายละเอียดของรายงานใหม่</small>
                </div>
                <span id="progress_modal" class="pull-right hide"> </span>
            </h3>
            <hr class="m-b-xs" />
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Seq
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>ลำดับที่</small>
                                </div>
                            </label>
                            <input
                                type="text"
                                name="seq"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.seq"
                            />
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Attribute Name
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>ชื่อแอตทริบิวต์</small>
                                </div>
                            </label>
                            <input
                                name="attribute_name"
                                type="text"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.attributeName"
                            />
                        </div>
                    </div>

                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Form Type
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>ประเภทข้อมูล</small>
                                </div>
                            </label>
                            <select class="form-control" v-model="form.formType" name="form_type">
                                <option
                                    v-for="(listFormType, index) in listFormTypes"
                                    :value="index"
                                    :key="index"
                                    >{{ listFormType }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row m-t-sm" v-if="form.formType === 'select'">
                        <div class="col-sm-12">
                            <div>
                                <label>
                                    <div>
                                        View or table
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div>
                                        <small></small>
                                    </div>
                                </label>
                            </div>
                            <div id="div_txt_form_value_create">
                                <textarea
                                    autocomplet="off"
                                    class="form-control"
                                    v-model="form.viewOrTable"
                                    name="view_or_table"
                                >

                                </textarea>

                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div>
                                <label>
                                    <div>
                                        Field value
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div>
                                        <small></small>
                                    </div>
                                </label>
                            </div>
                            <div id="div_txt_form_value_create">
                                <input
                                    name="field_value"
                                    type="text"
                                    autocomplet="off"
                                    class="form-control"
                                    v-model="form.fieldValue"
                                />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div>
                                <label>
                                    <div>
                                        Field description
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div>
                                        <small></small>
                                    </div>
                                </label>
                            </div>
                            <div id="div_txt_form_value_create">
                                <input
                                    type="text"
                                    autocomplet="off"
                                    class="form-control"
                                    name="field_description"
                                    v-model="form.fieldDescription"
                                />
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-6">
                            <div>
                                <label>
                                    <div>
                                        Group BY
                                    </div>
                                    <div>
                                        <small></small>
                                    </div>
                                </label>
                            </div>
                            <div id="div_txt_form_value_create">
                                <input
                                    type="text"
                                    autocomplet="off"
                                    class="form-control"
                                    name="group_by"
                                    v-model="form.groupBy"
                                />
                            </div>
                        </div> -->
                        <!-- <div class="col-sm-6">
                            <div>
                                <label>
                                    <div>
                                        Order BY
                                        <span class="text-danger">*</span>
                                    </div>
                                    <div>
                                        <small></small>
                                    </div>
                                </label>
                            </div>
                            <div class="form-inline">
                                <input
                                    type="text"
                                    autocomplet="off"
                                    class="form-control col-sm-7 mr-2"
                                    v-model="form.orderBy"
                                    name="order_by"
                                />
                                <select class="form-control col-sm-4" v-model="form.orderByType" name="order_by_type">
                                    <option
                                        v-for="orderByType in orderByTypes"
                                        :value="orderByType"
                                        :key="orderByType"
                                        >{{ orderByType }}
                                    </option>
                                </select>
                            </div>
                        </div> -->
                    </div>
                    <div class="row m-t-sm" v-if="form.formType === 'date'">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Date picker Type
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>ประเภทข้อมูล date picker</small>
                                </div>
                            </label>
                            <select class="form-control" v-model="form.dateTypeSelected" name="date_type">
                                <option
                                    v-for="dateType in dateTypes"
                                    :value="dateType"
                                    :key="dateType"
                                    >{{ dateType }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <div>
                                <label>
                                    <div>
                                        Default Value
                                    </div>
                                    <div>
                                        <small>ข้อมูล</small>
                                    </div>
                                </label>
                            </div>
                            <div id="div_txt_form_value_create">
                                <input
                                    name="default_value"
                                    type="text"
                                    autocomplet="off"
                                    class="form-control"
                                    v-model="form.defaultValue"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>Display</div>
                                <div>
                                    <small>แสดง</small>
                                </div>
                            </label>
                            <input
                                name="display_value"
                                type="text"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.displayValue"
                            />
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>Purpose</div>
                                <div>
                                    <small>จุดประสงค์</small>
                                </div>
                            </label>
                            <input
                                name="purpose"
                                type="text"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.purpose"
                            />
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <label>
                                    required (บังคับกรอก)
                                    <span class="text-danger">*</span>
                                    <input
                                        type="checkbox"
                                        id="required"
                                        name="required"
                                        v-model="form.required"
                                    />
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row m-t-sm">
                        <p v-if="errors.length > 0">
                            <!-- <p>Please correct the following error(s):</p> -->
                            <ul>
                                <li v-for="(error, index) in errors" :key="index">
                                    {{ error }}
                                </li>
                            </ul>
                        </p>
                    </div>
                </div>
                <input
                    type="hidden"
                    name="program_code"
                    v-model="form.program_code"
                />
            </div>
            <input type="hidden" name="_token" :value="csrf">
            <div class="row clearfix text-right">
                <div class="col-sm-12">
                    <button
                        id="btn_create"
                        class="btn btn-sm btn-primary"
                        type="submit"
                    >
                        save
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-white"
                        data-dismiss="modal"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </form>
        <!-- {!! Form::close()!!} -->
    </div>
</template>

<script>
export default {
    // name: "settings-report-info",
    props: ["program", "infos", "list-form-types", "info", "url", "method-url", "csrf"],
    data() {
        return {
            defaultListFormType: "",
            dateTypes:{
                year: "Year",
                month:"Month",
                date: "Date"
            },
            orderByTypes:{
                asc: "ASC",
                desc:"DESC",
            },
            errors: [],
            form:{
                seq:                this.info.seq
                                        ? this.info.seq
                                        : "",
                attributeName:      this.info.attribute_name
                                        ? this.info.attribute_name
                                        : "",
                formType:           this.info
                                        ? this.info.form_type
                                        :"",
                displayValue:       this.info
                                        ? this.info.display_value
                                        :"",
                purpose:            this.info
                                        ? this.info.purpose
                                        :"",
                defaultValue:       this.info
                                        ? this.info.default_value
                                        :"",
                input: "",
                required:           this.info
                                        ? this.info.required
                                        :"",
                dateTypeSelected:   this.info
                                        ? this.info.date_ty
                                        :"",
                viewOrTable:        this.info
                                        ? this.info.view_or_table
                                        :"",
                fieldValue:         this.info
                                        ? this.info.field_value
                                        :"",
                fieldDescription:   this.info
                                        ? this.info.field_description
                                        :"",
                groupBy:            this.info
                                        ? this.info.group_by
                                        :"",
                orderBy:            this.info
                                        ? this.info.order_by
                                        :"",
                orderByType:        this.info
                                        ? this.info.order_by_type
                                        :"",
                program_code:       this.program.program_code,
            }


        };
    },

    components: {},
    mounted(){
         
    },
    methods: {
        modalOpen() {
             
            // this.loading.table_header = true;
            // this.mesReviewIssueHeader = [];
            // axios.get(this.url.getHeaders+'?item_classification_code='+this.classClassificationCode).then(res => {
            //     let mesReviewIssueHeaders = res.data.mesReviewIssueHeaders;
            //     this.mesReviewIssueHeaders = mesReviewIssueHeaders;
            //     this.loading.table_header = false;
            // });
        },
        checkForm: function (e) {
            this.errors = [];
            if (this.form.seq) {
                return true;
            }

            if (!this.form.seq) {
                this.errors.push('Name seq.');
            }
            e.preventDefault();
        },

        updateForm(){
                this.form.seq= this.info.seq ? this.info.seq : "";
                this.form.attributeName=  this.info.attribute_name ? this.info.attribute_name : "";
                this.form.formType=  this.info ? this.info.form_type :"";
                this.form.displayValue= "";
                this.form.purpose= "";
                this.form.defaultValue= "";
                this.form.input= "";
                this.form.required= "";

                this.form.dateTypeSelected="";
                this.form.viewOrTable="";
                this.form.fieldValue="";
                this.form.fieldDescription="";
                this.form.groupBy="";
                this.form.orderBy="";
                this.form.orderByType="";
                this.form.program_code= this.program.program_code;
        }
    },
    watch:{

    }
    // computed:{
    //     update
    // }
};
</script>
