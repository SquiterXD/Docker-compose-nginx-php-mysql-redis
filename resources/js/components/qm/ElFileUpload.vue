<template>
    <el-upload
        class="upload-demo"
        ref="upload"
        :id="id"
        :name="name"
        action=""
        :on-change="handleUploadChange"
        :before-upload="handleBeforeUpload"
        accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
        :file-list="fileList"
        :auto-upload="false"
        :limit="1"
    >
        <el-button slot="trigger" size="medium" type="success">
            <i class="fa fa fa-file-excel-o tw-mr-1"></i> Choose file
        </el-button>
        <el-button type="primary" size="medium" @click="submitUpload">
            <i class="fa fa-upload tw-mr-1"></i> Upload ผลการทดสอบ
        </el-button>
        <div class="el-upload__tip" slot="tip">
            .xlxs file with a size less than xxxx mb
        </div>
    </el-upload>
</template>

<script>

export default {

    props: ["id", "name", "action"],

    data() {
        return {
            fileList: []
        };
    },

    methods: {
        submitUpload() {
            // this.$refs.upload.submit();
            const formData = new FormData();
            formData.append("file", this.fileList[0].raw);
            axios
                .post(this.action, formData)
                .then(() => {
                    alert("upload success")
                })
                .catch(() => {
                    alert("upload error");
                });
        },
        handleUploadChange(file, fileList) {
            this.fileList = fileList.slice(-1);
        },
        handleBeforeUpload(file) {
            const allowedExcelMime = [
                "text/csv",
                "text/plain",
                "application/csv",
                "text/comma-separated-values",
                "application/excel",
                "application/vnd.ms-excel",
                "application/vnd.msexcel",
                "text/anytext",
                "application/octet-stream",
                "application/txt"
            ];
            if (allowedExcelMime.includes(file.type)) {
                return true;
            } else {
                this.$message.error(
                    "You can only upload Excel files. No other file types are allowed"
                );
                this.fileList.pop(file);
            }
        }
    }
};
</script>
