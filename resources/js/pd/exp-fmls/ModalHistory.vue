<template>
    <span>
        <div class="modal inmodal fade" id="historyModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 100%; max-width: 1600px;  padding-top: 1%;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">ประวัติการแก้ไข Blend No. {{ header.blend_no }}</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left table-responsive" >
                        <table id="myDataTable" class="table table-bordered display nowrap">
                            <thead>
                                <tr>
                                    <th>ครั้งที่</th>
                                    <th>ผู้แก้ไข</th>
                                    <th>วันที่แก้ไข</th>
                                    <th>หัวข้อที่แก้ไข</th>
                                    <th>แก้ไข Leaf</th>
                                    <th>แก้ไข Casing, Flavor</th>
                                    <th>รายการที่</th>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th>รายละเอียดวัตถุดิบ</th>
                                    <th>หน่วยนับ</th>
                                    <th>คอลัมน์</th>
                                    <th>ข้อมูลเดิม</th>
                                    <th>ข้อมูลที่แก้ไข</th>
                                </tr>
                            </thead>
                            <tfoot>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                            </tfoot>
                        </table>
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
    props:['header', "transBtn", "transDate", "url", "countOpen", "menu", "data"],
    data() {
        return {
            newHeader: {},
            items: [],
        }
    },
    beforeMount() {
        // this.newHeader = JSON.parse(JSON.stringify(this.header));
        // this.newHeader.blend_no = '';
        // this.checkFmlType()
    },
    mounted() {

    },
    computed: {
        // blendLists(){
        //     return this.inputParams.blend_no_list;
        // }
    },
    watch:{
        countOpen : async function (value, oldValue) {
            this.openModal();
            // this.getParam(' ')
            this.fetchData()
        },
    },
    methods: {
        async fetchData() {
            let vm = this;
            vm.items = [];
            $('#myDataTable').DataTable().destroy();
            vm.createDataTable();
            return;
        },
        createDataTable() {
            let vm = this;
            var params = {
                action: 'get-history',
                blend_no: vm.header.blend_no,
                tobacco_type_code: vm.header.tobacco_type_code,
                formula_type_code:vm.header.formula_type_code,
                formula_status: vm.header.formula_status,
                recipe_fiscal_year: vm.header.recipe_fiscal_year
            }
            $('#myDataTable').DataTable({
                pageLength: 50,
                processing: true,
                ajax: {
                    url: vm.url.index,
                    data: params,
                    beforeSend: function(jqXHR, e){
                    },
                    complete: function(jqXHR, textStatus){
                        var newData = jqXHR.responseJSON.data.data;
                        $('#myDataTable').DataTable().clear().rows.add(newData).draw();
                    },
                    error: function(jqXHR, textStatus){
                        console.log('error');
                        $('.dataTables_empty').addClass('warning').html(jqXHR.responseJSON.errors.title).fadeIn('slow');
                    }
                },
                initComplete: function() {
                    this.api()
                      // .columns([0, 1, 2, 3, 4, 5])
                        .columns([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12])
                        .every(function(i) {
                        let column = this;
                        let input;

                        if (i === 999) {
                            input = $(document.createElement("select"));
                            input.append('<option value="">ทั้งหมด</option>');

                            vm.roles.forEach(r => {
                                input.append(`<option value="${r.id}">${r.name}</option>`);
                            });
                        }
                        else {
                            input = $(document.createElement("input"));
                        }

                        input
                            .addClass("form-control form-control-sm")
                            .css("width", "100%")
                            .css("height", "10%")
                            .appendTo($(column.footer()).empty())
                            .on("change", function() {
                                column.search($(this).val(), false, false, true).draw();
                            });
                    });
                    this.find("tfoot tr").appendTo(this.find("thead"));
                }
            })
            // .draw()
            ;
        },
        openModal() {
            $('#historyModal').modal('show');
            $('.slimScroll').slimScroll({
                height: '250px',
                width: '100%'
            });
        },
    }
}
</script>