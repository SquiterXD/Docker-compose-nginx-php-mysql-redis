<template>
    <tr>
        <th colspan="6" class="text-right font-weight-bold">
            รวมต้นทุน
        </th>
        <th class="text-right font-weight-bold tw-text-base">
            {{ Number(totalUnitCost).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6}) }}
        </th>
        <th></th>
        <th></th>
        <th class="text-right font-weight-bold tw-text-base">
            {{ Number(totalCostAfterPriceAdjus).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6}) }}
        </th>
        <th class="text-right font-weight-bold tw-text-base">
            {{ Number(totalCostPerCgkBaht).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6}) }}
        </th>
    </tr>
</template>

<script>

export default {
    props:[
        "items"
    ],
    data() {
        return {
        }
    },
    mounted() {
        // console.log('Casings: Component mounted.')
    },
    computed: {
        totalUnitCost() {
            let vm = this;
            let total = 0;
            vm.items.forEach((o, i) => {
                if (o.is_deleted == false && o.enable_flag == 'Y') {
                    total = parseFloat(total) + parseFloat(o.unit_cost);
                }
            });
            return parseFloat(total);
        },
        totalCostAfterPriceAdjus() {
            let vm = this;
            let total = 0;
            vm.items.forEach((o, i) => {
                if (o.is_deleted == false && o.enable_flag == 'Y') {
                    total = parseFloat(total) + parseFloat(o.cost_after_price_adjus);
                }
            });
            return parseFloat(total);
        },
        totalCostPerCgkBaht() {
            let vm = this;
            let total = 0;
            vm.items.forEach((o, i) => {
                if (o.is_deleted == false && o.enable_flag == 'Y') {
                    total = parseFloat(total) + parseFloat(o.cost_per_cgk_baht);
                }
            });
            return parseFloat(total);
        }
    },

}
</script>
