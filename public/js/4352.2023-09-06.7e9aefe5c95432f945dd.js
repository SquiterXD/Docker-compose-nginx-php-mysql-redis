(self.webpackChunk=self.webpackChunk||[]).push([[4352],{37746:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>i});var n=s(23645),a=s.n(n)()((function(t){return t[1]}));a.push([t.id,"#textarea-count .count-number{text-align:right;margin-top:-20px;position:relative;padding-right:20px;font-size:smaller;width:100px;float:right}#textarea-count{width:100%}",""]);const i=a},4352:(t,e,s)=>{"use strict";s.r(e),s.d(e,{default:()=>a});const n={model:{prop:"model",event:"input"},computed:{isVisible:function(){return this.theMessage=this.model,this.totalInput=this.theMessage?this.theMessage.length:0,null!==this.model}},data:function(){return{limitMaxCount:this.maxlength,theMessage:null,totalInput:0}},props:{model:{type:String},maxlength:{type:Number}},methods:{onChange:function(t){console.debug("onChange",t),this.$emit("change",this.theMessage)},dispatchInput:function(t){console.debug("dispatchInput",t),this.theMessage=t.target.value,this.totalInput=this.theMessage?this.theMessage.length:0,this.$emit("input",this.theMessage)}}};s(97182);const a=(0,s(51900).Z)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{attrs:{id:"textarea-count"}},[s("textarea",{staticClass:"form-control",attrs:{visible:t.isVisible,maxlength:t.maxlength},domProps:{value:t.theMessage},on:{input:t.dispatchInput,change:t.onChange}}),t._v(" "),s("div",{staticClass:"count-number"},[t._v(t._s(t.totalInput)+" / "+t._s(t.maxlength))])])}),[],!1,null,null,null).exports},97182:(t,e,s)=>{var n=s(37746);n.__esModule&&(n=n.default),"string"==typeof n&&(n=[[t.id,n,""]]),n.locals&&(t.exports=n.locals);(0,s(45346).Z)("56ee28cc",n,!0,{})}}]);