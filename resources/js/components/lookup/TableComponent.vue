<template>
    <div>
        <div v-if="this.irs">
            <td></td>
        </div>
        <div v-else>
            <td></td>
        </div>
    </div>
</template>
<script>
export default {
    // , 'defaultValue', 'urlEdit', 'urlDelete'
    props: ['program', 'programColumns', 'irs', 'lookup'],

    data(){
        return {
            // data_value: this.defaultValue ? this.defaultValue : '',
            // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        getData(){
            $('.transactions_tb').DataTable({pageLength: 25, searching: false, lengthChange: false, bPaginate: false,
                bInfo: false,
                responsive: true,
                aaSorting: [],
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {
                        extend: 'csv', 
                        title: "Transaction_CSV_"+moment().format('YYYYMMDD'),
                    },
                    {
                        extend: 'excel', 
                        title: "Transaction_EXCEL_"+moment().format('YYYYMMDD'),
                    },
                ],
            });
        }
    }
}
</script>