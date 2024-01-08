<template>
    <div>
        <button data-toggle="modal" data-target="#myModal5" class="btn btn-outline-primary btn-xs">Export</button>
        <div class="modal inmodal fade" id="myModal5" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Pogram Code</h4>
                    </div>
                    <div class="modal-body">
                        <FormStockYearly>
                        </FormStockYearly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormStockYearly from './FormStockYearly';
export default {
    components:{
        FormStockYearly,
    },

    props:[
        'program-code'
    ],
    data() {
        return {

        };
    },

    mounted(){

    },
};
</script>
