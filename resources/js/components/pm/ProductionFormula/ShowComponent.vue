<script>
import { isInRange, jsDateToString, toJSDate, toThDateString } from "../../../dateUtils";

export default {
  props: ["header", "urlInactive", "urlActive", "urlApprove", "btnTrans", "wipSteps", "formulaType"],
  data() {
    return {
      isLoading: false,
      loading: false,
      fm_date: "",
      routing_desc: this.header ? this.header.routing_desc : "",
      multi_wip_step: "",
    };
  },
  computed: {
    _fm_date() {
      return toJSDate(this.fm_date, "yyyy-MM-dd");
    },
  },
  mounted() {
    this.multi_wip_step = this.header.oprn_id;
  },
  methods: {
    async getValueTransactionDate(date) {
      Vue.set(this, "fm_date", jsDateToString(date));
    },
    async inactive() {
      var vm = this;
      swal(
        {
          title: "Warning",
          text: "ต้องการยกเลิกสูตรหรือไม่?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true,
        },
        function (isConfirm) {
          if (isConfirm) {
            vm.loading = true;

            axios.get(vm.urlInactive).then((res) => {
              console.log("then res" + res);
              if (res.data.status == "E") {
                swal({
                  title: "มีข้อผิดพลาด",
                  text:
                    '<span style="font-size: 15px; text-align: left;">' +
                    res.data.message +
                    "</span>",
                  type: "warning",
                  html: true,
                });
              }

              vm.loading = false;
              location.reload();
            });
          } else {
            swal({
              title: "มีข้อผิดพลาด",
              text: "",
              timer: 3000,
              type: "success",
              showCancelButton: false,
              showConfirmButton: false,
            });
          }
        }
      );
    },

    async active() {
      var vm = this;
      swal(
        {
          title: "Warning",
          text: "ต้องการเปิดใช้งานสูตรหรือไม่?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true,
        },
        function (isConfirm) {
          if (isConfirm) {
            vm.loading = true;

            axios.get(vm.urlActive).then((res) => {
              console.log("then res" + res);
              if (res.data.status == "E") {
                swal({
                  title: "มีข้อผิดพลาด",
                  text:
                    '<span style="font-size: 15px; text-align: left;">' +
                    res.data.message +
                    "</span>",
                  type: "warning",
                  html: true,
                });
              }
              vm.loading = false;
              location.reload();
            });
          } else {
            swal({
              title: "มีข้อผิดพลาด",
              text: "",
              timer: 3000,
              type: "success",
              showCancelButton: false,
              showConfirmButton: false,
            });
          }
        }
      );
    },

    async approveSubmit() {
      var vm = this;
        if( this.fm_date == '') {
            this.$message({'message' :'กรุณาตรวจสอบวันที่ๆ เลือกใหม่อีกครึ่ง','type': 'error'})
            $('#modal-confirm-date').modal('hide')
            return false
        }
      vm.loading = true;

      await axios.get(vm.urlApprove + "?start_date=" +  this.fm_date).then((res) => {
        console.log("then res" + res);
        if (res.data.data.status == "E") {
          swal({
              title: "Warning",
              text: res.data.data.message,
              type: "warning",
          },
          function(isConfirm) {
            vm.loading = false;
            location.reload();
          });
          // swal({
          //   title: "มีข้อผิดพลาด",
          //   text:
          //     '<span style="font-size: 15px; text-align: left;">' +
          //     res.data.data.message +
          //     "</span>",
          //   type: "warning",
          //   html: true,
          // });
        }else {

          vm.loading = false;
          location.reload();
        }
      });
    },
    async approve() {
      var vm = this;
      swal(
        {
          title: "Warning",
          text: "ต้องการส่งอนุมัติสูตรหรือไม่?",
          type: "warning",
          showCancelButton: true,
          closeOnConfirm: false,
          closeOnCancel: true,
          showLoaderOnConfirm: true,
        },
        function (isConfirm) {
          if (isConfirm) {
            if (vm.formulaType == 'สูตรใช้จริง') {
              swal.close();
              $("#modal-confirm-date").modal("show");
            } else {
              // swal.close();
              vm.fm_date = vm.header.start_date;
              vm.approveSubmit();
            }
            // swal.close();
            // $("#modal-confirm-date").modal("show");
          } else {
            swal({
              title: "มีข้อผิดพลาด",
              text: "",
              timer: 3000,
              type: "success",
              showCancelButton: false,
              showConfirmButton: false,
            });
          }
        }
      );
    },
    // loadingPage(loading)
    // {
    // console.log('loadingPage <---->');
    // if(loading){
    //     $('#page-wrapper').prepend('<div id="loading-page" style="position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;z-index: 9999999999;overflow: hidden;background:#fff"><div class="sk-spinner sk-spinner-double-bounce text-center w-100" style="font-size: 18px; margin-top: 6.5rem;"> กำลังดำเนินการ </div><div class="sk-spinner sk-spinner-double-bounce" style="width: 100px; height: 100px;"><div class="sk-double-bounce1"></div><div class="sk-double-bounce2"></div></div></div>');
    // }else {
    //     $('#page-wrapper').find('#loading-page').remove();
    // }
    // }
  },
};
</script>
