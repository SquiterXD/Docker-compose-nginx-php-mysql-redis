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
        src: url("file://{!! public_path('/fonts/THSarabunNew.ttf') !!}") format('truetype');
    }
    @font-face {
        font-family: 'THSarabunNew';
        font-style: normal;
        font-weight: normal;
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
        font-weight: normal;
        src: url("file://{!! public_path('/fonts/THSarabunNew Bold.ttf') !!}") format('truetype');
    }
    body {
        margin: -1;
        font-family: "THSarabunNew";
        font-size: 16px;
        line-height: 1;
        padding: 0;
    }


    table, thead, tbody, tfoot, th, tr, td {
        border-collapse: collapse;
        page-break-inside:avoid;
        page-break-after:auto;

    }

    tr{
        /* border: 1px solid #000; */
        padding: 5px;
        margin: 0px;
    }
    
    th, td {
        padding: 3px;
    }

    /* tr,td{
        font-weight:bold;
    } */
    .font-bold{
        font-weight:bold;
    }
    .table-tb{
        width: 100%;
        margin-top: 2px;

    }

    /* .table-footer>thead>tr>th {
        text-align: center;
        padding: 0;
        margin: 0;
        page-break-inside:avoid;
        page-break-after:auto;
    } */





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


    /* .row {
        display: flex;
        flex-direction: row;
        height: 20px;
    }

    .col {
        display: flex;
        flex-direction: column;
    } */

  
    .page-break {
        page-break-after: always;
    }

    /* .word-wrap {
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
    } */
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

    /* .td-top{
        border-bottom: none; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 0.5px solid black; 
    } */

    .td-border-none{
        border-right: 0.01em  solid black;
    }
    .td-border-r{
        border-right: 0.01em  solid black;
    }
    .td-border-left{
        border-left: 0.01em  solid black; border-right: 0.01em  solid black; 
    }
    .td-border-lr{
        border-left: 0.01em  solid black; border-right: 0.01em  solid black;
    }
    .td-border-l{
        border-left: 0.01em  solid black;
    }
    .td-border-full{
        border: 0.01em  solid black;
    }
    .td-border{
        border-right: 0.01em  solid black; border-top: 0.01em solid black; border-bottom: 0.01em solid black; 
    }
    .td-border2{
        border-right: 0.01em  solid black; border-bottom: 0.01em solid black;
    }
    .td-border3{
        border-top: 0.01em  solid black; border-right: 0.01em  solid black; border-bottom: 0.01em solid black; 
    }

</style>
