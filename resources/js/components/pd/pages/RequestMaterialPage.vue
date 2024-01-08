<template>
    <form @submit.prevent="mainFormSubmit" ref="mainForm">
<!--        <pre>{{ JSON.stringify({header, lines}, null, 2) }}</pre>-->
        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Request Header <small>การขอเบิกวัตถุดิบนอกแผน</small></h5>
                        <div class="ibox-tools mb-2">
                            <a href="/pd/requestMaterial/new" class="btn btn-primary" @click.prevent="newHeader">
                                <i class="fa fa-plus"></i> สร้าง
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-plus"></i> บันทึก
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6 b-r"><h3 class="m-t-none m-b">ข้อมูล</h3>
                                <div class="form-group">
                                    <label>หน่วยงานที่ขอเบิก</label>
                                    <input type="text"
                                           :value="header.attribute1"
                                           name="header.attribute1"/>
                                </div>
                                <div class="form-group">
                                    <label>เลขที่ใบเบิก</label>
                                    <input type="text"
                                           :value="header.attribute2"
                                           disabled="disabled"/>
                                </div>
                                <div class="form-group">
                                    <label>วันที่ขอเบิก</label>
                                    <input type="date"
                                           class="form-control"
                                           autocomplete="off"
                                           name="created_at"
                                           :value="header.created_at">
                                </div>
                                <div class="form-group">
                                    <label>กลุ่มวัตถุดิบ</label>
                                    <pd-lookup name="header_intencat_matgroup_v"
                                               table="PtinvItemcatMatgroupV"></pd-lookup>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>ผู้ขอเบิก</label>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           disabled="disabled"
                                           :value="header.attribute8">
                                </div>
                                <div class="form-group">
                                    <label>วัตถุประสงค์ในการเบิก</label>
                                    <pd-lookup name="header_request_transfer_status"
                                               table="PtpmRequestTransferStatus"></pd-lookup>
                                </div>
                                <div class="form-group">
                                    <label>สถานะขอเบิก</label>
                                    <input type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           disabled="disabled"
                                           :value="header.attribute8">
                                </div>
                                <div class="form-group">
                                    <label>วันที่นำส่ง ยสท.</label>
                                    <input type="date"
                                           class="form-control"
                                           autocomplete="off" name="attribute3">
                                </div>
                                <div class="form-group">
                                    <label>ขั้นตอนการทำงาน</label>
                                    <pd-lookup name="header_wip_step" table="PtpmWipStep"></pd-lookup>
                                </div>
                                <div class="form-group">
                                    <label>ชุดเครื่องจักร</label>
                                    <pd-lookup table="PtpmWipStep"></pd-lookup>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">

                        <!--                        <div class="ibox-tools mb-2">-->
                        <!--                            <button type="submit" class="btn btn-primary">-->
                        <!--                                <i class="fa fa-plus"></i> เบอร์เล่ย์-->
                        <!--                            </button>-->
                        <!--                        </div>-->

                        <div>
                            <button class="btn btn-sm btn-primary float-right m-t-n-xs" @click.prevent="addNewLine">
                                <strong>เพิ่มรายการ</strong>
                            </button>
                            <button class="btn btn-sm btn-primary float-right m-t-n-xs">
                                <strong>ลบรายการ</strong>
                            </button>
                        </div>

                        <table class="table">
                            <thead>
                            <tr class="">
                                <th>#</th>
                                <th class="" v-for="(header, i) in linesHeader" v-bind:key="i">
                                    <div><small>{{ i + 1 }}</small></div>
                                    <div>{{ header }}</div>
                                </th>
                            </tr>
                            </thead>
                            <tbody v-if="lines.length > 0">
                            <tr v-for="(line, i) in lines">

                                <td>{{ line.newRecord ? '*' : '' }}{{ i + 1 }}</td>

                                <td contenteditable="true" v-html="line.attribute1"
                                    @focusout="onHtmlInput(i,'attribute1',$event.target.innerHTML)">
                                </td>
                                <td contenteditable="true" v-html="line.attribute2"
                                    @focusout="onHtmlInput(i,'attribute2',$event.target.innerHTML)">
                                </td>
                                <td>
                                    <pd-lookup table="PtpmWipStep"
                                               selectedKey="line.attribute3"
                                               @change="(val) => onHtmlInput(i,'attribute3',val)"
                                               :name="`line.lot_number[${i}]`">
                                    </pd-lookup>
                                </td>
                                <td contenteditable="true" v-html="line.attribute4"
                                    @focusout="onHtmlInput(i,'attribute4',$event.target.innerHTML)">
                                </td>
                                <td contenteditable="true" v-html="line.attribute5"
                                    @focusout="onHtmlInput(i,'attribute5',$event.target.innerHTML)">
                                </td>
                                <td contenteditable="true" v-html="line.attribute6"
                                    @focusout="onHtmlInput(i,'attribute6',$event.target.innerHTML)">
                                </td>
                                <td contenteditable="true" v-html="line.attribute7"
                                    @focusout="onHtmlInput(i,'attribute7',$event.target.innerHTML)">
                                </td>
                                <td contenteditable="true" v-html="line.attribute8"
                                    @focusout="onHtmlInput(i,'attribute8',$event.target.innerHTML)">
                                </td>
                                <td>
                                    <button @click.prevent="removeNewLine(i)">delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="text-center" v-if="lines.length === 0">
                            <span class="lead">No Data.</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>

import {extractDataFormEvent, DefaultDBRecord, copyObject} from "../helpers";
import {instance as http} from "../httpClient";

export default {
    created: function () {
        console.log('!! created !!')
    },
    mounted() {
        console.log('!! mounted !!', this.initlines.map(line => ({...line, newRecord: false})))
    },
    data() {
        return {
            linesHeader: [
                "รหัสวัตถุดิบ", "รายละเอียด", "Lot", "ปริมาณที่ต้องใช้+สูญเสีย", "หน่วยนับ", "คงคลังฝ่ายจัดหา", "ปริมาณเบิก", "หน่วยเบิก", ""
            ],
            mode: this.header_id ? 'edit' : 'new',
            header: this.initheader,
            lines: this.initlines.map(line => ({...line, newRecord: false})),
            lineTableModel: {}
        }
    },
    props: {
        header_id: null,
        initheader: {type: Object},
        initlines: {type: Array, default: []},
    },
    methods: {
        triggerMainFormSubmit() {
            console.log('triggerMainFormSubmit')
            this.$refs.mainForm.submit()
        },
        mainFormSubmit(event) {
            let form = extractDataFormEvent(event)
            console.log('mainFormModel', form)
            console.log('linesModel', ...this.lines)
            if (this.mode === 'new') {
                console.log('post', this.header_id, {form})
                //http.post('/api/pd/requestMaterial', form)
            } else {
                console.log('put', this.header_id, {...form, lines: [...this.lines]})
                http.put(`/api/pd/requestMaterial/${this.header_id}`, {...form, lines: [...this.lines]})
            }
        },
        newHeader() {
            this.mode = 'new'
            this.header = {...DefaultDBRecord}
        },
        addNewLine() {
            this.lines.push({...DefaultDBRecord, newRecord: true})
        },
        removeNewLine(i) {
            let line = this.lines[i]
            console.log(i, this.lines[i])
            if (!confirm(`remove line ${line.request_line_id} ?`)) return
            let head = this.lines.slice(0, i)
            let tail = this.lines.slice(i + 1)
            this.lines = [...head, ...tail]
            if (!line.newRecord) {
                console.log('remove new line', line.request_line_id)
                http.delete(`/api/pd/requestMaterial/${line.request_line_id}`)
            }
        },
        onHtmlInput(row, col, val) {
            this.lines[row][col] = val
            console.log('html', row, col, copyObject(this.lines))
        }
    },
}
</script>
