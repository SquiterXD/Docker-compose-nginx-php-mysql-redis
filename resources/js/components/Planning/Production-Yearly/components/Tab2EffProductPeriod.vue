<template>
    <div>
        <vue-numeric
            separator="," 
            v-bind:precision="2" 
            v-bind:minus="false"
            class="form-control input-sm text-right"
            v-model="value"
            :placeholder="placeholder"
            disabled
        ></vue-numeric>
    </div>
</template>
<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric
        },
        props:['placeholder', 'totalEffProduct', 'summaryTotal'],
        data() {
            return {
                value: Number(this.totalEffProduct) - Number(this.summaryTotal),
            }
        },
        mounted() {
        },
        methods: {
            //
        }
    }
</script>