<template>
    <div>
        <a :href="this.urlEdit" type="button" class="btn btn-warning btn-xs"> <i class="fa fa-edit m-r-xs"></i> แก้ไข </a>

        <form :id="this.formID" :action="urlDelete" method="post" @submit.prevent="checkForm" onkeydown="return event.key != 'Enter';">
            <input type="hidden" name="_token" :value="csrf">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" :name="this.dataName" :value="this.lookup_code">
            <input type="hidden" name="lookup_test[]" :value="this.lookup_test">
            
            <button class="btn btn-danger btn-xs" type="submit"> <i class="fa fa-times"></i> ลบ </button>
        </form>
    </div>
</template>
<script>
export default {
    props: ['urlEdit', 'urlDelete', 'LookupCode', 'dataName'],

    data(){
        return {
            lookup_code: this.LookupCode,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            lookup_test: [],
            formID: '',
        }
    },
    mounted(){
        this.formID = 'deleteForm'+this.name;
    },
    methods: {
        async checkForm (e) {
            console.log('func checkForm <--> ' + this.lookup_code);
            var form  = $('#deleteForm'+this.name);
            var vm = this;
            
            swal({
                title: "Warning",
                text: "ต้องการลบข้อมูลหรือไม่?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false
            },
            function(isConfirm) {
                vm.lookup_test.push(vm.lookup_code);
                if (isConfirm) {
                    console.log(vm.urlDelete);
                    // console.log('urlDelete');
                    form.submit();
                } else {
                    console.log('xxx');
                    console.log(vm.urlDelete);
                    // e.preventDefault();
                }
            });

            // e.preventDefault();
        },
    }
}
</script>