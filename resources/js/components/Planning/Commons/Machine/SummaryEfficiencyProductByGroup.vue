<template>
    <div>
        <span> {{ totalEffProductByGroup | number2Digit }} </span>
    </div>
</template>
<script>
    export default {
        props:['pMachineGroup', 'pTotalProductArr', 'pResPlanDate'],
        data() {
            return {
                machineGroup: this.pMachineGroup,
                productArr: this.pTotalProductArr,
                resPlanDate: this.pResPlanDate,
                totalEffProductByGroup: 0,
            }
        },
        mounted() {
            //
        },
        watch: {
            effProductByGroup: function(newValue) {
                return newValue;
            },
        },
        computed: {
            effProductByGroup: function () {
                var vue = this;
                var totalByGroup = 0;
                vue.resPlanDate.filter(function(planDate) {
                    if(vue.pTotalProductArr[vue.machineGroup+planDate.res_plan_date_display]){
                        totalByGroup += Number(vue.productArr[vue.machineGroup+planDate.res_plan_date_display][0].total.toFixed(3));
                    }
                });
                vue.totalEffProductByGroup = totalByGroup.toFixed(3);
            }
        },
    }
</script>