<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <!-- Table -->
                <div class="table-responsive mt-3" style="max-height: 420px;">
                    <table class="table text-nowrap table-bordered table-hover mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col text-center">ลำดับ</th>
                                <th class="sticky-col text-center">Type</th>
                                <th class="sticky-col text-center">กองทุน</th>
                                <th class="sticky-col text-center">% การปันส่วน</th>
                                <th class="sticky-col text-center">Dr/Cr</th>
                                <th class="sticky-col text-center">Company Code</th>
                                <th class="sticky-col text-center">EVM</th>
                                <th class="sticky-col text-center">Department Code</th>
                                <th class="sticky-col text-center">Cost Center</th>
                                <th class="sticky-col text-center">Budget Year</th>
                                <th class="sticky-col text-center">Budget Type</th>
                                <th class="sticky-col text-center">Budget Detail</th>
                                <th class="sticky-col text-center">Budget Reason</th>
                                <th class="sticky-col text-center">Main Account</th>
                                <th class="sticky-col text-center">Sub Account</th>
                                <th class="sticky-col text-center">Reserved1</th>
                                <th class="sticky-col text-center">Reserved2</th>
                                <th class="sticky-col text-center">Start Date</th>
                                <th class="sticky-col text-center">End Date</th>
                                <th class="sticky-col text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(stamp, index) in stampAdjs">
                                <td class="text-center">{{ index + 1 }}</td>
                                <td>{{ stamp.product_type ? stamp.product_type.description : '' }}</td>
                                <td>{{ stamp.fund_location }}</td>
                                <td class="text-center">{{ stamp.fund }}</td>
                                <td>{{ stamp.amount_type }}</td>
                                <td class="text-center">{{ stamp.segment1 }}</td>
                                <td class="text-center">{{ stamp.segment2 }}</td>
                                <td class="text-center">{{ stamp.segment3 }}</td>
                                <td class="text-center">{{ stamp.segment4 }}</td>
                                <td class="text-center">{{ stamp.segment5 }}</td>
                                <td class="text-center">{{ stamp.segment6 }}</td>
                                <td class="text-center">{{ stamp.segment7 }}</td>
                                <td class="text-center">{{ stamp.segment8 }}</td>
                                <td class="text-center">{{ stamp.segment9 }}</td>
                                <td class="text-center">{{ stamp.segment10 }}</td>
                                <td class="text-center">{{ stamp.segment11 }}</td>
                                <td class="text-center">{{ stamp.segment12 }}</td>
                                <td class="text-center">{{ convertDate(stamp.start_date) }}</td>
                                <td class="text-center">{{ convertDate(stamp.end_date) }}</td>
                                <td class="text-center">
                                    <a  type="button" :href="`/ct/stamp_adj/${stamp.stamp_adj_id}/edit`" class="btn btn-warning btn-xs">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ['trans_btn', 'stampAdjs'],
    data() {
        return {
        }
    },
    created() {
    },
    methods: {
        convertDate(date){
            return date ? moment(date).format("DD-MM-YYYY") : '';
        }
    }
}
</script>
<style type="text/css" scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }

    .sticky-col {
        position: sticky;
        background-color: #dcdfdb;
        z-index: 9999;
        top: 0;
    }

    .error-message {
        display: flex;
        color: #ec4958;
        margin-top: 5px;

        strong {
            margin-right: 5px;
        }
    }

    .el-date-picker {
        z-index: 9999 !important;
    }
</style>