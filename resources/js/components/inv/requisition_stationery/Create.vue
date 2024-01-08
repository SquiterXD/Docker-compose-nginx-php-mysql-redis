<template>
  <div class="container" v-loading="loading">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-md-3 col-form-label">เลขที่ใบเบิก</label>
          <div class="col-md-9">
            <el-input
              :disabled="true"
              placeholder="เลขที่ใบเบิกจะถูกสร้างหลังการบันทึก"
              v-model="form.issue_number"
              disable
            >
            </el-input>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required"
            >รายละเอียดขอเบิก</label
          >
          <div class="col-md-9">
            <el-input
              :autosize="{ minRows: 3, maxRows: 3 }"
              type="textarea"
              placeholder="รายละเอียดขอเบิก"
              v-model="form.description"
            >
            </el-input>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label">สถานะ</label>
          <div class="col-md-9">
            <el-input
              :disabled="true"
              placeholder="สถานะ"
              v-model="form.issue_status"
            >
            </el-input>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group row">
          <label class="col-md-3 col-form-label">วันที่สร้างรายการ</label>
          <div class="col-md-9">
            <el-input
              :disabled="true"
              placeholder="วันที่สร้างรายการ"
              v-model="form.creation_date"
            >
            </el-input>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required">หน่วยงานผู้ขอเบิก</label>
          <div class="col-md-9" v-loading="loadingInput.coaDeptCode" @change="form.cost_center = ''">
            <el-select
              v-model="department_code"
              filterable
              remote
              :debounce="2000"
              :remote-method="getCOAs"
              placeholder="หน่วยงานผู้ขอเบิก"
              :loading="loadingInput.coaDeptCodes"
              style="width: 100%"
            >
              <el-option
                v-for="item in coaDeptCodes"
                :key="item.department_code"
                :label="`${item.department_code} - ${item.description}`"
                :value="item.department_code"
              >
              </el-option>
            </el-select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required">Cost Center</label>
          <div class="col-md-9" v-loading="loadingInput.costCenters">
            <el-select
              v-model="form.cost_center"
              filterable
              remote
              :debounce="2000"
              :remote-method="getCostCenters"
              placeholder="Cost Center"
              :loading="loadingInput.costCenters"
              style="width: 100%"
            >
              <el-option
                v-for="item in costCenters"
                :key="item.flex_value_id"
                :label="`${item.flex_value} - ${item.description}`"
                :value="item.flex_value"
              >
              </el-option>
            </el-select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required">Org</label>
          <div class="col-md-9">
            <el-select
              filterable
              remote
              :debounce="2000"
              v-model="form.organization_id"
              placeholder="คลังสินค้า"
              style="width: 100%"
            >
              <el-option
                v-for="(item, index) in organizations"
                :key="index"
                :label="`${item.parameter.organization_code} - ${item.name}`"
                :value="item.organization_id"
              >
              </el-option>
            </el-select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required">Subinventory</label>
          <div class="col-md-9">
            <el-select
              v-model="form.subinventory_code"
              filterable
              remote
              :debounce="2000"
              :remote-method="getSecondaryInventory"
              placeholder="คลังสินค้าย่อย"
              :loading="loadingInput.secondaryInventory"
              style="width: 100%"
            >
              <el-option
                v-for="(item, index) in secondaryInventory"
                :key="index"
                :label="`${item.secondary_inventory_name} - ${item.description}`"
                :value="item.secondary_inventory_name"
              >
              </el-option>
            </el-select>
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label required">รหัสบัญชี</label>
          <div class="col-md-9">
            <el-select
              v-model="gl_alias_name"
              filterable
              remote
              :debounce="2000"
              :remote-method="getAliasName"
              placeholder="รหัสบัญชี"
              style="width: 100%"
              :loading="loadingInput.aliasName"
              :change="aliasNameOnchange()"
            >
              <el-option
                v-for="(item, index) in aLiasNames"
                :key="index"
                :label="item.description"
                :value="item.alias_name"
              >
              </el-option>
            </el-select>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-9 offset-md-3">
            <input 
              v-model="account_combine" 
              type="plaintext"
              readonly
              class="form-control-plaintext"/>
          </div>
        </div>
      </div>

      <el-divider></el-divider>

      <div class="col-md-9 mb-2">
        <el-select
          v-model="selectItem"
          filterable
          placeholder="เลือกสินค้า"
          style="width: 100%"
          remote
          :remote-method="getItemMaster"
          class="mb-2"
          :loading="loadingInput.systemItem"
        >
          <el-option
            v-for="(item, index) in systemItems"
            :key="index"
            :label="`${item.segment1} - ${item.description}`"
            :value="item.segment1"
          ></el-option>
        </el-select>
      </div>

      <div class="col-md-3 mb-2">
        <el-button
          class="btn-success"
          type="success"
          style="width: 100%"
          @click.native.prevent="addRow()"
          >Add</el-button
        >
      </div>

      <div class="col-md-12">
        <el-table border :data="form.items" style="width: 100%">
          <el-table-column
            class-name="text-center"
            label="Line"
            type="index"
            width="60"
            :index="indexMethod"
          ></el-table-column>
          <el-table-column
            prop="item"
            label="Item"
            width="120"
          ></el-table-column>
          <el-table-column
            prop="description"
            label="รายละเอียดสินค้า"
          ></el-table-column>
          <el-table-column
            class-name="text-center"
            prop="onhand_quantity"
            label="จำนวนคงเหลือ"
            width="150"
          ></el-table-column>
          <el-table-column
            prop="transaction_quantity"
            label="จำนวนที่ขอเบิก"
            width="120"
          >
            <template slot-scope="scope">
              <el-input
                type="number"
                placeholder="จำนวนที่ขอเบิก"
                min="1"
                required
                v-model="scope.row.transaction_quantity"
              >
              </el-input>
            </template>
          </el-table-column>

          <el-table-column
            class-name="text-center"
            prop="primary_unit_of_measure"
            label="หน่วยนับ"
            width="80"
          ></el-table-column>
          <el-table-column
            prop="transaction_account"
            label="เลขทางบัญชี"
          ></el-table-column>
          <el-table-column class-name="text-center" width="100">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="danger"
                @click.native.prevent="deleteRow(scope.$index, form.items)"
                ><i class="el-icon-delete"></i>Delete</el-button
              >
            </template>
          </el-table-column>
        </el-table>
      </div>

      <div class="col-md-12 text-right mt-2">
        <el-button
          class="btn-success"
          size="mini"
          type="success"
          @click="submitForm('DRAFT')"
          v-if="!form.issue_header_id"
          :disabled="!validDraft"
          >บันทึก</el-button
        >
        <el-button
          class="btn-success"
          size="mini"
          type="success"
          @click="submitForm('WAITING')"
          v-if="!form.issue_header_id"
          :disabled="!valid"
          >ส่งรายการเบิก</el-button
        >
        <el-button
          class="btn-success"
          size="mini"
          type="success"
          @click="submitForm('WAITING')"
          v-if="copy"
          >บันทึก</el-button
        >

        <el-button
          class="btn-success"
          size="mini"
          type="success"
          @click="submitForm('UPDATE')"
          v-if="form.issue_header_id && !copy"
        >บันทึกและส่งรายการเบิก</el-button
        >
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.input-label {
  display: inline-block;
  width: 130px;
}

.btn-success {
  background-color: #1ab394;
  border-color: #1ab394;
}
</style>

<script>
import moment from "moment";

export default {
  props: ["defaultIssueHeader", "copy", "department", "edit", "create"],
  data() {
    return {
      coaDeptCodes: [],
      secondaryInventory: [],
      aLiasNames: [],
      systemItems: [],
      organizations: [],
      glCodeCombinations: [],
      costCenters: [],

      gl_alias_name: this.defaultIssueHeader?.gl_alias_name || "",
      account_combine: this.defaultIssueHeader?.account_code || "",
      department_code: this.defaultIssueHeader?.department_code || "",

      selectItem: "",
      form: {
        issue_header_id: this.defaultIssueHeader?.issue_header_id || "",
        issue_number: this.defaultIssueHeader?.issue_number || "",
        transaction_date:
          this.defaultIssueHeader ? moment(this.defaultIssueHeader.transaction_date).add(543, "year").format("DD/MM/YYYY") : moment().add(543, "year").format("DD/MM/YYYY"),
        creation_date:
          this.defaultIssueHeader ? moment(this.defaultIssueHeader.creation_date).add(543, "year").format("DD/MM/YYYY") : moment().add(543, "year").format("DD/MM/YYYY"),
        inventory_item_id: this.defaultIssueHeader?.inventory_item_id || "",
        description: this.defaultIssueHeader?.description || "",
        department_code: this.defaultIssueHeader?.department_code || "",
        subinventory_code: this.defaultIssueHeader?.subinventory_code || "",
        gl_alias_name: this.defaultIssueHeader?.gl_alias_name || "",
        issue_status: 
          this.defaultIssueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย" 
          : this.defaultIssueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
          : this.defaultIssueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
          : this.defaultIssueHeader?.issue_status == 'RETURN' ? "ยกเลิก" 
          : this.defaultIssueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
          : "รอตัดจ่าย" ,
        account_code: "",
        organization_id: this.defaultIssueHeader?.organization_id || "",
        items:
          this.defaultIssueHeader?.details.map((detail) => {
            let data = {
              ...detail,
              ...{ item: detail.inventory_item.segment1 },
              ...{ primary_unit_of_measure: detail.inventory_item.primary_unit_of_measure },
              ...{ item_cost: detail.transaction_cost},
            };
            return data;
          }) || [],
        cost_center: this.defaultIssueHeader?.acc_segment4 || "",
      },

      loadingInput: {
        coaDeptCodes: false,
        secondaryInventory: false,
        aliasName: false,
        systemItem: false,
        organization: false,
        costCenters: false,
      },

      loading: false,
    };
  },
  created: function () {
    this.getMasterData();
  },
  watch: {
    department_code(val) {
      this.gl_alias_name = this.defaultIssueHeader?.gl_alias_name || "";
      this.form.gl_alias_name = this.gl_alias_name;
      this.account_combine = this.defaultIssueHeader?.account_code || "";
      
      this.form.department_code = val;
      this.getCostCenters();

    },
    gl_alias_name: function (val) {
      this.form.gl_alias_name = val;
      this.aliasNameOnchange()

      if (val == "") {
        return
      }

      if (this.department === this.form.department_code) {
        this.form.department_code = this.department.department_code;
      }
      let accountArray = this.form.account_code.split('.');
      accountArray[2] = this.form.department_code;
      accountArray[3] = this.form.cost_center;
      let account_combine = accountArray.join('.');
      
      let selectedGlCodeCombination = this.glCodeCombinations.find((g) => {
        return g.concatenated_segments === account_combine
      });
      if (!selectedGlCodeCombination) {
        this.form.gl_alias_name = "";
        this.gl_alias_name = "";
        return alert("ไม่สามารถเพิ่มสินค้าได้เนื่องจากไม่มีเลขทางบัญชีนี้ในระบบ กรุณาติดต่อฝ่ายบัญชี")
      }
      this.account_combine = account_combine;
      for (let index = 0; index < this.form.items.length; index++) {
        this.form.items[index]['transaction_account'] = account_combine
      }
    }
  },
  async mounted() {
    if (this.create) {
      await this.getCOAsWithDefault(this.department.department_code)
      this.department_code = this.department.department_code
    }
    
    if (this.edit) {
      let originalCOA = (this.defaultIssueHeader.department_code)
      await this.getCOAsWithDefault(originalCOA)
      this.department_code = Number(this.defaultIssueHeader.department_code)
    }
  },
  methods: {
    indexMethod(index) {
      return index + 1;
    },
    getMasterData() {
      this.getAliasName();
      this.getSecondaryInventory(this.form.subinventory_code);
      this.getOrganization();
      this.getGlCodeCombination();
    },
    getItemMaster(query) {
      this.loadingInput.systemItem = true;
      axios
        .get("/inv/ajax/system_item", { params: { text: query, organization_id: this.form.organization_id, subinventory_code: this.form.subinventory_code } })
        .then((response) => {
          this.systemItems = response.data;
        })
        .then(() => {
          this.loadingInput.systemItem = false;
        });
    },

    getAliasName(query) {
      this.loadingInput.aliasName = true;
      axios
        .get("/inv/ajax/alias_name", { params: { text: query, prefix: "A91:จ่ายค่าเครื่องเขียน%" } })
        .then((response) => {
          this.aLiasNames = response.data;
        })
        .catch((err) => {
          console.log("error get alias name");
        })
        .then(() => {
          this.loadingInput.aliasName = false;
        });
    },

    getCOAsWithDefault(query) {
      this.loadingInput.coaDeptCodes = true;
      let getByQuery =   axios.get("/inv/ajax/coa_dept_code_all", { params: { text: query } })
      let getAll =   axios.get("/inv/ajax/coa_dept_code_all", { })

      axios.all([getByQuery, getAll]).then(responses => {
        responses[0].data.map(i => {
          this.coaDeptCodes.push(i)
        })
        responses[1].data.map(i => {
          this.coaDeptCodes.push(i)
        })
      }).then(() => {
          this.loadingInput.coaDeptCodes = false;
        });
    },

    getCOAs(query) {
      axios
        .get("/inv/ajax/coa_dept_code_all", { params: { text: query } })
        .then((response) => {
          this.coaDeptCodes = response.data;
        })
        .then(() => {
          this.loadingInput.coaDeptCodes = false;
        });
    },

    getSecondaryInventory(query) {
      this.loadingInput.secondaryInventory = true;
      axios
        .get("/inv/ajax/secondary_inventories", { params: { text: query, attribute3: 'Yes', organization_code: 'A91' } })
        .then((response) => {
          this.secondaryInventory = response.data;
          this.form.subinventory_code = this.secondaryInventory[0].secondary_inventory_name
        })
        .then(() => {
          this.loadingInput.secondaryInventory = false;
        });
    },

    getOrganization(query) {
      this.loadingInput.organization = true;
      axios
        .get("/inv/ajax/organization_units", { params: { text: query, organization_code: 'A91' } })
        .then((response) => {
          this.organizations = response.data;
          this.form.organization_id = this.organizations[0].organization_id
          this.getItemMaster();
        })
        .then(() => {
          this.loadingInput.organization = false;
        });
    },

    getGlCodeCombination() {
      axios
        .get("/inv/ajax/gl_code_combinations")
        .then((response) => {
          this.glCodeCombinations = response.data;
        });
    },

    getCostCenters(query) {
      axios
        .get("/inv/ajax/cost_centers", { params: { text: query, department_code: this.form.department_code } })
        .then((response) => {
          this.costCenters = response.data;

          if (this.costCenters.length == 1) {
            this.form.cost_center = this.costCenters[0]['flex_value']
          }
        })
        .then(() => {
          this.loadingInput.costCenters = false;
        });;
    },

    deleteRow(index, data) {
      data.splice(index, 1);
    },
    addRow() {
      if (!this.selectItem) {
        return alert("กรุณาเลือกรายการก่อน");
      }

      let existingItem = this.form.items.find((i) => {
        return i.item == this.selectItem
      });

      if (existingItem) {
        return alert("สินค้านี้ถูกเลือกไปแล้ว");
      }

      const selectItem = this.systemItems.find((systemItem) => {
        return systemItem.segment1 == this.selectItem;
      });
      
      this.selectItem = undefined;

      if (selectItem.onhand_quantity <= "0") {
        return alert("จำนวนคงเหลือของสินค้าเท่ากับ 0");
      }

      if (selectItem != "") {
        this.form.items.push({
          item: selectItem.segment1,
          description: selectItem.description,
          onhand_quantity: selectItem.onhand_quantity,
          transaction_quantity: "",
          primary_unit_of_measure: selectItem.primary_unit_of_measure,
          transaction_uom: selectItem.primary_uom_code,
          transaction_account: this.account_combine,
          inventory_item_id: selectItem.inventory_item_id,
          item_cost: selectItem.item_cost_type.item_cost
        });
      }
    },
    submitForm(status) {
      this.form.issue_status = status;
      this.loading = true;
      let invalidateItems = this.form.items.filter(item => {
          return item.transaction_quantity <=0 || item.transaction_quantity == ""
      })
      if (invalidateItems.length > 0) {
        this.loading = false;
        this.form.issue_status = this.defaultIssueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย"
        : this.defaultIssueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
        : this.defaultIssueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
        : this.defaultIssueHeader?.issue_status == 'RETURN' ? "ยกเลิก" 
        : this.defaultIssueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
        : "รอตัดจ่าย" ;
        alert("ไม่สามารถระบุจำนวนติดลบ (-) หรือระบุจำนวนเท่ากับ 0 ได้")
        return
      }
      this.form.department_code = this.form.department_code + ""
      if (status == "UPDATE") {

        for (let index = 0; index < this.form.items.length; index++) {
          if (parseInt(this.form.items[index].onhand_quantity) < parseInt(this.form.items[index].transaction_quantity)) {
            alert("จำนวนรายการสินค้า "+this.form.items[index].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ")
            this.loading = false;
            return 
          }
        }
        
        if (confirm("บันทึกการแก้ไขรายการเบิกจ่ายเครื่องเขียน ?")) {
          axios
          .patch(
            "/inv/requisition_stationery/" + this.form.issue_header_id,
            this.form
          )
          .then((res) => {
            this.loading  = true;
            this.$notify({
                title: 'Success',
                message: 'Successfully',
                type: 'success'
            });
            window.location.replace("/inv/requisition_stationery/");
          })
          .catch((err) => {
            let errorMessage = this.$formatErrorMessage(error);
            alert(errorMessage);
          })
        } else {
          this.form.issue_status = this.defaultIssueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย" 
            : this.defaultIssueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
            : this.defaultIssueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
            : this.defaultIssueHeader?.issue_status == 'RETURN' ? "ยกเลิก" 
            : this.defaultIssueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
            : "รอตัดจ่าย" ,
          this.loading = false;
        }
      } else if (status == "DRAFT") {

        for (let index = 0; index < this.form.items.length; index++) {
          if (parseInt(this.form.items[index].onhand_quantity) < parseInt(this.form.items[index].transaction_quantity)) {
            alert("จำนวนรายการสินค้า "+this.form.items[index].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ")
            this.loading = false;
            return 
          }
        }

        if (confirm("บันทึกร่างรายการเบิกจ่ายเครื่องเขียน ?")) {
            axios
            .post("/inv/requisition_stationery", this.form)
            .then((res) => {
              this.$notify({
                  title: 'Success',
                  message: 'Successfully',
                  type: 'success'
              });
              window.location.replace("/inv/requisition_stationery/");
            })
            .catch((err) => {
              this.loading = false;
              let errorMessage = this.$formatErrorMessage(error);
              alert(errorMessage);
            });
        } else {
          this.form.issue_status = this.defaultIssueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย" 
            : this.defaultIssueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
            : this.defaultIssueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
            : this.defaultIssueHeader?.issue_status == 'RETURN' ? "ยกเลิก"
            : this.defaultIssueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
            : "รอตัดจ่าย" ,
          this.loading = false;
        }
      } else if (status == "WAITING") {
        for (let index = 0; index < this.form.items.length; index++) {
          if (parseInt(this.form.items[index].onhand_quantity) < parseInt(this.form.items[index].transaction_quantity)) {
            alert("จำนวนรายการสินค้า "+this.form.items[index].description+" ที่ขอเบิกมีมากกว่าจำนวนคงเหลือ")
            this.loading = false;
            return 
          }
        }

        if (confirm("ขออนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
            axios
            .post("/inv/requisition_stationery", this.form)
            .then((res) => {
              this.$notify({
                  title: 'Success',
                  message: 'Successfully',
                  type: 'success'
              });
              window.location.replace("/inv/requisition_stationery/");
            })
            .catch((err) => {
              this.loading = false;
              let errorMessage = this.$formatErrorMessage(error);
              alert(errorMessage);
            });
        } else {
          this.form.issue_status = this.defaultIssueHeader?.issue_status == 'WAITING' ? "รอตัดจ่าย" 
            : this.defaultIssueHeader?.issue_status == 'APPROVED' ? "ตัดจ่ายสำเร็จ" 
            : this.defaultIssueHeader?.issue_status == 'CANCELLED' ? "ยกเลิก" 
            : this.defaultIssueHeader?.issue_status == 'RETURN' ? "ยกเลิก"
            : this.defaultIssueHeader?.issue_status == 'DRAFT' ? "ร่างรายการเบิก" 
            : "รอตัดจ่าย" ,
          this.loading = false;
        }
      } else if (status == "APPROVE") {
        if (confirm("อนุมัติการเบิกจ่ายเครื่องเขียน ?")) {
          axios
          .patch(
            `/inv/requisition_stationery/${this.form.issue_header_id}/approve`
          )
          .then((res) => {
            window.location.replace("/inv/requisition_stationery/");
          })
          .catch((err) => {
            this.loading = false;
            let errorMessage = this.$formatErrorMessage(error);
            alert(errorMessage);
          })
          .then(() => {
          });
        } else {
          this.loading = false;
        }
      }
    },
    aliasNameOnchange() {
      if (this.aLiasNames.length > 0 && this.form.gl_alias_name != "") {
        const transaction_account = this.aLiasNames.find(
          (aLiasName) => aLiasName.alias_name == this.form.gl_alias_name
        );
        this.form.account_code = transaction_account.template;
      }
    },
  },
  computed: {
    valid() {
      let isBlank =
        (this.form.description === '') ||
        (this.form.department_code === '') ||
        (this.form.organization_id === '') ||
        (this.form.subinventory_code === '') ||
        (this.form.gl_alias_name === '') || 
        (this.form.items.length === 0);
      return !isBlank;
    },
    validDraft() {
      let isBlank =
        (this.form.description === '') ||
        (this.form.department_code === '') ||
        (this.form.organization_id === '') ||
        (this.form.subinventory_code === '') ||
        (this.form.gl_alias_name === '');
      return !isBlank;
    },
  },
};
</script>
