<template>
    <div>
        <input
            type="hidden"
            v-model="selected"
            :name="name"
            :id="id ? id : null"
        />
        <el-date-picker
            v-model="selected"
            :value="selected"
            type="datetime"
            :format="format"
            :value-format="valueFormat"
            :placeholder="placeholder"
            class="w-100"
            required
        >
        </el-date-picker>
    </div>
</template>

<script>
export default {
    props: [
        "name",
        "id",
        "value",
        "format",
        "valueFormat",
        "placeholder",
    ],

    data() {
        return {
            selected: this.value ? this.value : ""
        };
    },

    methods: {
        setSelected(value) {
            this.$emit("onSelected", result);
        }
    }
};
</script>