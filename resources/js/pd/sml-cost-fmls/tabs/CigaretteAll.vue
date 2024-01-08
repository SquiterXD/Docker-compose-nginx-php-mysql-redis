<template>
    <div v-loading="loading.page">
       <div v-html="cigaretteAll._set1_all_tab"></div>
    </div>
</template>

<script>


export default {
    // components: {
    //     LeafIngredient
    // },
    props:[
        // "header", 'url', 'transBtn', 'transDate', 'data', 'cigaretteAll', 'cigarDtl', "tabs"
        "header", 'url', 'transBtn', 'transDate', 'cigaretteAll', "tabs"
    ],
    computed: {
    },
    watch:{
        cigaretteAll : async function (value, oldValue) {
            let vm = this;
            vm.lines = value;
        },
    },
    data() {
        return {
            loading: {
                page: false,
                leaf_formula: false,
            },
            lines: [],
        }
    },
    mounted() {
        console.log('Cigarette All: Component mounted.')
    },
    methods: {
    }
}
</script>

<style scoped>

</style>