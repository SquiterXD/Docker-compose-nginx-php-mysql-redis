<script>
    export default {
    props: ["itemCatSeg1s"],
    data() {
        return{
            itemCatSeg1Selected: '',
            itemCatSeg2Selected: '', 
            itemCatSeg2Lists : [], 
            lists: [],
            input: [],
            setDefault: '',
            loading:{
                itemCatSeg2: false
            },
            tableData: [{
                inventory_item_id: '',
                item_desc: '',
                notification: ''
            }],
        };
    },
    mounted() {

    },
    methods: {
        async getTobaccoItemcatSeg2Lists(value) {
            var params = {
                itemCatSeg1 : value
            };
            this.loading.itemCatSeg2 = true;
            return await axios
                .get('/pd/ajax/ohhand-tobacco-forewarn/get_tobacco_itemcat_seg2',{ params })
                .then(res => {
                    this.itemCatSeg2Lists = res.data.tobaccoItemcatSeg2;
                    this.loading.itemCatSeg2 = false;
                    this.itemCatSeg2Selected = '';
                });
        },
        async findTobaccoForewarn(value, value2) {
            console.log(value, value2);
            var params = {
                itemCatSeg1 : value,
                itemCatSeg2 : value2
            };
            return await axios
                .get('/pd/ajax/ohhand-tobacco-forewarn/create/findTobaccoForewarn', { params })
                .then(res => {
                    $('.program_info_tb').DataTable().destroy();
                    $('tbody').html(res.data);
                }).then(() => {
                    $('.program_info_tb').DataTable(); 
                    
                    
                });
                
        },        
    },
    };
</script>