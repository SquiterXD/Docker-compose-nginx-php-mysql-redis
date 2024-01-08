export function setAllObjectKeys(obj, val) {
    Object.keys(obj).forEach(function (index) {
        obj[index] = val;
    });
}

export function warningBeforeUnload(callback) {
    if (typeof callback !== 'function') {
        callback = () => callback ? callback : null;
    }

    window.onbeforeunload = function () {
        let res = callback();
        if (!res) return null;
        if (typeof res === 'string') return res;
        return 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?';
    };
}

export function preventUnload(message = 'มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?') {
    if (typeof message !== 'function') {
        message = () => message;
    }
    window.onbeforeunload = message;
}

export function cancelPreventUnload() {
    window.onbeforeunload = null;
}
