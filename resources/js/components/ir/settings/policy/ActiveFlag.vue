<template>
    <div>
        <div class="form-check" style="position: inherit;">
            <input  class="form-check-input" 
                type="checkbox"
                v-model="active_flag"
                @change="changeChecked(policy, active_flag)"
                style="position: inherit;">
        </div>
    </div>
</template>
<script>
export default {
    props: ['policy'],

    data() {
        return {
            active_flag: this.policy.active_flag == 'Y' ? true : false,
        }
    },
     methods: {
        changeChecked (dataRow, flag) {
            let _this = this;
            let data = {
                ...dataRow,
                active_flag: flag ? 'Y' : 'N'
            }
            axios.put(`/ir/ajax/policy/active-flag`, { data })
            .then(({data}) => {
                swal({
                title: "Success",
                text: data.message,
                type: "success",
                })
            })
            .catch((error) => {
                if (error.response.data.status === 400) {
                    swal({
                        title: "Warning",
                        text: error.response.data.message,
                        type: "warning",
                    });

                    _this.active_flag = _this.policy.active_flag;
                } else {
                    swal("Error", error, "error");
                }
            })
        }
    },
}
</script>