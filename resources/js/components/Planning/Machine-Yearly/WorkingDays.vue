<template>
    <div class="text-right" style="width: 45px;">
        <vue-numeric style="width: 100%; font-size: 11px;"
            name="working_days"
            v-bind:minus="false"
            :min="0"
            :max="99"
            class="form-control input-sm text-right"
            v-model="value"
            @change="changeDays()"
            @blur="changeDays()"
            autocomplete="off"
        ></vue-numeric>
    </div>
</template>
<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['period', 'workingHour', 'pWorkingDays'],
        data() {
            return {
                oldWorkingDays: '',
                workingDays: this.pWorkingDays,
                value: this.pWorkingDays[this.period+'|'+this.workingHour],
            }
        },
        mounted() {
            this.value = this.workingDays[this.period+'|'+this.workingHour];
        },
        methods: {
            changeDays(){
                console.log('qqqq');
                var vm = this;
                console.log(Number(vm.value));
                Vue.set(vm.workingDays, vm.period+'|'+vm.workingHour, vm.value);
                console.log(vm.workingDays);
            },
        },
    }
</script>