<template>
    <div>
        <input type="hidden" :name="this.name" :value="value" autocomplete="off">
        <el-select
            v-model="value"
            filterable
            remote
            clearable 
            reserve-keyword
            :remote-method="getValueSetList"
            :loading="loading"
            size="small"
            @change="changeCoa"
            class="w-100"
            style="width: 100%;"
        >
            <el-option
                v-for="(item, key) in options"
                :key="item.meaning"
                :label="item.meaning + ' : ' + item.description "
                :value="item.meaning"
            ></el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props: ['setName', 'setData', 'setParent', 'name', 'valueSetName'],
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

        this.getValueSetList();

        this.changeCoa();

        // this.getValueSetList(this.value);

        // console.log('mounted  1 <--> ' + this.setName);
        // console.log('mounted  2 <--> ' + this.valueSetName);
    },
    watch: {
        setData() {
            this.value = this.setData;
            // console.log('mounted  2 <--> ' + this.valueSetName);
            // if (this.setParent) {
            //     this.getValueSetList(this.value);
            // }
            this.getValueSetList(this.value);
            // this.options = this.setOptions;
        }
    },
    methods: {
        async getValueSetList(query) {
            this.loading = true;
            await axios.get("/om/ajax/coa-mapping", {
                params: {
                    flex_value_set_name: this.setName,
                    flex_value_set_data: this.value,
                    flex_value_parent : this.setParent,
                    query: query,
                }
            })
            .then(res => {
                // console.log(res);
                this.options = res.data;
            })
            .catch(err => {
                console.log(err)
            })
            .then( () => {
                this.loading = false;
            });
        },
        changeCoa() {

            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-COMPANY_CODE') {
                this.$emit("coa", {name: this.setName, segment1: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-EVM') {
                this.$emit("coa", {name: this.setName, segment2: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-DEPT_CODE') {
                this.$emit("coa", {name: this.setName, segment3: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-COST_CENTER') {
            // if (this.setName == 'TOAT_GL_ACCT_CODE-COST_CENTER') {
                this.$emit("coa", {name: this.setName, segment4: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-BUDGET_YEAR') {
                this.$emit("coa", {name: this.setName, segment5: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-BUDGET_TYPE') {
                this.$emit("coa", {name: this.setName, segment6: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-BUDGET_DETAIL') {
                this.$emit("coa", {name: this.setName, segment7: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-BUDGET_REASON') {
                this.$emit("coa", {name: this.setName, segment8: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-MAIN_ACCOUNT') {
                this.$emit("coa", {name: this.setName, segment9: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-SUB_ACCOUNT') {
                this.$emit("coa", {name: this.setName, segment10: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-RESERVED1') {
                this.$emit("coa", {name: this.setName, segment11: this.value});
            }
            if (this.setName == this.valueSetName + '_GL_ACCT_CODE-RESERVED2') {
                this.$emit("coa", {name: this.setName, segment12: this.value});
            }
        }
    }
};
</script>

<style type="text/css">
    .el-select-dropdown{
        z-index: 9999 !important;
    }
</style>
