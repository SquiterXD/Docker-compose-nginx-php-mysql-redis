<template>
    <div class="el_select">
        <el-select  v-model="result"
                    :placeholder="placeholder"
                    :name="name"
                    :remote-method="remoteMethod"
                    :loading="loading"
                    remote
                    :clearable="true"
                    @focus="focus"
                    filterable
                    @change="change"
                    :popper-append-to-body="popperBody"
                    :size="size">
            <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.document_number"
                    :value="data.claim_header_id">
            </el-option>
        </el-select>
    </div>
</template>

<script>
export default {
    props: [
        'name', 'value', 'placeholder', 'popperBody', 'size'
    ],
    data () {
        return {
            rows: [],
            loading: false,
            result: this.value
        }
    },
    mounted() {
        this.gatDataRows({ keyword: '' });
    },
    watch: {
        'value' (newVal, oldVal) {
          this.result = newVal
        }
    },
    methods: {
        remoteMethod (query) {
            this.gatDataRows({
                keyword: query
            });
        },
        gatDataRows (params) {
            this.loading = true;
            axios.get(`/ir/ajax/lov/ar-document-number`, { params })
            .then((res) => {
                let data = res.data.data
                 
                this.loading = false;
                this.rows = data.filter(claim => {
                    return claim.irp0011_status == 'CONFIRMED' || claim.irp0011_status == 'INTERFACE';
                });
            })
            .catch((error) => {
                swal('Error', error, 'error')
            })
        },
        focus (event) {
            this.gatDataRows({
                keyword: ''
            });
        },
        change (value) {
            let status = '';
            this.rows.filter(claim => {
                if (claim.claim_header_id == value) {
                  status = claim.status;
                }
            });
            this.$emit('change-lov', {value: value, status:status});
        }
    },
}
</script>
