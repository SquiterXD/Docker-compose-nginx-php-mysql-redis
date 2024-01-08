<template>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row" style="padding-top: 15px;">
                <div class="col-3">
                    <label class="w-100 text-left">
                        <strong> รายละเอียดการทดสอบ </strong>
                    </label>
                    <input type="hidden" name="search[testDesc]" v-model="arraySearch.testDesc" autocomplete="off">
                    <el-select  v-model="arraySearch.testDesc" 
                                placeholder="โปรดเลือกรายละเอียดการทดสอบ"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword>
                        <el-option
                            v-for="(data,index) in testDescList"
                            :key="index"
                            :label="data.test_desc"
                            :value="data.test_desc">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="w-100 text-left">
                        <strong> หน่วยการทดสอบ </strong>
                    </label>
                    <input type="hidden" name="search[units]" v-model="arraySearch.units" autocomplete="off">
                    <el-select  v-model="arraySearch.units" 
                                placeholder="โปรดเลือกหน่วยการทดสอบ"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword>
                        <el-option
                            v-for="(data, index) in units"
                            :key="index"
                            :label="data.qcunit_code"
                            :value="data.qcunit_code">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="w-100 text-left" v-if="this.testTypeCode != '2'">
                        <strong> ระดับความรุนแรงของความผิดปกติ (อาการ) </strong>
                    </label>
                    <label class="w-100 text-left" v-else>
                        <strong> ระดับความรุนแรงของข้อบกพร่อง </strong>
                    </label>
                    <input type="hidden" name="search[resultSeverites]" v-model="arraySearch.resultSeverites" autocomplete="off">
                    <el-select  v-model="arraySearch.resultSeverites" 
                                placeholder="โปรดเลือกระดับความรุนแรงของความผิดปกติ"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword>
                        <el-option
                            v-for="(data, index) in resultSeverites"
                            :key="index"
                            :label="data.meaning"
                            :value="data.meaning">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="w-100 text-left">
                        <strong> สถานะการใช้งาน </strong>
                    </label>
                    <input type="hidden" name="search[enableFlag]" v-model="arraySearch.enableFlag" autocomplete="off">
                    <el-select  v-model="arraySearch.enableFlag" 
                                placeholder="โปรดเลือกสถานะการใช้งาน"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword>
                        <el-option
                            v-for="(data, index) in options"
                            :key="index"
                            :label="data.label"
                            :value="data.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row" style="padding-top: 15px;" v-if="this.testTypeCode == '2'">
                <div class="col-3">
                    <label class="w-100 text-left">
                        <strong> รายการตรวจสอบคุณภาพบุหรี่ </strong>
                    </label>
                    <input type="hidden" name="search[entity]" v-model="arraySearch.entity" autocomplete="off">
                    <el-select  v-model="arraySearch.entity" 
                                placeholder="โปรดเลือกรายการตรวจสอบคุณภาพบุหรี่"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword
                                @change="showData">
                        <el-option
                            v-for="(data, index) in entityTestSearchList"
                            :key="index"
                            :label="data.entity_meaning"
                            :value="data.entity_code">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-3">
                    <label class="w-100 text-left">
                        <strong> กระบวนการตรวจคุณภาพบุหรี่ </strong>
                    </label>
                    <input type="hidden" name="search[process]" v-model="arraySearch.process" autocomplete="off">
                    <el-select  v-model="arraySearch.process" 
                                placeholder="โปรดเลือกกระบวนการตรวจคุณภาพบุหรี่"
                                class="w-100"
                                clearable 
                                filterable
                                remote 
                                reserve-keyword
                                @change="showData">
                        <el-option
                            v-for="(data, index) in processTestSearchList"
                            :key="index"
                            :label="data.process_meaning"
                            :value="data.process_code">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="text-right" style="padding-top: 15px;">
                <button :class="btnTrans.search.class" type="submit">
                    <i :class="btnTrans.search.icon" aria-hidden="true"></i> {{ btnTrans.search.text }}
                </button>
                <a  type="button" 
                    :href="route" 
                    class="btn btn-danger">
                    ล้าง
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['btnTrans', 'resultSeverites', 'units', 'search', 
            'testDescList', 'testTypeCode', 'processTestList', 'entityTestList',
            'processDistinctTestList'],
    data() {
        return {
            arraySearch: {
                resultSeverites: this.search.resultSeverites ? this.search.resultSeverites : '',
                units: this.search.units ? this.search.units : '',
                enableFlag: this.search.enableFlag ? this.search.enableFlag : '',
                testDesc: this.search.testDesc ? this.search.testDesc : '',
                entity: '',
                process: ''
            },
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],
            route: window.location.pathname,
            entityTestSearchList: [],
            processTestSearchList: []
        };
    },
    mounted() {
        this.showData();
        this.arraySearch.entity = this.search.entity != '' ? this.search.entity : '';
        this.arraySearch.process = this.search.process != '' ? this.search.process : '';
    },
    computed:{
        
    },
    methods: {
        async showData() {
            let vm = this;

            if (vm.arraySearch.entity == '' || vm.arraySearch.entity == undefined) {
                vm.entityTestSearchList = (vm.entityTestList != undefined && vm.entityTestList) ? vm.entityTestList : [];
            }

            if (vm.arraySearch.process == '' || vm.arraySearch.process == undefined) {
                vm.processTestSearchList = (vm.processTestList != undefined && vm.processTestList) ? vm.processDistinctTestList : [];
            }

            if (vm.arraySearch.entity) {
                let selEntity = vm.entityTestList.filter(o => {
                    return o.entity_code == vm.arraySearch.entity;
                });
                
                if (selEntity.length > 0) {
                    selEntity = selEntity[0];
                    vm.processTestSearchList = vm.processTestList.filter(o => {
                        return o.entity_code == selEntity.entity_code;
                    })
                    // vm.arraySearch.process = selEntity.entity_code;
                }     
            }

            if (vm.arraySearch.process) {
                let selProcess = vm.processTestList.filter(o => {
                    return o.process_code == vm.arraySearch.process;
                });

                if (selProcess.length > 0) {
                    selProcess = selProcess[0];
                    vm.entityTestSearchList = vm.entityTestList.filter(o => {
                        return o.process_code == selProcess.process_code;
                    })
                }
            }
        },
    }
};
</script>
