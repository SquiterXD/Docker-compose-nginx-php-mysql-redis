(self.webpackChunk=self.webpackChunk||[]).push([[6268],{72725:(e,t,s)=>{"use strict";s.d(t,{Z:()=>n});var a=s(23645),i=s.n(a)()((function(e){return e[1]}));i.push([e.id,".el-select-dropdown{z-index:9999!important}",""]);const n=i},56268:(e,t,s)=>{"use strict";s.r(t),s.d(t,{default:()=>r});var a=s(87757),i=s.n(a);function n(e,t,s,a,i,n,o){try{var l=e[n](o),h=l.value}catch(e){return void s(e)}l.done?t(h):Promise.resolve(h).then(a,i)}const o={props:["setName","setData","setParent","error","defaultValueSetName","setOptions","name"],data:function(){return{options:[],value:"",loading:!1}},mounted:function(){this.value=this.setData,this.getValueSetList(this.value),this.changeCoa()},watch:{setData:function(){this.value=this.setData,this.getValueSetList(this.value),this.options=this.setOptions},error:function(){var e=this.$refs.input.$refs.reference.$refs.input;e.style="",!this.error||""!==this.value&&null!==this.value||(e.style="border: 1px solid red;")}},methods:{getValueSetList:function(e){var t,s=this;return(t=i().mark((function t(){return i().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:return t.next=2,axios.get("/ir/ajax/coa-mapping",{params:{flex_value_set_name:s.setName,flex_value_set_data:s.value,flex_value_parent:s.setParent,query:e}}).then((function(e){s.options=e.data})).catch((function(e){})).then((function(){s.loading=!1}));case 2:case"end":return t.stop()}}),t)})),function(){var e=this,s=arguments;return new Promise((function(a,i){var o=t.apply(e,s);function l(e){n(o,a,i,l,h,"next",e)}function h(e){n(o,a,i,l,h,"throw",e)}l(void 0)}))})()},changeCoa:function(){this.setName==this.defaultValueSetName.segment1&&this.$emit("coa",{name:this.setName,segment1:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment2&&this.$emit("coa",{name:this.setName,segment2:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment3&&this.$emit("coa",{name:this.setName,segment3:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment4&&this.$emit("coa",{name:this.setName,segment4:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment5&&this.$emit("coa",{name:this.setName,segment5:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment6&&this.$emit("coa",{name:this.setName,segment6:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment7&&this.$emit("coa",{name:this.setName,segment7:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment8&&this.$emit("coa",{name:this.setName,segment8:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment9&&this.$emit("coa",{name:this.setName,segment9:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment10&&this.$emit("coa",{name:this.setName,segment10:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment11&&this.$emit("coa",{name:this.setName,segment11:this.value,options:this.options}),this.setName==this.defaultValueSetName.segment12&&this.$emit("coa",{name:this.setName,segment12:this.value,options:this.options})}}};var l=s(93379),h=s.n(l),m=s(72725),u={insert:"head",singleton:!1};h()(m.Z,u);m.Z.locals;const r=(0,s(51900).Z)(o,(function(){var e=this,t=e.$createElement,s=e._self._c||t;return s("div",[s("input",{attrs:{type:"hidden",name:this.name,autocomplete:"off"},domProps:{value:e.value}}),e._v(" "),s("el-select",{ref:"input",staticClass:"w-100 el-select-input-segment",staticStyle:{width:"100%"},attrs:{filterable:"",remote:"",clearable:"","reserve-keyword":"",placeholder:"Please enter a value","remote-method":e.getValueSetList,loading:e.loading,size:"small"},on:{change:e.changeCoa},model:{value:e.value,callback:function(t){e.value=t},expression:"value"}},e._l(e.options,(function(e,t){return s("el-option",{key:e.meaning,attrs:{label:e.meaning+" : "+e.description,value:e.meaning}})})),1)],1)}),[],!1,null,null,null).exports}}]);