
<script>
    export default {
        props: ["headers", "modules"],
        data() {
            return {
                running_code : '',
                system_module: '',
            }
        },
        methods: {
            search() {
                console.log('Search');
                
                axios
                .get("/running-number", {
                    params: {
                        running_code: this.running_code,
                        system_module: this.system_module,
                    }
                })
                .then(() => {
                  
                });
            },

            clear () {
                console.log('clear');
            },
        },

    }
</script>