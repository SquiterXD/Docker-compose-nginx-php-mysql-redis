<template>
    <div v-loading="loading">
        <!-- stamp header -->
        <div class="mb-3 mt-2">
            <div class="card-body">
                <header-detail
                    :periodYears="periodYears"
                    :periodYearValue="periodYearValue"
                    :periodNameValue="periodNameValue"
                    :url="url"
                    :btnTrans="btnTrans"
                    :interfaceGlFlag="interfaceFlag"
                    :validData="stampCigarets.length > 0 || stampTobaccos.length > 0"
                    :stamps="stamps"
                    :manualTemps="manualTemps"
                    @updateInterfaceFlag="updateInterfaceFlag"
                />
            </div>
        </div>
        <!-- stamp table -->
        <stamp-adjust v-if="stampCigarets.length > 0 || stampTobaccos.length > 0"
            :setupStamps="setupStamps"
            :stampCigarets="stampCigarets"
            :percentCigarets="percentCigarets"
            :setupTobaccos="setupTobaccos"
            :stampTobaccos="stampTobaccos"
            :percentTobaccos="percentTobaccos"
            :url="url"
            :btnTrans="btnTrans"
            :interfaceGlFlag="interfaceFlag"
        />
    </div>
</template>

<script>
    import HeaderDetail  from './components/HeaderDetail.vue';
    import StampAdjust   from './components/StampAdjust.vue';
    export default {
        components: {
            HeaderDetail, StampAdjust
        },
        props:[
            'stampCigarets', 'percentCigarets', 'stampTobaccos', 'percentTobaccos'
            , 'setupStamps', 'setupTobaccos', 'periodYears', 'periodYearValue', 'periodNameValue', 'url', 'btnTrans', 'interfaceGlFlag'
            , 'stamps', 'manualTemps'
        ],
        data() {
            return {
                stamp_main: this.header,
                loading: false,
                interfaceFlag: this.interfaceGlFlag,
            }
        },
        methods: {
            updateInterfaceFlag(res){
                this.interfaceFlag = res.flag;
            },
        }
    }
</script>
<style scope>

</style>