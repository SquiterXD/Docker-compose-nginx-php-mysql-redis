<template>
    <div>
            <!-- :disabled="disabled" -->
        <el-select
            v-model="itemId"
            filterable
            :ref="'selected_' + i"
            remote
            placeholder="รหัสวัตถุดิบ"
            :remote-method="remoteMethod"
            :loading="loading"
            @change="itemWasSelected"
        >
            <el-option
                v-for="(item, index) in items"
                :key="parseInt(item.inventory_item_id)"
                :label="item.display"
                :value="parseInt(item.inventory_item_id)"
            ></el-option>
        </el-select>
    </div>
</template>
<script>
export default {
    props:[
        "pHeader", "inventoryItemId", 'url', 'lines', 'i'
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
        if (this.itemId !== "") {
            this.getItems({ inventory_item_id: this.itemId, header: this.pHeader, lines: this.lines });
        } else {
            this.items = [];
            this.getItems({
                number: ' ',
                header: this.pHeader,
                lines: this.lines
            });
        }
    },
    methods: {
        async itemWasSelected(selectItemId) {
            
            let vm = this;
            let item = vm.items.filter(o => o.inventory_item_id == selectItemId);
            setTimeout(() => {
                let el = $(this.$refs['selected_' + this.i].$el).find('input')
                el.val(el.val().split(" : ")[0])
            }, 50);

            if (item.length) {
                item = item[0];
            }
            
            
            vm.$emit("itemWasSelected", item);
        },
        remoteMethod(query) {
            if (query !== "") {
                this.getItems({
                    number: query,
                    header: this.pHeader,
                    lines: this.lines
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
                 setTimeout(() => {
                    let el = $(this.$refs['selected_' + vm.i].$el).find('input')
                    el.val(el.val().split(" : ")[0])
                }, 50);
            });
        }
    }
}
</script>