<script>
    export default {
        props:['programType', 'typeLists'],
        data() {
            return {
                name: this.programType? this.programType.program_type_name: '',
                description: this.programType? this.programType.description: '',
                type: this.programType? this.programType.program_type: '',
                userType: this.programType? this.programType.user_program_type_name: '',
                enableFlag: this.programType.length == 0? true: this.programType.enable_flag == 'Y'? true: false,
            }
        },
        mounted() {
            // console.log('Component mounted.')
        }
    }
</script>