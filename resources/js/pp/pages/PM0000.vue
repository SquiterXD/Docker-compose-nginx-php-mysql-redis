<template>
    <div>
        PP-0000 Example
    </div>
</template>
<script>

import {warningBeforeUnload} from "../helpers";
import {
    showProgressWithUnsavedChangesWarningDialog,
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
} from "../../commonDialogs";
import {instance as http} from "../httpClient";
import {$route} from "../../router";
import _cloneDeep from 'lodash/cloneDeep';
import _isEqual from 'lodash/isEqual';
import _get from "lodash/get";
//import Swal from "sweetalert2";

function getJobOptRelations(batchId, organizationId) {
    return http.get($route('api.pm.close-product-order.job-opt-relations'), {
        params: {
            batchId, organizationId
        }
    })
}


export default {
    created() {
    },
    mounted() {
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },

            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {
        user: {type: Object, default: {}},
    },
    methods: {
    },
}
</script>
