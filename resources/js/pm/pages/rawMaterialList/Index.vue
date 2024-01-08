<template>
  <div>
    <div class="row d-flex justify-content-end mb-3">
      <div class="col-lg-10">
        <div class="float-right">
          <button
            type="button"
            @click="resetFilter"
            :class="btn_trans.reset.class"
          >
            <i :class="btn_trans.reset.icon"></i>
            {{ btn_trans.reset.text }}
          </button>
          <button
            type="button"
            @click="searchBtn"
            :class="btn_trans.search.class"
          >
            <i :class="btn_trans.search.icon"></i>
            {{ btn_trans.search.text }}
          </button>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- Search box -->
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title">
            <div class="row align-items-center">
              <div class="col-sm-12 col-lg-4 align-middle">
                <h4>รายการวัตถุดิบ</h4>
              </div>
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">
              <div class="col-lg-6 col-sm-12">
                <div class="form-group row">
                  <label class="col-lg-3 col-sm-5 col-form-label"
                    >ประเภทวัตถุดิบ:</label
                  >
                  <div class="col-lg-9">
                    <v-select
                      v-model="selectFilter"
                      :options="itemsFilter"
                      label="name"
                      @option:selected="changeTypeMaterial"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Search box -->

      <!-- Content -->
      <div class="col-lg-12">
        <div class="ibox">
         
          <div class="ibox-content">
            <div class="tw-grid md:tw-grid-cols-3 lg:tw-grid-cols-3 tw-gap-4">
              <span v-for="item in items" :key="item.item_cat_code">
                <v-item-box
                  :url_ajax="url_ajax"
                  :item_prop="item"
                  :auth="auth"
                  :isLoading="loadingFunc"
                  :loadData="loadData"
                />
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- End Content -->
    </div>
    <loading :active.sync="isLoading" :is-full-page="true"></loading>
  </div>
</template>
<style scoped>
</style>
<script>
import axios from "axios";
import vSelect from "vue-select";
import itemBox from "./components/ItemBox.vue";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
// set component
Vue.component("v-select", vSelect);
Vue.component("v-item-box", itemBox);

// main
export default {
  components: { Loading },
  props: {
    btn_trans: { type: Object },
    url_ajax: { type: Object },
    auth: { type: Object },
  },
  data() {
    return {
      items: [],
      itemsFilter: [],
      isLoading: true,
      fullPage: true,
      filter: null,
      selectFilter: null,
    };
  },
  mounted() {
    console.log(this.auth, "auth");
    this.initialize();
  },
  methods: {
    async initialize() {
      await this.loadData();
    },
    async loadingFunc() {
      this.isLoading = true;
    },
    async changeTypeMaterial($event) {
      this.filter = $event;
    },
    async searchBtn($event) {
      this.isLoading = true;
      await this.loadData();
    },
    async resetFilter() {
      this.filter= null
      this.selectFilter= null
      this.isLoading = true
      this.loadData()
    },
    async loadData() {
      const url = this.url_ajax.raw_material_list_index;
      let filter = this.filter != null ? this.filter.item_cat_code : "";
      let params = { item_cat_code: filter };

      this.items = [];

      console.log("initialize data");
      await axios
        .post(url, params)
        .then((result) => result.data)
        .then((result) => {
          if (result.status_code == 200) {
            this.items = result.data;
          }
        });
      await axios
        .post(url, {})
        .then((result) => result.data)
        .then((result) => {
          if (result.status_code == 200) {
            this.itemsFilter = result.data;
          }
        });
      this.isLoading = false;
    },
  },
};
</script>
