(self.webpackChunk=self.webpackChunk||[]).push([[865],{20865:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>i});const n={data:function(){return{tableData:{ptct_item_tax_v:[],determine:[],not_determine:[]},loading:!1,activeName:"determine"}},mounted:function(){this.getMasterData()},methods:{handleClick:function(){},getMasterData:function(){this.loading=!0,this.getPtctItemTaxV(),this.loading=!1},getDetermine:function(){var t=this;axios.get("/ct/ajax/tax_medicine/determine").then((function(e){t.tableData.determine=e.data}))},getPtctItemTaxV:function(){var t=this;axios.get("/ct/ajax/tax_medicine/ptct_item_tax_v").then((function(e){t.tableData.ptct_item_tax_v=e.data,console.log(e.data)}))},getNotDetermine:function(){var t=this;axios.get("/ct/ajax/tax_medicine/not_determine").then((function(e){t.tableData.not_determine=e.data}))}}};const i=(0,a(51900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.loading,expression:"loading"}],staticClass:"from-group"},[a("div",{staticClass:"col-md-12 mt-4 p-0"},[a("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableData.ptct_item_tax_v}},[a("el-table-column",{attrs:{prop:"item_number",label:"รหัสวัตถุดิบ",width:"180",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{label:"ชื่อวัตถุดิบ",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(""+e.row.item_description)+"\n                    ")]}}])}),t._v(" "),a("el-table-column",{attrs:{prop:"tax_item_number",label:"รหัสวัตถุดิบ(ภาษี)",width:"180",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{label:"ชื่อวัตถุดิบ(ภาษี)",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n                        "+t._s(""+e.row.tax_item_description)+"\n                    ")]}}])})],1)],1)])}),[],!1,null,"98df774a",null).exports}}]);