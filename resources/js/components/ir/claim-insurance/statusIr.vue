<template>
    <div class="el_field">
        <el-select  v-model="result"
                    placeholder="สถานะ"
                    :name="name"
                    :clearable="true"
                    @change="change"
                    :size="size"
                    :popper-append-to-body="popperBody"
                    :disabled="disabled">
            <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.description"
                    :value="data.lookup_code">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'value', 'name', 'size', 'popperBody', 'disabled', 'profile'
    ],
    data() {
        return {
          rows: [],
          loading: false,
          result: this.value
        };
    },
    created () {
        this.getDataRows()
    },
    watch: {
        'value' (newVal, oldVal) {
          this.result = newVal
        }
    },
    methods: {
        getDataRows() {
            axios.get(`/ir/ajax/lov/status`)
            .then(({data}) => {
                if (this.profile.program_code == 'IRP0010') {
                    this.rows = data.filter(item => {
                        return item.lookup_code != 'PENDING' && item.lookup_code != 'INTERFACE';
                    });
                }else{
                    this.rows = data.filter(item => {
                        return item.lookup_code != 'PENDING';
                    });
                }
            })
            .catch((error) => {
                swal("Error", error, "error");
            })
        },
        change (value) {
            this.$emit('change-lov', value)
        },
    },
};
</script>

