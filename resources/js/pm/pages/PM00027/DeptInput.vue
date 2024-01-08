<template>
    <div>
        <h1>xxxx</h1>
    </div>
</template>
<script>

// import {
//     instance as http
// } from "../httpClient";
// import {
//     $route
// } from '../../router'



// function searchDept(query) {
//     let params = {
//         label: query,
//         action: 'get-dept'
//     }
//     return http.get($route('pm.sample-cigarettes.index'), { params })
// }

export default {
    data() {
        return {
            // isInRange,
            // jsDateToString,
            // toJSDate,
            // linesHeader: [
            //     "รหัสหน่วยงาน", "ชื่อหน่วยงาน", "รหัสสินค้า", "รายละเอียด", "จำนวน", "หน่วยนับ",
            // ],
            // // mode: this.line_id ? 'update' : 'create',
            // sampleproducts: this.init_lines,
            // date: this.p_date,
            // sampleproducts: this.init_lines.map(line => ({
            //     ...sampleproducts,
            //     newRecord: false
            // })),
            // lineTableModel: {}
        }
    },
    props: {
        // line_id: null,
        // init_lines: {
        //     type: Object,
        //     //default: []
        // },
        // // sampleproducts: {
        // //     type: Object,
        // // },
        // user: {
        //     type: Object
        // },
        // p_date: {
        //     type: String,
        // }
        // organization_id: {
        //     type: String,
        // },
    },
    methods: {
        getDeptList(query) {
            let vm = this;
            let deptData = [];
            searchDept(query).then(({data}) => {
                console.log('getDeptList', query, data);
                deptData = data
            }).catch(err => {
            })
            return deptData;
        },

    },

};

</script>
