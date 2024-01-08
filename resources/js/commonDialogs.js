
export function showSimpleConfirmationDialog(title) {
    return new Promise((resolve) => {
        swal({
            title: title,
            type: 'warning',
            dangerMode: true,
            showCancelButton: true,
            closeOnCancel: true,
            cancelButtonText: 'ยกเลิก',
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ยืนยัน',
        }, (value) => {
            resolve(value);
        });
    });
}


export function showProgressWithUnsavedChangesWarningDialog() {
    return new Promise((resolve) => {
        swal({
            title: `\nคุณแน่ใจไหม?`, // new line is a workaround for icon cover text
            text: 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่',
            type: 'warning',
            dangerMode: true,
            showCancelButton: true,
            closeOnCancel: true,
            cancelButtonText: 'ยกเลิก',
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ดำเนินการต่อ',
            allowClickOutside: true,
            closeOnClickOutside: true,
        }, (value) => {
            resolve(value);
        });
    });
}

export function showValidationFailedDialog(errorMessages) {
    let errorText =
        '<div style="text-align:left;">' +
        'ข้อมูลที่คุณใส่ไม่ถูกต้องหรือไม่ครบถ้วน กรุณาตรวจสอบข้อมูลและลองใหม่อีกครั้ง<br/><br/>' +
        '</div>';

    errorText += '<div style="text-align:left;color:red">';
    errorText += '<ul>';
    errorMessages.forEach(message => {
        errorText += `<li>${message}<br/></li>`;
    });
    errorText += '</ul>';
    errorText += '</div>';

    return new Promise((resolve) => {
        swal({
            title: `\nเกิดข้อผิดพลาด`,// new line is a workaround for icon cover text
            text: errorText,
            type: 'error',
            html: true,
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ตกลง',
        }, (value) => {
            resolve(value);
        });
    });
}


export function showLoadingDialog() {
    console.debug('showLoadingDialog');

    return new Promise((resolve) => {
        swal({
            // new line is a workaround for icon cover text
            title: `
                    <div class="sk-spinner sk-spinner-wave mb-4">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>
                    กำลังดำเนินการ
                    `,
            html: true,
            showConfirmButton: false,
            closeOnConfirm: false,
        }, (value) => {
            resolve(value);
        });
    });
}

export function showSaveSuccessDialog() {
    return new Promise((resolve) => {
        swal({
            title: `\nสำเร็จ`,// new line is a workaround for icon cover text
            text: 'บันทึกข้อมูลเรียบร้อย',
            type: 'success',
            dangerMode: false,
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ปิด',
        }, (value) => {
            resolve(value);
        });
    });
}

export function showSaveFailureDialog() {
    let errorText = `มีข้อผิดพลาดเกิดขึ้น ไม่สามารถบันทึกข้อมูลได้ กรุณาลองใหม่อีกครั้ง\n`;

    return new Promise((resolve) => {
        swal({
            title: `\nมีข้อผิดพลาด`,// new line is a workaround for icon cover text
            text: errorText,
            type: 'error',
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ปิด',
        }, (value) => {
            resolve(value);
        });
    });
}

export function showGenericFailureDialog(errorText = `มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง\n`) {
    return new Promise((resolve) => {
        swal({
            title: `\nเกิดข้อผิดพลาด`,// new line is a workaround for icon cover text
            text: errorText,
            type: 'error',
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ปิด',
        }, (value) => {
            resolve(value);
        });
    });
}

export function showRemoveLineConfirmationDialog(rowCount) {
    return new Promise((resolve) => {
        swal({
            title: `\nคุณต้องการลบข้อมูลที่ถูกเลือกทั้งหมด ${rowCount} แถวใช่หรือไม่?`,// new line is a workaround for icon cover text
            type: 'warning',
            dangerMode: true,
            showCancelButton: true,
            closeOnCancel: true,
            cancelButtonText: 'ยกเลิก',
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ยืนยัน',
        }, (value) => {
            resolve(value);
        });
    });
}
