@font-face {
font-family: 'THSarabunNew';
font-style: normal;
font-weight: normal;
src: url("{{ base_path() }}/public/fonts/THSarabunNew.ttf") format("truetype");
}

@font-face {
font-family: 'THSarabunNew';
font-style: normal;
font-weight: bold;
src: url("{{ base_path() }}/public/fonts/THSarabunNew Bold.ttf") format("truetype");
}

@font-face {
font-family: 'THSarabunNew';
font-style: italic;
font-weight: normal;
src: url("{{ base_path() }}/public/fonts/THSarabunNew Italic.ttf") format("truetype");
}

@font-face {
font-family: 'THSarabunNew';
font-style: italic;
font-weight: bold;
src: url("{{ base_path() }}/public/fonts/THSarabunNew BoldItalic.ttf") format("truetype");
}

body {
margin: 0;
font-family: "THSarabunNew";
font-size: 16px;
line-height: 1;
padding: 0;
}


table {
page-break-inside: avoid;
}

thead {
display: table-header-group
}

tfoot {
display: table-row-group
}

tr {
page-break-inside: avoid
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

.report_header {
font-size: 18px;
text-align: center;
border: 0.5px solid #000000;
vertical-align: middle;
padding: 7px;
}

