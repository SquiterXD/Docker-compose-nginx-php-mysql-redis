<template>
    <div>
        <div class="ibox" v-loading="loading">
            <div class="ibox-content">
                <form @submit.prevent="getData()">
                    <div class="form-group row">
                        <label for="" class="col-lg-2 required col-form-label"
                            >ปีงบประมาณ</label
                        >
                        <select
                            name=""
                            id=""
                            class="form-control col-lg-3"
                            v-model="searchForm.year"
                        >
                            <option value=""></option>
                            <option
                                v-for="year in yearOptions"
                                :key="year"
                                :value="year"
                            >
                                {{ year + 543 }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2 required col-form-label"
                            >แผนประจำเดือน</label
                        >
                        <select
                            name=""
                            id=""
                            class="form-control col-lg-3"
                            v-model="searchForm.month"
                        >
                            <option value=""></option>
                            <option
                                v-for="option in monthBiWeeklyOptions"
                                :key="option.monthEn"
                                :value="option.monthEn"
                            >
                                {{ option.monthTh }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2 required col-form-label"
                            >ปักษ์ที่</label
                        >
                        <select
                            name=""
                            id=""
                            class="form-control col-lg-3"
                            v-model="searchForm.biweekly"
                        >
                            <option value=""></option>
                            <option
                                v-for="val in biweekOptions"
                                :key="val"
                                :value="val"
                            >
                                {{ val }}
                            </option>
                        </select>

                        <label for="" class="col-lg-1 col-form-label">ครั้งที่</label>
                        <input
                            type="text"
                            class="col-lg-1 form-control"
                            v-model="searchForm.rev"
                        />
                    </div>

                    <div class="row">
                        <div class="col-lg-2">วันที่</div>
                        <!-- <div class="col-lg-3">{{ selectedDate }}</div> -->
                        <div class="col-lg-3">
                            <div v-if="searchForm.biweekly != ''">
                                {{ thaiCombineDate }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-7 text-right pr-0">
                            <button class="btn btn-primary">ค้นหา</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="ibox" v-loading="loading">
            <div class="ibox-content">
                <div class="form-check mb-3">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        v-model="showQuantity"
                        id="showQuantity"
                    />
                    <label class="form-check-label" for="showQuantity"
                        >แสดงจำนวนยาเส้นที่ต้องใช้</label
                    >
                </div>

                <table class="table table-bordered table-responsive css-serial">
                    <TableHeader :date-list="dateList" :date-range="dateRange"></TableHeader>
                    <TableRow
                        :date-range="dateRange"
                        :group-by-machine-and-date="groupByMachineAndDate"
                        :date-list="dateList"
                        :show-quantity="showQuantity"
                    ></TableRow>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { DateTime } from "luxon";
import TableHeader from "./TableHeader";
import TableRow from "./TableRow";

const MASTER_MONTHS = [
    { month: 1, monthEn: "JANUARY", monthTh: "มกราคม", biweekly: [7, 8] },
    { month: 2, monthEn: "FEBRUARY", monthTh: "กุมภาพันธ์", biweekly: [9, 10] },
    { month: 3, monthEn: "MARCH", monthTh: "มีนาคม", biweekly: [11, 12] },
    { month: 4, monthEn: "APRIL", monthTh: "เมษายน", biweekly: [13, 14] },
    { month: 5, monthEn: "MAY", monthTh: "พฤษภาคม", biweekly: [15, 16] },
    { month: 6, monthEn: "JUNE", monthTh: "มิถุนายน", biweekly: [17, 18] },
    { month: 7, monthEn: "JULY", monthTh: "กรกฎาคม", biweekly: [19, 20] },
    { month: 8, monthEn: "AUGUST", monthTh: "สิงหาคม", biweekly: [21, 22] },
    { month: 9, monthEn: "SEPTEMBER", monthTh: "กันยายน", biweekly: [23, 24] },
    { month: 10, monthEn: "OCTOBER", monthTh: "ตุลาคม", biweekly: [1, 2] },
    { month: 11, monthEn: "NOVEMBER", monthTh: "พฤศจิกายน", biweekly: [3, 4] },
    { month: 12, monthEn: "DECEMBER", monthTh: "ธันวาคม", biweekly: [5, 6] }
];

export default {
    components: { TableHeader, TableRow },

    props: ["defaultSearch"],

    data() {
        return {
            dateRange: [],
            groupByDate: [],
            groupByMachineAndDate: [],
            dates: [],
            thaiCombineDate: '',
            searchForm: {
                // year: new Date().getFullYear(),
                // month: "", //DateTime.local().toFormat("LLLL").toUpperCase(),
                // biweekly: "", //parseInt(DateTime.local().weekNumber/2),
                year:  this.defaultSearch.period_year,
                month:this.defaultSearch.eng_month,
                biweekly:this.defaultSearch.biweekly,
                rev: this.defaultSearch.plan_revision_no,
            },
            showQuantity: false,

            loading: false,

            yearOptions: [],

            monthBiWeeklyOptions: MASTER_MONTHS,
            biweekOptions: []
        };
    },

    mounted() {
        // this.getData();
        this.yearOptions = _.range(-3, 4).map(i => {
            let d = new Date();
            return d.getFullYear() + i;
        });
        this.biweekOptions = _.range(1, 25);

        if (this.searchForm.month) {
            this.selectedMonth(this.searchForm.month);
        }
        if (this.searchForm.biweekly) {
            this.selectedBiweekly(this.searchForm.biweekly);
        }
    },

    methods: {
        getData() {
            this.loading = true;

            if (
                this.searchForm.year == "" ||
                this.searchForm.month == "" ||
                this.searchForm.biweekly == ""
            ) {
                this.loading = false;
                alert("กรุณาระบุช่องค้นหาให้ครบทั้งหมด");
                return;
            }

            axios
                .get("/ajax/pm/planning-jobs", { params: this.searchForm })
                .then(res => {
                    this.dateRange = res.data.dateRange;
                    this.groupByDate = res.data.groupBydates;
                    this.groupByMachineAndDate =
                        res.data.groupByMachineAndDates;
                })
                .catch(err => {

                    if (err.response?.data?.message) {
                        alert(err.response?.data?.message);

                        return
                    }
                    console.log(err.response);
                    alert("error")
                })
                .then(() => {
                    this.loading = false;
                });
        },

        getMaxRev() {
            this.loading = true;
            axios
                .get("/ajax/pm/planning-jobs/max-rev", { params: this.searchForm })
                .then(res => {
                    this.searchForm.rev = res.data.max_rev || 1
                    this.thaiCombineDate = res.data.thai_combine_date;
                })
                .catch(err => {
                    console.log(err.response);
                    alert("error")
                })
                .then(() => {
                    this.loading = false;
                });
        },
        async selectedMonth(newValue) {
            if (newValue) {
                // this.searchForm.biweekly = "";
                // this.searchForm.rev = "";

                let beginOfMonth = DateTime.fromFormat(
                    `1 ${newValue} ${this.searchForm.year}`,
                    "d LLLL yyyy"
                );
                let startWeekNumber =
                    beginOfMonth.weekYear < this.searchForm.year
                        ? 1
                        : beginOfMonth.weekNumber;

                this.biweekOptions = this.monthBiWeeklyOptions.find(m => {
                    return m.month == beginOfMonth.month;
                }).biweekly;
            }
        },
        async selectedBiweekly(newValue) {
            newValue = parseInt(newValue);
            if (newValue) {
                console.log('this.searchForm.month', this.searchForm.month);
                let month = await this.monthBiWeeklyOptions.find(m => {
                    return m.biweekly.includes(newValue);
                });
                this.searchForm.month = month.monthEn;

                // find max revision
                this.getMaxRev()
            }
        }
    },
    computed: {
        dateList: function() {
            return Object.keys(this.groupByDate).map(date => {
                return {
                    date: date,
                    working_hour: this.groupByDate[date][0].working_hour || ""
                };
            });
        },

        selectedDate: function() {
            let { year, month, biweekly } = { ...this.searchForm };

            if (year && month && biweekly) {
                // หาวันที่เริ่มต้นของช่วงเดือนตามปักษ์ที่เลือก
                let beginDate = biweekly % 2 == 0 ? 16 : 1;
                let beginDateRange = DateTime.fromFormat(
                    `${beginDate} ${month} ${year}`,
                    "d LLLL yyyy"
                );

                // หาวันที่สุดท้ายของช่วงเดือนตามปักษ์ที่เลือก
                let endDate = beginDate == 1 ? 15 : beginDateRange.daysInMonth;
                let endDateRange = DateTime.fromFormat(
                    `${endDate} ${month} ${year}`,
                    "d LLLL yyyy"
                );

                return (
                    beginDateRange
                        .setLocale("th")
                        .plus({ years: 543 })
                        .toFormat("d LLLL yyyy") +
                    " - " +
                    endDateRange
                        .setLocale("th")
                        .plus({ years: 543 })
                        .toFormat("d LLLL yyyy")
                );
            }
            return;
        }
    },
    watch: {
        "searchForm.year": function(newValue) {
            this.searchForm.month = "";
            this.searchForm.biweekly = "";
        },
        "searchForm.month": function(newValue) {
            if (newValue) {
                this.selectedMonth(newValue);
                // this.searchForm.biweekly = "";
                // this.searchForm.rev = "";

                // let beginOfMonth = DateTime.fromFormat(
                //     `1 ${newValue} ${this.searchForm.year}`,
                //     "d LLLL yyyy"
                // );
                // let startWeekNumber =
                //     beginOfMonth.weekYear < this.searchForm.year
                //         ? 1
                //         : beginOfMonth.weekNumber;

                // this.biweekOptions = this.monthBiWeeklyOptions.find(m => {
                //     return m.month == beginOfMonth.month;
                // }).biweekly;
            }
        },
        "searchForm.biweekly": function(newValue) {
            if (newValue) {
                this.selectedBiweekly(newValue);
                // let month = this.monthBiWeeklyOptions.find(m => {
                //     return m.biweekly.includes(newValue);
                // });
                // this.searchForm.month = month.monthEn;

                // // find max revision
                // this.getMaxRev()
            }
        }
    }
};
</script>

<style>
/*adding row numbers through css*/
.css-serial {
    counter-reset: serial-number; /* Set the serial number counter to 0 */
}

.css-serial td:first-child:before {
    counter-increment: serial-number; /* Increment the serial number counter */
    content: counter(serial-number); /* Display the counter */
}
</style>
