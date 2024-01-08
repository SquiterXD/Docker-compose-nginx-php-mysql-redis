<table class="table">
    <thead>
        <tr>
            <th width="20%" class="text-center">
                <div> ปีงบประมาณ </div>
            </th>
            <th width="20%" class="text-center">
                <div> งวดที่ </div>
            </th>
            <th width="20%" class="text-right">
                <div> วันที่เริ่มต้น </div>
            </th>
            <th width="20%" class="text-right">
                <div> วันที่สิ้นสุด </div>
            </th>
        </tr>
    </thead>
    <tbody>
        <template v-if="periodLists.length">
            <template v-for="list in periodLists">
                <tr>
                    <td class="text-center">
                        @{{ budget_year }}
                    </td>
                    <td class="text-center">
                        @{{ list.period_no }}
                    </td>
                    <td class="text-right">
                        @{{ list.start_period }}
                    </td>
                    <td class="text-right">
                        @{{ list.end_period }}
                    </td>
                </tr>
            </template>
        </template>
    </tbody>
</table>

<div class="col-12 mt-3" v-if="periodLists.length">
    <hr>
    <div class="row clearfix m-t-lg text-right">
        <div class="col-sm-12">
            <button class="btn btn-sm btn-primary" @click.prevent="save()"> <i class="fa fa-save"></i> บันทึก </button>
            <a href="{{ $actionUrl }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
        </div>
    </div>
</div>