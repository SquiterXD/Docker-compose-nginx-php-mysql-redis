<template>
    <div>
        <el-select
            v-model="car_license_plate"
            filterable
            remote
            :debounce="2000"
            :remote-method="getCarInfos"
            placeholder="ทะเบียนรถ"
            :loading="loadingInput.carInfos"
            style="width: 100%"
            >
            <el-option
                v-for="(item, index) in carInfos"
                :key="index"
                :label="item.car_license_plate"
                :value="item.car_license_plate"
            >
            </el-option>
        </el-select>
        <input type="hidden" :name="name" :value="car_license_plate">
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            default: 'car_license_plate'
        },
        default: {
            type: String,
        },
    },
    data() {
        return {
            carInfos: [],
            car_license_plate: this.default,

            loadingInput: {
                carInfos: false,
            }
        }
    },

    created: function () {
        this.getMasterData();
    },

    methods: {
        getMasterData() {
            this.getCarInfos(this.car_license_plate);
        },
        
        getCarInfos(query) {
            this.loadingInput.carInfos = true;
            axios
                .get("/inv/ajax/car_info", {
                    params: { text: query, organization_code: "A32" },
                })
                .then((response) => {
                    this.carInfos = response.data;
                })
                .catch((err) => {
                    console.log("error get car info");
                })
                .then(() => {
                    this.loadingInput.carInfos = false;
                });
        },
    }
}
</script>