<template>
    <div>
        <el-select v-model="value"
                    :placeholder="placeholder"
                    :name="attrName"
                    :remote-method="getDataRows"
                    :loading="loading"
                    clearable
                    remote
                    filterable
                    @change="onChange"
                    style="width: 100%">
            <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.document_number"
                    :value="data.document_number">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'placeholder', 'attrName', 'setData'
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
    },
    methods: {
        getDataRows (query) {
            this.loading = true;
            axios.get(`/ir/ajax/lov/irp-document-number`, {
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
            this.$emit('change-value', {document_no: value});
        },
    },
}
</script>