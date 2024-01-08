<style>

    @include('ir.reports.irr8020._set_font')

    @page {
        padding-top: 31.4px;
        /* padding-bottom: 31.4px; */
        padding-left: 31.4px;
        padding-right: 31.4px;
    }

    .page-number:before {
        counter-increment: page;
        content: "หน้า " counter(page);
    }

    table, thead, tbody, tfoot, th, tr, td {
        border: 0.5px solid rgb(200, 200, 200);
        border-collapse: collapse;
        height: 20px;
    }

    th, td {
        padding: 3px;
    }

    .table{
        width: 100%;
        margin-top: -1.5px;
        margin-bottom: -1.5px;
        padding-left: -0.5px;
        padding-right: -0.5px;
    }

    .table-footer>thead>tr>th {
        border-bottom: 0px solid #fff;
        border-left: 0px solid #fff;
        border-right: 0px solid #fff;
        border-top: 0px solid #fff;
        padding-left: 0.6rem;
        padding-right: 0.6rem;
    }

    .table-footer>tbody>tr>td {
        border-bottom: 0px solid #fff;
        border-left: 0px solid #fff;
        border-right: 0px solid #fff;
        border-top: 0px solid #fff;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .row {
        display: -webkit-box; /* wkhtmltopdf uses this one */
        display: flex;
        -webkit-box-pack: center; /* wkhtmltopdf uses this one */
        justify-content: flex-start;
        margin-bottom: 3px;
    }

    .row > div {
        -webkit-box-flex: 1;
        -webkit-flex: 1;
        flex: 1;
    }

    .row > div:last-child {
        margin-right: 0;
    }

    h1,
    .h1 {
        font-size: 30;
    }

    h5,
    .h5 {
        font-size: 8;
    }

    .border {
        margin-top : -1px;
        border: 1px solid #000;
    }

    .text-right {
        text-align: right !important;
    }

    .text-center {
        text-align: center !important;
    }

    .text-left {
        text-align: left !important;
    }

    .n-mg-t-23 {
        margin-top: -230px;
    }

    .n-mg-t-25 {
        margin-top: -250px;
    }

    .n-mg-b-23 {
        margin-bottom: -230px;
    }

    .pd-t-1 {
        padding-top: 10px;
    }

    .n-pd-t-1 {
        padding-top: -10px;
    }

    .n-pd-t-1 {
        padding-top: -10px;
    }

    .header-box {
        border: 1px solid #000;
    }

    .box {
        border: 1px solid #000;
        width: 18px;
        height: 18px;
        display: inline-block;
    }

    .box p {
        width: 18px;
        height: 18px;
        margin-top: -4px;
    }

    .b {
        font-weight: bold;
    }

    .inline {
        display: inline;
    }

    .inline-block {
        vertical-align: middle;
        display: inline-block;
    }

    .dashed {
        padding-bottom: -1px;
        width: 100%;
        border-bottom: 1px dashed #000;
        display: inline-block;
    }

    .u {
        text-decoration: underline;
    }

    .underline {
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-50 {
        width: 50px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-100 {
        width: 100px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-150 {
        width: 150px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-200 {
        width: 200px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-250 {
        width: 250px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .underline-300 {
        width: 300px;
        border-bottom: 0.5px solid black;
        display: inline-block;
    }

    .page-break {
        page-break-after: always;
    }

    .word-wrap {
        word-wrap: break-word;
    }

    .report_header{
        font-size: 18px;
        text-align: center;
        border: 0.5px solid #000000;
        vertical-align: middle;
        padding: 7px;
    }

    .report_qty{
        font-size: 16px;
        border: 0.5px solid #000000;
        text-align: right;
        padding: 4px;
    }

    .footer{
        width:25%;
        padding-top: 50px;
        padding-bottom: 5px;
        padding-left: 5px;
        padding-right: 5px;
        vertical-align: text-top;
    }

    footer {
        position: fixed;
        bottom: 25px;
        left: 0px;
        right: 0px;
        height: 100px;
        color: black;
        text-align: center;
    }
</style>