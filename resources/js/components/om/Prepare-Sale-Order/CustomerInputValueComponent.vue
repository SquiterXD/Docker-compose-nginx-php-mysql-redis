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
                :label="item.flex_value+' : '+item.customer_name"
                :value="item.flex_value"
            >
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
            if (this.setName == 'customer') {
                let cust_id = '';
                let cust_name = '';
                this.options.find((cust) =>{
                    if (cust.flex_value == this.value) {
                        cust_id = cust.flex_id;
                        cust_name = cust.customer_name;
                    }
                });
                this.$emit("def", {name: this.setName, value: this.value, value_id: cust_id, value_name: cust_name, options: this.options});
            }
        }
    }
};
</script>