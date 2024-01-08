<template>
    <div class="" v-loading="loading">
        <div class="ibox float-e-margins mb-2" >
            <div class="col-12 text-right mt-2">
                <modal-search
                    :btnTrans="btnTrans"
                    :url="url"
                    :budgetYears="searchInput.budget_years"
                    :defBudgetYear="searchInput.def_period_year"
                    :monthList="searchInput.month_list"
                    :search="defaultSearch"
                />

                <template v-if="!stamp_main">
                    <modal-create
                        :btnTrans="btnTrans"
                        :url="url"
                        :createInput="createInput"
                    />
                </template>
                <template v-else>
                    <a v-if="stamp_main" :href="'/planning/stamp-follow'" type="button" :class="btnTrans.search.class + ' btn-lg tw-w-25'" >
                        <i :class="btnTrans.reset.icon"></i>
                        ล้างการค้นหา
                    </a>
                </template>

                <modal-interface v-if="stamp_main && valid"
                    :btnTrans="btnTrans"
                    :url="url"
                    :header="header"
                    :stampMain="stamp_main"
                    :users="users"
                    @updateStampHeader="updateStampHeader"
                />
                <!-- <a v-if="stamp_main" :href="'/planning/stamp-follow/'+stamp_main.follow_stamp_main_id+'/export'" target="_blank"
                    type="button" :class="btnTrans.print.class + ' btn-lg tw-w-25'" >
                    <i :class="btnTrans.print.icon"></i>
                    {{ btnTrans.print.text }}
                </a> -->
            </div>
        </div>

        <div class="card border-primary mb-3 mt-2">
            <div class="card-body">
                <header-detail :header="stamp_main" />
            </div>
        </div>
        <!-- daily table -->
        <stamp-daily v-if="stamp_main"
                    :header="stamp_main"
                    :btnTrans="btnTrans"
                    :url="url"
                    :interfaceTemps="temps"
                    :poLists="poMaps"
                    @updateStamp="updateStamp"
                />
        <template v-else-if="Object.values(defaultSearch).length">
            <div class="col-12 text-center mt-4">
                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                <div class="hr-line-dashed"></div>
            </div>
        </template>
    </div>
</template>

<script>
    import ModalCreate      from './ModalCreate.vue';
    import ModalSearch      from './ModalSearch.vue';
    import ModalInterface   from './ModalInterfacePR.vue';
    import HeaderDetail     from './components/HeaderDetail.vue';
    import StampDaily       from './components/StampDaily.vue';
    import moment from "moment";
    export default {
        components: {
            ModalCreate, ModalSearch, ModalInterface, HeaderDetail, StampDaily
        },
        props:[
            "btnTrans", "dateFormat", "createInput", "searchInput", "url", "header", "defaultSearch", 'users', 'interfaceTemps', 'poLists', 'lastDate'
        ],
        data() {
            return {
                stamp_main: this.header,
                loading: false,
                valid: false,
                temps: this.interfaceTemps,
                poMaps: this.poLists,
                poMaps: this.poLists,
            }
        },
        mounted() {
            this.checkCanEdit();
        },
        methods: {
            updateStamp(res){
                this.stamp_main = res;
            },
            updateStampHeader(res){
                // update when interface PR
                this.stamp_main = res.header;
                this.temps = res.interfaceTemps;
                this.poMaps = res.poLists;
            },
            checkCanEdit(){
                let last_date = moment(this.lastDate).format('YYYY-MM-DD');
                let curr_date = moment().format('YYYY-MM-DD');
                if (last_date > curr_date) {
                    this.valid = true;
                }
            },
        }
    }
</script>
<style scope>

</style>