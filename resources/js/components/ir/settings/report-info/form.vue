<template>
    <div>
        <!-- <form action=""> -->
        <!-- </form> -->

        <form
            :action="methodUrl === 'create' ?url.storeInfo :url.storeInfo+'/'+info.report_info_id"
            method="POST"
            >
            <input type="hidden" name="_token" :value="csrf">
            <!-- <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
            >
                <span aria-hidden="true">&times;</span>
            </button> -->
            <h3 class="m-b-md">
                <div>Create Report Infomation</div>
                <div>
                    <small>สร้างข้อมูลรายละเอียดของรายงานใหม่</small>
                </div>
            </h3>
            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    SEQ
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>ลำดับ</small>
                                </div>
                            </label>
                            <input
                                name="seq"
                                type="text"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.seq"
                            />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
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
                </div>
                <div class="col-sm-6">
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
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-6">
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
                </div>
                <div class="col-sm-6">
                    <div class="row m-t-sm" v-if="form.formType === 'select'">
                        <div class="col-sm-12">
                            <div>
                                <label>
                                    <div>
                                        SQL
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
                    </div>
                    <div class="row m-t-sm" v-if="form.formType === 'options'">
                        <div class="col-sm-12">
                            <div>
                                <label>
                                    <div>
                                        Options
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
                                    v-model="form.options"
                                    name="options"
                                >

                                </textarea>

                            </div>
                        </div>
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
                                    v-for="(dateType, index) in dateTypes"
                                    :value="index"
                                    :key="index"
                                    > {{ index  }}
                                </option>
                            </select>
                            <div class="mt-2 mb-2">
                                <small>Format date</small>
                            </div>
                            <select class="form-control" v-model="form.formatDate" name="format_date">
                                <option
                                    v-for="(dateType, index) in transDate"
                                    :value="dateType"
                                    :key="index"
                                    > {{ index + ' : '+ dateType }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row m-t-sm" v-if="form.formType === 'text'">
                        <div class="col-sm-12">

                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row clearfix">
                <div class="col-sm-6">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Default value From field
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small>แสดงค่า เรื่มต้น โดยระบุ ชื่อ field </small>
                                </div>
                            </label>
                            <input
                                name="default_value_field"
                                type="text"
                                autocomplet="off"
                                class="form-control"
                                v-model="form.attribute_2"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-sm-6">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <label>
                                <div>
                                    Dependent from 
                                    <span class="text-danger">*</span>
                                </div>
                                <div>
                                    <small> มีการเชื่อมโยงกับ .... </small>
                                </div>
                            </label>
                            <select class="form-control" v-model="form.dependent" name="format_date">
                                <option
                                    v-for="(dateType, index) in transDate"
                                    :value="dateType"
                                    :key="index"
                                    > {{ index + ' : '+ dateType }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="row clearfix">
                <div class="col-sm-6">
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
                </div>
            </div>
            <div class="row clearfix p-2" v-if="methodUrl != 'create'">
                <div class="col-sm-12">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <h4>
                                    Relation
                                </h4>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        id="required"
                                        name="required"
                                        v-model="relationType.where"
                                        @click="selectOnlyOne('where')"
                                    />
                                     : Where
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        id="required"
                                        name="required"
                                        @click="selectOnlyOne('whereBetween')"
                                        v-model="relationType.whereBetween"
                                    />
                                    : Where between
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mb-2 pb-2 tw-bg-red-100" v-if="relationType.where == true">
                    <div class="row m-t-sm">
                        <div class="col-sm-6">
                            <div>
                                <label>
                                    Where From :
                                </label>
                                <el-select v-model="relation.fromAttributeName" clearable class="form-control-file"  @change="updateDate()">
                                    <el-option
                                        v-for="(list, index) in uListInfos"
                                        :key="index"
                                        :value="index"
                                        :label="list.attribute_name + ' : ' + list.display_value">
                                    </el-option>
                                </el-select>
                                <!-- <select class="form-control" v-model="relation.fromAttributeName" >
                                    <option
                                        v-for="(list, index) in listInfos"
                                        :value="list.attribute_name"
                                        :key="index"
                                        > {{ list.attribute_name + ' : ' + list.display_value}}
                                    </option>
                                </select> -->
                            </div>

                            <!-- <div v-if="fromInfo != '' && (fromInfo.form_type == 'select' || fromInfo.form_type == 'options')"> -->
                            <div v-if="info.attribute_8 != '' && (fromInfo.form_type == 'select' || fromInfo.form_type == 'options')">
                                <label>
                                    Field :
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        autocomplet="off"
                                        class="form-control"
                                        v-model="relation.fromField" 
                                        @change="updateDate()"
                                    />
                                </div>
                            </div>

                            <!-- <div v-if="fromInfo != '' && fromInfo.form_type == 'date'"> -->
                            <div v-if="info.attribute_8 != '' && fromInfo.form_type == 'date'">
                                <label>
                                    Format date :
                                </label>
                                <select class="form-control" v-model="relation.formatDate" @change="updateDate()">
                                    <option
                                        v-for="(list, index) in transDate"
                                        :value="index"
                                        :key="index"
                                        > {{ list+' : ' +  index }}
                                    </option>
                                </select>
                            </div>
                        </div>
                  
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    Where To Field:
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        autocomplet="off"
                                        class="form-control"
                                        v-model="relation.toField"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- between -->
                <div class="col-sm-12 mb-2 pb-2 tw-bg-indigo-200" v-if="relationType.whereBetween == true">
                    <div class="row m-t-sm">
                        <div class="col-sm-6">
                            <div>
                                <label>
                                    Where between from:
                                </label>
                                <el-select  v-model="info.attribute_5" clearable class="form-control-file"  @change="updateDate()">
                                    <el-option
                                        v-for="(list, index) in uListInfos"
                                        :key="index"
                                        :value="index"
                                        :label="list.attribute_name + ' : ' + list.display_value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div v-if="!!info.attribute_5">
                                <label>
                                    Field start:
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        autocomplet="off"
                                        class="form-control"
                                        v-model="relation.whereBetweenFromField" 
                                        @change="updateDate()"
                                    />
                                </div>
                            </div>
                            <div>
                                <label>
                                    Where between to:
                                </label>
                                <el-select v-model="info.attribute_6" clearable class="form-control-file"  @change="updateDate()">
                                    <el-option
                                        v-for="(list, index) in uListInfos"
                                        :key="index"
                                        :value="index"
                                        :label="list.attribute_name + ' : ' + list.display_value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div v-if="!!info.attribute_6">
                                <label>
                                    Field from:
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        autocomplet="off"
                                        class="form-control"
                                        v-model="relation.whereBetweenToField" 
                                        @change="updateDate()"
                                    />
                                </div>
                            </div>

                            <div v-if="fromInfo != '' && fromInfo.form_type == 'date'">
                                <label>
                                    Format date :
                                </label>
                                <select class="form-control" v-model="relation.formatDate" @change="updateDate()">
                                    <option
                                        v-for="(list, index) in transDate"
                                        :value="index"
                                        :key="index"
                                        > {{ list+' : ' +  index }}
                                    </option>
                                </select>
                            </div>
                        </div>
                  
                        <div class="col-sm-6">
                            <div class="checkbox">
                                <label>
                                    Where To Field :
                                </label>
                                <div>
                                    <input
                                        type="text"
                                        autocomplet="off"
                                        class="form-control"
                                        v-model="relation.toField"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row m-t-sm">
                        <div class="col-sm-12">
                            <div class="checkbox">
                                <h4>
                                    Enable 
                                </h4>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input
                                        type="checkbox"
                                        name="enable_if"
                                        v-model="enableIf"
                                    />
                                    If has value (Default disable)
                                </label>
                            </div>
                            <div>
                                <el-select v-if="enableIf == true"  v-model="info.attribute_4" clearable class="form-control-file"  @change="updateDate()">
                                    <el-option
                                        v-for="(list, index) in uListInfos"
                                        :key="index"
                                        :value="index"
                                        :label="list.attribute_name + ' : ' + list.display_value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
                <input  name="enable_field" type="hidden" :value="info.attribute_4">
                <input  name="enable_if" type="hidden" :value="enableIf">
                <input  name="relation[attribute_name]" type="hidden" :value="relation.fromAttributeName">
                <input  name="relation[from_field]" type="hidden" :value="relation.fromField">
                <input  name="relation[format_date]" type="hidden" :value="relation.formatDate">
                <input  name="relation[to_field]" type="hidden" :value="relation.toField">
                <input  name="relation[type]" type="hidden" :value="relation.type">
                <input  name="relation_type" type="hidden" :value="typeRelation(info)">


                <div v-if="relationType.whereBetween ==true">
                    <input  name="relation_between[where_from]" type="hidden" :value="info.attribute_5">
                    <input  name="relation_between[where_to]" type="hidden" :value="info.attribute_6">
                    <input  name="relation_between[where_from_field]" type="hidden" :value="relation.whereBetweenFromField">
                    <input  name="relation_between[where_to_field]" type="hidden" :value="relation.whereBetweenToField">
                    <input  name="relation_between[to_field]" type="hidden" :value="relation.toField">
                </div>

            </div>
            <div class="row clearfix text-right pt-4">
                <div class="col-sm-12">
                    <button
                        id="btn_create"
                        class="btn btn-sm btn-primary"
                        type="submit"
                    >
                       {{ methodUrl == 'create' ?  'Create' : 'Update' }}
                    </button>
                </div>
            </div>
        </form>
        <!-- {!! Form::close()!!} -->
        <hr class="m-b-xs" />
    </div>
</template>

<script>
export default {
    // name: "settings-report-info",
    props: ["program", "infos", "list-form-types", "info", "url", "method-url", "csrf", "trans-date","u-list-infos"],
    data() {
        return {
            uInfos: this.infos,
            fromInfo: "",
            relation:{
                fromAttributeName: "",
                fromField: "",
                formatDate: "",
                toField:"",
                type: "",
                whereBetweenFrom: "",
                whereBetweenTo: "",
                whereBetweenFromField: "",
                whereBetweenToField: ""
            },
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
                                        ? this.info.required == '1' ? true : false
                                        :false,
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
                options:            this.info
                                        ? this.info.options
                                        :"",

                dateTypeSelected:   this.info
                                        ? this.info.date_type
                                        :"",
                formatDate:          this.info
                                        ? this.info.attribute_1
                                        :"",
                defaultFromField:          this.info
                                        ? this.info.attribute_2
                                        :"",
                dependent:          this.info
                                        ? this.info.attribute_3
                                        :"",
                relation:           this.relation                                
                
            },
            relationType: {
                where: false,
                whereBetween: false,
            },

            enableIf:   this.info.attribute_4 != null
                            ? true
                            : false

            // copyShow : false,


        };
    },

    components: {},
    mounted(){

        if(this.methodUrl != 'create'){
            this.defaultRelation(this.info, this.info.attribute_7)
            this.selectOnlyOne(this.info.attribute_7);
        }

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
                this.form.defaultFromField= "";
                this.form.dependent= "";
        },

        updateDate(){
            // this.typeRelation(this.info)
            this.form.relation = this.relation

            if(this.relation.fromAttributeName == "" || this.relation.fromAttributeName == null){
                return [];
            }

            let info =  this.uInfos.find(item => {
                return item.attribute_name == this.relation.fromAttributeName
            })

            this.fromInfo = info;
            this.relation.type =info.form_type;

        },

        selectOnlyOne(selected){
            if(selected == 'where'){
                this.relationType.where = true
                this.relationType.whereBetween = false
            }

            if(selected == 'whereBetween'){
                this.relationType.where = false
                this.relationType.whereBetween = true
            }

            if(selected == null){
                this.relationType.where = false
                this.relationType.whereBetween = false
            }
        },

        defaultRelation(info , type){

            if(!!info.attribute_8 & type == 'where'){
                this.relation.fromAttributeName = info.option_1.attribute_name  
                this.relation.fromField         = info.option_1.from_field  
                this.relation.formatDate        = info.option_1.format_date 
                this.relation.toField           = info.option_1.to_field 
                this.relation.type              = info.option_1.type 

            }

            if(!!info.attribute_5 & !!info.attribute_6 & type == 'whereBetween'){
                // console.log('whereBetween', 'xxxxxxxxxxxx')
                this.relation.whereBetweenFrom          = info.attribute_5  
                this.relation.whereBetweenTo            = info.attribute_6  
                this.relation.whereBetweenFromField     = info.option_2.where_from_field 
                this.relation.whereBetweenToField       = info.option_2.where_to_field 
                this.relation.toField                   = info.option_2.to_field 
            }
        },

        typeRelation(info){

            if(this.relationType.where == false && this.relationType.whereBetween == false){
                return ""
            }
            if(this.relationType.where == true){
                return 'where'
            }

            if(this.relationType.whereBetween == true){
                return 'whereBetween'
            }

            if(info.attribute_7){
                return info.attribute_7;
            }

            return ""
        }
    },
    watch:{

    },
    computed:{
        listInfos(){
            return  this.uInfos.filter(item => {
                return item.form_type == 'select' || item.form_type == 'options' || item.form_type == 'date';
            })
        },

        fieldLists(){
            if(this.relation.fromAttributeName == "" || this.relation.fromAttributeName == null){
                return [];
            }

            let info =  this.uInfos.find(item => {
                return item.attribute_name == this.relation.fromAttributeName
            })

            this.fromInfo = info;
            this.relation.type =info.form_type;

            if(info.form_type == 'date'){
                return [];
            }

            return info.lists;
        },

        uLists(){
            if (!this.info) {
                return [];
            }

            return this.info.lists;
        }, 


    }
};
</script>


