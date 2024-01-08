<style>
    @page {
        margin-top: 20;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        size: A4;
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
        src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: bold;
        src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: normal;
        src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: italic;
        font-weight: bold;
        src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
    }
    body {
        margin: 0;
        font-family: "THSarabunNew";
        font-size: 16px;
        line-height: 1;
        padding: 0;
    }


    table, thead, tbody, tfoot, th, tr, td {
        border-collapse: collapse;
        height: 10px;
        page-break-inside:avoid;
        page-break-after:auto;

    }

    .body-border-color tr, th {
        padding: 2px; 
        border-top: 1px  solid #000;
        border-bottom: 1px  solid #000;
        
    }


    .p-h2 {
        padding: 0px;
        margin: 0px;
    }


    /* .table{
        width: 100%;
        margin-top: -1.5px;
        margin-bottom: -1.5px;
        padding-left: -0.5px;
        padding-right: -0.5px;
        page-break-inside:avoid;
        page-break-after:auto;
    }  */

    /* .table-footer>thead>tr>th {
        text-align: center;
        padding: 0px;
        margin: 0px;
        page-break-inside:avoid;
        page-break-after:auto;
    } */

    .row {
        display: -webkit-box; /* wkhtmltopdf uses this one */
        display: flex;
        -webkit-box-pack: center; /* wkhtmltopdf uses this one */
        justify-content: center;
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

    .col {
    -ms-flex-preferred-size: 0;
        flex-basis: 0;
    -webkit-box-flex: 1;
        -ms-flex-positive: 1;
            flex-grow: 1;
    max-width: 100%;
    }

    .col-md-2 {
        -webkit-box-flex: 0;
            -ms-flex: 0 0 16.66666667%;
                flex: 0 0 16.66666667%;
        max-width: 16.66666667%;
    }

    .col-md-4 {
        -webkit-box-flex: 0;
            -ms-flex: 0 0 33.33333333%;
                flex: 0 0 33.33333333%;
        max-width: 33.33333333%;
    }

    .col-md-6 {
        -webkit-box-flex: 0;
            -ms-flex: 0 0 50%;
                flex: 0 0 50%;
        max-width: 50%;
    }

    .col-md-10 {
        -webkit-box-flex: 0;
            -ms-flex: 0 0 83.33333333%;
                flex: 0 0 83.33333333%;
        max-width: 83.33333333%;
    }

    .col-md-12 {
        -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
                flex: 0 0 100%;
        max-width: 100%;
    }


    /* .flex-container > div {
        width: 100%;
        text-align: center;
        line-height: 75px;
        font-size: 30px;
    } */

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

    /* .row {
        display: flex;
        flex-direction: row;
        height: 20px;
    }

    .col {
        display: flex;
        flex-direction: column;
    } */

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
        /* margin-top: -240px; */
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

    .empty-box {
        border: 1px solid #000;
        width: 15px;
        height: 15px;
        display: inline-block;
    }

    .footer-top {
        width: 100%;
        height: 170px;
        padding-right: -3px;
        border: 1px solid #000;
        display: inline-block;
    }

    .footer-bottom {
        width: 100%;
        height: 190px;
        margin-top: -1px;
        padding-right: -3px;
        border: 1px solid #000;
        display: inline-block;
    }

    .footer-condition {
        width: 55%;
        height: 145px;
        margin-top: -1px;
        padding-right: -3px;
        border: 1px solid #000;
        display: inline-block;
    }

    .footer-payfor {
        width: 45%;
        height: 145px;
        margin-left: -4px;
        border: 1px solid #000;
        display: inline-block;
    }

    .footer-request {
        width: 55%;
        height: 160px;
        margin-top: 2px;
        padding-right: -3px;
        border: 1px solid #000;
        display: inline-block;
    }

    .footer-check {
        width: 45%;
        height: 160px;
        margin-left: -4px;
        border: 1px solid #000;
        display: inline-block;
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
    .td-b-l {
        border-left: 1px solid #000;
    }

    .td-b-r {
        border-right: 1px solid #000;
    }

    .td-b-rl {
        border-right: 1px solid #000;
        border-left: 1px solid #000;
    }

    .td-b-b {
        border-bottom: 1px solid #000;
    }
    .td-b-bt {
        border-bottom: 1px solid #000;
        border-top: 1px solid #000;
    }
    .pagenum:after {
        content: counter(page);
    }

    
    #content {
        display: table;
    }

    #pageFooter {
        display: table-row-group;
    }

    #pageFooter:before {
        counter-increment: page;
        content: counter(page);
    }
    .color-td {
        color:#3B3B3B;
    }

    footer .pagenum:before {
            content: counter(page);
    }

    /*@import url('https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap');*/


/* hr { background-color: black; height: 1px; border: 0; } */


</style>
