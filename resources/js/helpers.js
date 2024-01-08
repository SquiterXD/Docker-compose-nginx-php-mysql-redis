
import moment from "moment";
export async function convertDate(value, format = 'DD/MM/YYYY') {
    return value ? moment(value, format).toDate() : null;
}

export async function parseToDateTh(value = null, format = 'DD/MM/YYYY') {
    if (value == null) {
        return moment().add(543, 'years').toDate();
    }
    // console.log('parseToDateTh value:'+ value);
    return moment(value, format).add(543, 'years').toDate();
}

export async function parseToDateThFormat(value, format = 'DD/MM/YYYY') {
    return moment(value).format(format);
}