<template>
    <div>
        <!-- <input type="hidden" :name="this.dataName" :value="data_value" autocomplete="off">
        <el-select  class="w-100"
                    v-model="data_value"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >              
            <el-option  v-for="list in this.dataLists"
                        :key="list.value"
                        :label="list.label"
                        :value="list.value">
            </el-option>
        </el-select> -->

        <input type="hidden" :name="this.dataName" :value="data_value" autocomplete="off">
        <el-select v-if="programColumn.remote_search !== null" class="w-100"
                    v-model="data_value"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    :remote-method="getDataList"
                    >              
            <el-option  v-for="list in sortArrays(this.data_Lists)"
                        :key="list.value"
                        :label="list.label"
                        :value="list.value">
            </el-option>
        </el-select>
        <el-select v-else class="w-100"
                    v-model="data_value"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    @change="handleChange"
                    >              
            <el-option  v-for="list in sortArrays(this.data_Lists)"
                        :key="list.value"
                        :label="list.label"
                        :value="list.value">
            </el-option>
        </el-select>
    

    </div>
</template>
<script>
export default {
    props: ['dataName', 'dataLists', 'defaultValue', 'old', 'programCode', 'programColumn'],
    data() {
        return {
            data_value: this.old ? this.old : this.defaultValue ? this.defaultValue : '',
            remote_flag: false,
            // data_Lists: this.dataLists,
            data_Lists: [],
        };
    },
    async mounted(){
        console.log(this.programColumn.remote_search, '<================== this.programColumn.remote_search')
        await this.getDataList();
        console.log(this.programColumn.remote_search)
        
    },
    methods: {
        async handleChange() {
            if((this.programCode === 'PMS0014' || this.programCode === 'EMS0003')  && this.programColumn.column_name === 'ATTRIBUTE2') {
                _.each(this.$parent.$children, async (el, k) => {
                    if(el.dataName == 'ATTRIBUTE1') {
                        console.log(this.$parent.$children[k])
                        this.$parent.$children[k].$data.data_Lists = []
                        this.$parent.$children[k].$data.data_value = ''
                        setTimeout(() => {
                            this.$parent.$children[k].getDataList()
                        }, 1000);
                    }
                })
            }
        },
        async getDataList(query) {
            // if (this.programColumn.remote_search) {
                let data_vaue = '';
                if((this.programCode === 'PMS0014' || this.programCode === 'EMS0003')  && this.programColumn.column_name === 'ATTRIBUTE1') {
                    data_vaue = $('input[name="ATTRIBUTE2"]').val()
                }else {
                    data_vaue = this.data_value
                }
                await axios.get("/lookup/search", {
                    params: {
                        program_code: this.programCode,
                        program_column: this.dataName,
                        search: query,
                        id: data_vaue,
                    }
                })
                .then(res => {
                    Vue.set(this, 'data_Lists', res.data)
                })
                .catch(err => {
                    console.log(err)
                });
            // }
        },

        sortArrays(arrays) {
            return _.orderBy(arrays, 'label', 'asc');
        },
    },
}
</script>