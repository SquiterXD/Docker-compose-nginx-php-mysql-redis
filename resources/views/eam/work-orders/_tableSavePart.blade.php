{{-- <div style="overflow-x:auto;"> --}}
<div>
  <table id="tableSavePart" class="table mt-4">
    <thead>
      <tr>
        <th class="text-center" style="min-width: 100px;" width="10%">
          <div><input id="checkboxAllTable" type="checkbox"> เลือกทั้งหมด</div>
        </th>
        <th class="text-center" style="min-width: 100px;" width="10%">
          <label>ขั้นตอนที่ <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 170px;" width="15%">
          <label>Item Type <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 200px;" width="15%">
          <label>Item Code <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 200px;" width="15%">
          <label>Item Description <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 100px;" width="15%">
          <label>ตัดใช้ผ่านระบบ WMS</label>
        </th>
        <th class="text-center" style="min-width: 130px;" width="13%">
          <label>จำนวนที่ต้องการใช้<br>(Required) <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 150px;" width="15%">
          <label>สถานะการตัดใช้อะไหล่ </label>
        </th>
        <th class="text-center" style="min-width: 130px;" width="13%">
          <label>จำนวนที่ตัดใช้แล้ว</label>
        </th>
        <th class="text-center" style="min-width: 130px;" width="13%">
          <label>หน่วยนับ <label class="pl-1 text-danger">*</label></label>
        </th>
        <th class="text-center" style="min-width: 130px;" width="13%">
          <label>ราคาต่อหน่วย </label>
        </th>
        <th class="text-center" style="min-width: 150px;" width="12%">
          {{-- <label>Subinventory <label class="pl-1 text-danger">*</label></label> --}}
          <label>Subinventory </label>
        </th>
        <th class="text-center" style="min-width: 200px;" width="12%">
          {{-- <label>Locator <label class="pl-1 text-danger">*</label></label> --}}
          <label>Locator </label>
        </th>
        <th class="text-center" style="min-width: 120px;" width="12%">
          <label>On Hand </label>
        </th>
        <!-- <th class="text-center" style="min-width: 145px;" width="12%">
          <label>PR Number </label>
        </th>
        <th class="text-center" style="min-width: 145px;" width="12%">
          <label>PO Number </label>
        </th>
        <th class="text-center" style="min-width: 145px;" width="12%">
          <label>Received Qty </label>
        </th> -->
        <th class="text-center" style="min-width: 90px;">
          <label></label>
        </th>
        <!-- <th class="text-center" style="min-width: 90px;">
          <label></label>
        </th> -->
      </tr>
    </thead>
    <tbody id="setTbodyTableSavePart"></tbody>
  </table>
</div>