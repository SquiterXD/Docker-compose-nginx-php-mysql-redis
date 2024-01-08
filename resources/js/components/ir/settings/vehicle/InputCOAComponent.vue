<template>
    <div>
        <el-select
            v-model="value"
            filterable
            remote
            clearable 
            reserve-keyword
            placeholder="Please enter a value"
            :remote-method="getValueSetList"
            :loading="loading"
            size="small"
            @change="changeCoa"
            class="w-100 el-select-input-segment"
            style="width: 100%;"
            ref="input"
        >
            <el-option
                v-for="(item, key) in options"
                :key="key"
                :label="item.flex_value + ' : ' + item.description"
                :value="item.flex_value"
            ></el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props: ['setName', 'setData', 'setParent', 'error', 'defaultValueSetName', 'setOptions'],
    // , "setOptions"
    data() {
        return {
            options: [],
            value: '',
            loading: false
        };
    },
    mounted() {
        this.value = this.setData;
        this.getValueSetList(this.value);
        this.changeCoa();
    },
    watch: {
        setData() {
            this.value = this.setData;
            this.getValueSetList(this.value);
            this.options = this.setOptions;
        },
        error() {
            let ref = this.$refs['input'].$refs.reference.$refs.input;
            ref.style = "";
            if(this.error && (this.value === '' || this.value === null)){
                ref.style = "border: 1px solid red;";
            }
        },
    },
    methods: {
        async getValueSetList(query) {
            // this.loading = true;
            await axios.get("/ir/ajax/vehicles/get-coa", {
                params: {
                    flex_value_set_name: this.setName,
                    flex_value_set_data: this.value,
                    flex_value_parent: this.setParent,
                    query: query,
                }
            })
            .then(res => {
                this.options = res.data;
            })
            .catch(err => {
                 
            })
            .then( () => {
                this.loading = false;
            });
        },
        changeCoa() {
            if (this.setName == this.defaultValueSetName.segment1) {
                this.$emit("coa", {name: this.setName, segment1: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment2) {
                this.$emit("coa", {name: this.setName, segment2: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment3) {
                this.$emit("coa", {name: this.setName, segment3: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment4) {
                this.$emit("coa", {name: this.setName, segment4: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment5) {
                this.$emit("coa", {name: this.setName, segment5: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment6) {
                this.$emit("coa", {name: this.setName, segment6: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment7) {
                this.$emit("coa", {name: this.setName, segment7: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment8) {
                this.$emit("coa", {name: this.setName, segment8: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment9) {
                this.$emit("coa", {name: this.setName, segment9: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment10) {
                this.$emit("coa", {name: this.setName, segment10: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment11) {
                this.$emit("coa", {name: this.setName, segment11: this.value});
            }
            if (this.setName == this.defaultValueSetName.segment12) {
                this.$emit("coa", {name: this.setName, segment12: this.value});
            }
        }
    }
};
</script>

<style type="text/css" scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }
    /*.el-select-input-segment {
        border: 1px solid #DCDFE6;
        border-radius: 5px;
    }*/
</style>