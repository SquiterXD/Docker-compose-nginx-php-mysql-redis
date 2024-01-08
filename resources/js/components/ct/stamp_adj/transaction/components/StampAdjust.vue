<template>
    <div>
        <div class="tabs-container mb-3">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a :class="valid && currTab == 'tab1'
                        ? 'nav-link disabled active'
                        : valid
                        ? 'nav-link disabled'
                        : currTab == 'tab1'
                        ? 'nav-link active'
                        : 'nav-link'" data-toggle="tab" href="#tab1"
                    >
                        บุหรี่
                    </a>
                </li>
                <li>
                    <a :class="valid && currTab == 'tab2'
                        ? 'nav-link disabled active'
                        : valid
                        ? 'nav-link disabled'
                        : currTab == 'tab2'
                        ? 'nav-link active'
                        : 'nav-link'"
                        data-toggle="tab" href="#tab2"
                    >
                        ยาเส้น
                    </a>
                </li>
            </ul>
            <div class="tab-content" v-loading="">
                <div role="tabpanel" id="tab1" class="tab-pane active">
                    <div class="panel-body">
                        <div v-if="stampCigarets.length > 0">
                            <stamp-cigaret-table
                                :stampCigarets="stampCigarets"
                                :percentCigarets="percentCigarets"
                                :setupStamps="setupStamps"
                                :url="url"
                                :btnTrans="btnTrans"
                                :interfaceFlag="interfaceFlag"
                                @checkStampWorking="checkStampWorking"
                            />
                        </div>
                    </div>
                </div>

                <!-- TAB2 -->
                <div role="tabpanel" id="tab2" class="tab-pane">
                    <div class="panel-body ">
                        <div v-if="stampTobaccos.length > 0">
                            <stamp-tobacco-table
                                :stampTobaccos="stampTobaccos"
                                :percentTobaccos="percentTobaccos"
                                :setupStamps="setupTobaccos"
                                :url="url"
                                :btnTrans="btnTrans"
                                :interfaceFlag="interfaceFlag"
                                @checkStampWorking="checkStampWorking"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import StampCigaretTable from './StampCigaretTable.vue';
    import StampTobaccoTable from './StampTobaccoTable.vue';
    export default {
        components: {
            StampCigaretTable, StampTobaccoTable
        },
        props:[
            'stampCigarets', 'percentCigarets', 'stampTobaccos', 'percentTobaccos', 'setupStamps', 'setupTobaccos', 'url', 'btnTrans', 'interfaceGlFlag'
        ],
        data() {
            return {
                valid: false,
                currTab: 'tab1',
                interfaceFlag: this.interfaceGlFlag,
            }
        },
        watch: {
            'interfaceGlFlag': function(newValue) {
                this.interfaceFlag = newValue;
            },
        },
        methods: {
            checkStampWorking(res){
                this.valid = res.flag;
                this.currTab = res.tab;
            },
        },
    }
</script>