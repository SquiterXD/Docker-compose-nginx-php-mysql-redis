<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.detail.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.detail.icon"></i>
            {{ btnText ? btnText : btnTrans.detail.text }}
        </button>

        <div class="modal inmodal fade" :id="'modal-' + modalId" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">{{ modalTitle }}</h4>
                        <small class="font-bold">
                            &nbsp;
                        </small>
                    </div>
                    <div class="modal-body text-left">
                        <div class="ibox-content" v-html="html"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    export default {
        props:['modalId', 'modalTitle', 'html', "btnTrans", 'btnText'],
        data() {
            return {
                loading: false,
            }
        },
        mounted() {
        },
        computed: {
        },
        watch:{

        },
        methods: {
            openModal() {
                $('#modal-' + this.modalId).modal('show');
            },
        }
    }
</script>