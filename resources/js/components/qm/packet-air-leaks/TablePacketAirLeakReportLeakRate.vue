<template>

    <div class="tw-py-2">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2" class="text-center pt-4"> หมายเลขเครื่อง </th>
                    <th rowspan="2" class="text-center pt-4"> ประเภทเครื่อง </th>
                    <th rowspan="2" class="text-center pt-4"> วันที่บันทึก </th>
                    <th rowspan="2" class="text-center pt-4"> เวลา </th>
                    <th rowspan="2" class="text-center pt-4"> ตราบุหรี่ </th>
                    <th colspan="11" class="text-center"> ค่ามาตรฐาน ≤ 200 มล./นาที</th>
                    <th rowspan="2" class="text-center pt-4"> ตำแหน่งที่รั่ว </th>	
                    <th rowspan="2" class="text-center pt-4"> เลขที่การตรวจสอบ </th>
                    <th rowspan="2" class="text-center pt-4"> เขตตรวจคุณภาพ </th>
                </tr>
                <tr>
                    <th class="text-center"> ซองที่ 1 </th>
                    <th class="text-center"> P1 </th>
                    <th class="text-center"> ซองที่ 2 </th>
                    <th class="text-center"> P2 </th>
                    <th class="text-center"> ซองที่ 3 </th>
                    <th class="text-center"> P3 </th>
                    <th class="text-center"> ซองที่ 4 </th>
                    <th class="text-center"> P4 </th>
                    <th class="text-center"> ซองที่ 5 </th>
                    <th class="text-center"> P5 </th>
                    <th class="text-center"> ค่าเฉลี่ย </th>
                </tr>
            </thead>

            <tbody v-if="reportItemByDates.length > 0">

                <template v-for="(reportItemByDate, rdIndex) in reportItemByDates">

                    <template v-for="(reportItem, index) in reportItemByDate.report_items">

                        <tr :key="`${rdIndex}_${index}`">

                            <td class="text-center" v-bind:style="{ backgroundColor: reportItem.result_status == 'FAILED' ? '#fff0a0' : '' }">  
                                {{ reportItem.machine_set ? reportItem.machine_set : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.machine_type_desc ? reportItem.machine_type_desc : "-" }} </td>
                            <td class="text-center"> {{ reportItem.date_drawn_formatted ? reportItem.date_drawn_formatted : "-" }} </td>
                            <td class="text-center"> {{ reportItem.time_drawn_formatted ? reportItem.time_drawn_formatted : "-" }} </td>
                            <td class="text-center"> {{ reportItem.brand_desc ? reportItem.brand_desc : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status1 == 'FAILED' ? '#fff0a0' : '' }"> 
                                {{ reportItem.leak1 !== null ? reportItem.leak1 : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.position1 ? reportItem.position1 : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status2 == 'FAILED' ? '#fff0a0' : '' }"> 
                                {{ reportItem.leak2 !== null ? reportItem.leak2 : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.position2 ? reportItem.position2 : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status3 == 'FAILED' ? '#fff0a0' : '' }"> 
                                {{ reportItem.leak3 !== null ? reportItem.leak3 : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.position3 ? reportItem.position3 : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status4 == 'FAILED' ? '#fff0a0' : '' }"> 
                                {{ reportItem.leak4 !== null ? reportItem.leak4 : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.position4 ? reportItem.position4 : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status5 == 'FAILED' ? '#fff0a0' : '' }"> 
                                {{ reportItem.leak5 !== null ? reportItem.leak5 : "-" }} 
                            </td>
                            <td class="text-center"> {{ reportItem.position5 ? reportItem.position5 : "-" }} </td>
                            
                            <td class="text-right" v-bind:style="{ backgroundColor: reportItem.status_average == 'FAILED' ? '#fff0a0' : '' }">  
                                {{ reportItem.average ? reportItem.average : "-" }} 
                            </td>
                            
                            <td class="text-center"> {{ reportItem.position_leak_desc ? reportItem.position_leak_desc : "-" }} </td>
                            <td class="text-left"> {{ reportItem.sample_no }} </td>
                            <td class="text-center"> {{ reportItem.qc_area }} </td>

                        </tr>

                    </template>

                </template>

            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="20">
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
    props: ["reportItems", "reportItemByDates"],
    components: { Loading },
    data() {
        return {
            isLoading: false
        };
    },

    methods: {

    }

};
</script>
