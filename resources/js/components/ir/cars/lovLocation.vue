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
            size="small"
            @change="changeInput(), getValueSetList()"
            style="width: 100%;"
            :disabled="disabled"
        >
            <el-option
                v-for="(item, key) in options"
                :key="key"
                :label="item.meaning"
                :value="item.meaning"
            >
                <span style="float: left">{{ item.meaning }}</span>
                <span style="float: left; color: #8492a6;"> : {{ item.description }}</span>
            </el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props: ['setName', 'setData', 'placeholder', 'disabled'],
    data() {
        return {
            options: [],
            value: '',
            loading: false
        };
    },
    mounted() {
        this.value = this.setData;
        // this.getValueSetList(this.value);
        // this.changeInput();
    },
    watch: {
        setData() {
            this.value = this.setData;
            this.getValueSetList(this.value);
            this.options = this.setOptions;
        },
        setOptions: async function (newValue) {
            this.options = newValue;
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
                this.changeInput();
                // this.$emit("getLocation", {name: this.setName, value: this.value, value_code: location_code, value_name: location_desc});
            })
            .catch(err => {
                 
            })
            .then( () => {
                this.loading = false;
            });
        },
        changeInput() {
            let location_code = '';
            let location_desc = '';
            if (this.value) {
                this.options.find((val) =>{
                    if (val.meaning == this.value) {
                        location_code = val.meaning;
                        location_desc = val.description;
                    }
                });
            } else {
                this.options.find((val) =>{
                    if (val.meaning == this.value) {
                        location_code = val.meaning;
                        location_desc = val.description;
                    }
                });
            }
            // let location_code = this.value ? this.value : '';
            // let location_desc = '';
            // this.options.find((val) =>{
            //     if (val.meaning == this.value) {
            //         location_code = val.meaning;
            //         location_desc = val.description;
            //     }
            // });
            this.$emit("getLocation", {name: this.setName, value: this.value, value_code: location_code, value_name: location_desc});
        }
    }
};
</script>