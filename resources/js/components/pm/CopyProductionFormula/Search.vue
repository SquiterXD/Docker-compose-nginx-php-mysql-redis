<template>
    <form :action="search_data.search_url" id="searchForm" v-loading="loading">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <label>สถานะ</label>
                <el-input name="status" :value="form.status" disabled></el-input>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <label>ประเภทสูตร</label>
                <el-input name="folmula_type" :value="form.folmula_type" disabled></el-input>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <label>ปีงบประมาณ<span class="text-danger">*</span></label>
                <el-select  v-model="form.period_year"
                                filterable
                                remote
                                reserve-keyword
                                placeholder=""
                                class="w-100">              
                    <el-option  v-for="item in period_year_list"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">

                    </el-option>
                </el-select>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                <label>คัดลอกเป็นปีงบประมาณ<span class="text-danger">*</span></label>
                <el-select  v-model="form.to_period_year"
                                filterable
                                remote
                                reserve-keyword
                                placeholder=""
                                class="w-100">              
                    <el-option  v-for="item in to_period_year_list"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">

                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-right">
                <label>&nbsp;</label>
                <div>
                    <button type="button" :class="trans_btn.search.class" @click="searchForm" >
                        <i :class="trans_btn.search.icon"></i>
                        แสดงข้อมูล
                    </button>
                    
                    <button type="button"  class="btn btn-danger" @click="clearForm" >
                        ล้างค่า
                    </button>
                </div>
            </div>
        </div>

        <input type="hidden" name="status"            :value="form.status">
        <input type="hidden" name="folmula_type"      :value="form.folmula_type">
        <input type="hidden" name="period_year"       :value="form.period_year">
        <input type="hidden" name="to_period_year"    :value="form.to_period_year">
        <input type="hidden" name="search"            :value="search">

    </form>
</template>
<script>
export default {
    props:['search_data', 'trans_btn', 'periodYearList', 'toPeriodYears'],
    data() {
        return {
            loading: false,
            period_year_list: this.periodYearList,
            to_period_year_list: this.toPeriodYears,
            form: {
                status:            'อนุมัติ',
                folmula_type:      'สูตรมาตรฐาน',
                period_year:       this.search_data.period_year    ? this.search_data.period_year    : null,
                to_period_year:    this.search_data.to_period_year ? this.search_data.to_period_year : null,
            },
            search:   'Y',
            errors: [],
        }
    },
    methods: {
        async searchForm() {
            this.errors = [];

            if (!this.form.period_year) {
                this.errors.push('ปีงบประมาณ');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.form.to_period_year) {
                this.errors.push('คัดลอกเป็นปีงบประมาณ');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.errors.length) {
                $( "#searchForm" ).submit();
            }
            
        },
        async clearForm() {
            window.location.reload();
        },
    },
    
}
</script>