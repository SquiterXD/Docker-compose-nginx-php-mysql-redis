<template>
    <div class="row">
        <div class="col-md-3 b-r hidden-xs hidden-sm">
            <form :action="url.saveFunction" method="POST">
            <h4>Report Detail</h4>
            <ul class="list-group clear-list m-t">
                <li class="list-group-item fist-item">
                    Program Code :
                    <span class="pull-right">
                        {{ program.program_code }}
                    </span>
                </li>
                <li class="list-group-item fist-item">
                    Report Name :
                    <span class="pull-right">
                        {{ program.description }}
                    </span>
                </li>
                <!-- <li class="list-group-item fist-item">
                    <button
                        class="btn btn-primary btn-xs"
                    >
                        <i class="fa fa-plus"></i> Add Button
                    </button>
                </li> -->
                <li class="list-group-item fist-item">
                    Input Function Report
                </li>
                <input type="hidden" name="_token" :value="csrf">
                <li class="list-group-item fist-item">
                    <textarea name="function_name" class="form-control" rows="2" v-model="functionName"></textarea>
                </li>
                <li class="list-group-item fist-item mt-2">
                    <input
                        type="checkbox"
                        id="required"
                        name="multi_type"
                        v-model="mulTiType"
                    />
                    <label> Multi Type Report </label>
                </li>

            </ul>
            <button class="pull-right btn btn-primary btn-xs" type="submit"> Save </button>
            </form>
        </div>
        <div class="col-md-9">
            <form :action="'/report/report-info/report-info-copy/copy-program/'+value+'/'+program.program_code" method="GET">
                <div class="row m-2 p-2 " alight="right">
                    <div class="col-12 text-right">
                        <button type="button"  @click="showCopy" class="btn btn-outline-dark" > Copy from program</button>
                    </div> 
                </div>
                <div v-if="copyShowForm == true" class="bg-muted row text-right p-4">
                    <el-select
                        v-model="value"
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Please enter a report "
                        :remote-method="remoteMethod"
                        @input="remoteMethod(' ')"
                        clearable 
                        class="col-8"
                    >
                        <el-option
                            v-for="item in options"
                            :key="item.program_code"
                            :label="item.program_code + ' ' +item.description"
                            :value="item.program_code"
                        >
                        </el-option>
                    </el-select>
                    <button type="submit"  class="btn btn-primary pull-right" > Copy program </button>         
                </div>
            </form>
            <div class="clearfix">
            <formCreate
                :program="program"
                :infos="infos"
                :list-form-types="listFormTypes"
                :url="url"
                :info="info"
                :method-url="'create'"
                :csrf="csrf"
                :transDate="transDate">
            </formCreate>
            </div>
            <div class="table-responsive">
                <div v-if="newInfos.length > 0" class="form-group">
                    <!-- <draggable v-model="newInfos"> -->
                        <div v-for="(info, index) in newInfos" :key="index">
                            <div v-if="info.form_type == 'text'"  class="row m-2">
                                <div class="m-1 col-1 text-right">
                                    <div>{{ info.seq }}</div>
                                </div>
                                <div class="m-1 col-2 text-right">
                                    <div>{{ info.display_value }}  <span v-if="info.required =='1'" class="tw-text-red-400">* </span></div>
                                </div>
                                <div class="col-6">
                                    <input type="text" :name="info.attribute_name" class="form-control w-100 ">
                                </div>
                                <div class="pull-right form-inline">
                                    <a
                                        href="#"
                                        class="btn btn-outline btn-warning btn-xs"
                                        @click="modalOpen(info)"
                                        data-toggle="modal"
                                        :data-target="'#edit_'+info.report_info_id"
                                    >
                                        <i class="fa fa-pencil"></i>แก้ไข
                                    </a>
                                    <form :action="url.storeInfo+'/'+info.report_info_id+'/delete'"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to submit the form?');"
                                            class="m-2">
                                            <input type="hidden" name="_token" :value="csrf">
                                        <button
                                            type="submit"
                                            class="btn btn-outline btn-danger btn-xs"
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div v-if="info.form_type == 'date'" class="row m-2">
                                <div class="m-1 col-1 text-right">
                                    <div>{{ info.seq }}</div>
                                </div>
                                <div class="m-1 col-2 text-right">
                                    <div>
                                        {{ info.display_value }} <span v-if="info.required =='1'" class="tw-text-red-400">* </span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <datepicker-th
                                    v-model="info.attribute_name"
                                        placeholder="เลือกวัน"
                                        style="width: 100%; border-radius:3px;"
                                        class="form-control col-lg-12"
                                        :name="info.attribute_name"
                                        id="input_date"
                                        :pType="info.date_type"
                                        @dateWasSelected="getYear"
                                        :format="info.attribute_1"
                                    />
                                </div>
                                <div class="pull-right form-inline">
                                    <a
                                        href="#"
                                        class="btn btn-outline btn-warning btn-xs"
                                        @click="modalOpen(info)"
                                        data-toggle="modal"
                                        :data-target="'#edit_'+info.report_info_id"
                                    >
                                        <i class="fa fa-pencil"></i>แก้ไข
                                    </a>
                                    <form :action="url.storeInfo+'/'+info.report_info_id+'/delete'"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to submit the form?');"
                                            class="m-2">
                                            <input type="hidden" name="_token" :value="csrf">
                                        <button
                                            type="submit"
                                            class="btn btn-outline btn-danger btn-xs"
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div v-if="info.form_type == 'select'" class="row m-2">
                                <div class="m-1 col-1 text-right">
                                    <div>{{ info.seq }}</div>
                                </div>
                                <div class="m-1 col-2 text-right">
                                    <div>{{ info.display_value }} <span v-if="info.required =='1'" class="tw-text-red-400">* </span></div>
                                </div>
                                <div class="col-6">
                                    <el-select v-model="info.default_value" filterable clearable
                                        :name="info.attribute_name"
                                        :popper-append-to-body='false'
                                        class="w-100 text-left"
                                    >
                                        <el-option
                                            v-for="list in info.lists"
                                            :key="list.value"
                                            :label="list.label"
                                            :value="list.value">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="pull-right form-inline">
                                    <a
                                        href="#"
                                        class="btn btn-outline btn-warning btn-xs"
                                        @click="modalOpen(info)"
                                        data-toggle="modal"
                                        :data-target="'#edit_'+info.report_info_id"
                                    >
                                        <i class="fa fa-pencil"></i>แก้ไข
                                    </a>
                                    <form :action="url.storeInfo+'/'+info.report_info_id+'/delete'"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to submit the form?');"
                                            class="m-2">
                                            <input type="hidden" name="_token" :value="csrf">
                                        <button
                                            type="submit"
                                            class="btn btn-outline btn-danger btn-xs"
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div v-if="info.form_type == 'options'" class="row m-2">
                                <div class="m-1 col-1 text-right">
                                    <div>{{ info.seq }}</div>
                                </div>
                                <div class="m-1 col-2 text-right">
                                    <div>{{ info.display_value }} <span v-if="info.required =='1'" class="tw-text-red-400">* </span></div>
                                </div>
                                <div class="col-6">
                                    <select class="form-control w-100" :name="info.attribute_name">
                                        <option
                                            v-for="list in info.lists"
                                            :value="list.value"
                                            :key="list.value"
                                            >{{ list.label }}
                                        </option>
                                    </select>
                                </div>
                                <div class="pull-right form-inline">
                                     <a
                                        href="#"
                                        class="btn btn-outline btn-warning btn-xs"
                                        @click="modalOpen(info)"
                                        data-toggle="modal"
                                        :data-target="'#edit_'+info.report_info_id"
                                    >
                                        <i class="fa fa-pencil"></i>แก้ไข
                                    </a>
                                    <form :action="url.storeInfo+'/'+info.report_info_id+'/delete'"
                                            method="post"
                                            onsubmit="return confirm('Do you really want to submit the form?');"
                                            class="m-2">
                                            <input type="hidden" name="_token" :value="csrf">
                                        <button
                                            type="submit"
                                            class="btn btn-outline btn-danger btn-xs"
                                        >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <div
                                class="modal inmodal fade"
                                :id="'edit_'+info.report_info_id"
                                tabindex="-1"
                                role="dialog"
                                aria-hidden="true"
                                style="display: none;"
                            >
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <formCreate
                                                    :program="program"
                                                    :infos="infos"
                                                    :list-form-types="listFormTypes"
                                                    :url="url"
                                                    :info="info"
                                                    :method-url="'update'"
                                                    :csrf="csrf"
                                                    :transDate="transDate"
                                                    :u-list-infos="listInfos">
                                                </formCreate>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- </draggable> -->
                    <!-- <div cla ss="text-center">
                        <button  class="btn btn-primary btn-xs" type="button" @click="update()"> Save Sequence </button>
                    </div> -->

                    <!-- <button></button> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import createInfo from './create.vue'
import previewInfo from './preview.vue'
// import draggable from 'vuedraggable'
import formCreate from './form.vue'
export default {

    name: "settings-report-info",
    props: ["program", "infos", "list-form-types", "url","csrf", "trans-date", "sys-date", "func","list-infos"],

    data() {
        return {
            info:"",
            newInfos: this.infos,
            functionName: this.func
                            ?  this.func.function
                            : "",
            mulTiType: this.func
                            ?  this.func.attribute_9 == "Y" ? true : false
                            : false,
            form:{
                attributeName:""
            },

            copyShowForm:false,
            value:"",
            options: [],
            programs:[],
            module: null
        };
    },
    components: {
        createInfo,
        previewInfo,
        // draggable,
        formCreate,

    },

    methods: {
        update(){

            this.newInfos.map((newInfo, index) => {
                newInfo.new_seq = index + 1;
            })

             
        },
        modalOpen(info) {
            this.info = info !== null ? info : {};
            // this.loading.table_header = true;
            // this.mesReviewIssueHeader = [];
            // axios.get(this.url.getHeaders+'?item_classification_code='+this.classClassificationCode).then(res => {
            //     let mesReviewIssueHeaders = res.data.mesReviewIssueHeaders;
            //     this.mesReviewIssueHeaders = mesReviewIssueHeaders;
            //     this.loading.table_header = false;
            // });
        },
        getYear(value){
             
        },

        showCopy(){
            this.copyShowForm = !this.copyShowForm;
             
        },

        async remoteMethod(query) {
            var request = {
                params: {
                    module: [this.module],
                    uQuery: query
                    
                }
            }
            axios.get('/report/ajax/get-report-programs', request)
            .then((res) => {
                // this.infos = res.data.ptirReportInfos;
                this.programs = res.data.programs;
                this.options = res.data.programs;
            })
            .catch((error) => {
                // swal("Error", error, "error");
            })

        },
    },

};
</script>
