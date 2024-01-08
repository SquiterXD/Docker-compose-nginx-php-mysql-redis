<template>
    <div>
        <button type="button" class="btn btn-success btn-md tw-w-25" @click="clickFetch()">
            <i :class="btnTrans.pull.icon"></i> {{ btnTrans.pull.text }}
        </button>
    </div>
</template>
<script>
export default {
    props: ['btnTrans'],
    methods: {
        clickFetch(){
            console.log('clickFetch clickFetch');
            // axios.get(`/ir/settings/vehicle/get_fa_location`)
            // .then(({data}) => {
            //     console.log(data);
            //     if(data.status === 'S'){
            //         swal({
            //             title: "Success",
            //             text: 'ดึงข้อมูลสำเร็จ',
            //             type: "success",
            //             showCancelButton: false,
            //             showConfirmButton: true
            //         }, function(confirm){
            //             if(confirm){
            //                 window.location.href = '/ir/settings/vehicle';
            //             }
            //         });
            //     }else {
            //         swal("Error", data.msg, "error");
            //     }
            // })
            // .catch((error) => {
            //     swal("Error", error, "error");
            // });
        }
    },
}
</script>