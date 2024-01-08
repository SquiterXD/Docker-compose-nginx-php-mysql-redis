{{-- <div style="overflow-x:auto;"> --}}
<div>
  <table id="tableComplete" class="table mt-4">
    <thead>
      <tr>
        <th class="text-center" style="min-width: 150px;" width="15%">
          <label>สถานะการ Complete </label>
        </th>
        <th class="text-center" style="min-width: 225px;" width="22%">
          <label>วันและเวลาที่เริ่มทำงานจริง  <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 230px;" width="23%">
          <label>ระยะเวลาที่ใช้ในการทำงาน (ชั่วโมง) <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 225px;" width="22%">
          <label>วันและเวลาที่ทำงานเสร็จจริง <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 225px;" width="22%">
          <label>วันและเวลาที่เริ่มหยุดเครื่องจักร <label id="dateTimeStopMachineSt" class="pl-1 text-danger"></label></label>
        </th>
        <th class="text-center" style="min-width: 225px;" width="22%">
          <label>ระยะเวลาที่ใช้ในการหยุดเครื่องจักร <label id="dateTimeStopMachineSum" class="pl-1 text-danger"></label></label>
        </th>
        <th class="text-center" style="min-width: 225px;" width="22%">
          <label>วันและเวลาที่หยุดเครื่องจักรเสร็จ <label id="dateTimeStopMachineEn" class="pl-1 text-danger"></label></label>
        </th>
        <th class="text-center" style="min-width: 250px;" width="25%">
          <label>ผู้ปิดงาน <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 130px;" width="13%">
          <label>เป็น Job JP หรือไม่</label>
        </th>
        <th class="text-center" style="min-width: 160px;" width="16%">
          <label>ปริมาณอะไหล่ที่ผลิตได้ <label id="quantityOfSpare" class="pl-1 text-danger"></label></label>
        </th>
      </tr>
    </thead>
    <tbody id="setTbodyTableComplete"></tbody>
  </table>
</div>