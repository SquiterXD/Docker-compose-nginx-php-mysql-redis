<template>
  <form>
    <input type="hidden" name="l" value="1" />
    <div class="ibox">
      <div class="ibox-content" v-loading="loading">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label for="" class="tw-font-bold"
                >กลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)</label
              >
              <el-select
                v-model="machineGroup"
                name="machineGroup"
                placeholder="เลือกข้อมูลกลุ่มชุดเครื่องจักร(มวน)/กลุ่มผลิตภัณฑ์(ก้นกรอง)"
                class="tw-w-full"
                clearable
                filterable
                remote
                @change="handleMachineGroupChange"
                reserve-keyword
              >
                <el-option
                  v-for="item in listsMachineGroup"
                  :key="item"
                  :label="item"
                  :value="item"
                >
                </el-option>
              </el-select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label for="" class="tw-font-bold">เซ็ตเครื่องจักร</label>
              <el-select
                v-model="lineMf"
                name="LineMf"
                placeholder="เลือกข้อมูลเซ็ตเครื่องจักร"
                class="tw-w-full"
                @change="handleChangeLineMf"
                clearable
                filterable
                remote
                reserve-keyword
              >
                <el-option
                  v-for="item in listsLineMf"
                  :key="item"
                  :label="item"
                  :value="item"
                >
                </el-option>
              </el-select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label for="" class="tw-font-bold">ขั้นตอนการทำงาน</label>
              <el-select
                v-model="work"
                name="work"
                placeholder="เลือกข้อมูลขั้นตอนการทำงาน"
                class="tw-w-full"
                clearable
                filterable
                @change="handleChangeWork"
                remote
                reserve-keyword
              >
                <el-option
                  v-for="item in listsWork"
                  :key="item"
                  :label="item"
                  :value="item"
                >
                </el-option>
              </el-select>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label for="" class="tw-font-bold">ประเภทเครื่องจักร</label>
              <el-select
                v-model="machine"
                name="machine"
                placeholder="เลือกข้อมูลประเภทเครื่องจักร"
                class="tw-w-full"
                clearable
                filterable
                remote
                reserve-keyword
              >
                <el-option
                  v-for="item in listsMachine"
                  :key="item"
                  :label="item"
                  :value="item"
                >
                </el-option>
              </el-select>
            </div>
          </div>
        </div>

        <div class="text-right" style="padding-top: 15px">
          <button type="submit" class="btn btn-light">
            <i aria-hidden="true" class="fa fa-search"></i> แสดงข้อมูล
          </button>
          <a type="button" href="/pm/settings/machine-relation" class="btn btn-danger">
            ล้างค่า
          </a>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  data() {
    return {
      loading: false,
      listsMachineGroup: [],
      listsLineMf: [],
      listsWork: [],
      listsMachine: [],
      machineGroup: null,
      lineMf: null,
      work: null,
      machine: null,
    };
  },
  async mounted() {
    await this.fetchListsMachineGroup();

     let urlParams = new URLSearchParams(window.location.href)
      this.machineGroup = urlParams.get('machineGroup')
      await this.fetchListsLineMf();

      this.lineMf = urlParams.get('LineMf')
      await this.fetchListsWork();

      this.work = urlParams.get('work')
      await this.fetchListsMachine();

      this.machine = urlParams.get('machine')
  },
  methods: {
    async fetchListsMachineGroup() {
      this.loading = true;
      await axios
        .post("/pm/settings/machine-relation/api/fetch/machine-group")
        .then((result) => {
          this.listsMachineGroup = result.data;
        })
        .catch((ex) => {
          this.loading = false;
        });
      this.loading = false;
    },

    handleMachineGroupChange() {
      console.log("############# handleMachineGroupChange");
      this.fetchListsLineMf();
      Vue.set(this, "lineMf", null);
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },

    handleChangeLineMf() {
      console.log("############# handleChangeLineMf");
      this.fetchListsWork();
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },

    handleChangeWork() {
      console.log("############# handleChangeWork");
      this.fetchListsMachine();
      Vue.set(this, "machine", null);
    },

    resetFilter() {
      Vue.set(this, "machineGroup", null);
      Vue.set(this, "lineMf", null);
      Vue.set(this, "work", null);
      Vue.set(this, "machine", null);
    },

    async fetchListsLineMf() {
      this.loading = true;
      await axios
        .post("/pm/settings/machine-relation/api/fetch/line-mf", {
          machineGroup: this.machineGroup,
        })
        .then((result) => {
          this.listsLineMf = result.data;
        })
        .catch((ex) => {
          this.loading = false;
        });
      this.loading = false;
    },

    async fetchListsWork() {
      this.loading = true;
      await axios
        .post("/pm/settings/machine-relation/api/fetch/work", {
          machineGroup: this.machineGroup,
          lineMf: this.lineMf,
        })
        .then((result) => {
          this.listsWork = result.data;
        })
        .catch((ex) => {
          this.loading = false;
        });
      this.loading = false;
    },

    async fetchListsMachine() {
      this.loading = true;
      await axios
        .post("/pm/settings/machine-relation/api/fetch/machine", {
          machineGroup: this.machineGroup,
          lineMf: this.lineMf,
          work: this.work,
        })
        .then((result) => {
          this.listsMachine = result.data;
        })
        .catch((ex) => {
          this.loading = false;
        });
      this.loading = false;
    },
  },
};
</script>
