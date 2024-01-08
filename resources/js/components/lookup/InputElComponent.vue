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
        <el-input class="w-100" v-model="data_value" :name="this.dataName" :placeholder="this.text_detail" :disabled="this.data_disabled" @input="checkNumber()"></el-input>
        <!-- <el-input class="w-100" placeholder="{{ $text }}" name="{{ $programColumn->column_name }}" value="{{ old($programColumn->column_name, $lookup->getOriginal((strtolower($programColumn->column_name)))) }}" {{ $programColumn->column_name == 'LOOKUP_CODE' && $lookup->lookup_code ? 'disabled' : ''}}></el-input> -->

    </div>
</template>
<script>
export default {
    props: ['dataName', 'defaultValue', 'textDetail', 'lookupCode', 'inputType', 'programCode', 'old'],
    data() {
        return {
            data_value:    this.old ? this.old : this.defaultValue ? this.defaultValue : '',
            text_detail:   this.textDetail   ? this.textDetail   : '',
            data_disabled: this.lookupCode   ? true              : false,
            input_type:    this.inputType    ? this.inputType   : '',
        };
    },
    mounted() {
        console.log('defaultValue <---> ' + this.defaultValue);
        console.log('dataName <---> ' + this.dataName);
        console.log('lookupCode <---> ' + this.lookupCode);
    },
    methods: {
        async checkNumber() {
            if (this.input_type) {
                this.data_value = this.data_value.replace(/[^0-9 .]/g, '');
            }


            if (this.programCode === 'PPS0009') {
                if (this.dataName === 'ATTRIBUTE2' || this.dataName === 'ATTRIBUTE3') {
                    this.data_value = Math.ceil(this.data_value);
                }
            }

        },
    },
}
</script>