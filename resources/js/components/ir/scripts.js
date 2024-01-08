import moment from "moment"

/** VARIABLES */
export let vars = {
    formatDate: 'DD/MM/YYYY',
    formatMonth: 'MM/YYYY',
    formatYear: 'YYYY',
    monthNameShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
}
/** VARIABLES */


/** MOCKS */
export let mocks = {
    irp0001_table_header: [{
        document_number: '',
        status: 'NEW',
        period_year: '2020',
        period_name: 'Jan-20',
        period_from: '12/01/2020',
        period_to: '12/01/2020',
        policy_set_number: '1',
        policy_set_description: 'POLICY SET DESCRIPTION',
        department_code: 'DEPARTMENT CODE',
        department_desc: 'DEPARTMENT DESC',
    }],
    irp0001_table_line: [{
        line_number: '1',
        status: 'NEW',
        period_from: '01/2020',
        period_to: '01/2020',
        period_name: 'Jan-20',
        organization_code: 'ORGANIZATION CODE',
        sub_inventory_code: 'SUB INVENTORY CODE',
        sub_inventory_desc: 'SUB INVENTORY DESC',
        location_code: 'LOCATION CODE',
        location_desc: 'LOCATION DESC',
        item_code: 'ITEM CODE',
        item_description: 'ITEM DESCRIPTION',
        uom_code: 'UOM CODE',
        uom_description: 'UOM DESCRIPTION',
        original_quantity: '12',
        unit_price: '12',
        line_amount: '1212',
        coverage_amount: '343',
        calculate_start_date: '12/04/2021',
        calculate_end_date: '15/04/2021',
        calculate_days: '4',
        line_type: 'MANUAL'
    }, {
        line_number: '2',
        status: 'INTERFACE',
        period_from: '01/2020',
        period_to: '01/2020',
        period_name: 'Jan-20',
        organization_code: 'ORGANIZATION CODE',
        sub_inventory_code: 'SUB INVENTORY CODE',
        sub_inventory_desc: 'SUB INVENTORY DESC',
        location_code: 'LOCATION CODE',
        location_desc: 'LOCATION DESC',
        item_code: 'ITEM CODE',
        item_description: 'ITEM DESCRIPTION',
        uom_code: 'UOM CODE',
        uom_description: 'UOM DESCRIPTION',
        original_quantity: '12',
        unit_price: '12',
        line_amount: '1212',
        coverage_amount: '343',
        calculate_start_date: '12/04/2021',
        calculate_end_date: '15/04/2021',
        calculate_days: '4',
        line_type: 'MANUAL'
    }, {
        line_number: '3',
        status: 'NEW',
        period_from: '01/2020',
        period_to: '01/2020',
        period_name: 'Jan-20',
        organization_code: 'ORGANIZATION CODE',
        sub_inventory_code: 'SUB INVENTORY CODE',
        sub_inventory_desc: 'SUB INVENTORY DESC',
        location_code: 'LOCATION CODE',
        location_desc: 'LOCATION DESC',
        item_code: 'ITEM CODE',
        item_description: 'ITEM DESCRIPTION',
        uom_code: 'UOM CODE',
        uom_description: 'UOM DESCRIPTION',
        original_quantity: '12',
        unit_price: '12',
        line_amount: '1212',
        coverage_amount: '343',
        calculate_start_date: '12/04/2021',
        calculate_end_date: '15/04/2021',
        calculate_days: '4',
        line_type: 'MANUAL'
    }, {
        line_number: '2',
        status: 'CONFIRMED',
        period_from: '01/2020',
        period_to: '01/2020',
        period_name: 'Jan-20',
        organization_code: 'ORGANIZATION CODE',
        sub_inventory_code: 'SUB INVENTORY CODE',
        sub_inventory_desc: 'SUB INVENTORY DESC',
        location_code: 'LOCATION CODE',
        location_desc: 'LOCATION DESC',
        item_code: 'ITEM CODE',
        item_description: 'ITEM DESCRIPTION',
        uom_code: 'UOM CODE',
        uom_description: 'UOM DESCRIPTION',
        original_quantity: '12',
        unit_price: '12',
        line_amount: '1212',
        coverage_amount: '343',
        calculate_start_date: '12/04/2021',
        calculate_end_date: '15/04/2021',
        calculate_days: '4',
        line_type: 'MANUAL'
    }],
    irp0010_table_header: [{
        claim_header_id: '1',
        status: 'NEW',
        document_number: 'Dept-Year-XXX',
        accident_date: '04/08/2019',
        accident_time: '22:00',
        location_code: '',
        location_name: 'สถานีใบยาดอนนางหงส์',
        department_code: '10000000',
        department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
        requestor_id: '',
        requestor_name: 'นายคนดี ว่องไว',
        requestor_tel: '02-345-6667',
        claim_amount: '400000',
        year: '2020',
        // tableLine: [{
        //   line_number: '',
        //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
        //   line_amount: '100000'
        // }, {
        //   line_number: '',
        //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
        //   line_amount: '60000'
        // }],
        // apply: {
        //   apply_companies: [{
        //     company_id: '01',
        //     company_name: 'บริษัทกรุงเทพประกันภัย',
        //     claim_percent: '40',
        //     claim_amount: '160000'
        //   }, {
        //     company_id: '02',
        //     company_name: 'บริษัททิพยประกันภัย',
        //     claim_percent: '40',
        //     claim_amount: '160000'
        //   }]
        // },
        // informant_date: '04/08/2020',
        // invoice_date: '15/03/2020',
        // gl_date: '15/03/2020',
        // ar_invoice_num: '120091228',
        // policy_number: '14016-114-06000',
        // ar_receipt_date: '15/03/2020',
        // ar_receipt_id: '',
        // ar_receipt_number: 'RE12110333',
        // ar_received_amount: '350674.21'
    }, {
        claim_header_id: '2',
        status: 'INTERFACE',
        document_number: 'Dept-Year-XXX',
        accident_date: '04/08/2019',
        accident_time: '22:00',
        location_code: '',
        location_name: 'สถานีใบยาดอนนางหงส์',
        department_code: '10000000',
        department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
        requestor_id: '',
        requestor_name: 'นายคนดี ว่องไว',
        requestor_tel: '02-345-6667',
        claim_amount: '400000',
        year: '2020',
        // tableLine: [{
        //   line_number: '',
        //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
        //   line_amount: '100000'
        // }, {
        //   line_number: '',
        //   line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
        //   line_amount: '60000'
        // }],
        // apply: {
        //   apply_companies: [{
        //     company_id: '01',
        //     company_name: 'บริษัทกรุงเทพประกันภัย',
        //     claim_percent: '40',
        //     claim_amount: '160000'
        //   }, {
        //     company_id: '02',
        //     company_name: 'บริษัททิพยประกันภัย',
        //     claim_percent: '40',
        //     claim_amount: '160000'
        //   }]
        // },
        // informant_date: '04/08/2020',
        // invoice_date: '15/03/2020',
        // gl_date: '15/03/2020',
        // ar_invoice_num: '120091228',
        // policy_number: '14016-114-06000',
        // ar_receipt_date: '15/03/2020',
        // ar_receipt_id: '',
        // ar_receipt_number: 'RE12110333',
        // ar_received_amount: '350674.21'
    }],
    irp0010_form: {
        headers: {
            claim_header_id: '1',
            status: 'NEW',
            document_number: 'Dept-Year-XXX',
            accident_date: '04/08/2019',
            accident_time: '22:00',
            location_code: '',
            location_name: 'สถานีใบยาดอนนางหงส์',
            department_code: '10000000',
            department_name: 'ผู้ว่าการการยาสูบแห่งประเทศไทย',
            requestor_id: '',
            requestor_name: 'นายคนดี ว่องไว',
            requestor_tel: '02-345-6667',
            claim_amount: '400000',
            year: '2020'
        },
        apply: {
            apply_company: [{
                company_id: 55,
                company_name: 'บริษัท เทเวศประกันภัย จำกัด (มหาชน)',
                claim_percent: '40',
                claim_amount: '140000',
                // status: 'INTERFACE',
                apply_details: [{
                    line_number: '',
                    line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
                    line_amount: '100000',
                    claim_detail_id: ''
                }, {
                    line_number: '',
                    line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
                    line_amount: '60000',
                    claim_detail_id: ''
                }],
                informant_date: '04/08/2020',
                invoice_date: '15/03/2020',
                gl_date: '15/03/2020',
                ar_invoice_num: '120091228',
                policy_number: '14016-114-06000',
                ar_receipt_date: '15/03/2020',
                ar_receipt_id: '',
                ar_receipt_number: 'RE12110333',
                ar_received_amount: '350674.21',
                claim_apply_id: '',
                ar_invoice_id: ''
            }, {
                company_id: 54,
                company_name: 'บริษัท ทิพยประกันภัย จำกัด (มหาชน)',
                claim_percent: '60',
                claim_amount: '160000',
                // status: 'NEW',
                apply_details: [{
                    line_number: '',
                    line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันไหลเข้าไปในโรงซื้อใบยาสด - เก็บใบยาแห้ง ทำให้ทรัพย์สินได้รับความเสียหาย',
                    line_amount: '100000',
                    claim_detail_id: ''
                }, {
                    line_number: '',
                    line_description: 'เกิดฝนตกหนัก ทำให้เกิดน้ำท่วมฉับพลันทำให้อาคารเสียหาย',
                    line_amount: '60000',
                    claim_detail_id: ''
                }],
                informant_date: '04/08/2020',
                invoice_date: '15/03/2020',
                gl_date: '15/03/2020',
                ar_invoice_num: '120091228',
                policy_number: '14016-114-06000',
                ar_receipt_date: '15/03/2020',
                ar_receipt_id: '',
                ar_receipt_number: 'RE12110333',
                ar_received_amount: '350674.21',
                claim_apply_id: '',
                ar_invoice_id: ''
            }]
        }
    },
    irp0002_table_line: [{
        status: 'NEW',
        line_number: '',
        period_name: 'Jan-20',
        organization_code: 'ORGANIZATION CODE',
        sub_inventory_code: 'SUB INVENTORY CODE',
        sub_inventory_desc: 'SUB INVENTORY DESC',
        location_code: 'LOCATION CODE',
        location_desc: 'LOCATION DESC',
        item_code: 'ITEM CODE',
        item_description: 'ITEM DESCRIPTION',
        uom_code: 'UOM CODE',
        uom_description: 'UOM DESCRIPTION',
        original_quantity: '111',
        unit_price: '2',
        line_amount: '222',
        coverage_amount: '230',
        calculate_days: '2',
        calculate_start_date: '12/01/2020',
        calculate_end_date: '15/01/2020'
    }]
}
/** MOCKS */


/** FUNCTIONS */
export let funcs = {
    setFirstLetterUpperCase(value) {
        if (value && value !== null && value !== undefined) {
            let lowerLetter = value.toLowerCase()
            let nameCapitalized = lowerLetter.charAt(0).toUpperCase() + lowerLetter.slice(1)
            return nameCapitalized
        }
        return value
    },
    setYearCE(type, value) {
        let result = '';
        // if (type === 'month' && value && value !== null && value !== undefined) {
        //   let arrYearCE = value.split('/')
        //   let yearCE = +arrYearCE[1] - 543
        //   result = `${arrYearCE[0]}/${yearCE}`
        //   return result
        // } else if (type === 'date' && value && value !== null && value !== undefined) {
        //   let arrYearCE = value.split('/')
        //   let yearCE = +arrYearCE[2] - 543
        //   result = `${arrYearCE[0]}/${arrYearCE[1]}/${yearCE}`
        //   return result
        // } else if (type === 'year' && value && value !== null && value !== undefined) {
        //   return +value - 543
        // }
        let format = type === 'month' ? vars.formatMonth :
            type === 'date' ? vars.formatDate :
                type === 'year' ? vars.formatYear : '';
        if (value && format) {
            result = moment(moment(value, format).subtract(543, 'years').toDate()).format(format); // add - 543
            return result
        }
        return result
    },
    setYearBE(type, value) {
        let result = '';
        // if (type === 'month' && value && value !== null && value !== undefined) {
        //   let arrYearCE = value.split('/')
        //   let yearCE = +arrYearCE[1] - 543
        //   result = `${arrYearCE[0]}/${yearCE}`
        //   return result
        // } else if (type === 'date' && value && value !== null && value !== undefined) {
        //   let arrYearCE = value.split('/')
        //   let yearCE = +arrYearCE[2] - 543
        //   result = `${arrYearCE[0]}/${arrYearCE[1]}/${yearCE}`
        //   return result
        // } else if (type === 'year' && value && value !== null && value !== undefined) {
        //   return +value - 543
        // }
        let format = type === 'month' ? vars.formatMonth :
            type === 'date' ? vars.formatDate :
                type === 'year' ? vars.formatYear : '';
        if (value && format) {
            result = moment(moment(value, format).add(543, 'years').toDate()).format(format); // add + 543
            return result
        }
        return result
    },
    showYearBE(type, value) {
        let result = ''
        if (type === 'month' && value && value !== null && value !== undefined) {
            let arrYearBE = value.split('/')
            let yearBE = +arrYearBE[1] + 543
            result = `${arrYearBE[0]}/${yearBE}`
            return result
        } else if (type === 'date' && value && value !== null && value !== undefined) {
            let arrYearBE = value.split('/')
            let yearBE = +arrYearBE[2] + 543
            result = `${arrYearBE[0]}/${arrYearBE[1]}/${yearBE}`
            return result
        } else if (type === 'year' && value && value !== null && value !== undefined) {
            return +value + 543
        }
        return result
    },
    getTime(value, type = 'date') {
        let result = ''
        if (value && value !== null && value !== undefined) {
            let arrDate = value.split('/')
            result = new Date(`${arrDate[1]}/${arrDate[0]}/${arrDate[2]}`).getTime()
            return result
        }
        return result
    },
    calculateDate(start, end) {
        let days = ''
        let qtyDay = ''
        if (start && end) {
            var oneDay = 24 * 60 * 60 * 1000;
            let getTimeStDate = funcs.getTime(start)
            let getTimeEnDate = funcs.getTime(end)
            qtyDay = Math.round(Math.abs((getTimeEnDate - getTimeStDate) / (oneDay)));
            days = qtyDay ? qtyDay + 1 : qtyDay
        }
        return days
    },
    checkStatusInterface(status) {
        if (status) {
            if (status.toUpperCase() === 'INTERFACE') {
                return true
            }
        }
        return false
    },
    checkStatusCancelled(status) {
        if (status) {
            if (status.toUpperCase() === 'CANCELLED') {
                return true
            }
        }
        return false
    },
    isNullOrUndefined(value) {
        if (value === null || value === undefined) {
            return ''
        }
        return value
    },
    formatCurrency(number, decimalValue = 2) {
        let num = ''
        if (number || number === 0) {
            num = parseFloat(number)
            let covertToCurrency = num.toFixed(decimalValue).split('.')
            let currency = null
            if (covertToCurrency[1] === undefined) {
                let decimal = parseInt(covertToCurrency[0]).toFixed(decimalValue).split('.')[1]
                currency = `${parseInt(covertToCurrency[0]).toLocaleString()}.${decimal}`
                return currency
            } else {
                if (num.toString().split('.')[0] == 0) {
                    let decimal = num.toFixed(decimalValue).split('.')[1]
                    return `${num.toString().split('.')[0]}.${decimal}`
                }
                let decimal = num.toFixed(decimalValue).split('.')[1]
                let currency = `${parseInt(covertToCurrency[0]).toLocaleString()}.${decimal}`
                return currency
            }
            // let setNum = num.toFixed(decimal).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
            // return setNum
        }
        return num
    },
    formatfloat(number) {
        let digit = "2"
        return number.slice(0, (number.indexOf(".")) + 1 + +digit);
    },

    checkStatusConfirmed(status) {
        if (status) {
            if (status.toUpperCase() === 'CONFIRMED') {
                return true;
            }
            return false;
        }
    },
    showPeriodNameFormat(period_name) {
        if (period_name) {
            let period_nameStr = period_name.split('-')
            let getDate = new Date(`${period_nameStr[0]} 01, ${period_nameStr[1]}`)
            let year = getDate.getFullYear()
            let month = (getDate.getMonth() + 1).toString().length === 1 ? `0${getDate.getMonth() + 1}` : getDate.getMonth() + 1
            return `${month}/${year + 543}`
        }
        return period_name
    },
    setValuePeriodNameFormat(date) {
        let period_name = '';
        if (date && date !== null && date !== undefined) {
            let monthName = vars.monthNameShort[date.getMonth()];
            let getFullYearCE = +date.getFullYear() - 543;
            let getFullYearCEStr = getFullYearCE.toString();
            let yearShort = getFullYearCEStr.substr(getFullYearCEStr.length - 2);
            period_name = `${monthName}-${yearShort}`;
        }
        return period_name
    },
    checkStatusNew(status) {
        if (status) {
            if (status.toUpperCase() === 'NEW') {
                return true
            }
        }
    },
    calculateDateMomentTable(row) {
        let formatDate = vars.formatDate;
        let momentStDate = '';
        let momentEnDate = '';
        let days = '';
        let start = row.start_calculate_date
        let end = row.end_calculate_date
        if (start && end) {
            let full_date_st = helperDate.convertDate(start, formatDate)
            let full_date_en = helperDate.convertDate(end, formatDate)
            full_date_st.then((st) => {
                momentStDate = moment(st, formatDate)
                full_date_en.then((en) => {
                    momentEnDate = moment(en, formatDate)
                    days = momentEnDate.diff(momentStDate, 'days')
                    row.days = Math.sign(days) === -1 ? '' : days + 1;
                })
            })
        } else {
            row.days = ''
        }
    },
    covertFomatDateMoment(date, type) {
        let format = type === 'date' ? vars.formatDate :
            type === 'month' ? vars.formatMonth :
                type === 'year' ? vars.formatYear : '';
        if (date && type) {
            return moment(date).format(format);
        }
        return '';
    },
    getDateByBudgetYear(year){
        let date = {
            start: '',
            end: '',
        }

        if(year){
            let currentYear = year.getFullYear();
            let cycle = moment({'year': currentYear, 'month': 8, 'date': 30});
            let stMoMent = moment({'year': year.getFullYear(), 'month': year.getMonth(), 'date': year.getDate()});
            let offset = stMoMent.isAfter(cycle) ? 1 : 0;
            date.end = moment(moment({'year': currentYear + offset, 'month': 8, 'date': 30}), vars.formatDate).toDate();
            date.start = moment(moment({'year': (currentYear +offset)-1 , 'month': 9, 'date': 1}), vars.formatDate).toDate();
        }

        return date;
    },
    setBudgetYearFromFieldStCalendar(start, type = 'date') {
        let format = type === 'date' ? vars.formatDate :
            type === 'month' ? vars.formatMonth :
                type === 'year' ? vars.formatYear : '';
        let budgetYear = '';

        if (start) {
            let currentYear = start.getFullYear();
            let cycle = moment({'year': currentYear, 'month': 8, 'date': 30});
            let stMoMent = moment({'year': start.getFullYear(), 'month': start.getMonth(), 'date': start.getDate()});
            let offset = stMoMent.isAfter(cycle) ? 1 : 0;
            return moment(moment({'year': currentYear + offset, 'month': 8, 'date': 30}), vars.formatDate).toDate();

            let getMonth = start.getMonth();
            if (getMonth > 8 || getMonth === 10) {
                let nextYearFull = moment(start).add(1, 'years').format(vars.formatYear);
                let nextYearNum = nextYearFull ? +nextYearFull : nextYearFull;
                budgetYear = moment.utc().set({'year': nextYearNum, 'month': 8, 'date': 30}); // month = 8 is Sept
                return moment(budgetYear, vars.formatDate).toDate();
                // return budgetYear.format(vars.formatDate);
            } else {
                let year = moment(start).format(vars.formatYear);
                let yearNum = year ? +year : year;
                budgetYear = moment.utc().set({'year': yearNum, 'month': 8, 'date': 30}); // month = 8 is Sept
                return moment(budgetYear, vars.formatDate).toDate();
                // return budgetYear.format(vars.formatDate);
            }
            // // let nextYearFormat = moment(nextYearFull).format(vars.formatYear);
            // let nextYearNum = nextYearFull ? +nextYearFull : nextYearFull;
            // budgetYear = moment.utc().set({'year': nextYearNum, 'month': 8, 'date': 30}); // month = 8 is Sept
            // // var newDate = moment.utc();
            // // newDate.set('year', nextYearNum);
            // // newDate.set('month', 8); // month = 8 is Sept
            // // newDate.set('date', 30);
            // // // newDate.startOf('day');
            // return budgetYear;
        }
        return budgetYear;
    },
    setLabelStatusAsset(status) {
        if (status === 'Y') {
            return 'Active';
        } else if (status === 'N') {
            return 'Inactive';
        } else {
            return '';
        }
    },
    setFotmatPeriodNameIsFullDate(period_name) {
        if (period_name) {
            let periodNameStr = period_name.split('-');
            let getDate = new Date(`${periodNameStr[0]} 01, ${periodNameStr[1]}`);
            return moment(getDate).format(vars.formatDate);
        }
        return '';
    },
    setFullDateIsDateCE(fullDate) {
        let dateCE = '';
        if (fullDate) {
            let dateBE = moment(fullDate).format(vars.formatDate);
            dateCE = funcs.setYearCE('date', dateBE);
            return dateCE;
        }
        return dateCE;
    },
    setLabelExpenseFlag(flag) {
        if (flag == 'Y') {
            return 'Yes';
        }
        return 'No';
    },
    setLabelVatRefund(flag) {
        if (flag == 'Y') {
            return 'Yes';
        }
        return 'No';
    },
    // IRM0001, IRM0002
    setDefaultActive(classNameCheckbox) {
        let checked = $(`.${classNameCheckbox}`).is(':checked');
        $(`.${classNameCheckbox}`).prop('checked', !checked);
    },
    setDefaultEndDateIsLastDateOfMonth(startFullDate) {
        let formatDate = vars.formatDate;
        let result = '';
        if (startFullDate) {
            let lastDateOfMonth = moment(startFullDate).endOf('month');
            return moment(lastDateOfMonth).format(formatDate);
        }
        return result;
    }
}
/** FUNCTIONS */
