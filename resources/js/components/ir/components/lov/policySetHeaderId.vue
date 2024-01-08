<template>
  <div class="el_field">
    <el-select
      v-model="result"
      :placeholder="placeholder"
      :name="name"
      :remote-method="remoteMethod"
      :loading="loading"
      remote
      :clearable="true"
      @focus="onfocus"
      filterable
      @change="onchange"
      :size="size"
      :popper-append-to-body="popperBody"
      :disabled="isDisabled"
    >
      <el-option
        v-for="(data, index) in dataSet"
        :key="index"
        :label="data.policy_set_number + ': ' + data.policy_set_description"
        :value="data.policy_set_header_id"
      >
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: "ir-components-lov-policy-set-header-id",
  data() {
    return {
      rows: [],
      dataSet: [],
      loading: false,
      result: this.value,
      isDisabled: this.disabled === undefined ? false : this.disabled,
    };
  },
  props: [
    "value",
    "name",
    "size",
    "placeholder",
    "popperBody",
    "fixTypeFr",
    "fixTypeSc",
    "check",
    "disabled",
  ],
  methods: {
    remoteMethod(query) {
      this.dataSet = this.rows.filter((item) => {
        return (
          item.policy_set_number.toLowerCase().indexOf(query.toLowerCase()) >
            -1 ||
          item.policy_set_description
            .toLowerCase()
            .indexOf(query.toLowerCase()) > -1
        );
      });
    },
    getDataRows(params) {
      this.loading = true;
      axios
        .get(`/ir/ajax/lov/policy-set-header`, { params })
        .then(({ data }) => {
          this.loading = false;
          if (this.check) {
            this.dataSet = this.rows = data.data.filter((item) => {
              return item.meaning.toLowerCase() == this.check.toLowerCase();
            });
          } else {
            this.dataSet = this.rows = data.data;
          }
        })
        .catch((error) => {
          swal("Error", error, "error");
        });
    },
    onfocus() {
      this.getDataRows({
        policy_set_header_id: "",
        keyword: "",
        type: this.fixTypeFr,
        type2: this.fixTypeSc,
      });
    },
    onchange(value) {
       
      this.$emit("change-lov", value);
    },
  },
  mounted() {
     
    this.result = this.value ? +this.value : this.value;
    this.getDataRows({
      policy_set_header_id: this.value,
      keyword: "",
      type: this.fixTypeFr,
      type2: this.fixTypeSc,
    });
  },
  watch: {
    value(newVal, oldVal) {
      this.result = newVal ? +newVal : newVal;
      this.getDataRows({
        policy_set_header_id: newVal,
        keyword: "",
        type: this.fixTypeFr,
        type2: this.fixTypeSc,
      });
    },
    disabled: function () {
      this.isDisabled = this.disabled;
    },
  },
};
</script>

