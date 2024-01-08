<template>
    <div>
        <input
            type="hidden"
            v-model="checked"
            :name="name"
            :id="id ? id : null"
        />
        <el-checkbox
            v-model="checked"
            :checked="checked"
            :label="label"
            border
            :class="inputClass"
            :size="size ? size : 'small'"
            :disabled="disabled ? disabled : false"
            @change="onChanged"
        ></el-checkbox>
    </div>
</template>

<script>
export default {
    props: [
        "name",
        "id",
        "label",
        "size",
        "disabled",
        "inputClass",
        "value"
    ],

    watch : {
        value : function (value) {
            this.checked = value;
        }
    },

    data() {
        return {
            checked: this.value
        };
    },

    methods: {
        onChanged(value) {
            this.$emit("change", value);
        }
    }
};
</script>
