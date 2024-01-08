@php
    $total_pao_tax_amount = 0;
    $data_txt = '';
    $header_txt = printWithSpace(1, 'H')
        .printWithSpace(10, '003')
        .printWithSpace(100, $hrLocationV->attribute1)
        .printWithSpace(70, $hrLocationV->address_line_1)
        .printWithSpace(70, $hrLocationV->address_line_2.' '.$hrLocationV->address_line_3)
        .printWithSpace(70, $hrLocationV->region_2)
        .printWithSpace(5, $hrLocationV->postal_code)
        .printWithSpace(20, $bankAccount->description)
        .printWithSpace(15, $hrLocationV->attribute4)
        .printWithSpace(15, '')
        .printWithSpace(8, $check_date)
        .printWithSpace(35, '001')
        .printWithSpace(25, '')
        .printWithSpace(5, '')
        .printWithSpace(1049, '')
        .printWithSpace(1, "\r\n");
    foreach ($data as $index => $item) {
        $data_txt .= printWithSpace(1, 'D')
            .printWithSpace(20, 'TOBACCO'.sprintf('%04d', $index+1))
            .printWithSpace(20, '')
            .printWithSpace(20, '')
            .printWithSpace(15, '-')
            .printWithSpace(1, 'C')
            .printWithSpace(100, $item['pao_account_name'])
            .printWithSpace(15, '')
            .printWithSpace(70, $item['payee_address1'] ?? '-')
            .printWithSpace(70, $item['payee_address2'] ?? '-')
            .printWithSpace(70, $item['payee_address3'] ?? '-')
            .printWithSpace(5, $item['post_code'] ?? '-')
            .printWithSpace(3, '')
            .printWithSpace(20, '')
            .printWithSpace(8, $check_date)
            .printWithSpace(20, '')
            .printWithSpace(20, '')
            .printWithSpace(5, '')
            .printWithSpace(20, '')
            .printWithSpace(20, '')
            .printWithSpace(20, '')
            .printWithSpace(20, number_format($item['pao_tax_amount'],2))
            .printWithSpace(2, $item['type'] == 'mt' ? 'RC' : 'MR')
            .printWithSpace(15, $item['type'] == 'mt' ? '009' : '700')
            .printWithSpace(10, '')
            .printWithSpace(5, '')
            .printWithSpace(8, '')
            .printWithSpace(1, 'B')
            .printWithSpace(20, '')
            .printWithSpace(70, '')
            .printWithSpace(20, '')
            .printWithSpace(8, '')
            .printWithSpace(3, '')
            .printWithSpace(1, '1')
            .printWithSpace(1, '1')
            .printWithSpace(200, '')
            .printWithSpace(15, '')
            .printWithSpace(25, '')
            .printWithSpace(30, '')
            .printWithSpace(151, '')
            .printWithSpace(350, '')
            .printWithSpace(1, "\r\n");
        $data_txt .= printWithSpace(1, 'M')
            .printWithSpace(20, 'TOBACCO'.sprintf('%04d', $index+1))
            .printWithSpace(20, '')
            .printWithSpace(20, '')
            .printWithSpace(100, $item['customer_name'])
            .printWithSpace(70, $item['payee_address1'])
            .printWithSpace(70, $item['payee_address2'])
            .printWithSpace(70, $item['payee_address3'])
            .printWithSpace(5, $item['post_code'])
            .printWithSpace(50, '')
            .printWithSpace(50, '')
            .printWithSpace(50, '')
            .printWithSpace(8, '')
            .printWithSpace(100, 'แคชเชียร์เช็ค 1 ฉบับ ประจำเดือน '.$period_check_date)
            .printWithSpace(100, 'จำนวนมวน '.number_format($item['quantity'], 2).' พันมวน')
            .printWithSpace(100, 'จำนวนเงินภาษี อบจ. '.number_format($item['pao_tax_amount'], 2).' บาท')
            .printWithSpace(100, $item['pao_account_name'])
            .printWithSpace(25, '')
            .printWithSpace(30, '')
            .printWithSpace(200, '')
            .printWithSpace(309, '')
            .printWithSpace(1, "\r\n");
        $total_pao_tax_amount += $item['pao_tax_amount'];
    }
    $footer_txt = printWithSpace(1, 'T')
        .printWithSpace(35, '001')
        .printWithSpace(15, count($data))
        .printWithSpace(20, number_format($total_pao_tax_amount, 2))
        .printWithSpace(15, '0')
        .printWithSpace(20, '0.000')
        .printWithSpace(15, '0')
        .printWithSpace(20, '0')
        .printWithSpace(15, count($data))
        .printWithSpace(25, '')
        .printWithSpace(1317, '')
        .printWithSpace(1, "\r\n");
    $all_txt = $header_txt.$data_txt.$footer_txt;
@endphp
{!! $all_txt !!}