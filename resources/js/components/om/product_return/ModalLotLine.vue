<template>
    <tr>
        <td v-if="state == 'search'">
            {{ item.inv_org_code+' : '+item.inv_org_name }}
        </td>
        <td v-else>
            <el-select 
                v-model="lotData[index].inv" 
                class="w-100"
                placeholder=""
                filterable 
                :popper-append-to-body="false"
                @change="getList">
                <el-option v-for="(inv) in invList" 
                    :key="inv.organization_id"
                    :label="inv.organization_code+' : '+inv.organization_name"
                    :value="inv.organization_id">
                </el-option>
            </el-select>
        </td>
        <td v-if="state == 'search'">
            {{ item.subinventory_code }}
        </td>
        <td v-else>
            <el-select 
                v-model="lotData[index].sub_inv" 
                class="w-100"
                placeholder=""
                :disabled="!subInvList.length"
                filterable 
                :popper-append-to-body="false"
                @change="getLocateSeg1List">
                <el-option v-for="(sub_inv) in subInvList" 
                    :key="sub_inv.sub_inv_name"
                    :label="sub_inv.sub_inv_name"
                    :value="sub_inv.sub_inv_name">
                </el-option>
            </el-select>
        </td>
        <td v-if="state == 'search'">
            {{ item.loc_segment1 }}
        </td>
        <td v-else>
            <el-select 
                v-model="lotData[index].locator_segment1" 
                class="w-100"
                placeholder=""
                :disabled="!locateSeg1List.length"
                filterable 
                :popper-append-to-body="false"
                @change="getLocateSeg2List">
                <el-option v-for="(loc1) in locateSeg1List" 
                    :key="loc1.segment1"
                    :label="loc1.segment1"
                    :value="loc1.segment1">
                </el-option>
            </el-select>
        </td>
        <td v-if="state == 'search'">
            {{ item.loc_segment2 }}
        </td>
        <td v-else>
            <el-select 
                v-model="lotData[index].locator_segment2" 
                class="w-100"
                placeholder=""
                :disabled="!locateSeg2List.length"
                filterable 
                :popper-append-to-body="false">
                <el-option v-for="(loc2) in locateSeg2List" 
                    :key="loc2.segment2"
                    :label="loc2.segment2"
                    :value="loc2.segment2">
                </el-option>
            </el-select>
        </td>
        <td v-if="state == 'search'">
            {{ item.lot_number }}
        </td>
        <td v-else>
            <el-select 
                v-model="lotData[index].lot_number" 
                class="w-100"
                placeholder=""
                :disabled="!lotNumberList.length"
                filterable 
                :popper-append-to-body="false">
                <el-option v-for="(lot_number) in lotNumberList" 
                    :key="lot_number.lot_number"
                    :label="lot_number.lot_number"
                    :value="lot_number.lot_number">
                </el-option>
            </el-select>
        </td>
        <td class="text-right" v-if="state == 'search'">
            {{ numberWithCommas(item.input_qty) }}
        </td>
        <td class="text-right" v-else>
            <vue-numeric read-only-class="el-input__inner text-right" 
                class="el-input__inner w-100 text-right" separator="," 
                :precision="2" :max="parseFloat(canUse)"
                v-model="item.input_qty">
            </vue-numeric>
        </td>
        <td v-if="state != 'search'">
            <a href="#" class="text-danger" @click="remove"><i class="fa fa-times"></i></a>
        </td>
    </tr>
</template>

<script>
    import VueNumeric from 'vue-numeric';
    export default {
        components: {
            VueNumeric,
        },

        props: [
            'state',
            'index',
            'remain',
            'item',
            'itemId',
            'lotData',
        ],

        data() {
            return {
                init: true,
                invList: [],
                subInvList: [],
                locateSeg1List: [],
                locateSeg2List: [],
                lotNumberList: [],
            }
        },

        mounted() {
            if(this.state == 'create'){
                this.initData();
            }
        },

        computed: {
            canUse(){
                let canUse = this.lotData.reduce((a, b, currentIndex) => {
                    return currentIndex == this.index ? a : a + parseFloat(b.input_qty);
                }, 0);
                return parseFloat(this.remain) - parseFloat(canUse);
            },
        },
        
        methods: {
            async initData(){
                let _this = this;
                await _this.getInvList();
                if(_this.item.sub_inv || (!_this.item.sub_inv && _this.item.inv)){
                    await _this.getSubInvList();
                }
                if(_this.item.locator_segment1 || (!_this.item.locator_segment1 && _this.item.sub_inv)){
                    await _this.getLocateSeg1List();
                }
                if(_this.item.locator_segment2 || (!_this.item.locator_segment2 && _this.item.locator_segment1)){
                    await _this.getLocateSeg2List();
                }
                if(_this.item.lot_number || (!_this.item.lot_number && _this.item.inv)){
                    await _this.getLotNumberList();
                }
                _this.init = false;
            },
            async getList(){
                let _this = this;
                _this.getSubInvList();
                _this.getLotNumberList();
            },
            async getInvList(query){
                let _this = this;
                let params = {
                    'keyword': query == '' ? '' : query,
                }
                axios.get('/om/product-return/get-inv-list', { params })
                .then(function(response){
                    _this.invList = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                });
            },
            async getSubInvList(query){
                let _this = this;
                if(!_this.init){
                    _this.lotData[_this.index].sub_inv = null;
                    _this.lotData[_this.index].locator_segment1 = null;
                    _this.lotData[_this.index].locator_segment2 = null;
                    _this.subInvList = [];
                    _this.locateSeg1List = [];
                    _this.locateSeg2List = [];
                }
                let params = {
                    'keyword': query == '' ? '' : query,
                    'inv': _this.lotData[_this.index].inv,
                }
                axios.get('/om/product-return/get-sub-inv-list', { params })
                .then(function(response){
                    _this.subInvList = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                });
            },
            async getLocateSeg1List(query){
                let _this = this;
                if(!_this.init){
                    _this.lotData[_this.index].locator_segment1 = null;
                    _this.lotData[_this.index].locator_segment2 = null;
                    _this.locateSeg1List = [];
                    _this.locateSeg2List = [];
                }
                let params = {
                    'keyword': query == '' ? '' : query,
                    'inv': _this.lotData[_this.index].inv,
                    'sub_inv': _this.lotData[_this.index].sub_inv,
                }
                axios.get('/om/product-return/get-locate-seg1-list', { params })
                .then(function(response){
                    _this.locateSeg1List = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                });
            },
            async getLocateSeg2List(query){
                let _this = this;
                if(!_this.init){
                    _this.lotData[_this.index].locator_segment2 = null;
                    _this.locateSeg2List = [];
                }
                let params = {
                    'keyword': query == '' ? '' : query,
                    'inv': _this.lotData[_this.index].inv,
                    'sub_inv': _this.lotData[_this.index].sub_inv,
                    'locator_segment1': _this.lotData[_this.index].locator_segment1,
                }
                axios.get('/om/product-return/get-locate-seg2-list', { params })
                .then(function(response){
                    _this.locateSeg2List = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                });
            },
            async getLotNumberList(query){
                let _this = this;
                if(!_this.init){
                    _this.lotData[_this.index].lot_number = null;
                    _this.lotNumberList = [];
                }
                let params = {
                    'keyword': query == '' ? '' : query,
                    'inv': _this.lotData[_this.index].inv,
                    'item_id': _this.itemId,
                }
                axios.get('/om/product-return/get-lot-number-list', { params })
                .then(function(response){
                    _this.lotNumberList = response.data;
                }).catch(function(error){
                    // console.log(error);
                    _this.showError(error.message);
                }).then(() => {
                    // always execute
                });
            },
            remove(e){
                let _this = this;
                e.preventDefault();
                swal({
                    title: "แจ้งเตือน",
                    text: "ยืนยันที่จะลบรายการนี้หรือไม่?",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: 'ยกเลิก',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ยืนยัน'
                },
                function(confirm) {
                    if (confirm) {
                        _this.$emit('remove-lot');
                    }
                });
            },
            showSuccess(msg){
                swal("Success!", msg, "success");
            },
            showError(msg){
                swal("Error!", msg, "error");
            },
            numberWithCommas(x) {
                return parseFloat(x).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
            },
        },
    }
</script>