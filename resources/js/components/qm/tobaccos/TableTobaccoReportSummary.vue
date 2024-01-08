<template>

    <div class="tw-ml-10">

        <div class="table-responsive tw-py-2" v-for="(reportQmGroup, index) in reportQmGroups" :key="index">
            
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th :colspan=" 3 + (reportQmGroup.count_locators * 2) "> {{ reportQmGroup.qm_group }} </th>
                    </tr>
                    <tr>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;"> วันที่ </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;"> เวลา </th>
                        <th rowspan="2" class="text-center" style="vertical-align: middle;"> ตรา/ชุด </th>
                        <th v-for="(reportQmGroupLocatorLH, indexLH) in reportQmGroupLocators.filter(itemLH => itemLH.qm_group == reportQmGroup.qm_group)" :key="indexLH" colspan="2" class="text-center" style="vertical-align: middle;"> 
                            ค่ามาตรฐาน {{ reportQmGroupLocatorLH.min_value }}-{{ reportQmGroupLocatorLH.max_value }}% 
                        </th>
                    </tr>
                    <tr>
                        <template v-for="(reportQmGroupLocatorLL, indexLL) in reportQmGroupLocators.filter(itemLL => itemLL.qm_group == reportQmGroup.qm_group)">
                            <th :key="indexLL + '_H'" class="text-center"> 
                                <p class="tw-mb-1"> หัววัด {{ reportQmGroupLocatorLL.location_desc }}  </p>
                                <p class="tw-mb-1"> {{ reportQmGroupLocatorLL.locator_desc }} </p>
                            </th>
                            <th :key="indexLL + '_L'" class="text-center"> Lab {{ reportQmGroupLocatorLL.location_desc }} </th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(reportItem, i) in reportItems" :key="i">
                        <template v-if="reportItem.qm_group == reportQmGroup.qm_group">
                            <td class="text-center"> {{ reportItem.date_drawn_formatted }} </td>
                            <td class="text-center"> {{ reportItem.time_drawn_formatted }} </td>
                            <td class="text-center"> {{ reportItem.sample_opt }} </td>
                            <template v-for="(reportQmGroupLocatorLI, indexLI) in reportQmGroupLocators.filter(itemLL => itemLL.qm_group == reportQmGroup.qm_group)">

                                <!-- MOISTURE_METER -->
                                <template v-for="(reportItemLocator, indexRILH) in reportItem.locators">

                                    <td :key="indexLI + indexRILH + '_H'" v-if="reportItemLocator.moisture_meter_under == true && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center" style="background-color: #ffe699;">
                                        {{ reportItemLocator.moisture_meter }}
                                    </td>
                                    <td :key="indexLI + indexRILH + '_H'" v-if="reportItemLocator.moisture_meter_over == true && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center" style="background-color: #ffc1c1;">
                                        {{ reportItemLocator.moisture_meter }}
                                    </td>
                                    <td :key="indexLI + indexRILH + '_H'" v-if="(reportItemLocator.moisture_meter_under == false && reportItemLocator.moisture_meter_over == false) && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center">
                                        {{ reportItemLocator.moisture_meter }}
                                    </td>

                                </template>

                                <!-- MOISTURE_LAB_AVERAGE -->
                                <template v-for="(reportItemLocator, indexRILL) in reportItem.locators">
                                    
                                    <td :key="indexLI + indexRILL + '_L'" v-if="reportItemLocator.moisture_lab_under == true && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center" style="background-color: #ffe699;">
                                        {{ reportItemLocator.moisture_lab_average }}
                                    </td>
                                    <td :key="indexLI + indexRILL + '_L'" v-if="reportItemLocator.moisture_lab_over == true && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center" style="background-color: #ffc1c1;">
                                        {{ reportItemLocator.moisture_lab_average }}
                                    </td>
                                    <td :key="indexLI + indexRILL + '_L'" v-if="(reportItemLocator.moisture_lab_under == false && reportItemLocator.moisture_lab_over == false) && reportItemLocator.locator_id == reportQmGroupLocatorLI.locator_id" class="text-center">
                                        {{ reportItemLocator.moisture_lab_average }}
                                    </td>

                                </template>

                            </template>
                        </template>
                    </tr>
                </tbody>
            </table>

            <loading :active.sync="is_loading" :is-full-page="true"></loading>

        </div>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";

export default {

    props: [ "reportQmGroups", "reportQmGroupLocators", "reportItems"],
    components: { Loading },
    data() {
        return {
            is_loading: false
        };
    },

    methods: {
        
    }
};
</script>
