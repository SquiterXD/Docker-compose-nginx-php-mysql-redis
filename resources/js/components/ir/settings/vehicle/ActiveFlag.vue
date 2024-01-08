<template>
    <div>
        <div class="form-check" style="position: inherit;">
            <input  class="form-check-input" 
                type="checkbox"
                v-model="active_flag"
                @change="changeActive(active_flag)"
                style="position: inherit;"
                :disabled="vehicle.sold_flag == 'Y'">
        </div>
    </div>
</template>
<script>
export default {
    props: ['vehicle'],

    data() {
        return {
            active_flag: this.vehicle.active_flag == 'Y' ? true : false,
        }
    },
     methods: {
        async changeActive(flag){
             
            var params = {
                vehicle_id:   this.vehicle.vehicle_id,
                asset_id:     this.vehicle.asset_id,
                vehicle:      this.vehicle,
                active_flag:  flag ? 'Y' : 'N' || flag ? 'N' : 'Y',
                program_code: 'IRM0007',
            };
            return await axios
            .get('/ir/ajax/vehicles/update-flag',{ params })
            .then(res => {
                 
                 
                
                if(res.data.status == '200'){
                    swal({
                        title: "Success !",
                        text: "บันทึกสำเร็จ",
                        type: "success",
                        showConfirmButton: true
                    });
                }
                else{
                    swal({
                        title: "Error !",
                        text: "ทำรายการไม่สำเร็จ",
                        type: "error",
                        showConfirmButton: true
                    });
                    this.active_flag = true;
                }
            });
        },
    },
}
</script>