<template>

    <div class="tw-py-2">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="10%" rowspan="2" class="text-center pt-4"> หมายเลขเครื่อง </th>
                    <th width="15%" rowspan="2" class="text-center pt-4"> ประเภทเครื่อง </th>
                    <th width="10%" rowspan="2" class="text-center pt-4"> ตรวจสอบทั้งหมด (ซอง) </th>
                    <th width="10%" rowspan="2" class="text-center pt-4"> ไม่ผ่านมาตรฐาน (ซอง) </th>
                    <th width="10%" rowspan="2" class="text-center pt-4"> ไม่ผ่านมาตรฐาน (%) </th>
                    <th width="45%" colspan="6" class="text-center"> ตำแหน่งที่รั่ว </th>
                </tr>
                <tr>
                    <th width="10%" class="text-center"> หัวซอง (ซอง) </th>
                    <th width="5%" class="text-center"> % </th>
                    <th width="10%" class="text-center"> ท้ายซอง (ซอง) </th>
                    <th width="5%" class="text-center"> % </th>
                    <th width="10%" class="text-center"> ข้างซอง (ซอง) </th>
                    <th width="5%" class="text-center"> % </th>
                </tr>
            </thead>

            <tbody v-if="reportItems.length > 0">

                <template v-for="(reportItem, index) in reportItems">

                    <tr :key="`${index}`">

                        <td class="text-center" v-bind:style="{ backgroundColor: parseFloat(reportItem.failed_average) >= hightlightMachineFromPercent ? '#fff0a0' : '' }"> 
                            {{ reportItem.machine_set ? reportItem.machine_set : "-" }} 
                        </td>
                        <td class="text-center"> {{ reportItem.machine_type_desc ? reportItem.machine_type_desc : "-" }} </td>

                        <td class="text-center"> {{ reportItem.count ? reportItem.count : "0" }} </td>
                        <td class="text-center"> {{ reportItem.failed_count ? reportItem.failed_count : "0" }} </td>

                        <td class="text-right" v-bind:style="{ backgroundColor: parseFloat(reportItem.failed_average) >= hightlightMachineFromPercent ? '#fff0a0' : '' }">  
                            {{ reportItem.failed_average ? `${reportItem.failed_average}%` : "-" }} 
                        </td>

                        <td class="text-right"> {{ reportItem.failed_top_count ? reportItem.failed_top_count : "0" }} </td>
                        <td class="text-right" v-bind:style="{ backgroundColor: parseFloat(reportItem.failed_top_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                            {{ reportItem.failed_top_average ? `${reportItem.failed_top_average}%` : "-" }} 
                        </td>
                        <td class="text-right"> {{ reportItem.failed_side_count ? reportItem.failed_side_count : "0" }} </td>
                        <td class="text-right" v-bind:style="{ backgroundColor: parseFloat(reportItem.failed_side_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                            {{ reportItem.failed_side_average ? `${reportItem.failed_side_average}%` : "-" }} 
                        </td>
                        <td class="text-right"> {{ reportItem.failed_bottom_count ? reportItem.failed_bottom_count : "0" }} </td>
                        <td class="text-right" v-bind:style="{ backgroundColor: parseFloat(reportItem.failed_bottom_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                            {{ reportItem.failed_bottom_average ? `${reportItem.failed_bottom_average}%` : "-" }} 
                        </td>

                    </tr>

                </template>

                <tr>

                    <td width="25%" colspan="2" class="text-left"> รวมทั้งหมด </td>

                    <td width="10%" class="text-center"> {{ summarizedReportItem.count ? summarizedReportItem.count : "0" }} </td>
                    <td width="10%" class="text-center"> {{ summarizedReportItem.failed_count ? summarizedReportItem.failed_count : "0" }} </td>
                    <td width="10%" class="text-right"  v-bind:style="{ backgroundColor: parseFloat(summarizedReportItem.failed_average) >= hightlightMachineFromPercent ? '#fff0a0' : '' }"> 
                        {{ summarizedReportItem.failed_average ? `${summarizedReportItem.failed_average}%` : "-" }} 
                    </td>

                    <td width="10%" class="text-right"> {{ summarizedReportItem.failed_top_count ? summarizedReportItem.failed_top_count : "0" }} </td>
                    <td width="5%" class="text-right" v-bind:style="{ backgroundColor: parseFloat(summarizedReportItem.failed_top_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                        {{ summarizedReportItem.failed_top_average ? `${summarizedReportItem.failed_top_average}%` : "-" }} 
                    </td>
                    <td width="10%" class="text-right"> {{ summarizedReportItem.failed_side_count ? summarizedReportItem.failed_side_count : "0" }} </td>
                    <td width="5%" class="text-right" v-bind:style="{ backgroundColor: parseFloat(summarizedReportItem.failed_side_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                        {{ summarizedReportItem.failed_side_average ? `${summarizedReportItem.failed_side_average}%` : "-" }} 
                    </td>
                    <td width="10%" class="text-right"> {{ summarizedReportItem.failed_bottom_count ? summarizedReportItem.failed_bottom_count : "0" }} </td>
                    <td width="5%" class="text-right" v-bind:style="{ backgroundColor: parseFloat(summarizedReportItem.failed_bottom_average) >= hightlightPositionLeakFromPercent ? '#fff0a0' : '' }"> 
                        {{ summarizedReportItem.failed_bottom_average ? `${summarizedReportItem.failed_bottom_average}%` : "-" }} 
                    </td>

                </tr>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="11">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>

        </table>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";

export default {
    props: ["reportItems", "summarizedReportItem", "hightlightMachineFromPercentValue", "hightlightPositionLeakFromPercentValue"],
    components: { Loading },
    data() {
        return {
            isLoading: false,
            hightlightMachineFromPercent: this.hightlightMachineFromPercentValue ? parseInt(this.hightlightMachineFromPercentValue) : 100,
            hightlightPositionLeakFromPercent: this.hightlightPositionLeakFromPercentValue ? parseInt(this.hightlightPositionLeakFromPercentValue) : 100,
        };
    },

    methods: {

    }

};
</script>
