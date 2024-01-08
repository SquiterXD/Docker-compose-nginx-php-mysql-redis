<script>
    export default {
        props:['search', 'types', 'statusLists', 'moduleLists'],
        data() {
            return {
                programType: this.search? this.search['program_type']: '',
                status: this.search? this.search['status']:'',
                startDate: this.search? this.search['start_date']:'',
                endDate: this.search? this.search['end_date']:'',
                //
                program: this.search? this.search['program']: '',
                module: this.search? this.search['module']: '',
            }
        },
        mounted() {
            // 
        },
        methods: {
            chooseStartDate(){
                this.endDate = this.startDate;
            },
            checkEndDate() {
                if (this.endDate != '' && dayjs().format(this.startDate) > dayjs().format(this.endDate)) {
                    this.$notify.error({
                        title: 'มีข้อผิดพลาด',
                        message: 'End Date ไม่สามารถน้อยกว่า Start Date',
                    });
                    this.endDate = this.startDate;
                }
            },
        }
    }
</script>