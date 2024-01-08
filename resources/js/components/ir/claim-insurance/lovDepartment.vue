<template>
    <div>
        <el-select v-model="value"
                    :placeholder="placeholder"
                    :remote-method="getDataRows"
                    :loading="loading"
                    remote
                    clearable
                    filterable
                    @change="onChange"
                    :disabled="disabled"
                    style="width: 100%"
                    ref="department_code">
            <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.department_code + ': ' + data.description"
                    :value="data.department_code">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'placeholder', 'attrName', 'setData', 'disabled'
    ],
    data () {
        return {
            rows: [],
            loading: false,
            value: '',
        }
    },
    mounted() {
        this.value = this.setData;
        this.getDataRows(this.value);
    },
    watch: {
        setData() {
            this.value = this.setData;
            this.getDataRows(this.value);
        },
        errors: {
            handler(val){
                 
                val.department_code? this.setError('department_code') : this.resetError('department_code');
            },
            deep: true,
        },
    },
    methods: {
        getDataRows (query) {
            this.loading = true;
            axios.get(`/ir/ajax/lov/department-code`, {
                params: {
                    keyword: query,
                }
            })
            .then(({data}) => {
                let response = data.data
                this.rows = response;
                this.loading = false;
            })
            .catch((error) => {
                swal("มีข้อผิดพลาด", error, "error");
            })
        },
        onChange (value) {
            this.$emit('change-lov', {department_code: value})
        },
        setError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference
                    ? this.$refs[ref_name].$refs.reference.$refs.input
                    : (this.$refs[ref_name].$refs.textarea
                        ? this.$refs[ref_name].$refs.textarea
                        : (this.$refs[ref_name].$refs.input.$refs
                            ? this.$refs[ref_name].$refs.input.$refs.input
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "border: 1px solid red;";
        },
        resetError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference
                    ? this.$refs[ref_name].$refs.reference.$refs.input
                    : (this.$refs[ref_name].$refs.textarea
                        ? this.$refs[ref_name].$refs.textarea
                        : (this.$refs[ref_name].$refs.input.$refs
                            ? this.$refs[ref_name].$refs.input.$refs.input
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "";
        },
    },
}
</script>