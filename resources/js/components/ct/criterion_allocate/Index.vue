<template>
    <div class="container">
        <div class="row">
          <div class="col-lg-12 mt-2">
            <el-table border :data="tableData" style="width: 100%">
                <el-table-column
                    prop="code"
                    label="เกณฑ์การปันส่วน"
                    align="center"
                    width="130"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="รายละเอียด"
                    align="start"
                >
                </el-table-column>
                
				<el-table-column
					prop="is_active"
					label="ใช้งาน"
					align="center"
                    width="80"
                >

					<template slot-scope="scope">
						<el-checkbox :v-model="tableData[scope.$index].is_active" :checked="convertBoolean(tableData[scope.$index].is_active)" 
						@change="checkboxOnChange($event, scope.row)"></el-checkbox>
					</template>
				</el-table-column>
            </el-table>
        </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
				tableData: [],
          }
        },
        
        created: function () {
          // created: Working first
          this.getList();
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
			getList() {
                let $this = this;

                axios.get('/ct/ajax/criterion_allocate')
                .then((response) => {
                    $this.tableData = response.data;
                })
                .catch(function (error) {
                    console.log('error: ',  error);
                });
            },
		  	convertBoolean(value) {
                if (value == '1') {
                    return true;
                }
                else if (value == '0') {
                    return false;
                }
            },
            checkboxOnChange(val, row) {
                row.is_active = val;
                this.update(row);
            },
            update(row) {
                axios.post("/ct/ajax/criterion_allocate/update", {
                    criterion_allocate_id: row.criterion_allocate_id,
                    is_active: row.is_active,
                })
                    .then((response) => {
                    this.$message({
                        showClose: true,
                        message: 'บันทึกสำเร็จ',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    this.$message({
                        showClose: true,
                        message: 'ไม่สามารถบันทึกได้',
                        type: 'error'
                    });
                });
            }
        }
    }
</script>
