<template>
    <div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> ทวีป <span class="text-danger">*</span></label>
                <el-select filterable remote reserve-keyword clearable class="w-100" name="continent_name" v-model="selectContinentName">
                    <el-option v-for="continent in continents"
                                :key="continent.value"
                                :label="continent.meaning"
                                :value="continent.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> ประเทศ <span class="text-danger">*</span></label>
                <input type="hidden" :value="selectCountry" name="country_code">
                <el-select filterable remote reserve-keyword clearable class="w-100" v-model="selectCountry">
                    <el-option v-for="allCountry in allCountries"
                                :key="allCountry.country_code"
                                :label="allCountry.country_name"
                                :value="allCountry.country_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> Status <span class="text-danger">*</span></label>
                <el-select class="w-100" name="status" v-model="selectStatus">
                    <el-option v-for="item in statusData"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value">
                    </el-option>
                </el-select>
            </div>
        </div>
    </div>
        
</template>

<script>

import Select from 'element-ui';


export default {
    props: ['old', 'continents', 'allCountries', 'defaultValue'],
    data(){
        return {
            selectContinentName:  this.defaultValue ? this.defaultValue.continent_name   : '',
            selectCountry:        this.defaultValue ? this.defaultValue.country_code     : '',
            selectStatus:         this.defaultValue ? this.defaultValue.status           : 'Active',

            geographies: [],

            statusData: [{
                value: 'Active',
                label: 'Active'
            }, {
                value: 'Inactive',
                label: 'Inactive'
            }],
        }
    },
    mounted() {
        // this.getGeographies();
        // if (this.defaultValue) {
        //     console.log('333');
        //     this.getGeographies().then(() => {
        //         this.selectGeographyName = this.defaultValue.country_name || "";
        //     });
        // } 
    },
    methods: {
    //     findSelected() {
    //         console.log(this.selectGeographyName);
    //         // this.contryCode = '3333';
    //         // console.log(this.selectGeographyName.geography_id);
    //         let geographySelect = this.hzGeographies.find(hzGeography => {
    //             console.log(this.hzGeography);
    //             return hzGeography.geography_id == this.selectGeographyName;
    //         });

    //         // this.contryCode = this.geographySelect.geography_code;

    //         console.log('xxx');
    //         console.log(this.geographySelect);
    //     },

        // getGeographies() {
        //     this.selectGeographyName = '';
        //     // this.item_category_id = [];
        //     this.geographies = [];

   
        //     axios.get(`/om/ajax/geographies`).then(res => {
        //         this.geographies = res.data.data.geographies;
        //     });
        // },

        // getGeographies() {
        //     this.selectGeographyName = "";
        //     this.geographies = [];
        //     this.defaultValue.reason_id = "";


        //     return axios
        //     .get(`/om/ajax/geographies`)
        //     .then(res => {
        //         this.geographies = res.data.data.geographies;
        //     });
        // },

        // getSelectedGeographyName() {
        //     this.selectGeographyName= this.geographies.find(i => {
        //         return i.geography_name == this.defaultValue.geography_name;
        //     });
        // },
    }
}
</script>
