<template>
    <div>
        <el-select
            v-model="itemId"            
            filterable
            remote
            reserve-keyword
            placeholder="รหัสสินค้าสำเร็จรูป"
            :remote-method="remoteMethod"
            :loading="loading"
            @change="itemWasSelected">
            <el-option
                v-for="(item, index) in items"
                :key="index"
                :label="item.display"
                :value="parseInt(item.inventory_item_id)"
            ></el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props:[
        "pHeader", "inventoryItemId", 'url'
    ],
    computed: {
    },
    watch:{
    },
    data() {
        return {
            itemId: (this.inventoryItemId != undefined && this.inventoryItemId != '') ? parseInt(this.inventoryItemId) : '',
            loading: false,
            items: [],
        }
    },
    mounted() {
        if (this.itemId !== "") {
            this.getItems({ inventory_item_id: this.itemId, header: this.pHeader });
        } else {
            // this.items = [];
            this.getItems({ header: this.pHeader });
        }
    },
    methods: {
        async itemWasSelected(selectItemId) {
            let vm = this;
            let item = vm.items.filter(o => o.inventory_item_id == selectItemId);
            if (item.length) {
                item = item[0];
                vm.itemId = item.item_number;
            }

            vm.$emit("itemWasSelected", item);
        },
        remoteMethod(query) {
            if (query !== "") {
                this.getItems({
                    number: query,
                    header: this.pHeader
                });
            } else {
                this.items = [];
            }
        },
        getItems(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.ajax_get_item, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.items = response.items;
                this.$emit('getItems', response)
                
                //เแยก item_number กับ item_des ในตอนที่มีการค้นหารายการโอนสินค้าสำเร็จรูป
                if(vm.items){
                    vm.items.forEach(element => {
                        if(vm.inventoryItemId == element.inventory_item_id){
                            vm.itemId = element.item_number
                        }
                    });
                }
            });
        }
    }
}
</script>