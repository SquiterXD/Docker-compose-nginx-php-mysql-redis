export function showProgressConfirm(text = 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก คุณต้องการดำเนินการต่อหรือไม่') {
    return new Promise((resolve) => {
        swal({
            title: `\nคุณแน่ใจไหม?`, // new line is a workaround for icon cover text
            text: text,
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


export function showLoadingDialog() {
    console.debug('helper showLoadingDialog');

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


export function showGenericFailureDialog(errorText = `มีข้อผิดพลาดเกิดขึ้น กรุณาลองใหม่อีกครั้ง\n`, html = false) {
    return new Promise((resolve) => {
        swal({
            title: `\nเกิดข้อผิดพลาด`,// new line is a workaround for icon cover text
            text: errorText,
            type: 'error',
            html: html,
            showConfirmButton: true,
            closeOnConfirm: true,
            confirmButtonText: 'ปิด',
        }, (value) => {
            resolve(value);
        });
    });
}