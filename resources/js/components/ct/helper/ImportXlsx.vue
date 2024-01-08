<template>
    <div>
        <input
            type="file"
            id="myfile"
            name="myfile"
            ref="file"
            @change="handleFileUpload()"
        />
    </div>
</template>
<script>
import XLSX from "xlsx";
export default {
    mounted() {
        this.textXlsx();
    },
    methods: {
        textXlsx() {},
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
            const file_extension = this.file.name?.split(".").pop();
            console.log(this.file.name?.split(".").pop());
            if (file_extension == "csv" || file_extension == "xlsx") {
                var reader = new FileReader();
                reader.onload = function() {
                    var fileData = reader.result;
                    var wb = XLSX.read(fileData, { type: "binary" });

                    wb.SheetNames.forEach(function(sheetName) {
                        var rowObj = XLSX.utils.sheet_to_row_object_array(
                            wb.Sheets[sheetName]
                        );
                        var jsonObj = JSON.stringify(rowObj);
                        console.log(JSON.parse(jsonObj));
                    });
                };
                reader.readAsBinaryString(this.file);
            } else {
                this.$refs.file.value = "";
                alert("อัพโหลดไม่ได้");
            }
        }
    }
};
</script>
