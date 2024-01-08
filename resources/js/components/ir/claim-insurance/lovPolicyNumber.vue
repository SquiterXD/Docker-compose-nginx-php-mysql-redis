<template>
    <div class="el_field">
        <el-select v-model="value"
                    :placeholder="placeholder"
                    :name="attrName"
                    :remote-method="getDataRows"
                    :loading="loading"
                    remote
                    :clearable="true"
                    filterable
                    @change="onChange">
            <el-option v-for="(data, index) in rows"
                    :key="index"
                    :label="data.policy_number"
                    :value="data.policy_number">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'attrName', 'placeholder', 'setData',
    ],
    data() {
        return {
            rows: [],
            loading: false,
            value: '',
        };
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
        getDataRows(query) {
            this.loading = true;
            axios.get(`/ir/ajax/lov/claim-policy-number`, {
                params: {
                    keyword: query,
                }
            })
            .then(({data}) => {
                this.loading = false;
                this.rows = data.data
            })
            .catch((error) => {
                swal("มีข้อผิดพลาด", error, "error");
            })
        },
        onChange (value) {
            this.$emit('change-lov', {policy_number: value})
        },
    },
}
</script>
