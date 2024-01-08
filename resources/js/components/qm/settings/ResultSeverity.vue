<template>
    <div>
        <table class="table">
            <thead>
                <th class="text-center">ลำดับที่</th>
                <th class="text-center">ระดับความรุนแรง</th>
                <th class="text-center">รายละเอียด ระดับความรุนแรง</th>
                <th class="text-center">วิธีการป้องกันและกำจัดมอดยาสูบ</th>
            </thead>
            <tbody>
                <tr v-for="(row, index) in lines"  :key="index" :row="row">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td>{{ row.meaning }}</td>
                    <td>{{ row.description }}</td>
                    <td>
                        <el-input :name="'attribute10['+row.id+']'" v-model="row.attribute10"></el-input>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ['lookups'],

    data() {
        return {
            // attribute10: 
            lines: [],
        }
    },
    mounted() {
        this.lookups.forEach(line => {
            this.lines.push({
                id            : line.lookup_code,
                meaning       : line.meaning,
                description   : line.description,
                attribute10   : line.attribute10,
            }); 
        });
    }
}
</script>