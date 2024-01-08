<template>
  <div class="box-item">
    <!-- Image -->
    <div>
      <label
        v-if="item.img == ''"
        :for="'upload-' + item.item_cat_code"
        class="upload-file"
      >
        <input
          type="file"
          :name="'upload-' + item.item_cat_code"
          :id="'upload-' + item.item_cat_code"
          class="tw-hidden"
          ref="file"
          @change="uploadFile()"
        />
        <i class="fa fa-cloud-upload"></i>
      </label>
      <label
        v-if="item.img != ''"
        @click="removeImage(item)"
        :for="'upload-' + item.item_cat_code"
        class="upload-file"
      >
        <i class="fa fa-trash-o"></i>
      </label>
      <img
        class="image-container"
        :src="
          item.img
            ? item.img
            : '/images/no-image.png'
        "
        alt="product"
      />
    </div>
    <!-- END Image -->

    <!-- Name -->
    <div class="name-container">
      <div
        class="tw-text-lg tw-pt-1 tw-font-extrabold tw-text-white tw-text-left"
      >
        {{ item.name }}
      </div>
      <div class="btn-container">
        <a
          :href="
            url_ajax.request_raw_material
              ? url_ajax.request_raw_material +
                '?name=' +
                item.name +
                '&code=' +
                item.item_cat_code
              : '#'
          "
          class="request-btn"
          >ร้องขอวัตถุดิบเพิ่ม</a
        >

        <a
          :href="
            url_ajax.inform_raw_material
              ? url_ajax.inform_raw_material +
                '?name=' +
                item.name +
                '&code=' +
                item.item_cat_code
              : '#'
          "
          class="report-btn"
          >รายงานวัตถุดิบคงเหลือ</a
        >
      </div>
    </div>
    <!-- END Name -->
  </div>
</template>

<script>
import axios from "axios";
export default {
  props: {
    item_prop: {},
    url_ajax: {},
    auth: {},
    loadData: { type: Function },
    isLoading: {},
  },
  data() {
    return {
      file: "",
      item: {},
    };
  },
  mounted() {
    this.item = this.item_prop;
  },
  methods: {
    async removeImage(item) {
      swal(
        {
          title: "แจ้งเตือน",
          text: "ยืนยันการลบรูปภาพหรือไม่?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "ยืนยัน",
        },
        (e) => {
          // confirm upload
          if (e) {
            this.isLoading();
            console.log("remove");
            this.confirmDelete(item);
          }
        }
      );
    },
    async confirmDelete(item) {
      const url = this.url_ajax.raw_material_remove_image;
      let formData = new FormData();
      formData.append("organization_id", this.item.organization_id);
      formData.append("organization_code", this.item.organization_code);
      formData.append("item_cat_code", this.item.item_cat_code);
      formData.append("last_updated_by_id", this.auth.fnd_user_id);
      formData.append("last_updated_by", this.auth.user_id);
      formData.append("created_by", this.auth.user_id);
      formData.append("created_by_id", this.auth.fnd_user_id);

      axios
        .post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((result) => {
          console.log(result);
          if (result.status) {
            this.loadData();
          }
        });
    },
    async uploadFile() {
      // Set image object
      this.file = "";
      this.file = this.$refs.file.files[0];
      let _this = this;
      // Cofirm upload image
      swal(
        {
          title: "แจ้งเตือน",
          text: "ยืนยันการเลือกรูปภาพหรือไม่?",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "ยืนยัน",
        },
        function (e) {
          // confirm upload
          if (e) {
            _this.isLoading();
            console.log("submit");
            _this.confirmUpload();
          }
        }
      );
    },

    async confirmUpload() {
      const url = this.url_ajax.raw_material_upload_image;
      let formData = new FormData();
      formData.append("image", this.file);
      formData.append("organization_id", this.item.organization_id);
      formData.append("organization_code", this.item.organization_code);
      formData.append("item_cat_code", this.item.item_cat_code);
      formData.append("last_updated_by_id", this.auth.fnd_user_id);
      formData.append("last_updated_by", this.auth.user_id);
      formData.append("created_by", this.auth.user_id);
      formData.append("created_by_id", this.auth.fnd_user_id);

      axios
        .post(url, formData, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((result) => {
          console.log(result);
          if (result.status) {
            this.loadData();
          }
        });
    },
  },
};
</script>
<style scoped>
.upload-file {
  @apply tw-m-1 tw-rounded-2xl tw-shadow-xl tw-cursor-pointer tw-border tw-p-2 tw-border-gray-600 tw-border-collapse;
}
.box-item {
  @apply tw-flex tw-flex-col tw-h-96 tw-relative tw-shadow-lg tw-overflow-hidden;
}
.image-container {
  @apply tw-w-full tw-h-96 hover:tw-scale-105 tw-transform tw-transition-all tw-object-scale-down tw-pb-16;
}
.name-container {
  @apply tw-px-2
        tw-absolute
        tw-flex
        tw-space-y-1
        tw-flex-col
        tw-bottom-0
        tw-bg-opacity-90
        tw-w-full
        tw-shadow
        tw-text-center
        tw-bg-black
        tw-rounded-sm
        tw-pb-2;
}
.btn-container {
  @apply tw-flex
          tw-flex-col
          tw-space-y-1
          tw-font-extrabold
          tw-text-white
          tw-items-center;
}
.request-btn {
  @apply tw-py-1 tw-border-red-300
            hover:tw-border-red-500
            tw-px-3
            tw-w-full
            tw-border-2
            tw-border-solid
            tw-rounded-md
            tw-text-lg
            md:tw-text-sm
            lg:tw-text-sm
            tw-text-white
            hover:tw-text-gray-200;
}
.report-btn {
  @apply tw-py-1 tw-border-purple-300
            hover:tw-border-purple-500
            tw-px-3
            tw-w-full
            tw-border-2
            tw-border-solid
            tw-rounded-md
            tw-text-lg
            md:tw-text-sm
            lg:tw-text-sm
            tw-text-white
            hover:tw-text-gray-200;
}
</style>