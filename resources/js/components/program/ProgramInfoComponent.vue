<script>
    export default {
        props:['programInfo', 'types', 'moduleLists', 'schemaLists', 'sourceTypeLists'],
        data() {
            return {
                name: this.programInfo? this.programInfo.program_code: '',
                description: this.programInfo? this.programInfo.description: '',
                module: this.programInfo? this.programInfo.module_name: '',
                programType: this.programInfo? this.programInfo.program_type_name: '',
                sourceType: this.programInfo? this.programInfo.source: '',
                sourceName: this.programInfo? this.programInfo.source_name: '',
                schema: this.programInfo? this.programInfo.schemas_name: '',
                enableFlag: this.programInfo.length == 0? true :this.programInfo.enable_flag == 'Y'? true: false,
                insertFlag: this.programInfo.length == 0? true :this.programInfo.insert_flag == 'Y'? true: false,
                updateFlag: this.programInfo.length == 0? true :this.programInfo.update_flag == 'Y'? true: false,
                deleteFlag: this.programInfo.length == 0? true :this.programInfo.delete_flag == 'Y'? true: false,
                //PATH
                archiveDirectory: this.programInfo.length == 0? this.programInfo.archive_directory: '',
                outputDirectory: this.programInfo.length == 0? this.programInfo.output_directory: '',
                errorDirectory: this.programInfo.length == 0? this.programInfo.error_directory: '',
                logDirectory: this.programInfo.length == 0? this.programInfo.log_directory: '',
            }
        },
        mounted() {
            // console.log('Component mounted.')
        },
        methods: {
            chooseModule() {

                // this.schema = this.schemaLists.filter((schema, index) => {
                //     console.log(schema);
                //     console.log(index);
                //     if (this.module == index) {
                //         return schema;
                //     }
                // })
                
                if(this.module == 'IE'){
                    this.schema = 'OAIE';
                }else if(this.module == 'IR'){
                   this.schema = 'OAIR';
                }else if(this.module == 'PM'){
                    this.schema = 'OAPM';
                }else if(this.module == 'QM'){
                    this.schema = 'OAQM';
                }else if(this.module == 'OM'){
                    this.schema = 'OAOM';
                }else if(this.module == 'PD'){
                    this.schema = 'OAPD';
                }else if(this.module == 'EM'){
                    this.schema = 'OAEAM';
                }else if(this.module == 'IN'){
                    this.schema = 'OAINV';
                }else if(this.module == 'PP'){
                    this.schema = 'OAPP';
                }else if(this.module == 'CT'){
                    this.schema = 'OACT';
                }
            },
        }
    }
</script>