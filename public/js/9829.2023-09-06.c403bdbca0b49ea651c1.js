(self.webpackChunk=self.webpackChunk||[]).push([[9829],{2407:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>n});var a=s(23645),i=s.n(a)()((function(e){return e[1]}));i.push([e.id,".el-select-dropdown{z-index:9999!important}",""]);const n=i},9829:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>l});var a=s(87757),i=s.n(a);function n(e,t,s,a,i,n,o){try{var l=e[n](o),m=l.value}catch(e){return void s(e)}l.done?t(m):Promise.resolve(m).then(a,i)}const o={props:["setName","setData","setParent","error","defaultValueSetName","setOptions"],data:function(){return{options:[],value:"",loading:!1}},mounted:function(){this.value=this.setData,this.getValueSetList(this.value),this.changeCoa()},watch:{setData:function(){this.value=this.setData,this.getValueSetList(this.value),this.options=this.setOptions},error:function(){var e=this.$refs.input.$refs.reference.$refs.input;e.style="",!this.error||""!==this.value&&null!==this.value||(e.style="border: 1px solid red;")}},methods:{getValueSetList:function(e){var t,s=this;return(t=i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/ajax/inquiry-funds",{params:{flex_value_set_name:s.setName,flex_value_set_data:s.value,flex_value_parent:s.setParent,query:e}}).then((function(e){s.options=e.data})).catch((function(e){console.log(e)})).then((function(){s.loading=!1}));case 2:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(a,i){var o=t.apply(e,s);function l(e){n(o,a,i,l,m,"next",e)}function m(e){n(o,a,i,l,m,"throw",e)}l(void 0)}))})()},changeCoa:function(){this.setName==this.defaultValueSetName.segment1&&this.$emit("coa",{name:this.setName,segment1From:this.value,segment1To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment2&&this.$emit("coa",{name:this.setName,segment2From:this.value,segment2To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment3&&this.$emit("coa",{name:this.setName,segment3From:this.value,segment3To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment4&&this.$emit("coa",{name:this.setName,segment4From:this.value,segment4To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment5&&this.$emit("coa",{name:this.setName,segment5From:this.value,segment5To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment6&&this.$emit("coa",{name:this.setName,segment6From:this.value,segment6To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment7&&this.$emit("coa",{name:this.setName,segment7From:this.value,segment7To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment8&&this.$emit("coa",{name:this.setName,segment8From:this.value,segment8To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment9&&this.$emit("coa",{name:this.setName,segment9From:this.value,segment9To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment10&&this.$emit("coa",{name:this.setName,segment10From:this.value,segment10To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment11&&this.$emit("coa",{name:this.setName,segment11From:this.value,segment11To:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment12&&this.$emit("coa",{name:this.setName,segment12From:this.value,segment12To:this.value,options:this.options})}}};s(87598);const l=(0,s(51900).Z)(o,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("el-select",{ref:"input",staticClass:"w-100 el-select-input-segment",staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",clearable:"","reserve-keyword":"",placeholder:"Please enter a value","remote-method":e.getValueSetList,loading:e.loading,size:"small"},on:{change:e.changeCoa},model:{value:e.value,callback:function(t){e.value=t},expression:"value"}},e._l(e.options,(function(e,t){return s("el-option",{key:t,attrs:{label:e.flex_value+" : "+e.description,value:e.flex_value}})})),1)],1)}),[],!1,null,null,null).exports},87598:(e,t,s)=>{var a=s(2407);a.__esModule&&(a=a.default),"string"==typeof a&&(a=[[e.id,a,""]]),a.locals&&(e.exports=a.locals);(0,s(45346).Z)("4ec04a16",a,!0,{})}}]);