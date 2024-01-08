import {DateTime} from "luxon";
import _merge from 'lodash/merge';

export function customBuddhistYearDatePicker(customConfig, yearDisplayQuerySelector = null) {

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
        // dateInRange(min, max) {
        //     return (date) => {
        //         //console.log({min, max, date});
        //         //console.log(DateTime.fromISO(min).toJSDate());
        //         let minDate = min instanceof Date ? min : DateTime.fromISO(min).toJSDate();
        //         let maxDate = max instanceof Date ? max : DateTime.fromISO(max).toJSDate();
        //         if (min && date < minDate) return true;
        //         if (max && date > maxDate) return true;
        //         return false;
        //     };
        // },
        toDateTime(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
            console.debug('dateString 00');
            if (!dateString) {
                console.debug('dateString 01');
                return defaultValue;
            }

            console.debug('dateString 02', dateString);
            let dateTime = DateTime.fromFormat(dateString, dateFormat);
            console.debug('dateString 03');
            if (dateTime.isValid) {
                console.debug('dateString 04');
                return dateTime;
            } else {
                console.debug('dateString 05');
                return defaultValue;
            }
        },
        toJsDate(dateString, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
            console.debug('toJsDate 00', dateString);
            let dateTime = this.toDateTime(dateString, dateFormat, defaultValue);
            console.debug('toJsDate 01');
            if ((dateTime instanceof DateTime) && dateTime.isValid) {
                console.debug('toJsDate 02');
                return dateTime.toJSDate();
            }
            console.debug('toJsDate 03');
            console.warn('toJsDate: conversion failed return default value');
            return defaultValue;
        },
        dateTimeToString(dateTime, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
            if (!dateTime || (dateTime instanceof DateTime)) {
                return defaultValue;
            }

            if (dateTime && dateTime.isValid) {
                return dateTime.toFormat(dateFormat);
            } else {
                return defaultValue;
            }
        },
        jsDateToString(jsDate, dateFormat = 'yyyy-MM-dd', defaultValue = null) {
            if (!jsDate) {
                return defaultValue;
            }

            let dateTime = DateTime.fromJSDate(jsDate);
            if (dateTime && dateTime.isValid) {
                return dateTime.toFormat(dateFormat);
            } else {
                return defaultValue;
            }
        },
        dateInRange(minDate, maxDate, isIncludeTargetDate = true) {
            //return true for disabled date
            return (targetDate) => {

                let isMinDateValid = !!(minDate && minDate instanceof DateTime && minDate.isValid);
                let isMaxDateValid = !!(maxDate && maxDate instanceof DateTime && maxDate.isValid);

                if ((!isMinDateValid && !isMaxDateValid) || !targetDate) {
                    return false;
                }

                minDate = isMinDateValid ? minDate.startOf('day') : null;
                maxDate = isMaxDateValid ? maxDate.startOf('day') : null;

                if (minDate && maxDate) {
                    if (isIncludeTargetDate) {
                        if (minDate.hasSame(targetDate, 'day') || maxDate.hasSame(targetDate, 'day')) {
                            return false;
                        }
                    }

                    return !(minDate < targetDate && targetDate < maxDate);
                }

                if (minDate) {
                    if (minDate.hasSame(targetDate, 'day')) {
                        return !isIncludeTargetDate;
                    }
                    return (minDate.startOf('day') > targetDate);
                }

                if (maxDate) {
                    if (maxDate.hasSame(targetDate, 'day')) {
                        return !isIncludeTargetDate;
                    }
                    return (maxDate.startOf('day') < targetDate);
                }

                return true;
            };
        },
    };

    return _merge(config, customConfig);
}

// function toJSDate(value, format = null) {
//     if (value instanceof Date) return value;
//     if (typeof value === 'number') return new Date(value);
//     if (typeof value === 'object' && typeof value.toJSDate === 'function') return value.toJSDate();
//     if (typeof value === 'string') {
//         let d = typeof format === 'string' ? DateTime.fromFormat(value, format) : DateTime.fromISO(value);
//         return d.isValid ? d.toJSDate() : null;
//     }
//     return null;
// }
