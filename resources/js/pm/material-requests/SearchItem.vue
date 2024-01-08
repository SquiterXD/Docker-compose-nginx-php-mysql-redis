<template>
    <div>
            <!-- :disabled="disabled" -->
        <el-select
            v-model="itemId"
            filterable
            remote
            placeholder="รหัสวัตถุดิบ"
            :remote-method="remoteMethod"
            :loading="loading"
            @change="itemWasSelected"
        >
            <el-option
                v-for="(item, index) in items"
                :key="parseInt(item.inventory_item_id)"
                :label="item.item_number"
                :value="parseInt(item.inventory_item_id)"
            >
                <span>{{ item.display }}</span>
            </el-option>
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
        console.log('Component mounted.')
        if (this.itemId !== "" || true) {
            this.getItems({ inventory_item_id: this.itemId, header: this.pHeader });
        } else {
            this.items = [];
        }
    },
    methods: {
        async itemWasSelected(selectItemId) {
            let vm = this;
            let item = vm.items.filter(o => o.inventory_item_id == selectItemId);
            if (item.length) {
                item = item[0];
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
            });
        }
    }
}
</script>