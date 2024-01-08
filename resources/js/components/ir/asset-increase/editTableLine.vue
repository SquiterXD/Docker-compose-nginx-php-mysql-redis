<template>
    <div class="margin_top_20" v-loading="dataLoading">
        <el-form :model="form"
                 ref="save_table_line"
                 label-width="120px"
                 class="demo-dynamic form_table_line">
            <div class="table-responsive margin_top_20">
                <div style="font-size: 18px;"> &nbsp;
                    <span>กรมธรรม์ชุดที่ {{poli}} : {{polides}}</span>
                    <span class="ml-2">ปี : {{yearr}}</span>
                    <span class="ml-2">ครั้งที่ : {{count_set}}</span>
                    <span class="ml-2">วันที่ขึ้นทะเบียน/ตัดจำหน่าย : {{startt}} ถึง {{endd}}</span>
                </div>
                <br>
                <table class="table table-bordered"
                       style="display: block; overflow: auto; max-height: 500px;">
                    <thead>
                    <tr>
                        <th style="min-width: 110px;" class="text-center">IR Status<br>สถานะ</th>
                        <th style="min-width: 110px;" class="text-center">Count<br>จำนวนรายการ</th>
                        <th style="min-width: 200px;" class="text-center">Total Transaction Amount <br>จำนวนเงินทั้งหมด
                        </th>
                        <th style="min-width: 200px;" class="text-center">Total Coverage Amount <br>มูลค่าทุนประกันทั้งหมด
                        </th>
                        <th style="min-width: 150px;" class="text-center">Total Premium <br>ค่าเบี้ยประกันทั้งหมด</th>
                        <th style="min-width: 110px;" class="text-center">Total Duty Fee <br>อากรทั้งหมด</th>
                        <th style="min-width: 140px;" class="text-center">Total Vat <br>ภาษีมูลค่าเพิ่มทั้งหมด</th>
                        <th style="min-width: 200px;" class="text-center">Total Net Amount<br>ค่าเบี้ยประกันสุทธิทั้งหมด</th>
                        <th style="min-width: 200px; vertical-align: middle;" class="text-center">ค่าเบี้ยประกันเรียกเก็บสุทธิรวม</th>
                    </tr>
                    </thead>
                    <tbody id="table_search">
                    <tr>
                        <td>New</td>
                        <td class="text-center">{{testt}}</td>
                        <td class="text-right">{{tran}}</td>
                        <td class="text-right">{{formatCurrency(money)}}</td>
                        <td class="text-right">{{formatCurrency(prem)}}</td>
                        <td class="text-right">{{formatCurrency(dutt)}}</td>
                        <td class="text-right">{{formatCurrency(vatt)}}</td>
                        <td class="text-right">{{formatSum(prem,dutt,vatt)}}</td>
                        <td class="text-right">{{formatCurrency(receivableNet)}}</td>
                    </tr>
                    <tr>
                        <td>Confirmed</td>
                        <td class="text-center">{{test2}}</td>
                        <td class="text-right">{{tran2}}</td>
                        <td class="text-right">{{formatCurrency(money2)}}</td>
                        <td class="text-right">{{formatCurrency(prem2)}}</td>
                        <td class="text-right">{{formatCurrency(dutt2)}}</td>
                        <td class="text-right">{{formatCurrency(vatt2)}}</td>
                        <td class="text-right">{{formatSum(prem2,dutt2,vatt2)}}</td>
                        <td class="text-right">{{formatCurrency(receivableNet2)}}</td>
                    </tr>
                    <tr>
                        <td>cancelled</td>
                        <td class="text-center">{{test3}}</td>
                        <td class="text-right">{{tran3}}</td>
                        <td class="text-right">{{formatCurrency(money3)}}</td>
                        <td class="text-right">{{formatCurrency(prem3)}}</td>
                        <td class="text-right">{{formatCurrency(dutt3)}}</td>
                        <td class="text-right">{{formatCurrency(vatt3)}}</td>
                        <td class="text-right">{{formatSum(prem3,dutt3,vatt3)}}</td>
                        <td class="text-right">{{formatCurrency(receivableNet3)}}</td>
                    </tr>
                    <tr>
                        <td>Interface</td>
                        <td class="text-center">{{test4}}</td>
                        <td class="text-right">{{tran4}}</td>
                        <td class="text-right">{{formatCurrency(money4)}}</td>
                        <td class="text-right">{{formatCurrency(prem4)}}</td>
                        <td class="text-right">{{formatCurrency(dutt4)}}</td>
                        <td class="text-right">{{formatCurrency(vatt4)}}</td>
                        <td class="text-right">{{formatSum(prem4,dutt4,vatt4)}}</td>
                        <td class="text-right">{{formatCurrency(receivableNet4)}}</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td class="text-center">{{testt + test2 + test3 + test4}}</td>
                        <td class="text-right">{{totaltran}}</td>
                        <td class="text-right">{{formatCurrency(money+money2+money3+money4)}}</td>
                        <td class="text-right">{{formatSum(prem,prem2,prem3,prem4)}}</td>
                        <td class="text-right">{{formatSum(dutt,dutt2,dutt3,dutt4)}}</td>
                        <td class="text-right">{{formatSum(vatt,vatt2,vatt3,vatt4)}}</td>
                        <td class="text-right">
                            {{formatTotal(formatSum(prem,prem2,prem3,prem4),formatSum(dutt,dutt2,dutt3,dutt4),formatSum(vatt,vatt2,vatt3,vatt4))}}
                        </td>
                        <td class="text-right">{{formatSum(receivableNet,receivableNet2,receivableNet3,receivableNet4)}}</td>
                    </tr>
                    </tbody>
                    <tfoot></tfoot>
                </table>
            </div>

            <div class="mt-2 mb-2">
                <a :href="`/ir/assets/asset-increase/export?id=${headerRow.header_id}&program_code=IRP0004`" type="button" class="btn btn-sm btn-info" target="_bank"> <i class="fa fa-print"></i> Export </a>
            </div>

            <div class="table-responsive margin_top_20 ">

                <b-table
                    table-class="table table-bordered"
                    style="display: block; overflow: auto; max-height: 500px;"
                    :busy.sync="isBusy"
                    :items="form.tableLine"
                    :fields="fields"
                    :current-page="current_page"
                    :per-page="perPage"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    :tbody-tr-class="rowClass"
                    primary-key="rowId"
                    show-empty
                    hover
                    small
                    select-mode="single"
                    selectable
                    @row-selected="onRowSelected"
                >
                    <!-- th header -->
                    <!-- ------------------------------------------------------ -->
                    <template #head(selected)="header">
                        Select All <br>
                        <div class="form-check" style="position: inherit;">
                            <input class="form-check-input"
                                type="checkbox"
                                @click="clickSelectAll()"
                                :name="`asset_increase_select_all`"
                                style="position: inherit;"
                                :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag">
                        </div>
                    </template>
                    <template #head(line_no)="header">
                        <div>
                            Line No
                        </div>
                    </template>
                    <template #head(status)="header">
                        <div>
                            IR Status<br>สถานะ
                        </div>
                    </template>
                    <template #head(line_type)="header">
                        <div>
                            Line Type<br>ประเภท
                        </div>
                    </template>
                    <template #head(department_location_code)="header">
                        <div>
                            Department Code By Location <br>รหัสหน่วยงานตามสถานที่ *
                        </div>
                    </template>
                    <template #head(department_location_desc)="header">
                        <div>
                            Department By Location <br>หน่วยงานตามสถานที่ *
                        </div>
                    </template>
                    <template #head(department_cost_code)="header">
                        <div>
                            Department Code By Expense <br>รหัสหน่วยงานตามค่าใช้จ่าย *
                        </div>
                    </template>
                    <template #head(department_cost_desc)="header">
                        <div>
                            Department By Expense <br>หน่วยงานตามค่าใช้จ่าย *
                        </div>
                    </template>
                    <template #head(account_code)="header">
                        <div>
                            Expense Account Code <br>รหัสบัญชี *
                        </div>
                    </template>
                    <template #head(account_desc)="header">
                        <div>
                            Expense Account Description <br>บัญชีค่าใช้จ่าย
                        </div>
                    </template>
                    <template #head(asset_number)="header">
                        <div>
                            Asset Number <br>รหัสทรัพย์สิน *
                        </div>
                    </template>
                    <template #head(department_code)="header">
                        <div>
                            รหัสสังกัด *
                        </div>
                    </template>
                    <template #head(department_name)="header">
                        <div>
                             สังกัด *
                        </div>
                    </template>
                    <template #head(location_name)="header">
                        <div>
                            กลุ่มของทรัพย์สิน *
                        </div>
                    </template>
                    <template #head(category_code)="header">
                        <div>
                            รหัสหมวด *
                        </div>
                    </template>
                    <template #head(category_description)="header">
                        <div>
                            หมวด *
                        </div>
                    </template>
                    <template #head(quantity)="header">
                        <div>
                            Qty. <br>จำนวน *
                        </div>
                    </template>
                    <template #head(adjustment_amount)="header">
                        <div>
                            Transaction Amount <br>จำนวนเงิน * (บาท)
                        </div>
                    </template>
                    <template #head(coverage_amount)="header">
                        <div>
                            Coverage Amount <br>มูลค่าทุนประกัน เพิ่ม/ลด *
                        </div>
                    </template>
                    <template #head(insurance_amount)="header">
                        <div>
                            Premium <br>ค่าเบี้ยประกัน เพิ่ม/ลด
                        </div>
                    </template>
                    <template #head(duty_amount)="header">
                        <div>
                            Duty Fee <br>อากร
                        </div>
                    </template>
                    <template #head(vat_amount)="header">
                        <div>
                            Vat <br>ภาษีมูลค่าเพิ่ม
                        </div>
                    </template>
                    <template #head(net_amount)="header">
                        <div>
                            Net Amount <br>ค่าเบี้ยประกัน เพิ่ม/ลดสุทธิ
                        </div>
                    </template>
                    <template #head(receivable_name)="header">
                        <div>
                           เรียกเก็บ
                        </div>
                    </template>
                    <template #head(expense_flag)="header">
                        <div>
                           สถานะการตัดค่าใช้จ่าย
                        </div>
                    </template>
                    <template #head(remove)="header">
                        <div>
                           ลบ
                        </div>
                    </template>

                    <!-- td row -->
                    <!-- ------------------------------------------------------ -->
                    <template #cell(selected)="row">
                        <div class="form-check padding_top_10" style="position: inherit;">
                            <input
                                :class="`form-check-input ${checkStatusInterface(row.item.status) ? 'checkbox_edit_disabled' : ''}`"
                                type="checkbox"
                                @click="clickSelectRow(row.index, row.item)"
                                :name="`asset_increase_select${row.index}`"
                                :value="`${row.index}`"
                                :checked="columnSelectedId.includes(row.item.rowId)"
                                :disabled="checkStatusInterface(row.item.status) || !complete || checkExpenseFlag ? true : false"
                                style="position: inherit;">
                        </div>
                    </template>
                    <template #cell(line_no)="row">
                        <div>
                            {{row.item.line_no}}
                        </div>
                    </template>
                    <template #cell(status)="row">
                        <div>
                            {{setFirstLetterUpperCase(row.item.status)}}
                        </div>
                    </template>
                    <template #cell(line_type)="row">
                        <div>
                            {{setFirstLetterUpperCase(row.item.line_type)}}
                        </div>
                    </template>
                    <template #cell(department_location_code)="row">
                        <div v-if="row.item.flag === 'edit'" class="padding_top_10">
                            {{isNullOrUndefined(row.item.department_location_code)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.department_location_code'" :rules="rules.department_location_code">
                            <lov-department-location v-if="complete"
                                                        :attrName="`department_location_code${row.index}`"
                                                        :departmentLocationCode="row.item.department_location_code"
                                                        :row="row.item"/>
                            <div v-else class="">
                                {{isNullOrUndefined(row.item.department_location_code)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(department_location_desc)="row">
                        <div>
                            {{setFirstLetterUpperCase(row.item.department_location_desc)}}
                        </div>
                    </template>
                    <template #cell(department_cost_code)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{isNullOrUndefined(row.item.department_cost_code)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.department_cost_code'" :rules="rules.department_cost_code">
                            <lov-department-cost v-if="complete" 
                                :attrName="`department_cost_code${row.index}`" 
                                :departmentCostCode="row.item.department_cost_code"
                                :row="row.item"/>
                            <div v-else class="">
                                {{isNullOrUndefined(row.item.department_cost_code)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(department_cost_desc)="row">
                        <div >
                            {{isNullOrUndefined(row.item.department_cost_desc)}}
                        </div>
                    </template>
                    <template #cell(account_code)="row">
                        <el-form-item v-if="complete && row.item.flag === 'add'" :prop="'tableLine.' + row.index + '.account_code'" :rules="rules.account_code">
                            <div style="padding-top: 3px;">
                                <el-input placeholder="รหัสบัญชี"
                                            v-model="row.item.account_code"
                                            type="text"
                                            @focus="focusNotKey()"
                                            @change="accountEnter(row.item)"
                                            size="small">
                                    <el-button slot="append"
                                                data-toggle="modal"
                                                @click="clickModalAccount(row.item, row.index)"
                                                :data-target="`#modal_account${row.index}`"
                                                native-type="button">
                                        <i class="fa fa-search"></i>
                                    </el-button>
                                </el-input>
                            </div>
                        </el-form-item>
                        <div v-else class="padding_top_10">
                            {{isNullOrUndefined(row.item.account_code)}}
                        </div>
                    </template>
                    <template #cell(account_desc)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.account_desc)}}
                        </div>
                    </template>
                    <template #cell(asset_number)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{isNullOrUndefined(row.item.asset_number)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.asset_number'" :rules="rules.asset_number">
                            <el-input placeholder="รหัสทรัพย์สิน"
                                        v-model="row.item.asset_number"
                                        v-if="complete"
                                        size="small"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.asset_number)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(department_code)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{isNullOrUndefined(row.item.department_code)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.department_code'" :rules="rules.department_code">
                            <lov-department v-if="complete"
                                            :attrName="`department_code${row.index}`"
                                            :departmentCode="row.item.department_code"
                                            :row="row.item"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.department_code)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(department_name)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.department_name)}}
                        </div>
                    </template>
                    <template #cell(location_name)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{isNullOrUndefined(row.item.location_name)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.location_name'" :rules="rules.location_name">
                            <lov-asset-group v-if="complete"
                                                :attrName="`asset_group${row.index}`"
                                                v-model="row.item.location_code"
                                                @change-value-asset-group="getDataAssetGroupTable"
                                                :isTable="true"
                                                :row="row.item"
                                                size="small"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.location_name)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(category_code)="row">
                        <div v-if="row.item.flag === 'edit'" class="padding_top_10">
                            {{isNullOrUndefined(row.item.category_code)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.category_code'" :rules="rules.category_code">
                            <lov-category v-if="complete"
                                            :attrName="`category_code${row.index}`"
                                            :categoryId="row.item.category_code"
                                            :row="row.item"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.category_code)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(category_description)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.category_description)}}
                        </div>
                    </template>
                    <template #cell(quantity)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{formatCurrency(row.item.quantity)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.quantity'" :rules="rules.quantity" class="currency_right">
                                <currency-input v-model="row.item.quantity"
                                                :name="`quantity${row.index}`"
                                                :sizeSmall="true"
                                                placeholder="จำนวน"
                                                :disabled="false"
                                                @input="changeQuantity(...arguments, row.index)"
                                                v-if="complete"
                                                @blur-currency="blurQuantity(...arguments, row.index)"/>
                                <div v-else class="">
                                    {{formatCurrency(row.item.quantity)}}
                                </div>
                            </el-form-item>
                    </template>
                    <template #cell(adjustment_amount)="row">
                        <div v-if="checkStatusInterface(row.item.status) || !complete" class="padding_top_10">
                            {{isNullOrUndefined(row.item.adjustment_amount) ?
                            formatCurrency(row.item.adjustment_amount) :
                            isNullOrUndefined(row.item.adjustment_amount)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.adjustment_amount'" :rules="rules.adjustment_amount">
                            <ceil-thousand-currency-input v-model="row.item.adjustment_amount"
                                                        :isChangeCeli="false"
                                                        :isBlurCeli="true"
                                                        :row="row.item"
                                                        :insurance_amount_master="row.item.premium_rate"
                                                        :vat_amount_master="row.item.premium_tax"
                                                        v-if="complete"
                                                        :sizeSmall="true"
                                                        placeholder="จำนวนเงิน"
                                                        :qtyDay="qtyDay"
                                                        @value-cover-amount="getValueCoverAmountFromAdjAmount(...arguments, row.index, row.item.adjustment_amount, row.item)"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.adjustment_amount) ?
                                formatCurrency(row.item.adjustment_amount) :
                                isNullOrUndefined(row.item.adjustment_amount)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(coverage_amount)="row">
                        <div v-if="checkStatusInterface(row.item.status) || !complete" class="padding_top_10">
                            {{isNullOrUndefined(row.item.coverage_amount) ? formatCurrency(row.item.coverage_amount) : isNullOrUndefined(row.item.coverage_amount)}}
                        </div>
                        <el-form-item v-else :prop="'tableLine.' + row.index + '.coverage_amount'" :rules="rules.coverage_amount">
                            <ceil-thousand-currency-input v-model="row.item.coverage_amount"
                                                            :isChangeCeli="true"
                                                            :isBlurCeli="false"
                                                            :row="row.item"
                                                            :insurance_amount_master="row.item.premium_rate"
                                                            :vat_amount_master="row.item.premium_tax"
                                                            v-if="complete"
                                                            :sizeSmall="true"
                                                            placeholder="มูลค่าทุนประกัน เพิ่ม/ลด"
                                                            :qtyDay="qtyDay"
                                                            @value-cover-amount="getValueCoverAmount(...arguments, row.index, true, row.item)"/>
                            <div v-else
                                    class="">
                                {{isNullOrUndefined(row.item.coverage_amount) ?
                                formatCurrency(row.item.coverage_amount) :
                                isNullOrUndefined(row.item.coverage_amount)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(insurance_amount)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.insurance_amount) || isNullOrUndefined(row.item.insurance_amount)
                            === 0 ?
                            formatCurrency(row.item.insurance_amount) :
                            isNullOrUndefined(row.item.insurance_amount)}}
                        </div>
                    </template>
                    <template #cell(duty_amount)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.duty_amount) || isNullOrUndefined(row.item.duty_amount) === 0 ?
                            formatCurrency(row.item.duty_amount) :
                            isNullOrUndefined(row.item.duty_amount)}}
                        </div>
                    </template>
                    <template #cell(vat_amount)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.vat_amount) || isNullOrUndefined(row.item.vat_amount) === 0 ? formatCurrency(row.item.vat_amount) : isNullOrUndefined(row.item.vat_amount)}}
                        </div>
                    </template>
                    <template #cell(net_amount)="row">
                        <div class="padding_top_10">
                            {{isNullOrUndefined(row.item.net_amount) || isNullOrUndefined(row.item.net_amount) === 0 ? formatCurrency(row.item.net_amount) : isNullOrUndefined(row.item.net_amount)}}
                        </div>
                    </template>
                    <template #cell(receivable_name)="row">
                        <div v-if="row.item.flag === 'edit'"
                                class="padding_top_10">
                            {{isNullOrUndefined(row.item.receivable_name)}}
                        </div>
                        <el-form-item v-else>
                            <lov-receivable v-if="complete"
                                            :attrName="`receivable_name${row.index}`"
                                            :receivable="row.item.receivable_name"
                                            :row="row.item"
                                            :headerRow="headerRow"/>
                            <div v-else
                                    class="padding_top_10">
                                {{isNullOrUndefined(row.item.receivable_name)}}
                            </div>
                        </el-form-item>
                    </template>
                    <template #cell(expense_flag)="row">
                        <div class="padding_top_10">
                            {{setLabelExpenseFlag(row.item.expense_flag)}}
                        </div>
                    </template>
                    <template #cell(remove)="row">
                        <template v-if="row.item.line_type == 'MANUAL' && complete">
                                <el-form-item v-if="row.item.status === 'NEW'">
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            @click="clickRemove(row.item, row.index)"
                                            :name="`line_remove${row.index}`">
                                        <i class="fa fa-times m-r-xs"></i>ลบ
                                    </button>
                                </el-form-item>
                            </template>
                            <template v-else>
                                <el-form-item v-if="row.item.flag === 'add' && !row.item.line_id">
                                    <button type="button"
                                            class="btn btn-danger btn-sm"
                                            @click="clickRemove(row.item, row.index)"
                                            :name="`line_remove${row.index}`">
                                        <i class="fa fa-times m-r-xs"></i>ลบ
                                    </button>
                                </el-form-item>
                            </template>
                    </template>
                </b-table>
            </div>
            <div class="row" v-show="totalRows > perPage">
                <div class="col-md-12">
                    <b-pagination
                    v-model="current_page"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="right"
                    ></b-pagination>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-12 text-right">
                    <el-pagination
                        :disabled="disabled_change_page"
                        :hide-on-single-page="true"
                        :page-size="perPage"
                        :current-page.sync="current_page"
                        @current-change="handleTablePage()"
                        layout="prev, pager, next"
                        :total="form.tableLine.length"
                    >
                    </el-pagination>
                </div>
            </div> -->
            <div class="row margin_top_20">
                <div class="col-md-6">
                    <div class="form-group el_field">
                        <el-form-item>
                            <button type="button"
                                    class="btn btn-primary"
                                    :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                                    @click="clickConfirm()">
                                <i class="fa fa-check"></i>
                                ยืนยัน
                            </button>
                            <button type="button"
                                    class="btn btn-danger"
                                    :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                                    @click="clickCancel()">
                                <i class="fa fa-times"></i>
                                ยกเลิก
                            </button>
                            <button type="button"
                                    class="btn btn-warning"
                                    :disabled="!complete || checkStatusInterface(headerRow.status) || checkExpenseFlag"
                                    @click="clickClear()">
                                <i class="fa fa-repeat"></i>
                                รีเซต
                            </button>
                        </el-form-item>
                    </div>
                </div>
                <div class="col-md-6 lable_align">
                    <div class="form-group el_field">
                        <el-form-item>
                            <button type="button"
                                    class="btn btn-primary"
                                    v-show="complete"
                                    @click="clickComplete()"
                                    :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag">
                                <i class="fa fa-check-square-o"></i> บันทึก (ล็อค)
                            </button>
                            <button type="button"
                                    class="btn btn-danger"
                                    v-show="!complete"
                                    @click="clickIncomplete()"
                                    :disabled="checkStatusInterface(headerRow.status) || checkExpenseFlag">
                                <i class="fa fa-minus-square-o"></i> แก้ไข (ปลดล็อค)
                            </button>
                        </el-form-item>
                    </div>
                </div>
            </div>
        </el-form>
        <modal-account-code :index="indexTable"
                            :rows="form.tableLine"
                            @select-accounts="getDataRowSelectAccount"
                            :accounts="account"
                            ref="editTableLineModalAccountCode"
                            @clear-req="clearReqAccountCode"
                            :accountId="accountId"
                            :descriptions="account2"
                            :type_cost="type_cost"/>
    </div>
</template>

<script>
    import lovAssetGroup from './lovAssetGroup'
    import lovDepartmentLocation from './lovDepartmentLocation'
    import lovDepartmentCost from './lovDepartmentCost'
    import lovDepartment from './lovDepartment'
    import lovCategory from './lovCategory'
    import lovReceivable from './lovReceivable'
    import modalAccountCode from './modalAccountCode'
    import ceilThousandCurrencyInput from './ceilThousandCurrencyInput'
    import currencyInput from '../components/currencyInput'
    import dropdownStatusAsset from '../components/dropdown/statusAsset'
    import moment from 'moment'

    export default {
        name: 'ir-asset-increase-edit-table-line',
        data() {
            return {
                setDataRowsNotInterface: [],
                complete: true,
                columnSelected: [],
                columnSelectedId: [],
                manual_cover_amounts: [],
                indexTable: 0,
                account: {
                    company: '',
                    branch: '',
                    department: '',
                    product: '',
                    source: '',
                    account: '',
                    subAccount: '',
                    projectActivity: '',
                    interCompany: '',
                    allocation: '',
                    futureUsed1: '',
                    futureUsed2: ''
                },
                account2: {
                    company: '',
                    branch: '',
                    department: '',
                    product: '',
                    source: '',
                    account: '',
                    subAccount: '',
                    projectActivity: '',
                    interCompany: '',
                    allocation: '',
                    futureUsed1: '',
                    futureUsed2: ''
                },
                rules: {
                    department_location_code: [{
                        required: true, message: 'กรุณาระบุรหัสหน่วยงานตามสถานที่', trigger: 'change'
                    }],
                    department_cost_code: [{
                        required: true, message: 'กรุณาระบุรหัสหน่วยงานตามค่าใช้จ่าย', trigger: 'change'
                    }],
                    account_code: [{
                        required: true, message: 'กรุณาระบุรหัสบัญชี', trigger: 'change'
                    }],
                    asset_number: [{
                        required: true, message: 'กรุณาระบุรหัสทรัพย์สิน', trigger: 'blur'
                    }],
                    department_code: [{
                        required: true, message: 'กรุณาระบุรหัสสังกัด', trigger: 'change'
                    }],
                    location_name: [{
                        required: true, message: 'กรุณาระบุกลุ่มของทรัพย์สิน', trigger: 'change'
                    }],
                    category_code: [{
                        required: true, message: 'กรุณาระบุรหัสหมวด', trigger: 'change'
                    }],
                    quantity: [{
                        required: true, message: 'กรุณาระบุจำนวน', trigger: 'blur'
                    }],
                    adjustment_amount: [{
                        required: true, message: 'กรุณาระบุจำนวนเงิน', trigger: 'blur'
                    }],
                    coverage_amount: [{
                        required: true, message: 'กรุณาระบุมูลค่าทุนประกัน', trigger: 'blur'
                    }]
                },
                isInputActive: false,
                res_rows_id: [],
                accountId: '',
                type_cost: '',
                activeIndex: '',
                dataLoading: false,
                disabled_change_page: false,
                current_page: 1,


                //B-Table
                totalRows: 0,
                per_page: 500,
                sortBy: '',
                sortDesc: false,
                sortDirection: 'asc',
                showLoading: false,
                isBusy: false,

                fields: [
                    { key: 'selected', sortable: false, class:'text-center text-nowrap options-column align-middle', },
                    { key: 'line_no', sortable: true, class:'text-center text-nowrap options-column align-middle', },
                    { key: 'status', sortable: true, class:'text-nowrap options-column align-middle', tdClass:'align-middle'},
                    { key: 'line_type', sortable: true, class:'text-nowrap options-column align-middle', tdClass:'align-middle'},
                    { key: 'department_location_code', sortable: true, class:'text-center text-nowrap options-column align-middle', tdClass:'align-middle el_field'},
                    { key: 'department_location_desc', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'department_cost_code', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'department_cost_desc', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'account_code', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'account_desc', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'asset_number', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'department_code', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'department_name', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'location_name', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'category_code', sortable: true, class:'text-center text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'category_description', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'quantity', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'adjustment_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'coverage_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle el_field'},
                    { key: 'insurance_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'duty_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'vat_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'net_amount', sortable: true, class:'text-right text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'receivable_name', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'expense_flag', sortable: true, class:'text-nowrap align-middle', tdClass:'align-middle'},
                    { key: 'remove', sortable: false, class:'text-center text-nowrap align-middle', thStyle: 'min-width: 65px;', },
                ],
            }
        },
        props: [
            'isNullOrUndefined',
            'formatCurrency',
            'headerRow',
            'insurance_amount_master',
            'vat_amount_master',
            'form',
            'yearTh',
            'setFirstLetterUpperCase',
            'showYearBE',
            'setYearCE',
            'revision',
            'someInterfaceNotEmpty',
            'tableLineAll',
            'perPage',
            'test',
            'header_id',
            'qtyDay',
            'setLabelStatusAsset',
            'vars',
            'setLabelExpenseFlag',
            'revenue_stamp',
            'formatfloat',
            'checkExpenseFlag',
            'lastRowId',
        ],
        methods: {
            //B-table
            onRowSelected(items) {
                this.selected = items
            },
            rowClass(item, type, test) {
                if (!item || type !== 'row') return
                if (item.rowId === this.lastRowId) return 'newLine'
                // if (item.expense_id === this.selectRowId) return 'mouse-over highlight'
                // return 'mouse-over';
            },

            formatSum(v1, v2, v3 = 0, v4 = 0) {
                return Number(Number(Number(v1).toFixed(2)) + Number(Number(v2).toFixed(2)) + Number(Number(v3).toFixed(2)) + Number(Number(v4).toFixed(2))).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            formatTotal(v1, v2, v3 = 0) {
                return Number(Number(Number(v1.replace(",", "")).toFixed(2)) + Number(Number(v2.replace(",", "")).toFixed(2)) + Number(Number(v3.replace(",", "")).toFixed(2))).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            clickRow(dataRoww, index) {
                let Row = {
                    line_number: this.isNullOrUndefined(dataRoww.line_number),
                    department_location_code: this.isNullOrUndefined(dataRoww.department_location_code),
                    department_location_desc: this.isNullOrUndefined(dataRoww.department_location_desc),
                    department_cost_code: this.isNullOrUndefined(dataRoww.department_cost_code),
                    department_cost_desc: this.isNullOrUndefined(dataRoww.department_cost_desc),
                    account_code: this.isNullOrUndefined(dataRoww.account_code),
                    account_desc: this.isNullOrUndefined(dataRoww.account_desc),
                    asset_number: this.isNullOrUndefined(dataRoww.asset_number),
                    department_code: this.isNullOrUndefined(dataRoww.department_code),
                    department_name: this.isNullOrUndefined(dataRoww.department_name),
                    location_code: this.isNullOrUndefined(dataRoww.location_code),
                    location_name: this.isNullOrUndefined(dataRoww.location_name),
                    category_code: this.isNullOrUndefined(dataRoww.category_code),
                    category_id: this.isNullOrUndefined(dataRoww.category_id),
                    category_description: this.isNullOrUndefined(dataRoww.category_description),
                    quantity: 1,
                    current_cost: this.isNullOrUndefined(dataRoww.current_cost),
                    coverage_amount: this.isNullOrUndefined(dataRoww.coverage_amount),
                    insurance_amount: this.isNullOrUndefined(dataRoww.insurance_amount),
                    vat_amount: this.isNullOrUndefined(dataRoww.vat_amount),
                    net_amount: this.isNullOrUndefined(dataRoww.net_amount),
                    receivable_name: this.isNullOrUndefined(dataRoww.receivable_name),
                    line_type: 'MANUAL',
                    insurance_start_date: this.isNullOrUndefined(dataRoww.insurance_start_date),
                    insurance_end_date: this.isNullOrUndefined(dataRoww.insurance_end_date),
                    flag: 'add',
                    year: this.headerRow.year,
                    account_id: this.isNullOrUndefined(dataRoww.account_id),
                    asset_id: this.isNullOrUndefined(dataRoww.asset_id),
                    location: this.isNullOrUndefined(dataRoww.location),
                    adjustment_source_type: 'ADJUSTMENT',
                    adjustment_date: moment(moment().add(543, 'years')).format(this.vars.formatDate),
                    adjustment_id: this.isNullOrUndefined(dataRoww.adjustment_id),
                    adjustment_type: 'COST',
                    adjustment_quantity: this.isNullOrUndefined(dataRoww.adjustment_quantity),
                    adjustment_cost: this.isNullOrUndefined(dataRoww.adjustment_cost),
                    adjustment_amount: this.isNullOrUndefined(dataRoww.adjustment_amount),
                    original_cost: this.isNullOrUndefined(dataRoww.original_cost),
                    policy_set_header_id: this.headerRow.policy_set_header_id,
                    policy_set_description: this.headerRow.policy_set_description,
                    revision: this.someInterfaceNotEmpty ? this.revision : this.headerRow.revision,
                    expense_flag: 'N',
                    type_cost: this.isNullOrUndefined(dataRoww.type_cost),
                    duty_amount: this.isNullOrUndefined(dataRoww.duty_amount),
                    premium_rate: this.insurance_amount_master,
                    prepaid_insurance: this.prepaid_insurance,
                    revenue_stamp: this.revenue_stamp,
                    tax: this.vat_amount_master
                }

                this.$emit('click-row', Row)
                this.activeIndex = index;

            },
            clickSelectAll() {
                let vm = this;
                vm.columnSelected = [];
                vm.columnSelectedId = [];
                let checked = $(`input[name="asset_increase_select_all"]`).is(':checked')
                vm.form.tableLine.forEach((row, index) => {
                    if (checked && !(vm.checkStatusInterface(row.status) || !vm.complete || vm.checkExpenseFlag)) {
                        vm.setSelectedColumn(row);
                    }
                })
            },
            clickSelectRow(rowId, obj) {
                let vm = this;
                let checked = $(`input[name="asset_increase_select${rowId}"]`).is(':checked')
                if (checked) {
                    vm.setSelectedColumn(obj)
                    let setDataRowsNotInterface = vm.form.tableLine.filter((row, i) => {
                        return !(vm.checkStatusInterface(row.status) || !vm.complete || vm.checkExpenseFlag);
                    })
                    if(setDataRowsNotInterface.length === vm.columnSelected.length){
                        $(`input[name="asset_increase_select_all"]`).prop('checked', true)
                    }
                } else {
                    const index = vm.columnSelected.indexOf(obj);
                    if (index > -1) {
                        vm.columnSelected.splice(index, 1);
                        vm.columnSelectedId.splice(index, 1);
                    }
                    $(`input[name="asset_increase_select_all"]`).prop('checked', false)
                }
            },
            clickConfirm() {
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยืนยัน!', 'warning')
                    return
                }
                this.$refs.save_table_line.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row) => {
                            row.status = 'CONFIRMED'
                            return row
                        })
                    } else {
                        return false;
                    }
                })
            },
            clickCancel() {
                this.$refs.save_table_line.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row) => {
                            row.status = 'CANCELLED'
                            return row
                        })
                    } else {
                        return false;
                    }
                })
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการยกเลิก!', 'warning')
                }
            },
            clickClear() {
                if (this.columnSelected.length === 0) {
                    swal('Warning', 'กรุณาเลือกข้อมูลที่ต้องการรีเซต!', 'warning')
                    return
                }
                this.$refs.save_table_line.validate((valid) => {
                    if (valid) {
                        this.columnSelected.filter((row) => {
                            row.status = 'NEW'
                            return row
                        })
                    } else {
                        return false;
                    }
                })
            },
            clickComplete() {
                this.$refs.save_table_line.validate((valid) => {
                    if (valid) {
                        this.setComplete()
                    } else {
                    }
                })
            },
            someStatusNew(row) {
                if (row.status) {
                    if (row.status.toUpperCase() === 'NEW') {
                        return true
                    }
                }
                return false
            },
            everyStatusNew(row) {
                if (row.status) {
                    if (row.status.toUpperCase() === 'NEW') {
                        return true
                    }
                }
                return false
            },
            everyStatusConfirmed(row) {
                if (row.status) {
                    if (row.status.toUpperCase() === 'CONFIRMED') {
                        return true
                    }
                }
                return false
            },
            everyStatusCancelled(row) {
                if (row.status) {
                    if (row.status.toUpperCase() === 'CANCELLED') {
                        return true
                    }
                }
                return false
            },
            someStatusConfirmedCancelled(row) {
                if (row.status) {
                    if (row.status.toUpperCase() === 'CONFIRMED' || row.status.toUpperCase() === 'CANCELLED') {
                        return true
                    }
                }
                return false
            },
            everyStatusInterface(row) {
                if (row.status && row.status.toUpperCase() === 'INTERFACE') {
                    return true
                }
                return false
            },
            someStatusInterface(row) {
                if (row.status && row.status.toUpperCase() === 'INTERFACE') {
                    return true
                }
                return false
            },
            setSelectedColumn(data) {
                this.columnSelected.push(data)
                this.columnSelectedId.push(data.rowId);
            },
            setDefault() {
                let params = {
                    searchDefault: true
                }
                this.$emit('set-default-edit', params)
            },
            clickIncomplete() {
                this.$emit('toggle-loading', true)
                this.complete = !this.complete
                this.$emit('complete', this.complete)
                setTimeout(() => {
                    this.$emit('toggle-loading', false);
                }, 5000);
            },
            getDataAssetGroupTable(obj) {
                let index = this.form.tableLine.indexOf(obj.row);
                this.form.tableLine[index].location_code = obj.asset_group
                this.form.tableLine[index].location_name = obj.asset_group_name
                this.form.tableLine[index].location_id = obj.id
            },
            getDataRows(dataRows) {
                this.form.tableLine = dataRows
            },
            focusNotKey() {
                $(".readonly").on("keydown paste focus mousedown", function (e) {
                    if (e.keyCode != 9) {
                        e.preventDefault();
                    }
                })
            },
            clickModalAccount(obj, index) {
                this.indexTable = index
                this.$refs.editTableLineModalAccountCode.$refs.modal_account_mapping.clearValidate();
                this.accountId = obj.account_id;
                this.type_cost = obj.type_cost;
                
                this.account['company']         =  '';
                this.account['branch']          =  '';
                this.account['department']      =  '';
                this.account['product']         =  '';
                this.account['source']          =  '';
                this.account['account']         =  '';
                this.account['subAccount']      =  '';
                this.account['projectActivity'] =  '';
                this.account['interCompany']    =  '';
                this.account['allocation']      =  '';
                this.account['futureUsed1']     =  '';
                this.account['futureUsed2']     =  '';

                this.account2['company']         =  '';
                this.account2['branch']          =  '';
                this.account2['department']      =  '';
                this.account2['product']         =  '';
                this.account2['source']          =  '';
                this.account2['account']         =  '';
                this.account2['subAccount']      =  '';
                this.account2['projectActivity'] =  '';
                this.account2['interCompany']    =  '';
                this.account2['allocation']      =  '';
                this.account2['futureUsed1']     =  '';
                this.account2['futureUsed2']     =  '';

                if (obj.account_code) {

                    let coaEnter = obj.account_code;
                    var coa = coaEnter.split('.');

                    this.account['company']         =  coa[0];
                    this.account['branch']          =  coa[1];
                    this.account['department']      =  coa[2];
                    this.account['product']         =  coa[3];
                    this.account['source']          =  coa[4];
                    this.account['account']         =  coa[5];
                    this.account['subAccount']      =  coa[6];
                    this.account['projectActivity'] =  coa[7];
                    this.account['interCompany']    =  coa[8];
                    this.account['allocation']      =  coa[9];
                    this.account['futureUsed1']     =  coa[10];
                    this.account['futureUsed2']     =  coa[11];

                    axios.get("/ir/ajax/asset/validate-account", {
                        params: {
                            segmentAlls: coa,
                            type: 'all',
                            coaEnter: coaEnter
                        }
                    }).then(res => {              
                        if (res.data.status == 'E') {
                            swal({
                                title: "Warning",
                                text: res.data.msg,
                                type: "warning",
                                closeOnConfirm: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                }
                            });

                            let found = this.form.tableLine[this.form.tableLine.indexOf(obj)];
                            found.account_desc = '';
                            found.account_code_desc = '';
                            found.account_code = '';
                            this.dataLoading = false;
                        } else {

                            var desc = res.data.data.split('.');
                            this.account2['company']         =  desc[0];
                            this.account2['branch']          =  desc[1];
                            this.account2['department']      =  desc[2];
                            this.account2['product']         =  desc[3];
                            this.account2['source']          =  desc[4];
                            this.account2['account']         =  desc[5];
                            this.account2['subAccount']      =  desc[6];
                            this.account2['projectActivity'] =  desc[7];
                            this.account2['interCompany']    =  desc[8];
                            this.account2['allocation']      =  desc[9];
                            this.account2['futureUsed1']     =  desc[10];
                            this.account2['futureUsed2']     =  desc[11];
                        
                        }
                    });
                }
            },
            getDataRowSelectAccount(dataRows) {
                this.form.tableLine = dataRows
            },
            clearReqAccountCode(value) {
                if (value) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + this.indexTable + '.account_code').clearValidate()
                } else {
                    this.$refs.save_table_line.validateField('tableLine.' + this.indexTable + '.account_code')
                }
            },
            changeQuantity(value, index) {
                this.form.tableLine[index].adjustment_quantity = value
                this.form.tableLine[index].original_quantity = value
            },
            getDataRowsFieldAdjAmount(dataRows, value, index) {
                this.form.tableLine = dataRows
                if (value) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.adjustment_amount').clearValidate()
                } else {
                    this.$refs.save_table_line.validateField('tableLine.' + index + '.adjustment_amount')
                }
                if (value) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.coverage_amount').clearValidate()
                }
            },
            getDataRowsFieldCoverAmount(dataRows, value, index) {
                this.form.tableLine = dataRows
                if (value) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.coverage_amount').clearValidate()
                } else {
                    this.$refs.save_table_line.validateField('tableLine.' + index + '.coverage_amount')
                }
            },
            setComplete() {
                let _this = this
                let rowsManualYearCE = []
                this.form.tableLine.filter((row) => {
                    let data = {
                        ...row,
                        adjustment_date: row.flag === 'add' ? this.setYearCE('date', row.adjustment_date) : row.adjustment_date
                    }
                    rowsManualYearCE.push(data)
                })
                let setDataRowsIsConfirm = this.form.tableLine.filter((row) => {
                    if (row.status && row.status.toLowerCase() === 'confirmed', 'interface', 'new', 'cancelled') {
                        return row
                    }
                })
                // let setDataRowsIsConfirm = this.form.tableLine + 1
                let setDataRowsIsReceivableCodeNotEmpty = this.form.tableLine.filter((row) => {
                    if (row.receivable_code) {
                        return row
                    }
                })
                let params = {
                    data: {
                        header_id: this.headerRow.header_id,
                        document_number: this.headerRow.document_number,
                        status: this.checkStatus ? this.checkStatus : this.headerRow.status,
                        year: this.headerRow.year,
                        asset_status: this.headerRow.asset_status,
                        policy_set_header_id: this.headerRow.policy_set_header_id,
                        policy_set_description: this.headerRow.policy_set_description,
                        count_asset: setDataRowsIsConfirm.length || setDataRowsIsConfirm.length === 0 ? setDataRowsIsConfirm.length : this.headerRow.count_asset,
                        total_adjustment_cost: this.headerRow.total_adjustment_cost,
                        total_cover_amount: this.headerRow.total_cover_amount,
                        total_insu_amount: this.headerRow.total_cover_amount,
                        total_vat_amount: this.headerRow.total_vat_amount,
                        total_net_amount: this.headerRow.total_net_amount,
                        total_rec_insu_amount: this.headerRow.total_rec_insu_amount,
                        receivable_name: this.headerRow.receivable_name,
                        as_of_date: '',
                        start_calculate_date: this.headerRow.start_calculate_date,
                        end_calculate_date: this.headerRow.end_calculate_date,
                        start_addition_date: this.headerRow.start_addition_date,
                        end_addition_date: this.headerRow.end_addition_date,
                        program_code: 'IRP0004',
                        // rows: this.form.tableLine
                        rows: rowsManualYearCE,
                        insurance_start_date: this.headerRow.insurance_start_date,
                        insurance_end_date: this.headerRow.insurance_end_date,
                        revision: this.someInterfaceNotEmpty ? this.test : this.headerRow.revision
                    }
                }
                if (this.headerRow.header_id) {
                    if (this.checkStatus == 'PENDING' || this.checkStatus == 'NEW') {
                        swal({
                                title: "Warning",
                                text: "มีรายการที่ยังไม่ถูกยืนยัน!",
                                type: "warning",
                                showCancelButton: true,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                    _this.$emit('toggle-loading', true);
                                    _this.receivedCompleted(params)
                                }else {
                                    _this.$emit('toggle-loading', false)
                                }
                            });
                    } else {
                        _this.$emit('toggle-loading', true);
                        _this.receivedCompleted(params)
                    }
                } else {
                    swal('Warning', 'ไม่มีรหัสนี้ในระดับ Header!', 'warning');
                }
            },
            blurQuantity(value, index) {
                if (value) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.quantity').clearValidate()
                } else {
                    this.$refs.save_table_line.validateField('tableLine.' + index + '.quantity')
                }
            },
            checkStatusInterface(status) {
                if (status) {
                    if (status.toUpperCase() === 'INTERFACE') {
                        return true
                    }
                }
                return false
            },
            calColumn(dataRows) {
                this.form.tableLine = dataRows
            },
            getValueCoverAmount(value, index, field, data) {
                this.setCalulateColumsFromCoverAmount(value, this.form.tableLine.indexOf(data), data)
                if (field) {
                    if (value) {
                        this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.coverage_amount').clearValidate()
                    } else {
                        this.$refs.save_table_line.validateField('tableLine.' + index + '.coverage_amount')
                    }
                }
            },
            getValueCoverAmountFromAdjAmount(value, index, adjustment_amount, data) {
                this.setCalulateColumsFromCoverAmount(value, this.form.tableLine.indexOf(data), data)
                if (adjustment_amount) {
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.adjustment_amount').clearValidate()
                    this.$refs.save_table_line.fields.find((f) => f.prop == 'tableLine.' + index + '.coverage_amount').clearValidate()
                } else {
                    this.$refs.save_table_line.validateField('tableLine.' + index + '.adjustment_amount')
                    this.$refs.save_table_line.validateField('tableLine.' + index + '.coverage_amount')
                }
            },
            setCalulateColumsFromCoverAmount(value, index, data) {
                let coverage_amount = value || value === 0 && value !== undefined && value !== null ? value : 0;
                // let include_tax_flag = data.include_tax_flag
                this.form.tableLine[index].coverage_amount = coverage_amount
                let days = !this.headerRow.days ? 0 : this.headerRow.days
                // let day_of_year = data.day_of_year ?  +data.day_of_year : 0
                // let calculate_days = data.calculate_days?  +data.calculate_days : 0
                this.form.tableLine[index].insurance_amount = coverage_amount || coverage_amount === 0 ? [(coverage_amount * data.premium_rate) / 100] * days / 365 : '';// this.qtyDay, this.insurance_amount_master
                let insurance_amount = this.form.tableLine[index].insurance_amount;
                let duty = insurance_amount || insurance_amount === 0 ? insurance_amount * this.revenue_stamp / 100 : 0;
                // let net_amount = this.form.tableLine[index].net_amount ? +this.form.tableLine[index].net_amount : 0
                // let day_of_month = data.day_of_month ? +data.day_of_month : 0
                // let day_of_year = data.day_of_year ?  +data.day_of_year : 0
                // let calculate_days = data.calculate_days?  +data.calculate_days : 0
                // let vat_amount = include_tax_flag === "Y" ? coverage_amount * data.premium_rate * calculate_days / day_of_year : (insurance_amount + duty) * day_of_month / calculate_days
                // this.form.tableLine[index].duty_amount = this.revenue_stamp != 0 ? duty : 0;
                this.form.tableLine[index].duty_amount = insurance_amount || insurance_amount === 0 ? insurance_amount * this.revenue_stamp / 100 : 0;
                // this.form.tableLine[index].vat_amount = insurance_amount || insurance_amount === 0 ? insurance_amount * this.vat_amount_master / 100 : 0; // (insurance_amount + duty) * this.vat_amount_master / 100
                this.form.tableLine[index].vat_amount = insurance_amount || insurance_amount === 0 ? (insurance_amount + duty) * this.vat_amount_master / 100 : 0;
                this.form.tableLine[index].net_amount = insurance_amount || insurance_amount === 0 ? +insurance_amount + +(this.form.tableLine[index].duty_amount).toFixed(2) + +(this.form.tableLine[index].vat_amount).toFixed(2) : 0; // insurance_amount + this.form.tableLine[index].vat_amount
                // this.form.tableLine[index].duty_amount = this.revenue_stamp != 0 ? duty : 0;
            },
            receivedCompleted(params) {
                axios.post(`/ir/ajax/asset`, params)
                    .then(({data}) => {
                        let res = data.data
                        this.complete = !this.complete
                        // swal({
                        //     title: "Success",
                        //     text: data.message,
                        //     type: "success",
                        //     timer: 3000,
                        //     showConfirmButton: false,
                        //     closeOnConfirm: false
                        // });
                        swal("Success", data.message, "success");
                        
                        this.$emit('toggle-loading', false)
                        this.setDefault()
                        this.$emit('complete', this.complete)
                        this.res_rows_id = res.rows
                        this.setDisplayBtnRemove()
                        this.headerRow.document_number = res.document_number;
                    })
                    .catch((error) => {
                        this.$emit('toggle-loading', false)
                        if (error.response.data.status === 400) {
                            swal("Warning", error.response.data.message, "warning");
                        } else {
                            swal("Error", error, "error");
                        }
                    })
            },
            clickRemove(dataRow, i) {
                let _this = this;
                swal({
                        title: "Warning",
                        text: "ต้องการลบหรือไม่?",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            if (dataRow.line_id) {
                                axios.post(`/ir/ajax/asset/delete`, dataRow).then(({data}) => {
                                    let res = data.data;
                                    swal({
                                        title: "Success",
                                        text: '',
                                        type: "success",
                                        timer: 3000,
                                        showConfirmButton: false,
                                        closeOnConfirm: false
                                    });
                                });
                            } else {
                                // let index_tableLine = _this.form.tableLine.indexOf(dataRow)
                                // if (index_tableLine > -1) {
                                // }
                                swal({
                                    title: "Success",
                                    text: '',
                                    timer: 3000,
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                })
                            }

                            _this.tableLineAll.splice(_this.tableLineAll.indexOf(dataRow), 1);
                            _this.form.tableLine.splice(_this.form.tableLine.indexOf(dataRow), 1);
                        }
                    });
            },
            setDisplayBtnRemove() {
                if (this.res_rows_id.length > 0) {
                    this.form.tableLine.filter((show) => {
                        this.res_rows_id.filter((res) => {
                            show.line_id = show.rowId == res.row_id ? res.line_id : show.line_id
                        })
                        return show
                    })
                }
            },
            getValueAdjustmentDate(date, index) {
                let formatDate = this.vars.formatDate
                if (date) {
                    this.form.tableLine[index].adjustment_date = moment(date).format(formatDate)
                } else {
                    this.form.tableLine[index].adjustment_date = ''
                }
            },
            getValueAssetStatus(value, index) {
                this.form.tableLine[index].asset_status = value
            },
            accountEnter(obj) {
                var coaEnter = obj.account_code;
                var coa = coaEnter.split('.');

                if (coa.length != 12) {
                    swal({
                        title: "Warning",
                        text: "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบใหม่",
                        type: "warning",
                        closeOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                        }
                    });
                    return
                }

                if (coa[0] == '' || coa[1] == '' || coa[2] == '' || coa[3] == '' || coa[4] == '' || coa[5] == '' || coa[6] == '' || coa[7] == '' || coa[8] == '' || coa[9] == '' || coa[10] == '' || coa[11] == '') {
                    swal({
                        title: "Warning",
                        text: "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบใหม่",
                        type: "warning",
                        closeOnConfirm: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                        }
                    });
                }else {
                    this.dataLoading = true;
                    axios
                    .get("/ir/ajax/asset/validate-account", {
                        params: {
                            segmentAlls: coa,
                        }
                    }).then(res => {

                        if (res.data.status == 'E') {
                            swal({
                                title: "Warning",
                                text: res.data.msg,
                                type: "warning",
                                closeOnConfirm: true
                            },
                            function (isConfirm) {
                                if (isConfirm) {
                                }
                            });

                            let found = this.form.tableLine[this.form.tableLine.indexOf(obj)];
                            found.account_desc = '';
                            found.account_code_desc = '';
                            found.account_code = '';
                            this.dataLoading = false;
                        } else {

                            let found = this.form.tableLine[this.form.tableLine.indexOf(obj)];
                            found.account_desc = res.data.desc;
                            found.account_code_desc = res.data.data;
                            this.dataLoading = false;
                        }
                        
                        this.dataLoading = false;
                    }).catch(function (error) {
                        this.dataLoading = false;
                    });
                }
            },
            // handleTablePage() {
            //     let checked = $(`input[name="asset_increase_select_all"]`).is(":checked");
            //     if (checked) {
            //         for (let i in this.setDataRowsNotInterface) {
            //         let row = this.setDataRowsNotInterface[i];
            //         let found = this.tableData.find((el) => {
            //             return el.rowId == row.rowId;
            //         });
            //         if (found)$(`input[name="asset_increase_select${row.rowId}"]:not('.checkbox_edit_disabled')`).prop("checked", true);
            //         this.setSelectedColumn(row);
            //         }
            //     } else {
            //         for (let i in this.setDataRowsNotInterface) {
            //         let row = this.setDataRowsNotInterface[i];
            //         let found = this.tableData.find((el) => {
            //             return el.rowId == row.rowId;
            //         });
            //         if (found) $(`input[name="asset_increase_select${row.rowId}"]`).prop("checked", false);
            //         this.selection = [];
            //         }
            //     }
            // },
            // calPropIndex(rowId) {
            //     let _this = this;
            //     let index = null; 
            //     if(_this.tableLineAll.length === _this.form.tableLine.length){
            //         index = rowId;
            //     }else {
            //         index = _this.tableData.findIndex((item)=>{
            //         return item.rowId == rowId;
            //         });
            //     }
            //     return index;
            // },
        },
        computed: {
            testt() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        data += 1
                    }
                })
                return data;
            },
            test2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        data += 1
                    }
                })
                return data;
            },
            test3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        data += 1
                    }
                })
                return data;
            },
            test4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        data += 1
                    }
                })
                return data;
            },
            money() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        data += +row.coverage_amount
                    }
                })
                return data;
            },
            money2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        data += +row.coverage_amount
                    }
                })
                return data;
            },
            money3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        data += +row.coverage_amount
                    }
                })
                return data;
            },
            money4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        data += row.coverage_amount
                    }
                })
                return data;
            },
            prem() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        // data += +row.insurance_amount
                        data += +Number(row.insurance_amount).toFixed(2)
                    }
                })
                return data;
            },
            prem2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        // data += +row.insurance_amount
                        data += +Number(row.insurance_amount).toFixed(2)
                    }
                })
                return data;
            },
            prem3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        // data += +row.insurance_amount
                        data += +Number(row.insurance_amount).toFixed(2)
                    }
                })
                return data;
            },
            prem4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        // data += +row.insurance_amount
                        data += +Number(row.insurance_amount).toFixed(2)
                    }
                })
                return data;
            },
            dutt() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        // data += +row.duty_amount
                        data += +Number(row.duty_amount).toFixed(2)
                    }
                })
                return data;
            },
            dutt2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        // data += +row.duty_amount
                        data += +Number(row.duty_amount).toFixed(2)
                    }
                })
                return data;
            },
            dutt3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        // data += +row.duty_amount
                        data += +Number(row.duty_amount).toFixed(2)
                    }
                })
                return data;
            },
            dutt4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        // data += +row.duty_amount
                        data += +Number(row.duty_amount).toFixed(2)
                    }
                })
                return data;
            },
            vatt() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        data += +row.vat_amount
                    }
                })
                return data;
            },
            vatt2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        data += +row.vat_amount
                    }
                })
                return data;
            },
            vatt3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        data += +row.vat_amount
                    }
                })
                return data;
            },
            vatt4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        data += +row.vat_amount
                    }
                })
                return data;
            },
            nett() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        data += +row.net_amount
                    }
                })
                return data;
            },
            nett2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        data += +row.net_amount
                    }
                })
                return data;
            },
            nett3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        data += +row.net_amount
                    }
                })
                return data;
            },
            nett4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        data += +row.net_amount
                    }
                })
                return data;
            },
            tran() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'NEW') {
                        data += +row.adjustment_amount
                    }
                })
                return data.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            tran2() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CONFIRMED') {
                        data += +row.adjustment_amount
                    }
                })
                return data.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            tran3() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'CANCELLED') {
                        data += +row.adjustment_amount
                    }
                })
                return data.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            tran4() {
                let data = 0
                this.tableLineAll.filter(row => {
                    if (row.status === 'INTERFACE') {
                        data += +row.adjustment_amount
                    }
                })
                return data.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            totaltran() {
                let data = 0
                this.tableLineAll.filter(row => {
                    data += +row.adjustment_amount
                })
                return data.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            poli() {
                let pp = this.headerRow.policy_set_number
                return pp;
            },
            polides() {
                let pp = this.headerRow.policy_set_description
                return pp;
            },
            checkStatus() {
                let someNew = this.tableLineAll.some(this.someStatusNew)
                let everyNew = this.tableLineAll.every(this.everyStatusNew)
                let everyConfirmed = this.tableLineAll.every(this.everyStatusConfirmed)
                let everyCancelled = this.tableLineAll.every(this.everyStatusCancelled)
                let someConfirmedCancelled = this.tableLineAll.some(this.someStatusConfirmedCancelled)
                let everyInterface = this.tableLineAll.every(this.everyStatusInterface)
                let someInterface = this.tableLineAll.some(this.someStatusInterface)

                if (everyNew && !someInterface) {
                    return 'NEW'
                } else if (someConfirmedCancelled && !everyConfirmed && !everyCancelled && !someNew && !someInterface) {
                    return 'CONFIRMED'
                } else if (everyConfirmed && !someInterface) {
                    return 'CONFIRMED'
                } else if (everyCancelled && !someInterface) {
                    return 'CANCELLED'
                } else if (someNew && !everyNew) { // && !someInterface
                    return 'PENDING'
                } else if (everyInterface) {
                    return 'INTERFACE'
                } else if (someInterface && !someNew) {
                    return 'INTERFACE'
                }
                return ''
            },
            startt() {
                if (this.headerRow.start_addition_date != '') {
                    let pp = this.headerRow.start_addition_date.split("/")
                    return pp[0] + '/' + pp[1] + '/' + (Number(pp[2]) + 543);
                }
                return '';
            },
            endd() {
                if (this.headerRow.end_addition_date != '') {
                    let pp = this.headerRow.end_addition_date.split("/")
                    return pp[0] + '/' + pp[1] + '/' + (Number(pp[2]) + 543);
                }
                return '';
            },
            yearr() {
                let pp = (Number(this.headerRow.year) + 543);
                return pp;
            },
            policy_set() {
                let pp = this.headerRow.policy_set_number;
                return pp;
            },
            count_set() {
                let pp = this.headerRow.count_asset;
                return pp;
            },
            receivableNet() {
                let data = 0
                this.tableLineAll.filter(row => {
                if (row.status === 'NEW') {
                    if (row.receivable_name) {
                        data += +Number(row.net_amount).toFixed(2);
                        // data += +row.net_amount;
                    }
                }
                })
                return data;
            },
            receivableNet2() {
                let data = 0
                this.tableLineAll.filter(row => {
                if (row.status === 'CONFIRMED') {
                    if (row.receivable_name) {
                        data += +Number(row.net_amount).toFixed(2);
                        // data += +row.net_amount;
                    }
                }
                })
                return data;
            },
            receivableNet3() {
                let data = 0
                this.tableLineAll.filter(row => {
                if (row.status === 'CANCELLED') {
                    if (row.receivable_name) {
                        data += +Number(row.net_amount).toFixed(2);
                        // data += +row.net_amount;
                    }
                }
                })
                return data;
            },
            receivableNet4() {
                let data = 0
                this.tableLineAll.filter(row => {
                if (row.status === 'INTERFACE') {
                    if (row.receivable_name) {
                        data += +Number(row.net_amount).toFixed(2);
                        // data += +row.net_amount;
                    }
                }
                })
                return data;
            },
            tableData() {
                return this.form.tableLine.slice((this.current_page - 1) * this.perPage, this.current_page * this.perPage);
            },
        },
        components: {
            lovAssetGroup,
            lovDepartmentLocation,
            lovDepartmentCost,
            lovDepartment,
            lovCategory,
            lovReceivable,
            modalAccountCode,
            ceilThousandCurrencyInput,
            currencyInput,
            dropdownStatusAsset
        },
        watch: {
            'complete'(newVal, oldVal) {
                this.$emit('complete', newVal)
                if (!newVal) {
                    $("#table_edit").find("input").prop("disabled", true);
                    $(`input[name="asset_increase_select_all"]`).prop('checked', false)
                    $(`input[name="asset_increase_select_all"]`).prop('disabled', true)
                    $("#table_edit").find('input[type="checkbox"]').prop("checked", false)
                    this.columnSelected = []
                    this.columnSelectedId = []
                } else {
                    $("#table_edit").find("input").prop("disabled", false)
                    $(`input[name="asset_increase_select_all"]`).prop('disabled', false)
                }
                $('.checkbox_edit_disabled').prop("disabled", true);
            },
            'headerRow.document_number'(newVal, oldVal) {
                if (newVal) {
                    this.complete = false
                } else {
                    this.complete = true
                }
            },
            'form.tableLine' (newVal, oldVal) {
                this.totalRows = this.form.tableLine.length;
            }
        },
        mounted(){
        }
    }
</script>

<style scoped>
    th, td {
        padding: 0.25rem;
    }

    th {
        background: white;
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
    }

    .mouse-over:hover {
        background-color: #d4edda !important;
    }
</style>
<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }

  .table.b-table > thead > tr > [aria-sort] > div {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
  }

  .table.b-table > thead > tr > [aria-sort] {
    cursor: pointer;
  }

  table.b-table > thead > tr > th[aria-sort="descending"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="descending"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="descending"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="descending"] > div::after {
    opacity: 1;
    content: "\2193";
    padding-left: 10px;
  }

  table.b-table > thead > tr > th[aria-sort="ascending"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="ascending"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="ascending"] > div::after {
    opacity: 1;
    content: "\2191";
    padding-left: 10px;
  }

  table.b-table > thead > tr > th[aria-sort="none"] > div::before,
  table.b-table > tfoot > tr > th[aria-sort="none"] > div::before {
    content: "";
    padding-left: 15px;
  }

  table.b-table > thead > tr > th[aria-sort="none"] > div::after,
  table.b-table > tfoot > tr > th[aria-sort="none"] > div::after {
    opacity: 1;
    content: "\21C5";
    font-weight: normal;
    padding-left: 10px;
  }

  .table-hover > tbody > tr:hover {
    background-color: #d4edda!important;
  }

  .table-active, .table-active>td, .table-active>th {
    background-color: #d4edda!important;
  }

</style>


