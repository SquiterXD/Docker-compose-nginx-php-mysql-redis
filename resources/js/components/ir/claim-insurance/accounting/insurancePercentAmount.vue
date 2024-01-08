<template>
    <div>
        <vue-numeric style="width: 100%" name="claim_amount"
            separator="," 
            v-bind:precision="2" 
            v-bind:minus="false"
            :min="0"
            :max="999999999"
            class="form-control input-sm text-right"
            v-model="insurance_amount"
            disabled
        ></vue-numeric>
    </div>
</template>

<script>
export default {
    props: ['amount', 'company'],
    data() {
        return {
            loading: false,
            insurance_amount: 0,
        };
    },
    mounted() {
    },
    watch: {
        'amount': function(newValue) {
            if (newValue == 0 ) {
                this.insurance_amount = 0;
            }else{
                this.insurance_amount = (Number(this.amount) * Number(this.company.company_percent)) / 100;
            }
        },
    },
}
</script>