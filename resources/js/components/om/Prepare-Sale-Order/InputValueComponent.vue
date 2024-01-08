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
            @change="changeInput"
            class="w-100 el-select-input-segment"
            style="width: 100%;"
            ref="input"
        >
            <el-option
                v-for="(item, key) in options"
                :key="key"
                :label="item.flex_value"
                :value="item.flex_value"
            >
            <!-- <el-option v-else
                v-for="(item, key) in options"
                :key="key"
                :label="item.flex_value"
                :value="item.flex_value"
            > -->
            <!-- <span v-if="setName == 'customer'" style="float: left">{{ item.flex_value }}</span>
            <span v-if="setName == 'customer'" style="float: right; color: #8492a6;"> {{ item.customer_name }}</span> -->
            </el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props: ['setName', 'setData', 'placeholder', 'setOptions', 'url', 'type', 'dependCust'],
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
        this.changeInput();
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
            await axios.get(this.url, {
                params: {
                    type: this.type,
                    set_data: this.value,
                    depend_cust: this.dependCust,
                    query: query,
                }
            })
            .then(res => {
                this.options = res.data;
                this.changeInput();
            })
            .catch(err => {
                console.log(err)
            })
            .then( () => {
                this.loading = false;
            });
        },
        changeInput() {
            if (this.setName == 'period') {
                let period_id = '';
                this.options.find((period) =>{
                    if (period.flex_value == this.value) {
                        period_id = period.flex_id;
                    }
                });
                this.$emit("def", {name: this.setName, value: this.value, value_id: period_id, options: this.options});
            }
            if (this.setName == 'pi') {
                let pi_id = '';
                this.options.find((pi) =>{
                    if (pi.flex_value == this.value) {
                        pi_id = pi.order_header_id;
                    }
                });
                this.$emit("def", {name: this.setName, value: this.value, value_id: pi_id, options: this.options});
            }
            if (this.setName == 'invoice') {
                this.$emit("def", {name: this.setName, value: this.value, options: this.options});
            }
            if (this.setName == 'order_type') {
                let order_type_id = '';
                this.options.find((type) =>{
                    if (type.flex_value == this.value) {
                        order_type_id = type.flex_id;
                    }
                });
                this.$emit("def", {name: this.setName, value: this.value, value_id: order_type_id, options: this.options});
            }
            if (this.setName == 'so') {
                this.$emit("def", {name: this.setName, value: this.value, options: this.options});
            }
            if (this.setName == 'prepare_so') {
                this.$emit("def", {name: this.setName, value: this.value, options: this.options});
            }
            if (this.setName == 'sa') {
                this.$emit("def", {name: this.setName, value: this.value, options: this.options});
            }
        }
    }
};
</script>