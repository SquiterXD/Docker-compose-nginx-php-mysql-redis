<script>
  function parseTime(s) {
   var c = s.split(':');
   return parseInt(c[0]) * 60 + parseInt(c[1]);
  }
  function timeConvert(num) {
    if (num > 0) {
      var hours = (num / 60);
      var rhours = Math.floor(hours);
      var minutes = (hours - rhours) * 60;
      var rminutes = (Math.round(minutes)/60).toFixed(2);
      return (+rhours + +rminutes).toFixed(2)
    } else {
      return ''
    }
  }
  function conVertTime(dataInPut) {
    if (dataInPut) {
      let t1 = new Date(Date.parse(dataInPut));
      hours      = t1.getHours(),
      minutes      = t1.getMinutes(),
      seconds      = t1.getSeconds(),
      newTime = hours + ':' + minutes + ':' + seconds;
      return newTime
    } else {
      return ''
    }
  }

  function getTime() {
    let d = new Date();
    let hours = d.getHours()
    let minutes = d.getMinutes()
    let seconds = d.getSeconds()
    let newTime = hours + ':' + minutes + ':' + seconds;
    let output = newTime;
    return output
  }

  var vmTimePicker = {}
    function setTimePicker(data) {
      var timeFormat = '{{ trans('date.js-hm-time-format') }}';
      vmTimePicker[data.idTime] = new Vue({
        data() {
          return {
            pValue: data.time,
            pFormat: timeFormat,
            disabled: data.disabled
          }
        },
        template: `<datepicker-th style="width: 100%"
                                  class="form-control md:tw-mb-0 tw-mb-2"
                                  name="${data.nameTime}"
                                  id="${data.idTime}"
                                  placeholder="โปรดเลือกเวลา"
                                  @dateWasSelected='onchangeTime(...arguments)'
                                  :disabled="disabled"
                                  :value=pValue
                                  p-type="time"
                                  :format=pFormat />`,
        methods: {
          onchangeTime (time) {
            vmTimePicker[data.idTime].pValue = time
            if (data.onchange) {
              if ($("#eam0010").attr('id') === 'eam0010') {
                let StartTime = $("#"+data.idTime).parents('tr').find("td:eq(7) input[type='text']").val()
                let EndTime = $("#"+data.idTime).parents('tr').find("td:eq(8) input[type='text']").val()
                if (data.idTime.split('SaveCost')[0] == 'timeTableStart') {
                  StartTime = conVertTime(time)
                } else {
                  EndTime = conVertTime(time)
                }
                if (time != '') {
                  $("#"+data.idTime).parents('tr').find("td:eq(9) input[type='number']").val(timeConvert(parseTime(EndTime) - parseTime(StartTime)))
                  $("#"+data.idTime).parents('tr').find("td:eq(9) input[type='number']").val() == '' ? $("#"+data.idTime).parents('tr').find("td:eq(9) input[type='number']").val(0) : ''
                } else {
                  $("#"+data.idTime).parents('tr').find("td:eq(9) input[type='number']").val('')
                }
              }
            }
          }
        }
      }).$mount("#"+data.idTime)
      if (data.required) {
        $("#"+data.idTime).prop('required', true);
      }
    }
</script>