<template>
    <span>
        <div class="modal inmodal fade" id="modal_search" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ค้นหา{{ menu.menu_title }}</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="row col-12">
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> ยาเส้นปรุง Blend No. :</label>
                                <div class="input-group ">
                                    <input autocomplete="off" id="lb-2" type="text" class="form-control" name="blend_no"
                                       v-model="blendNo"/>
                                </div>
                            </div>

                            <!-- <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-2 col-sm-6 col-xs-6 mt-2">
                                <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งผลผลิต :</label>
                                <div class="input-group ">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="transactionDateFormat"
                                        :format="transDate['js-format']"
                                        @dateWasSelected="setdate(...arguments)"
                                        />
                                </div>
                            </div> -->

                            <div class="form-group text-right  pr-2 mb-0 col-lg-5 col-md-10 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-2 mb-1">&nbsp;</label>
                                <div class="text-left">
                                    <button type="button" @click="searchForm" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                        <i :class="transBtn.search.icon"></i>
                                        {{ transBtn.search.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content table-responsive m-t mb-3">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th width="90px" class="text-center">ประเภทสูตร</th>
                                        <th width="" class="text-left">ยาเส้นปรุง Blend No.</th>
                                        <th width="90px" class="text-center">สถานะ</th>
                                        <th width="90px" class="text-center">วันที่อนุมัติ</th>
                                        <th width="150px" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(line, index) in requestHeaders">
                                        <td class="text-center">{{ line.formula_type }}</td>
                                        <td>{{ line.blend_no }}</td>
                                        <td class="text-center">{{ line.formula_status }}</td>
                                        <td class="text-center">{{ line.formula_approval_date_format }}</td>
                                        <td class="text-right">
                                            <button type="button" :class="transBtn.detail.class + ' btn-lg tw-w-25'"
                                                @click="selectRow(line)">
                                                <i :class="transBtn.detail.icon"></i>
                                                {{ transBtn.detail.text }}
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
import moment from "moment";

export default {
    props:['header', "transBtn", "transDate", "url", "countOpen"],
    data() {
        return {
            loading: false,
            // reqHeaderHeaderId: '',
            transactionDateFormat: '',
            blendNo: '',
            requestHeaders: [],
        }
    },
    mounted() {
        // if (this.budget_year) {
        //     this.getBiWeekly();
        // }
    },
    computed: {
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
        },
    },
    methods: {
        async setdate(date) {
            let vm = this;
            vm.transactionDateFormat = await moment(date).format(vm.transDate['js-format']);
        },
        openModal() {
            $('#modal_search').modal('show');
        },
        // remoteMethod(query) {
        //     if (query !== "") {
        //         this.search({ wip_request_no: query, transaction_date: this.transactionDateFormat, action: 'search' });
        //     } else {
        //         this.requestHeaders = [];
        //     }
        // },
        search(params) {
            let vm = this;
            vm.loading = true;
            axios.get(vm.url.index, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                vm.requestHeaders = response.data;
            });
        },
        async selectRow(reqHeader) {
            $('#modal_search').modal('hide');
            this.requestHeaders = [];
            this.$emit("selectRow", reqHeader);
        },
        async searchForm() {
            this.search({ blend_no: this.blendNo, action: 'search', formula_type_code: this.header.formula_type_code });
        },
    }
}
</script>