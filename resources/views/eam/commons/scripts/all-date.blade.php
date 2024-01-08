
<script>
    $.datetimepicker.setLocale('th');

    function getMonthFromString(mon){
      var d = Date.parse(mon + "1, 2012");
      if(!isNaN(d)){
        let mm = new Date(d).getMonth() + 1;
        if(mm < 10) {
          mm = '0' + mm;
        }
        return mm
      } else {
        if(mon.length < 2) {
          mon = '0' + mon;
        }
        return mon;
      }
    }
    function dateTimeIn(dataInPut) {
      if (dataInPut) {
        let date = dataInPut.split(' ')[0]
        let time = dataInPut.split(' ')[1]
        return date.split('-')[0] + '-' + getMonthFromString(date.split('-')[1]) + '-' + (+(date.split('-')[2]) + 543) + ' ' + time.split(':')[0] + ':' + time.split(':')[1]
      } else {
        return ''
      }
    }
    function dateTimeOut(dataIOutPut) {
      if (dataIOutPut) {
        let date = dataIOutPut.split(' ')[0]
        let time = dataIOutPut.split(' ')[1]
        return date.split('-')[0] + '-' + date.split('-')[1] + '-' + (+(date.split('-')[2]) - 543) + ' ' + time.split(':')[0] + ':' + time.split(':')[1] + ':00'
      } else {
        return ''
      }
    }

    function getDate() {
      let d = new Date();
      let month = d.getMonth()+1;
      let day = d.getDate();
      let output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + (d.getFullYear() + 543);
      return output
    }

    function getDateLocal(data) {
      let d = new Date();
      let month = d.getMonth()+1 + (data.month ? data.month : 0);
      let day = d.getDate();
      let output = (month<10 ? '0' : '') + month + '/' + (day<10 ? '0' : '') + day + '/' + (d.getFullYear() + 543);
      return new Date(output)
    }

    function getDateTime() {
      let d = new Date();
      let month = d.getMonth()+1;
      let day = d.getDate();
      let hours = d.getHours()
      let minutes = d.getMinutes()
      let seconds = d.getSeconds()
      let newTime = hours + ':' + minutes + ':' + seconds;
      let output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + (d.getFullYear() + 543 + ' ' + newTime);
      return output
    }

    function getYear() {
      let d = new Date();
      return d.getFullYear() + 543
    }

    function conVertDate(dataInPut) {
      if (dataInPut) {
        let d1 = new Date(Date.parse(dataInPut));
        yr      = d1.getFullYear()+ 543,
        month   = (d1.getMonth()+1) < 10 ? '0' + (d1.getMonth()+1) : (d1.getMonth()+1),
        day     = d1.getDate()  < 10 ? '0' + d1.getDate()  : d1.getDate(),
        newDate = day + '/' + month + '/' + yr;
        return newDate
      } else {
        return ''
      }
    }
    var vmDatePicker = {}
    function setDatePicker(data) {
      var dateFormat = '{{ trans('date.js-format') }}';
      vmDatePicker[data.idDate] = new Vue({
        data() {
          return {
            pValue: data.date,
            pFormat: dateFormat,
            disabled: data.disabled,
            pDisabled: data.pDisabled
          }
        },
        template: `<datepicker-th style="width: 100%"
                                  class="form-control md:tw-mb-0 tw-mb-2"
                                  name="${data.nameDate}"
                                  id="${data.idDate}"
                                  placeholder="โปรดเลือกวันที่"
                                  @dateWasSelected='onchangeDate(...arguments)'
                                  :disabled="disabled"
                                  :value=pValue
                                  :disabledDateTo=pDisabled
                                  :format=pFormat />`,
        methods: {
          onchangeDate (date) {
            vmDatePicker[data.idDate].pValue = date
            if (data.dateEndId) {
              vmDatePicker[data.dateEndId].pDisabled = date
            }
            // console.log('---------------xxxxxxxxx >', data.onchange, data, date)
            if (data.onchange) {
              if (date) {
                if ($("#eam0006").attr('id') === 'eam0006') {
                  if ($("#statusPlan").val() == 'Confirm') {
                    editConfirm = true
                  }
                }
              } else {
                if ($("#eam0006").attr('id') === 'eam0006') {
                  if ($("#statusPlan").val() == 'Confirm') {
                    editConfirm = true
                  }
                }
              }
            }

            if (data.em0007CallDay.auto_calculate == true) {
                em0007CallDayFn(data.em0007CallDay)
            }
          }
        }
      }).$mount("#"+data.idDate)
      if (data.required) {
        $("#"+data.idDate).prop('required', true);
      }
      let startYear1 = (getYear() - 200).toString().split('')[0]
      let startYear2 = (getYear() - 200).toString().split('')[1]
      $("#"+data.idDate).prop('pattern', `(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(${startYear1}[${startYear2}-9]|[${+startYear1+1}-9][0-9])[0-9]{2}`);
      $("#"+data.idDate).prop('title', 'กรุณาระบุข้อมูลเป็นปี พ.ศ.');

      $("#"+data.idDate).focusin(() => {
        let startYear = getYear() - 200
        if ($("#"+data.idDate).val()) {
          if ((startYear - $("#"+data.idDate).val().split('/')[2]) > 0) {
            let d = $("#"+data.idDate).val().split('/');
            let val = d[0] + '/' + d[1] + '/' + (+d[2] + 543)
            vmDatePicker[data.idDate].pValue = val
          }
        }
      });
    }

    function parseDateTime(s) {
      var c = s.split(':');
      return parseInt(c[0]) * 60 + parseInt(c[1]);
    }
    function dateTimeConvert(en, st) {
      let num = 0
      let flg = true
      if (en - st > 0) {
        num = en - st
        flg = true
      } else {
        num = st - en
        flg = false
      }
      if (num > 0) {
        var hours = (num / 60);
        var rhours = Math.floor(hours);
        var minutes = (hours - rhours) * 60;
        var rminutes = (Math.round(minutes)/60).toFixed(2);
        return flg ? (+rhours + +rminutes).toFixed(2) : '-'+((+rhours + +rminutes).toFixed(2))
      } else {
        return num
      }
    }
    function conVertDateTime(dataInPut, status) {
      if (dataInPut) {
        if (status == 'time') {
          let t1 = new Date(Date.parse(dataInPut));
          hours = t1.getHours(),
          minutes = t1.getMinutes(),
          seconds = t1.getSeconds(),
          newTime = hours + ':' + minutes + ':' + seconds;
          return newTime
        } else if (status == 'date') {
          let d = new Date(Date.parse(dataInPut));
          return d.getDate()+ '/' + (d.getMonth()+1) + '/' + d.getFullYear();
        }
      } else {
        return ''
      }
    }
    function parseDate(str) {
      var mdy = str.split('/');
      return new Date(mdy[2], mdy[1]-1, mdy[0]);
    }
    function checkStEnDateTime(st, en, time) {
      return (Math.round((en-st)/(1000*60*60)) + +time) > 0 ? (Math.round((en-st)/(1000*60*60)) + +time) : 0
    }

    var vmDateTimePicker = {}
    function setDateTimePicker(data) {
      var dateFormat = '{{ trans('date.js-format').' '. trans('date.js-hm-time-format') }}';
      vmDateTimePicker[data.idDate] = new Vue({
        data() {
          return {
            pValue: data.date,
            pFormat: dateFormat,
            disabled: data.disabled,
            pDisabled: ''
          }
        },
        template: `<datepicker-th style="width: 100%"
                                  class="form-control md:tw-mb-0 tw-mb-2"
                                  name="${data.nameDate}"
                                  id="${data.idDate}"
                                  placeholder="โปรดเลือกวันที่"
                                  @dateWasSelected='onchangeDate(...arguments)'
                                  :disabled="disabled"
                                  :value=pValue
                                  :disabledDateTo=pDisabled
                                  p-type="datetime"
                                  :format=pFormat />`,
        methods: {
          onchangeDate (date) {
            if (data.dateEndId) {
              vmDateTimePicker[data.dateEndId].pDisabled = conVertDateTime(date, 'date')
            }
            vmDateTimePicker[data.idDate].pValue = date
            if (data.onchange) {
              if ($("#eam0010").attr('id') === 'eam0010') {
                if ((data.idDate.split('CompleteStart')[0] == 'dateTableStart') || (data.idDate.split('CompleteStart')[0] == 'dateTableEnd')) {
                  let StartTime = $("#"+data.idDate).parents('tr').find("td:eq(1) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(1) input[type='text']").val().split(' ')[1] : ''
                  let StartDate = parseDate($("#"+data.idDate).parents('tr').find("td:eq(1) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(1) input[type='text']").val().split(' ')[0] : '')
                  let EndTime = $("#"+data.idDate).parents('tr').find("td:eq(3) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(3) input[type='text']").val().split(' ')[1] : ''
                  let EndDate = parseDate($("#"+data.idDate).parents('tr').find("td:eq(3) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(3) input[type='text']").val().split(' ')[0] : '')
                  if (data.idDate.split('CompleteStart')[0] == 'dateTableStart') {
                    StartTime = conVertDateTime(date, 'time')
                    StartDate = parseDate(conVertDateTime(date, 'date'))
                  } else {
                    EndTime = conVertDateTime(date, 'time')
                    EndDate = parseDate(conVertDateTime(date, 'date'))
                  }
                  if (date != '') {
                    $("#"+data.idDate).parents('tr').find("td:eq(2) input[type='number']").val(checkStEnDateTime(StartDate, EndDate, dateTimeConvert(parseDateTime(EndTime), parseDateTime(StartTime))))
                    $("#"+data.idDate).parents('tr').find("td:eq(2) input[type='number']").val() == '' ? $("#"+data.idDate).parents('tr').find("td:eq(2) input[type='number']").val(0) : ''
                  } else {
                    $("#"+data.idDate).parents('tr').find("td:eq(2) input[type='number']").val('')
                  }
                } else if ((data.idDate.split('CompleteStop')[0] == 'dateTableStart') || (data.idDate.split('CompleteStop')[0] == 'dateTableEnd')) {
                  let StartTime = $("#"+data.idDate).parents('tr').find("td:eq(4) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(4) input[type='text']").val().split(' ')[1] : ''
                  let StartDate = parseDate($("#"+data.idDate).parents('tr').find("td:eq(4) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(4) input[type='text']").val().split(' ')[0] : '')
                  let EndTime = $("#"+data.idDate).parents('tr').find("td:eq(6) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(6) input[type='text']").val().split(' ')[1] : ''
                  let EndDate = parseDate($("#"+data.idDate).parents('tr').find("td:eq(6) input[type='text']").val() != '' ? $("#"+data.idDate).parents('tr').find("td:eq(6) input[type='text']").val().split(' ')[0] : '')
                  if (data.idDate.split('CompleteStart')[0] == 'dateTableStart') {
                    StartTime = conVertDateTime(date, 'time')
                    StartDate = parseDate(conVertDateTime(date, 'date'))
                  } else {
                    EndTime = conVertDateTime(date, 'time')
                    EndDate = parseDate(conVertDateTime(date, 'date'))
                  }
                  if (date != '') {
                    $("#"+data.idDate).parents('tr').find("td:eq(5) input[type='number']").val(checkStEnDateTime(StartDate, EndDate, dateTimeConvert(parseDateTime(EndTime), parseDateTime(StartTime))))
                    $("#"+data.idDate).parents('tr').find("td:eq(5) input[type='number']").val() == '' ? $("#"+data.idDate).parents('tr').find("td:eq(5) input[type='number']").val(0) : ''
                  } else {
                    $("#"+data.idDate).parents('tr').find("td:eq(5) input[type='number']").val('')
                  }
                }
              }
            }
          }
        }
      }).$mount("#"+data.idDate)
      if (data.required) {
        $("#"+data.idDate).prop('required', true);
      }
      let startYear1 = (getYear() - 200).toString().split('')[0]
      let startYear2 = (getYear() - 200).toString().split('')[1]
      $("#"+data.idDate).prop('pattern', `(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(${startYear1}[${startYear2}-9]|[${+startYear1+1}-9][0-9])[0-9]{2} (0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){1}`);
      $("#"+data.idDate).prop('title', 'กรุณาระบุข้อมูลเป็นปี พ.ศ.');
    }
    function dateRangeOverlaps(a_start, a_end, b_start, b_end) {
      if (a_start <= b_start && b_start <= a_end) return true; // b starts in a
      if (a_start <= b_end   && b_end   <= a_end) return true; // b ends in a
      if (b_start <  a_start && a_end   <  b_end) return true; // a in b
      return false;
    }
    function multipleDateRangeOverlaps(data) {
        var i, j;
        if (data.length % 2 !== 0)
            throw new TypeError('Arguments length must be a multiple of 2');
        for (i = 0; i < data.length - 2; i += 2) {
            for (j = i + 2; j < data.length; j += 2) {
                if (
                    dateRangeOverlaps(
                      data[i], data[i+1],
                      data[j], data[j+1]
                    )
                ) return true;
            }
        }
        return false;
    }
    var vmDateTimePickerAll = {}
    function setDateTimePickerAll(data) {
      var dateFormat = '{{ trans('date.js-datatime-format') }}';
      vmDateTimePickerAll[data.idDate] = new Vue({
        data() {
          return {
            pValue: data.date,
            pFormat: dateFormat,
            disabled: data.disabled,
            pDisabled: ''
          }
        },
        template: `<datepicker-th style="width: 100%"
                                  class="form-control md:tw-mb-0 tw-mb-2"
                                  name="${data.nameDate}"
                                  id="${data.idDate}"
                                  placeholder="โปรดเลือกวันที่"
                                  @dateWasSelected='onchangeDate(...arguments)'
                                  :disabled="disabled"
                                  :value=pValue
                                  :disabledDateTo=pDisabled
                                  p-type="datetime"
                                  :format=pFormat />`,
        methods: {
          onchangeDate (date) {
            if (data.dateEndId) {
              vmDateTimePickerAll[data.dateEndId].pDisabled = conVertDateTime(date, 'date')
            }
            vmDateTimePickerAll[data.idDate].pValue = date
            if (data.onchange) {
            }
            if (typeof data.ontrigger !== "undefined") {
              data.ontrigger(date)
            }
          }
        }
      }).$mount("#"+data.idDate)
      if (data.required) {
        $("#"+data.idDate).prop('required', true);
      }
      let startYear1 = (getYear() - 200).toString().split('')[0]
      let startYear2 = (getYear() - 200).toString().split('')[1]
      $("#"+data.idDate).prop('pattern', `(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/(${startYear1}[${startYear2}-9]|[${+startYear1+1}-9][0-9])[0-9]{2} (0[0-9]|1[0-9]|2[0-3])(:[0-5][0-9]){2}`);
      $("#"+data.idDate).prop('title', 'กรุณาระบุข้อมูลเป็นปี พ.ศ.');
    }
</script>
