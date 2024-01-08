<template>
    <div>

    </div>
</template>

<script>
import axios from 'axios';
export default {
    components:{

    },

    props:[
        'program-code',
        'programs',
        'url-get-infos',
        'module'
    ],
    data() {
        return {
            
        };
    },

    mounted(){

    },

    methods:{
        getInfo(query){
            var request = {
                params: {
                    module: [this.module],
                    uQuery: query
                    
                }
            }
            axios.get(this.urlGerParam, request)
            .then((res) => {
                // this.infos = res.data.ptirReportInfos;
                this.programs = res.data.programs;
            })
            .then(() =>{
                // this.list = this.infos.map(item => {
                //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                // });
                this.remote(query);
            })
            .catch((error) => {
                // swal("Error", error, "error");
            })
        }
    },

};
</script>
