(self.webpackChunk=self.webpackChunk||[]).push([[7891],{87891:(o,r,t)=>{"use strict";t.r(r),t.d(r,{default:()=>s});const e={props:["programInfo","types","moduleLists","schemaLists","sourceTypeLists"],data:function(){return{name:this.programInfo?this.programInfo.program_code:"",description:this.programInfo?this.programInfo.description:"",module:this.programInfo?this.programInfo.module_name:"",programType:this.programInfo?this.programInfo.program_type_name:"",sourceType:this.programInfo?this.programInfo.source:"",sourceName:this.programInfo?this.programInfo.source_name:"",schema:this.programInfo?this.programInfo.schemas_name:"",enableFlag:0==this.programInfo.length||"Y"==this.programInfo.enable_flag,insertFlag:0==this.programInfo.length||"Y"==this.programInfo.insert_flag,updateFlag:0==this.programInfo.length||"Y"==this.programInfo.update_flag,deleteFlag:0==this.programInfo.length||"Y"==this.programInfo.delete_flag,archiveDirectory:0==this.programInfo.length?this.programInfo.archive_directory:"",outputDirectory:0==this.programInfo.length?this.programInfo.output_directory:"",errorDirectory:0==this.programInfo.length?this.programInfo.error_directory:"",logDirectory:0==this.programInfo.length?this.programInfo.log_directory:""}},mounted:function(){},methods:{chooseModule:function(){"IE"==this.module?this.schema="OAIE":"IR"==this.module?this.schema="OAIR":"PM"==this.module?this.schema="OAPM":"QM"==this.module?this.schema="OAQM":"OM"==this.module?this.schema="OAOM":"PD"==this.module?this.schema="OAPD":"EM"==this.module?this.schema="OAEAM":"IN"==this.module?this.schema="OAINV":"PP"==this.module?this.schema="OAPP":"CT"==this.module&&(this.schema="OACT")}}};const s=(0,t(51900).Z)(e,undefined,undefined,!1,null,null,null).exports}}]);