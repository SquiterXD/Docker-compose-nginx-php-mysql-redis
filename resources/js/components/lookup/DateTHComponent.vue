<template>
    <div>
        <!-- <el-date-picker 
              v-model="data_value"
              style="width: 100%;"
              type="datetime"
              placeholder="วันที่เริ่มต้น"
              :name="this.dataName"
              format="dd-MM-yyyy"
              >
        </el-date-picker>  -->
        <datepicker-th
            style="width: 100%;"
            class="form-control md:tw-mb-0 tw-mb-2"
            :name="this.dataName"
            :placeholder="this.text_detail"
            v-model="data_value"
            format="DD-MM-YYYY"
            >
        </datepicker-th>

    </div>
</template>
<script>
export default {
    props: ['dataName', 'defaultValue', 'old', 'textDetail'],
    data() {
        return {
            data_value: '',
            text_detail: this.textDetail   ? this.textDetail   : '',
        };
    },
    mounted(){
        if (this.old) {
            this.data_value = this.old; 
            this.showDate();
        } else {
            this.data_value = this.defaultValue;
            this.showDate();
        }
    },
    methods: {
         async showDate() {
            if (this.data_value) {
                var date1 = await helperDate.parseToDateTh(this.data_value, 'yyyy-MM-DD');
                this.data_value = date1;
            }
        },
    },
}
</script>