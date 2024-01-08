<template>
    <div >
        <el-select
            v-model="value"
            filterable
            remote
            reserve-keyword
            placeholder="Please enter a report "
            :remote-method="remoteMethod"
            class="col-11"
        >
            <el-option
                v-for="item in options"
                :key="item.program_code"
                :label="item.program_code"
                :value="item.program_code"
            >
            </el-option>
        </el-select>
        <button class="btn btn-primary" @click="getInfos">Search </button>
        <!-- <form :action="url.getParam" method="get">
            <hr class="m-3">
            <div v-if="infoAttributes.length > 0" class="form-inline">
                <div v-for="(infoAttribute, index) in infoAttributes" :key="index" class="col-lg-6">
                    <div v-if="infoAttribute.form_type == 'text'" >
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }}</div>
                        </div>
                        <input type="text" :name="infoAttribute.attribute_name" class="form-control w-100">
                    </div>
                    <div v-if="infoAttribute.form_type == 'date'">
                        <div class="m-1 col-3 text-right">
                            <div>
                                {{ infoAttribute.display_value }}
                            </div>
                        </div>
                        <div class="m-1 col-6">
                            <datepicker-th
                                v-model="infoAttribute.attribute_name"
                                    placeholder="เลือกวัน"
                                    style="width: 100%; border-radius:3px;"
                                    class="form-control col-lg-12"
                                    :pType="infoAttribute.date_type"
                                    :name="infoAttribute.attribute_name"
                                    id="input_date"
                                    @dateWasSelected="getYear"
                            />
                        </div>
                    </div>
                    <div v-if="infoAttribute.form_type == 'select'" >
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }}</div>
                        </div>
                        <div class="m-1 col-6">
                            <select class="form-control w-100" :name="infoAttribute.attribute_name">
                                <option
                                    v-for="list in infoAttribute.lists"
                                    :value="list.value"
                                    :key="list.value"
                                    >{{ list.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" :value="value" name="program_code">
                <div class="col-lg-6">
                    <button class="btn btn-primary mt-4" type="submit">Export</button>
                </div>
            </div>
        </form> -->

            <form :action="url.getParam" method="get">
            <hr class="m-3">
            <div v-if="infoAttributes.length > 0" class="form-group">
                <div v-for="(infoAttribute, index) in infoAttributes" :key="index">
                    <div v-if="infoAttribute.form_type == 'text'"  class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }}</div>
                        </div>
                        <div class="col-6">
                            <input type="text" :name="infoAttribute.attribute_name" class="form-control w-100 ">
                        </div>

                    </div>
                    <div v-if="infoAttribute.form_type == 'date'" class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>
                                {{ infoAttribute.display_value }}
                            </div>
                        </div>
                        <div class="col-6">
                            <datepicker-th
                            v-model="infoAttribute.attribute_name"
                                placeholder="เลือกวัน"
                                style="width: 100%; border-radius:3px;"
                                class="form-control col-lg-12"
                                :name="infoAttribute.attribute_name"
                                id="input_date"
                                pType="year"
                                @dateWasSelected="getYear"
                                :format="transDate['js-year-format']"
                            />
                        </div>
                    </div>
                    <div v-if="infoAttribute.form_type == 'select'" class="row m-2">
                        <div class="m-1 col-3 text-right">
                            <div>{{ infoAttribute.display_value }}</div>
                        </div>
                        <div class="col-6">
                            <select class="form-control w-100" :name="infoAttribute.attribute_name">
                                <option
                                    v-for="list in infoAttribute.lists"
                                    :value="list.value"
                                    :key="list.value"
                                    >{{ list.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <input type="hidden" :value="value" name="program_code">
                <div>
                    <button class="btn btn-primary mt-4" type="submit">Export</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: [
        'url',
        'trans-date',
        'trans-btn'
    ],
    data() {
        return {
            options: [],
            value: [],
            list: [],
            loading: false,
            states: [
            ],
            infos:[],
            programs:[],
            infoAttributes:[],
            // urlTest: 'http://offline.test/ir/ajax/ir-report-get-info-attribute?program_code=IRR0001',
        };
    },
    mounted() {
        // console.log('xxx');
        // this.getData();
        // this.getInfos();
    },
    methods: {
        async remoteMethod(query) {
            axios.get(this.url.getInfor+'?query='+query)
            .then((res) => {
                this.infos = res.data.ptirReportInfos;
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

        },

        async remote(query){
            if (query !== "") {
                this.loading = true;
                setTimeout(() => {
                    this.loading = false;
                    this.options = this.programs.filter(item => {
                        return (
                            item.program_code
                                .toLowerCase()
                                .indexOf(query.toLowerCase()) > -1
                        );
                    });
                }, 200);
            } else {
                this.options = [];
            }
        },
        async getData(query){
            axios.get(this.url.getInfor)
            .then((res) => {
                this.infos = res.data.ptirReportInfos;
                this.programs = res.data.programs;

            })
            .then(() =>{
                this.list = this.infos.map(item => {
                    return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                });
            })
            .catch((error) => {
                // swal("Error", error, "error");
            })
        },
        async getInfos(){
            axios.get(
                this.url.getInfoAttribute+
                        '?program_code='+
                            this.value
                // this.urlTest
                        )
                .then((res) => {
                     
                     this.infoAttributes = res.data.reportInfor;
                    // this.programs = res.data.programs;

                })
                .then(() =>{
                    // this.list = this.infos.map(item => {
                    //     return { value: `value:${item.program_code}`, label: `label:${item.program_code}` };
                    // });
                })
                .catch((error) => {
                    // swal("Error", error, "error");
                });
        },
        getYear(value){
             
        },
        exportReport(){

        }
    }
};
</script>
