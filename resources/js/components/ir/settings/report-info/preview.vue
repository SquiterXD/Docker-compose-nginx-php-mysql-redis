<template>
    <div  class="form-group">
        <div v-if="info.form_type == 'text'"  class="row m-2">
            <div class="m-1 col-3 text-right">
                <div>{{ info.display_value }}</div>
            </div>
            <div class="col-6">
                <el-input
                    :name="info.attribute_name"
                    v-model="info.default_value"
                   ></el-input>
            </div>
        </div>
        <!-- <div v-if="info.form_type == 'text'" >
            <div class="m-1 col-3 text-right">
                    <div>{{ info.display_value }}</div>
                </div>
                <input type="text" :name="info.attribute_name" class="form-control w-100">
        </div> -->

            <div v-if="info.form_type == 'date'" class="row m-2">
                <div class="m-1 col-3 text-right">
                    <div>
                        {{ info.display_value }}
                    </div>
                </div>
                <div class="col-6">
                    <datepicker-th
                    v-model="info.default_value"
                        placeholder="เลือกวัน"
                        style="width: 100%; border-radius:3px;"
                        class="form-control col-lg-12"
                        :name="info.attribute_name"
                        id="input_date"
                        :pType="info.date_type"
                        @dateWasSelected="getYear"
                    />
                </div>
            </div>
            <div v-if="info.form_type == 'select'" class="row m-2">
                <div class="m-1 col-3 text-right">
                    <div>{{ info.display_value }}</div>
                </div>
                <div class="col-6">
                    <el-select v-model="info.default_value" filterable clearable
                        :name="info.attribute_name"
                        :popper-append-to-body='false'

                        class="w-100 text-left"
                    >
                        <el-option
                        v-for="list in info.lists"
                        :key="list.value"
                        :label="list.label"
                        :value="list.value">
                        </el-option>
                    </el-select>
                    <!-- <select class="form-control w-100" :name="info.attribute_name">
                        <option
                            v-for="list in info.lists"
                            :value="list.value"
                            :key="list.value"
                            >{{ list.label }}
                        </option>
                    </select> -->
                </div>
                <button class="btn btn-primary btn-xs col-2"> Save </button>
            </div>
    </div>
</template>

<script>
export default {
    // name: "settings-report-info",
    props: ["program", "infos", "list-form-types", "info", "url", "method-url"],
    data() {
        return {

        };
    },

    components: {},
    mounted(){
         
    },
    methods: {
        modalOpen() {
             

        },
        checkForm: function (e) {

        },

        updateForm(){

        },
        getYear(value){
             
        },
    },
    watch:{

    }
    // computed:{
    //     update
    // }
};
</script>
