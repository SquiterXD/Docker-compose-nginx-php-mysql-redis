import * as Validator from 'validatorjs';

export function buildValidatingEntry(data, rules, attributeNames) {
    return {
        data: data,
        rules: rules,
        attributeNames: attributeNames,
    };
}

export function validateDataAgainstRules(validatingEntries) {
    let errorMessages = [];
    let status = true;

    validatingEntries.forEach(entry => {
        let validator = new Validator(entry.data, entry.rules, {
            'required':     'คุณจำเป็นต้องใส่ข้อมูลในช่อง:attribute',
            'numeric':      'ข้อมูลในช่อง:attribute ต้องเป็นตัวเลขเท่านั้น',
        });
        validator.setAttributeNames(entry.attributeNames);

        if (validator.fails()) {
            status = false;
            let errors = validator.errors.all();
            Object.keys(errors).forEach(function (index) {
                let errorMessagesForAttribute = errors[index];
                errorMessagesForAttribute.forEach(message => {
                    errorMessages.push(message);
                });
            });
        }
        console.debug('validator =>', validator);
    });

    console.debug('result =>', status, errorMessages);

    if (status) {
        return {
            status: true,
        };
    } else {
        return {
            status: false,
            errorMessages: errorMessages,
        };
    }
}
