(self.webpackChunk=self.webpackChunk||[]).push([[9366],{79366:(e,a,t)=>{"use strict";t.r(a),t.d(a,{default:()=>n});const c={props:["qcAreas","machines","qcAreaValue","machineValue"],data:function(){return{qcArea:this.qcAreaValue,machine:this.machineValue,qcAreaOptions:this.qcAreas,machineOptions:this.getMachineOptionsInQcArea(this.qcAreaValue)}},methods:{getMachineOptionsInQcArea:function(e){return this.machines.filter((function(a){return a.qc_area==e}))},onQcAreaWasSelected:function(e){this.machineOptions=this.getMachineOptionsInQcArea(e),this.qcArea=e},onMachineNameWasSelected:function(e){this.machine=e}}};const n=(0,t(51900).Z)(c,(function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",{staticClass:"col-12"},[t("div",{staticClass:"row form-group"},[t("label",{staticClass:"col-md-4 col-form-label"},[e._v(" เขตตรวจคุณภาพ ")]),e._v(" "),t("div",{staticClass:"col-md-8"},[t("qm-el-select",{attrs:{name:"qc_area",id:"input_qc_area","option-key":"qc_area_value","option-value":"qc_area_value","option-label":"qc_area_label","select-options":e.qcAreaOptions,value:e.qcArea,clearable:!0,filterable:!0},on:{onSelected:e.onQcAreaWasSelected}})],1)]),e._v(" "),t("div",{staticClass:"row form-group"},[t("label",{staticClass:"col-md-4 col-form-label"},[e._v(" หมายเลขเครื่อง ")]),e._v(" "),t("div",{staticClass:"col-md-8"},[t("qm-el-select",{attrs:{name:"machine_name",id:"input_machine_name","option-key":"qc_area_machine_name","option-value":"machine_name_value","option-label":"machine_name_label","select-options":e.machineOptions,value:e.machine,clearable:!0,filterable:!0},on:{onSelected:e.onMachineNameWasSelected}})],1)])])}),[],!1,null,null,null).exports}}]);