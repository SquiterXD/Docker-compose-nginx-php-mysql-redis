<template>
    <div id="input-count">
        <input
            type="text"
            class="form-control"
            v-on:input="dispatchInput"
            v-on:change="onChange"
            v-bind:value="theMessage"
            :visible="isVisible"
            :maxlength="maxlength" />
        <div class="count-number">{{ totalInput}} / {{maxlength}}</div>
    </div>
</template>

<script>
export default{
    model: {
        prop: 'model',
        event: 'input',
    },
    computed: {
        isVisible(){
            this.theMessage = this.model
            this.totalInput = this.theMessage ? this.theMessage.length : 0;
            return this.model !== null
        },
    },
    data() {
        return {
            limitMaxCount: this.maxlength,
            theMessage: null,
            totalInput: 0,
        };
    },
    props:{
        model: {type: String},
        maxlength: {type: Number},
    },
    methods: {
        onChange(item){
            console.debug('onChange',item);
            this.$emit('change', this.theMessage);
        },
        dispatchInput(item) {
            console.debug('dispatchInput', item);
            this.theMessage = item.target.value;
            this.totalInput =   this.theMessage ? this.theMessage.length : 0;

            this.$emit('input', this.theMessage);
        },
    },
}
</script>

<style>
#input-count .count-number {
    text-align: right;
    margin-top: -20px;
    position: relative;
    padding-right: 15px;
    font-size: smaller;
    width: 100px;
    float: right;
}
</style>
