<template>
    <div>
        <el-select
            v-model="value"
            filterable
            remote
            clearable 
            reserve-keyword
            :placeholder="placeholder"
            :remote-method="getValueSetList"
            :loading="loading"
            size="large"
            @change="changeLookup"
            style="width: 100%;"
        >
            <el-option
                v-for="(item, key) in options"
                :key="key"
                :label="item.meaning"
                :value="item.lookup_code"
            ></el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props: ['setName', 'setData', 'placeholder'],
    data() {
        return {
            options: [],
            value: '',
            loading: false
        };
    },
    mounted() {
        this.value = this.setData;
        this.getValueSetList(this.value);
        this.changeLookup();
    },
    watch: {
        setData() {
            this.value = this.setData;
            this.getValueSetList(this.value);
            this.options = this.setOptions;
        },
    },
    methods: {
        async getValueSetList(query) {
            this.loading = true;
            await axios.get("/ir/ajax/vehicles/getlookupData", {
                params: {
                    flex_value_set_name: this.setName,
                    flex_value_set_data: this.value,
                    query: query,
                }
            })
            .then(res => {
                this.options = res.data;
            })
            .catch(err => {
                 
            })
            .then( () => {
                this.loading = false;
            });
        },
        changeLookup() {
            // if (this.setName == this.defaultValueSetName.segment1) {
            //     this.$emit("selLookup", {name: this.setName, value: this.value});
            // }
            if (this.setName == 'PTIR_RENEW_CAR_ACT') {
                this.$emit("selLookup", {name: this.setName, value: this.value});
            }
            if (this.setName == 'PTIR_RENEW_CAR_LICENSE_PLATE') {
                this.$emit("selLookup", {name: this.setName, value: this.value});
            }
            if (this.setName == 'PTIR_RENEW_CAR_INSPECTION') {
                this.$emit("selLookup", {name: this.setName, value: this.value});
            }
        }
    }
};
</script>