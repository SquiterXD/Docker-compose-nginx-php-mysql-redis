<template>
    <div>
        <div class="form-check" style="position: inherit;">
            <input  class="form-check-input" 
                type="checkbox"
                v-model="return_vat_flag"
                @change="changeChecked(gasStation, return_vat_flag)"
                style="position: inherit;">
        </div>
    </div>
</template>
<script>
export default {
    props: ['gasStation'],

    data() {
        return {
            return_vat_flag: this.gasStation.return_vat_flag == 'Y' ? true : false,
        }
    },
    methods: {
        changeChecked (dataRow, flag) {
            let _this = this;
            let data = {
                ...dataRow,
                return_vat_flag: flag ? 'Y' : 'N'
            }
            axios.put(`/ir/ajax/gas-stations/return-vat-flag`, { data })
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

                    _this.return_vat_flag = _this.gasStation.return_vat_flag;
                } else {
                    swal("Error", error, "error");
                }
            })
        }
    },
}
</script>