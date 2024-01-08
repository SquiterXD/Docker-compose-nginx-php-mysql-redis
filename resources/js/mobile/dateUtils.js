import {DateTime} from "luxon";
import _merge from 'lodash/merge';

/**
 * return helper and config object for setting vue2-datepicker display buddhist year
 * @param customConfig object
 * @param yearDisplayQuerySelector string|null
 * @returns object
 */
export function customBuddhistYearDatePicker(customConfig = {}, yearDisplayQuerySelector = null) {

    if (yearDisplayQuerySelector === null) {
        yearDisplayQuerySelector = '.mx-datepicker-main .mx-btn-current-year, .mx-datepicker-main .mx-calendar-header-label span, .mx-datepicker-main .mx-table-year div, .mx-datepicker-main .mx-calendar-header-label .mx-btn-text';
    }

    let config = {
        lang: {
            formatLocale: {
                months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                weekdaysShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
                weekdaysMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
                firstDayOfWeek: 0,
            },
            yearFormat: 'YYYY',
            monthFormat: 'MMM',
            monthBeforeYear: true
        },
        formatter: {
            //[optional] Date to String
            stringify: (date) => {
                let d = DateTime.fromJSDate(date);
                return date ? `${d.toFormat('dd/MM')}/${parseInt(d.toFormat('yyyy')) + 543}` : '';
            },
            //[optional]  String to Date
            parse: (value) => {
                let ds = value.split('/');
                if (ds.length !== 3 || ds.filter(it => isNaN(it)).length > 0) return null;
                let d = `${ds[0]}/${ds[1]}/${ds[2] - 543}`;
                return value ? DateTime.fromFormat(value, 'DD/MM/YYYY').toJSDate() : null;
            },
        },
        onUiFrameChange(...args) {
            Vue.nextTick(() => {
                let currentYear = args.length === 3 && args[0] instanceof Date ? args[0].getFullYear() : null;
                let els = $(yearDisplayQuerySelector);
                els.each(function () {
                    let el = $(this);
                    let text = el.text();
                    if (isNaN(text.trim())) return;
                    let displayYear = currentYear ? currentYear : parseInt(text);
                    if (displayYear < 2100) el.text(displayYear + 543);
                });
            });
        },
        dateInRange(minDate, maxDate, isIncludeTargetDate = true) {
            //return true for disabled date
            return (targetDate) => !isInRange(targetDate, minDate, maxDate, isIncludeTargetDate);
        },
    };

    return _merge(config, customConfig);
}

/**
 * convert value to JavaScript Date
 * if value is string, it will convert to Date by luxon's format (https://moment.github.io/luxon/docs/manual/formatting)
 * if format is null, it will convert string by ISO format
 * return null if it cannot convert to Date
 *
 * Test Case
 * toJSDate(null) null
 * toJSDate(1621267465092) Mon May 17 2021 23:04:25 GMT+0700 (Indochina Time)
 * toJSDate('2021-02-01') Mon Feb 01 2021 00:00:00 GMT+0700 (Indochina Time)
 * toJSDate('01/02/2021') null
 * toJSDate('01/02/2021', 'dd/MM/yyyy') Mon Feb 01 2021 00:00:00 GMT+0700 (Indochina Time)
 * toJSDate(new Date('2021-02-01')) Mon Feb 01 2021 07:00:00 GMT+0700 (Indochina Time)
 * toJSDate(DateTime.fromJSDate(new Date('2021-02-01'))) Mon Feb 01 2021 07:00:00 GMT+0700 (Indochina Time)
 * toJSDate(DateTime.fromJSDate(new Date('2021-99-99'))) null
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {Date|null}
 */
export function toJSDate(value, format = null) {
    if (value === null) return null;
    if (value instanceof Date) return value;
    if (value instanceof DateTime) return value.isValid ? value.toJSDate() : null;
    if (typeof value === 'number') return new Date(value);
    if (typeof value === 'string') {
        let d = typeof format === 'string' ? DateTime.fromFormat(value, format) : DateTime.fromISO(value);
        return d.isValid ? d.toJSDate() : null;
    }
    return null;
}

/**
 * convert value to luxon DateTime
 * if value is string, it will convert to Date by luxon's format (https://moment.github.io/luxon/docs/manual/formatting)
 * if format is null, it will convert string by ISO format
 *
 * Test Case
 * toDateTime(null) DateTime >> {ts: 1621321275092, _zone: LocalZone, loc: Locale, invalid: Invalid, weekData: null, >> …}
 * toDateTime(1621267465092) DateTime >> {ts: 1621267465092, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime('2021-02-01') DateTime >> {ts: 1612112400000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime('01/02/2021') DateTime >> {ts: 1621321275121, _zone: LocalZone, loc: Locale, invalid: Invalid, weekData: null, >> …}
 * toDateTime('01/02/2021', 'dd/MM/yyyy') DateTime >> {ts: 1612112400000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(new Date('2021-02-01')) DateTime >> {ts: 1612137600000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(DateTime.fromJSDate(new Date('2021-02-01'))) DateTime >> {ts: 1612137600000, _zone: LocalZone, loc: Locale, invalid: null, weekData: null, >> …}
 * toDateTime(DateTime.fromJSDate(new Date('2021-99-99'))) DateTime >> {ts: 1621321275131, _zone: LocalZone, loc: Locale, invalid: Invalid, week
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {DateTime}
 */
export function toDateTime(value, format = null) {
    if (value instanceof DateTime) return value;
    return DateTime.fromJSDate(toJSDate(value, format));
}

/**
 * check targetDate is in range between minDate to maxDate
 * if isIncludeTargetDate is true (default) minDate and maxDate will included in check range [minDate, maxDate]
 * else minDate and maxDate will not included in check range (minDate, maxDate)
 *
 * Test Case
 * isInRange('2021-01-15', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-02-15', '2021-01-01', '2021-01-31', true) false
 * isInRange('2021-01-01', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-01-01', '2021-01-01', '2021-01-31', false) false
 * isInRange('2021-01-31', '2021-01-01', '2021-01-31', true) true
 * isInRange('2021-01-31', '2021-01-01', '2021-01-31', false) false
 * isInRange('2021-01-15', '2021-01-01', null) true
 * isInRange('2021-01-15', null, '2021-01-31') true
 * isInRange('2021-01-01', '2021-01-15', null) false
 * isInRange('2021-01-31', null, '2021-01-15') false
 *
 * @param targetDate Date|DateTime|number|string|null
 * @param minDate Date|DateTime|number|string|null
 * @param maxDate Date|DateTime|number|string|null
 * @param isIncludeTargetDate bool
 * @returns {boolean}
 */
export function isInRange(targetDate, minDate, maxDate, isIncludeTargetDate = true) {

    //convert targetDate/minDate/maxDate to DateTime
    targetDate = DateTime.fromJSDate(toJSDate(targetDate));
    minDate = DateTime.fromJSDate(toJSDate(minDate));
    maxDate = DateTime.fromJSDate(toJSDate(maxDate));

    let isMinDateValid = !!(minDate && minDate instanceof DateTime && minDate.isValid);
    let isMaxDateValid = !!(maxDate && maxDate instanceof DateTime && maxDate.isValid);

    if ((!isMinDateValid && !isMaxDateValid) || !targetDate) {
        return true;
    }

    minDate = isMinDateValid ? minDate.startOf('day') : null;
    maxDate = isMaxDateValid ? maxDate.startOf('day') : null;

    if (minDate && maxDate) {
        if (isIncludeTargetDate) {
            if (minDate.hasSame(targetDate, 'day') || maxDate.hasSame(targetDate, 'day')) {
                return true;
            }
        }

        return (minDate < targetDate && targetDate < maxDate);
    }

    if (minDate) {
        if (minDate.hasSame(targetDate, 'day')) {
            return isIncludeTargetDate;
        }
        return (minDate.startOf('day') <= targetDate);
    }

    if (maxDate) {
        if (maxDate.hasSame(targetDate, 'day')) {
            return isIncludeTargetDate;
        }
        return (maxDate.startOf('day') >= targetDate);
    }

    return false;
}

/**
 * convert DateTime to string based on format
 * @param dateTime DateTime
 * @param dateFormat string
 * @param defaultValue string|null
 * @returns {string|null}
 */
export function dateTimeToString(dateTime, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
    if (!dateTime || (dateTime instanceof DateTime)) {
        return defaultValue;
    }

    if (dateTime && dateTime.isValid) {
        return dateTime.toFormat(dateFormat);
    } else {
        return defaultValue;
    }
}

/**
 * convert Date to string based on format
 * @param jsDate Date
 * @param dateFormat string
 * @param defaultValue string
 * @returns {string|null}
 */
export function jsDateToString(jsDate, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
    if (!jsDate) {
        return defaultValue;
    }

    let dateTime = DateTime.fromJSDate(jsDate);
    if (dateTime && dateTime.isValid) {
        return dateTime.toFormat(dateFormat);
    } else {
        return defaultValue;
    }
}

/**
 * return date string with buddhist year (ex. 31/01/2564)
 *
 * Test Case
 * toThDateString(1621267465092) 17/05/2564
 * toThDateString('2021-02-01') 01/02/2564
 * toThDateString('2021-99-99') null
 * toThDateString('01/02/2021', 'dd/MM/yyyy') 01/02/2564
 * toThDateString(new Date('2021-02-01')) 01/02/2564
 * toThDateString(new Date('2021-99-99')) null
 * toThDateString(DateTime.fromISO('2021-02-01')) 01/02/2564
 * toThDateString(DateTime.fromISO('2021-99-99')) null
 *
 * @param value Date|DateTime|number|string|null
 * @param format string|null
 * @returns {string|null}
 */
export function toThDateString(value, format = null) {
    let date = toJSDate(value, format);
    if (!date) return null;
    let dateTime = DateTime.fromJSDate(date);
    return dateTime.isValid ? dateTime.toFormat('dd/MM/') + (date.getFullYear() + 543) : null;
}

// export function customBuddhistYearDatePicker(customConfig, yearDisplayQuerySelector = null) {
//
//     if (yearDisplayQuerySelector === null) {
//         yearDisplayQuerySelector = '.mx-datepicker-main .mx-btn-current-year, .mx-datepicker-main .mx-calendar-header-label span, .mx-datepicker-main .mx-table-year div, .mx-datepicker-main .mx-calendar-header-label .mx-btn-text';
//     }
//
//     let config = {
//         lang: {
//             formatLocale: {
//                 months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
//                 monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
//                 weekdays: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
//                 weekdaysShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
//                 weekdaysMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
//                 firstDayOfWeek: 0,
//             },
//             yearFormat: 'YYYY',
//             monthFormat: 'MMM',
//             monthBeforeYear: true
//         },
//         formatter: {
//             //[optional] Date to String
//             stringify: (date) => {
//                 let d = DateTime.fromJSDate(date);
//                 return date ? `${d.toFormat('dd/MM')}/${parseInt(d.toFormat('yyyy')) + 543}` : '';
//             },
//             //[optional]  String to Date
//             parse: (value) => {
//                 let ds = value.split('/');
//                 if (ds.length !== 3 || ds.filter(it => isNaN(it)).length > 0) return null;
//                 let d = `${ds[0]}/${ds[1]}/${ds[2] - 543}`;
//                 return value ? DateTime.fromFormat(value, 'DD/MM/YYYY').toJSDate() : null;
//             },
//         },
//         onUiFrameChange(...args) {
//             Vue.nextTick(() => {
//                 let currentYear = args.length === 3 && args[0] instanceof Date ? args[0].getFullYear() : null;
//                 let els = $(yearDisplayQuerySelector);
//                 els.each(function () {
//                     let el = $(this);
//                     let text = el.text();
//                     if (isNaN(text.trim())) return;
//                     let displayYear = currentYear ? currentYear : parseInt(text);
//                     if (displayYear < 2100) el.text(displayYear + 543);
//                 });
//             });
//         },
//         // dateInRange(min, max) {
//         //     return (date) => {
//         //         //console.log({min, max, date});
//         //         //console.log(DateTime.fromISO(min).toJSDate());
//         //         let minDate = min instanceof Date ? min : DateTime.fromISO(min).toJSDate();
//         //         let maxDate = max instanceof Date ? max : DateTime.fromISO(max).toJSDate();
//         //         if (min && date < minDate) return true;
//         //         if (max && date > maxDate) return true;
//         //         return false;
//         //     };
//         // },
//         toDateTime(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             console.debug('dateString 00');
//             if (!dateString) {
//                 console.debug('dateString 01');
//                 return defaultValue;
//             }
//
//             console.debug('dateString 02', dateString);
//             let dateTime = DateTime.fromFormat(dateString, dateFormat);
//             console.debug('dateString 03');
//             if (dateTime.isValid) {
//                 console.debug('dateString 04');
//                 return dateTime;
//             } else {
//                 console.debug('dateString 05');
//                 return defaultValue;
//             }
//         },
//         toJsDate(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             console.debug('toJsDate 00', dateString);
//             let dateTime = this.toDateTime(dateString, dateFormat, defaultValue);
//             console.debug('toJsDate 01');
//             if ((dateTime instanceof DateTime) && dateTime.isValid) {
//                 console.debug('toJsDate 02');
//                 return dateTime.toJSDate();
//             }
//             console.debug('toJsDate 03');
//             console.warn('toJsDate: conversion failed return default value');
//             return defaultValue;
//         },
//         dateTimeToString(dateTime, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             if (!dateTime || (dateTime instanceof DateTime)) {
//                 return defaultValue;
//             }
//
//             if (dateTime && dateTime.isValid) {
//                 return dateTime.toFormat(dateFormat);
//             } else {
//                 return defaultValue;
//             }
//         },
//         jsDateToString(jsDate, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
//             if (!jsDate) {
//                 return defaultValue;
//             }
//
//             let dateTime = DateTime.fromJSDate(jsDate);
//             if (dateTime && dateTime.isValid) {
//                 return dateTime.toFormat(dateFormat);
//             } else {
//                 return defaultValue;
//             }
//         },
//         dateInRange(minDate, maxDate, isIncludeTargetDate = true) {
//             //return true for disabled date
//             return (targetDate) => {
//
//                 let isMinDateValid = !!(minDate && minDate instanceof DateTime && minDate.isValid);
//                 let isMaxDateValid = !!(maxDate && maxDate instanceof DateTime && maxDate.isValid);
//
//                 if ((!isMinDateValid && !isMaxDateValid) || !targetDate) {
//                     return false;
//                 }
//
//                 minDate = isMinDateValid ? minDate.startOf('day') : null;
//                 maxDate = isMaxDateValid ? maxDate.startOf('day') : null;
//
//                 if (minDate && maxDate) {
//                     if (isIncludeTargetDate) {
//                         if (minDate.hasSame(targetDate, 'day') || maxDate.hasSame(targetDate, 'day')) {
//                             return false;
//                         }
//                     }
//
//                     return !(minDate < targetDate && targetDate < maxDate);
//                 }
//
//                 if (minDate) {
//                     if (minDate.hasSame(targetDate, 'day')) {
//                         return !isIncludeTargetDate;
//                     }
//                     return (minDate.startOf('day') > targetDate);
//                 }
//
//                 if (maxDate) {
//                     if (maxDate.hasSame(targetDate, 'day')) {
//                         return !isIncludeTargetDate;
//                     }
//                     return (maxDate.startOf('day') < targetDate);
//                 }
//
//                 return true;
//             };
//         },
//     };
//
//     return _merge(config, customConfig);
// }
