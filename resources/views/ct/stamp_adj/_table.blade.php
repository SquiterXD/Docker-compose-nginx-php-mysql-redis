<div class="table-responsive mt-3">
    <table class="table text-nowrap table-hover table-bordered" id="data_tb"  style="position: sticky;">
        <thead>
            <tr>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">ลำดับ</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Type</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">กองทุน</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">เปอร์เซนต์</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Dr/Cr</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Company Code</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">EVM</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Department Code</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Cost Center</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Budget Year</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Budget Type</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Budget Detail</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Budget Reason</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Main Account</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Sub Account</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Reserved1</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Reserved2</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">Start Date</th>
                <th class="text-center" style="position: sticky; background-color: #dcdfdb; z-index: 9999; top: 0;">End Date</th>
            </tr>
        </thead>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('#data_tb');
            // var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 10,
                responsive: true,
                // dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                // language: {
                //     loadingRecords: loadingHtml,
                // },
                buttons: [
                ],
            });
        });
    </script>
@stop