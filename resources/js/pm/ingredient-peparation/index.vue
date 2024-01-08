<template>
    <div>
        <el-date-picker 
            v-model="dateSelected"
            style="width: 100%;"
            type="datetime"
            placeholder="วันที่เริ่มต้น"
            name="dateSelected"
            format="dd-MM-yyyy"
            >
        </el-date-picker>
    </div>
</template>
<script>
export default {
    data() {
        return {
            dateSelected: '',
        }
    }
}
</script>