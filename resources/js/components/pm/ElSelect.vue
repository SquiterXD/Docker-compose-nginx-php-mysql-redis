<template>
    <div>
        <input
            type="hidden"
            v-model="selected"
            :name="name"
            :id="id ? id : null"
        />
        <el-select
            v-model="selected"
            :placeholder="placeholder ? placeholder : null"
            class="w-100"
            :size="size ? size : 'medium'"
            :clearable="clearable ? true : false"
            :filterable="filterable ? true : false"
            @change="setSelected"
        >
            <el-option
                v-for="item in selectOptions"
                :key="item[optionKey]"
                :label="item[optionLabel]"
                :value="item[optionValue]"
            >
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        "name",
        "id",
        "selectOptions",
        "placeholder",
        "size",
        "clearable",
        "filterable",
        "value",
        "optionKey",
        "optionValue",
        "optionLabel",
    ],

    watch: {
        value: function (v) {
            this.selected = v;
        },
    },

    data() {
        return {
            selected: this.value ? this.value : ""
        };
    },

    methods: {
        setSelected(value) {
            this.$emit("onSelected", value);
        }
    }
};
</script>
