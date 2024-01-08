<template>
  <div class="ibox">
    <div class="ibox-content">
      <form method="get">
        <div class="row">
          <div class="col">
            <label class="w-100 text-left"><strong> ประเภทการเบิก </strong></label>
            <input type="hidden" name="l" value="1">
            <el-select
              v-model="tsm"
              name="tsm"
              placeholder="เลือกข้อมูลประเภทการเบิก"
              class="tw-w-full"
              clearable
              filterable
              remote
              reserve-keyword
            >
              <el-option
                v-for="item in filtersetuptransferlocv"
                :key="item"
                :label="item"
                :value="item"
              >
              </el-option>
            </el-select>
          </div>

          <div class="col">
            <label class="w-100 text-left"><strong> ประเภทวัตถุดิบ </strong></label>
            <el-select
              v-model="ty"
              name="ty"
              placeholder="เลือกข้อมูลประเภทวัตถุดิบ"
              class="tw-w-full"
              clearable
              filterable
              remote
              reserve-keyword
            >
              <el-option
                v-for="(item, key) in filteritemcat"
                :key="key"
                :label="item"
                :value="key"
              >
              </el-option>
            </el-select>
          </div>
        </div>

        <div class="text-right" style="padding-top: 15px">
          <button type="submit" class="btn btn-light">
            <i aria-hidden="true" class="fa fa-search"></i> แสดงข้อมูล
          </button>
          <a type="button" href="/pm/settings/setup-transfer" class="btn btn-danger">
            ล้างค่า
          </a>
        </div>
      </form>
    </div>
  </div>
</template>


<script>
export default {
    props: ['filteritemcat', 'filtersetuptransferlocv'],
    data() {
      return {
        ty: null,
        tsm: null
      }
    },
    mounted() {
      let filteritemcat           = this.filteritemcat
      let filtersetuptransferlocv = this.filtersetuptransferlocv


      let urlParams = new URLSearchParams(window.location.href)
      console.log(urlParams.get('ty'), urlParams.get('tsm'))
      this.ty = urlParams.get('ty')
      this.tsm = urlParams.get('tsm')

    },
}
</script>