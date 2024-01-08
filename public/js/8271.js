(self.webpackChunk=self.webpackChunk||[]).push([[8271],{96668:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>o});var n=a(23645),c=a.n(n)()((function(t){return t[1]}));c.push([t.id,".flex[data-v-63e7320c]{display:flex}.items-center[data-v-63e7320c]{align-items:center}.el-select[data-v-63e7320c]{width:300px}.card-custom[data-v-63e7320c]{background:#fff;border-radius:10px;padding:20px!important}",""]);const o=c},88271:(t,e,a)=>{"use strict";a.r(e),a.d(e,{default:()=>c});const n={data:function(){return{cost_center:"",org:"",options:{cost_center:[],org:[]},tableData:[],addTableData:[]}},mounted:function(){this.getMasterData()},methods:{getMasterData:function(){this.getCostCenters(),this.invOrg()},getCostCenters:function(){var t=this;axios.get("/ct/ajax/cost_center/cost-center-view").then((function(e){t.options.cost_center=e.data}))},selectCostCenter:function(){this.queryCostRm()},queryCostRm:function(){var t=this;axios.get("/ct/ajax/cost_rm?cost_code=".concat(this.cost_center)).then((function(e){var a=e.data.data;t.tableData=a}))},invOrg:function(){var t=this;axios.get("/ct/ajax/cost_center/inv_org").then((function(e){var a=e.data.data;t.options.org=a}))},confirmDelete:function(t,e){var a=this;this.$confirm("เมื่อกดยืนยันข้อมูลนี้จะถูกลบ","ต้องการลบข้อมูลนี้ใช่หรือไม่",{confirmButtonText:"ยืนยัน",cancelButtonText:"ยกเลิก"}).then((function(){console.log("test"),a.deleteOrg(t)})).catch((function(){console.log("cancel")}))},addOrgToTable:function(){var t=this,e=this.options.org.find((function(e){return e.organization_code==t.org}));this.addTableData.find((function(t){return e.organization_code==t.organization_code}))||this.addTableData.push(e),this.org=""},deleteRow:function(t,e){e.splice(t,1)},deleteOrg:function(t){var e=this,a=this.tableData[t];console.log(a),axios.delete("/ct/ajax/cost_rm?cost_code=".concat(this.cost_center,"&org_code=").concat(a.org_ingredient,"&org_name=").concat(a.org_ingredient)).then((function(t){swal({title:"&nbsp;",text:"ลบข้อมูลสำเร็จ",type:"success",html:!0}),e.selectCostCenter()}))},submitOrg:function(){var t=this;if(this.cost_center&&this.addTableData.length>0){var e={cost_code:this.cost_center,data:this.addTableData};axios.post("/ct/ajax/cost_rm",e).then((function(e){swal({title:"&nbsp;",text:"บันทึกข้อมูลสำเร็จ",type:"success",html:!0}),t.selectCostCenter(),t.addTableData=[]}))}else swal("Error","กรุณาเลือกศูนย์ต้นทุนก่อนก่อนเพิ่ม ORG วัตถุดิบ","error")}}};a(81997);const c=(0,a(51900).Z)(n,(function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("div",{staticClass:"row"},[a("div",{staticClass:"col-lg-6 col-md-12 mt-4 p-4"},[a("div",{staticClass:"card-custom"},[t._m(0),t._v(" "),a("div",{staticClass:"form-group text-center"},[a("label",{staticClass:"mr-2",attrs:{for:""}},[t._v("ศูนย์ต้นทุน")]),t._v(" "),a("el-select",{attrs:{placeholder:"เลือกศูนย์ต้นทุน"},on:{change:t.selectCostCenter},model:{value:t.cost_center,callback:function(e){t.cost_center=e},expression:"cost_center"}},t._l(t.options.cost_center,(function(t){return a("el-option",{key:t.cost_code,attrs:{label:t.cost_code+"-"+t.description,value:t.cost_code}})})),1)],1),t._v(" "),a("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.tableData}},[a("el-table-column",{attrs:{prop:"org_ingredient",label:"ORG วัตถุดิบ",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"org_description",label:"รายละเอียด",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{staticClass:"text-center"},[a("el-button",{attrs:{size:"mini",type:"danger"},nativeOn:{click:function(a){return a.preventDefault(),t.confirmDelete(e.$index,t.tableData)}}},[a("i",{staticClass:"el-icon-delete"}),t._v("ลบ\n                                ")])],1)]}}])})],1)],1)]),t._v(" "),a("div",{staticClass:"col-lg-6 col-md-12 mt-4 p-4"},[a("div",{staticClass:"card-custom"},[t._m(1),t._v(" "),a("div",{staticStyle:{display:"flex","justify-content":"center"}},[a("div",{staticClass:"form-group text-center"},[a("el-select",{attrs:{placeholder:"เลือก ORG วัตถุดิบ"},model:{value:t.org,callback:function(e){t.org=e},expression:"org"}},t._l(t.options.org,(function(t){return a("el-option",{key:t.organization_code,attrs:{label:t.organization_code+" - "+t.organization_name,value:t.organization_code}})})),1),t._v(" "),a("el-button",{staticClass:"btn-success mr-2 btn-p__tr",staticStyle:{"background-color":"#40c8b2",border:"none"},attrs:{id:"add_cost_center",type:"success"},on:{click:t.addOrgToTable}},[t._v("\n                            เพิ่ม\n                        ")])],1)]),t._v(" "),a("el-table",{staticStyle:{width:"100%"},attrs:{border:"",data:t.addTableData}},[a("el-table-column",{attrs:{prop:"organization_code",label:"ORG วัตถุดิบ",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{prop:"organization_name",label:"รายละเอียด",align:"center"}}),t._v(" "),a("el-table-column",{attrs:{width:"120"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("div",{staticClass:"text-center"},[a("el-button",{attrs:{size:"mini",type:"danger"},nativeOn:{click:function(a){return a.preventDefault(),t.deleteRow(e.$index,t.addTableData)}}},[a("i",{staticClass:"el-icon-delete"}),t._v("ลบ\n                                ")])],1)]}}])})],1),t._v(" "),a("div",{staticClass:"text-right mt-2"},[a("el-button",{staticClass:"btn-success mr-2 btn-p__tr",staticStyle:{"background-color":"#40c8b2",border:"none"},attrs:{id:"add_cost_center",type:"success"},on:{click:t.submitOrg}},[t._v("\n                        บันทึกการเพิ่มวัตถุดิบ\n                    ")])],1)],1)])])])}),[function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"text-center"},[a("h2",[t._v("\n                        ข้อมูล ORG วัตถุดิบ\n                    ")])])},function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"text-center"},[a("h2",[t._v("\n                        เพิ่มข้อมูลวัตถุดิบ\n                    ")])])}],!1,null,"63e7320c",null).exports},81997:(t,e,a)=>{var n=a(96668);n.__esModule&&(n=n.default),"string"==typeof n&&(n=[[t.id,n,""]]),n.locals&&(t.exports=n.locals);(0,a(45346).Z)("19834bd0",n,!0,{})}}]);