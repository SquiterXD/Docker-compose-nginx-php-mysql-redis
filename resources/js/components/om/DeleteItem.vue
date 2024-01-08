<template>
    <div>
        <button type="submit" @click="deleteItem()" class="btn btn-danger btn-xs">
            <i class="fa fa-times"></i>
            ลบ
        </button>
    </div>
</template>

<script>
    export default {
        props:[
            "url",
            "url-return"
            ],
        data(){
            return {

            }
        },

        methods:{
            deleteItem(){
                if(confirm("Do you really want to delete?")){
                    console.log(this.url);
                    axios
                    .delete(this.url)
                    .then(res => {
                        alert('deleted');
                    })
                    .then(res => {
                        window.location.href = this.urlReturn;
                    })
                    .catch(error => {
                        alert(error);
                        // console.log(error.message);
                        // alert('error');
                    });
                }
            }
        },
    }
</script>

<style>

</style>
