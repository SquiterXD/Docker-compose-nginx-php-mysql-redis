<template>
    <div class="el_select">
        <el-select v-model="value"
                    :placeholder="placeholder"
                    :name="attrName"
                    :remote-method="getDataRows"
                    :loading="loading"
                    remote
                    :clearable="true"
                    filterable
                    style="width: 100%"
                    @change="onChange">
            <el-option v-for="(data, index) in dataRows"
                    :key="index"
                    :label="data.ar_invoice_num"
                    :value="data.ar_invoice_num">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'attrName', 'setData', 'placeholder'
    ],
    data () {
        return {
            dataRows: [],
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
    },
    methods: {
        getDataRows (query) {
            this.loading = true;
            axios.get(`/ir/ajax/lov/ar-invoice-num`, {
                params: {
                    keyword: query,
                }
            })
            .then(({data}) => {
                let response = data.data
                this.dataRows = response;
                this.loading = false;
            })
            .catch((error) => {
                swal('มีข้อผิดพลาด', error, 'error')
            })
        },
        onChange (value) {
            this.$emit('change-value', {invoice_no: value})
        },
    },
}
</script>
