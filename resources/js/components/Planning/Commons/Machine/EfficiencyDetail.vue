<template>
    <div>
        <h2 class="tw-font-bold"> 
            กำลังการผลิตรวมทั้งปักษ์ : {{ total | number2Digit }} {{ unit }}
        </h2>
    </div>
</template>
<script>
    export default {
        props:['total', 'unit'],
        data() {
            return {
            }
        },
    }
</script>