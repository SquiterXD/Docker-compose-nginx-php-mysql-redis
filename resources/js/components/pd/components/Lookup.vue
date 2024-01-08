<template>
    <el-select
        v-model="value"
        :name="name"
        filterable
        remote
        :remote-method="remoteMethod"
        :loading="loading"
        @change="onChange">
        <el-option
            v-for="item in options"
            :key="item.label"
            :label="item.label"
            :value="item.value">
        </el-option>
    </el-select>
</template>

<script>
import {query as lookup} from '../lookup'

export default {
    data() {
        return {
            options: [],
            value: [],
            list: [],
            loading: false,
            states: []
        }
    },
    mounted() {
        // this.list = this.states.map(item => {
        //     return {value: `value:${item}`, label: `label:${item}`};
        // });
    },
    created() {
        if(typeof this.selectedKey !== 'undefined' && typeof this.selectedValue !== 'undefined'){
            this.value = {value: this.selectedKey, label: this.selectedValue}
        }
    },
    props: ['table', 'name', 'selectedValue', 'selectedKey'],
    methods: {
        remoteMethod(query) {
            if (query !== '') {
                this.loading = true;
                let field = 'meaning'
                lookup.on(this.table, field)(`%${query}%`).then(({data}) => {
                    //data = data.map(row => row[field])
                    console.log({data})
                    this.loading = false;
                    this.options = data.map(r => {
                        return {value: r.id, label: r.text}
                    })
                })
            } else {
                this.options = [];
            }
        },
        onChange(i) {
            console.log(i, this.valueKey)
            this.$emit('change', i)
        },
    }
}
</script>
