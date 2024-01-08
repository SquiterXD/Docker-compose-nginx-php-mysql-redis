<template>
    <div>
        <el-select  v-model="value"
                    :placeholder="placeholder"
                    :name="attrName"
                    :remote-method="getDataRows"
                    :loading="loading"
                    remote
                    clearable
                    filterable
                    @change="onChange"
                    style="width: 100%"
                    ref="location_code">
            <el-option v-for="(data, index) in rows"
                    :key="index"
                    :label="data.meaning + ': ' + data.description"
                    :value="data.meaning">
            </el-option>
        </el-select>
    </div>
</template>

<script>
    export default {
        props: [
            'placeholder', 'attrName', 'setData', 'errors'
        ],
        data () {
            return {
                rows: [],
                loading: false,
                value: ''
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
                     
                    val.location_code? this.setError('location_code') : this.resetError('location_code');
                },
                deep: true,
            },
        },
        methods: {
            getDataRows (query) {
                this.loading = true;
                axios.get(`/ir/ajax/lov/location`, {
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
            onChange () {
                this.$emit('selLocation', {location_code: this.value})
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
