<template>
    <div>
        <span> {{ dateRangeDetail }} </span>
    </div>
</template>
<script>
    export default {
        props:['dateRangeDetail'],
        data() {
            return {
                // oldEamMachine: this.line.machine_eamperformance,
            }
        },
        mounted() {
        },
    }
</script>