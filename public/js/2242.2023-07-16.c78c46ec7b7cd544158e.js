(self.webpackChunk=self.webpackChunk||[]).push([[2242],{62242:(e,a,t)=>{"use strict";t.r(a),t.d(a,{default:()=>n});var i=t(90605);t(30381);const l={props:["name","id","format","value","clearable"],components:{VueTimepicker:i.Z},data:function(){return{timeValue:this.value?this.value:""}},methods:{valueWasChanged:function(e){this.$emit("change",e.displayTime)},inputWasClosed:function(e){this.$emit("close",e.displayTime)}}};const n=(0,t(51900).Z)(l,(function(){var e=this,a=e.$createElement,t=e._self._c||a;return t("div",[t("vue-timepicker",{attrs:{format:e.format?e.format:"HH:mm","hide-clear-button":!1===e.clearable,"manual-input":""},on:{change:e.valueWasChanged,close:e.inputWasClosed},model:{value:e.timeValue,callback:function(a){e.timeValue=a},expression:"timeValue"}}),e._v(" "),t("input",{directives:[{name:"model",rawName:"v-model",value:e.timeValue,expression:"timeValue"}],attrs:{type:"hidden",name:e.name,id:e.id?e.id:null},domProps:{value:e.timeValue},on:{input:function(a){a.target.composing||(e.timeValue=a.target.value)}}})],1)}),[],!1,null,null,null).exports}}]);