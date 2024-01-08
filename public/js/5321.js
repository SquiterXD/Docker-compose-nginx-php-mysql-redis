(self.webpackChunk=self.webpackChunk||[]).push([[5321],{7980:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>n});var s=a(7398),i=a.n(s);a(19371),a(30381);const l={props:["sampleNoValue","taskTypes","taskTypeValue","equipmentTypes","equipmentTypeValue","equipments","machineNameValue","listMakers","makerValue","listBrands","brandValue","listBrandCategories","brandCategoryValue","showSampleResultTypes","showTestIdValue","qualityStatuses","qualityStatusValue","resultStatuses","resultStatusValue"],components:{Loading:i()},data:function(){return{sampleNo:this.sampleNoValue,taskType:this.taskTypeValue,equipmentType:this.equipmentTypeValue,machineName:this.machineNameValue,maker:this.makerValue,brand:this.brandValue,brandCategory:this.brandCategoryValue,showTestId:this.showTestIdValue,qualityStatus:this.qualityStatusValue,resultStatus:this.resultStatusValue,equipmentOptions:this.equipments,listMakerOptions:this.listMakers,listBrandOptions:this.listBrands,listBrandCategoryOptions:this.listBrandCategories,showSampleResultTypeOptions:this.showSampleResultTypes,qualityStatusOptions:this.qualityStatuses,resultStatusOptions:this.resultStatuses}},mounted:function(){(this.taskTypeValue||this.equipmentTypeValue||this.brandCategoryValue)&&(this.filterMakerOptions(this.taskTypeValue),this.filterBrandCategoryOptions(this.taskTypeValue),this.filterEquipmentOptions(this.taskTypeValue,this.equipmentTypeValue),this.filterBrandOptions(this.taskTypeValue,this.brandCategoryValue))},methods:{onTaskTypeChanged:function(t){this.taskType=t,this.filterMakerOptions(this.taskType),this.filterBrandCategoryOptions(t),this.filterEquipmentOptions(this.taskType,this.equipmentType),this.filterBrandOptions(this.taskType,this.brandCategory)},onMachineNameChanged:function(t){this.machineName=t},onEquipmentTypeChanged:function(t){this.equipmentType=t,this.filterEquipmentOptions(this.taskType,this.equipmentType)},onMakerChanged:function(t){this.maker=t},onBrandChanged:function(t){this.brand=t},onBrandCategoryChanged:function(t){this.brandCategory=t,this.filterBrandOptions(this.taskType,this.brandCategory)},onShowTestIdChanged:function(t){this.showTestId=t},filterEquipmentOptions:function(t,e){var a=this;this.equipmentOptions=this.equipments,"200"==t||"300"==t?(this.equipmentOptions=this.equipments.filter((function(e){return e.task_type_code==t})),e&&(this.equipmentOptions=this.equipments.filter((function(a){return a.task_type_code==t&&a.equipment_type==e})))):e&&(this.equipmentOptions=this.equipments.filter((function(t){return t.equipment_type==e})));var s=this.equipmentOptions.find((function(t){return t.equipment_value==a.equipment}));this.$nextTick((function(){s||(a.equipment="")}))},filterMakerOptions:function(t){var e=this;this.listMakerOptions=this.listMakers,"200"!=t&&"300"!=t||(this.listMakerOptions=this.listMakers.filter((function(e){return e.task_type_code==t})));var a=this.listMakerOptions.find((function(t){return t.maker_value==e.maker}));this.$nextTick((function(){a||(e.maker="")}))},filterBrandCategoryOptions:function(t){var e=this;this.listBrandCategoryOptions=this.listBrandCategories,"200"==t&&(this.listBrandCategoryOptions=this.listBrandCategories.filter((function(t){return t.category_code.startsWith("C")}))),"300"==t&&(this.listBrandCategoryOptions=this.listBrandCategories.filter((function(t){return t.category_code.startsWith("F")})));var a=this.listBrandCategoryOptions.find((function(t){return t.category_value==e.brandCategory}));this.$nextTick((function(){a||(e.brandCategory="")}))},filterBrandOptions:function(t,e){var a=this;this.listBrandOptions=this.listBrands,e?this.listBrandOptions=this.listBrands.filter((function(t){return t.category_code==e})):("200"==t&&(this.listBrandOptions=this.listBrands.filter((function(t){return t.category_code.startsWith("C")}))),"300"==t&&(this.listBrandOptions=this.listBrands.filter((function(t){return t.category_code.startsWith("F")}))));var s=this.listBrandOptions.find((function(t){return t.brand_value==a.brand}));this.$nextTick((function(){s||(a.brand="")}))}}};const n=(0,a(51900).Z)(l,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"col-md-8"},[a("div",{staticClass:"row"},[a("div",{staticClass:"col-md-6"},[a("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" เลขที่การตรวจสอบ ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("input",{directives:[{name:"model",rawName:"v-model",value:t.sampleNo,expression:"sampleNo"}],staticClass:"form-control",attrs:{type:"text",id:"input_sample_no",name:"sample_no"},domProps:{value:t.sampleNo},on:{input:function(e){e.target.composing||(t.sampleNo=e.target.value)}}})])]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" ประเภทเครื่อง ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"qtm_equipment_type",id:"input_qtm_equipment_type",placeholder:"เลือกประเภทเครื่อง ","option-key":"equipment_type_value","option-value":"equipment_type_value","option-label":"equipment_type_label","select-options":t.equipmentTypes,clearable:!0,filterable:!0,value:t.equipmentType},on:{onSelected:function(e){return t.onEquipmentTypeChanged(e)}}})],1)]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" หมายเลขเครื่อง QTM ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"machine_name",id:"input_machine_name",placeholder:"เลือกหมายเลขเครื่อง QTM ","option-key":"equipment_value","option-value":"equipment_value","option-label":"equipment_label","select-options":t.equipmentOptions,clearable:!0,filterable:!0,value:t.machineName},on:{onSelected:function(e){return t.onEquipmentChanged(e)}}})],1)]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" หมายเลขเครื่อง Maker ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"qtm_maker",id:"input_qtm_maker",placeholder:"เลือกหมายเลขเครื่อง Maker ","option-key":"maker_value","option-value":"maker_value","option-label":"maker_label","select-options":t.listMakerOptions,clearable:!0,filterable:!0,value:t.maker},on:{onSelected:function(e){return t.onMakerChanged(e)}}})],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" แสดงค่าความผิดปกติ ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"show_test_id",id:"input_show_test_id",placeholder:"เลือกแสดงค่าความผิดปกติ","option-key":"value","option-value":"test_id","option-label":"test_full_desc","select-options":t.showSampleResultTypeOptions,clearable:!0,filterable:!0,value:t.showTestId},on:{onSelected:function(e){return t.onShowTestIdChanged(e)}}})],1)])]),t._v(" "),a("div",{staticClass:"col-md-6"},[a("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" ตามข้อกำหนด ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"quality_status",id:"input_quality_status",placeholder:"เลือกตามข้อกำหนด ","option-key":"value","option-value":"value","option-label":"label","select-options":t.qualityStatusOptions,clearable:!0,filterable:!0,value:t.qualityStatus}})],1)]),t._v(" "),a("div",{directives:[{name:"show",rawName:"v-show",value:!1,expression:"false"}],staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" ผลการตรวจ ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"result_status",id:"input_result_status",placeholder:"เลือกผลการตรวจ ","option-key":"value","option-value":"value","option-label":"label","select-options":t.resultStatusOptions,clearable:!0,filterable:!0,value:t.resultStatus}})],1)]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" ประเภทงาน ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"task_type_code",id:"input_task_type_code",placeholder:"เลือกประเภทงาน ","option-key":"task_type_value","option-value":"task_type_value","option-label":"task_type_label","select-options":t.taskTypes,clearable:!0,filterable:!0,value:t.taskType},on:{onSelected:function(e){return t.onTaskTypeChanged(e)}}})],1)]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" หมวดงาน ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"qtm_brand_category_code",id:"input_qtm_brand_category_code",placeholder:"เลือกหมวดงาน ","option-key":"category_value","option-value":"category_value","option-label":"category_label","select-options":t.listBrandCategoryOptions,clearable:!0,filterable:!0,value:t.brandCategory},on:{onSelected:function(e){return t.onBrandCategoryChanged(e)}}})],1)]),t._v(" "),a("div",{staticClass:"row form-group"},[a("label",{staticClass:"col-md-4 col-form-label"},[t._v(" บุหรี่ / ก้นกรอง ")]),t._v(" "),a("div",{staticClass:"col-md-8"},[a("qm-el-select",{attrs:{name:"qtm_brand",id:"input_qtm_brand",placeholder:"เลือกบุหรี่ / ก้นกรอง ","option-key":"brand_value","option-value":"brand_value","option-label":"brand_label","select-options":t.listBrandOptions,clearable:!0,filterable:!0,value:t.brand},on:{onSelected:function(e){return t.onBrandChanged(e)}}})],1)])])])])}),[],!1,null,null,null).exports}}]);