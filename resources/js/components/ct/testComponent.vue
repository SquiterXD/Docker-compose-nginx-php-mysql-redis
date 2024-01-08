<template>
    <div class="container">
        component for test api
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: [
                {
                    id: 1, // CostCenterProductGroupID
                    cost_center_id: 1, // CostCenterID
                    product_group_id: 1, // ProductGroupID
                    percen_of_wage: 999,
                    percen_of_cp_vc: 20,
                    percen_of_cp_fe: 888
                },
                {
                    id: 2, // CostCenterProductGroupID
                    cost_center_id: 1, // CostCenterID
                    product_group_id: 1, // ProductGroupID
                    percen_of_wage: 233,
                    percen_of_cp_vc: 44,
                    percen_of_cp_fe: 66
                },
                {
                    id: 5, // CostCenterProductGroupID
                    cost_center_id: 1, // CostCenterID
                    product_group_id: 1, // ProductGroupID
                    percen_of_wage: 333,
                    percen_of_cp_vc: 44,
                    percen_of_cp_fe: 555
                }
            ]
        };
    },

    created: function() {
        // created: Working first
        this.query("/ct/ajax/purchase_price_info/line/2331");
    },
    mounted() {
        console.log("Component mounted.");
    },
    methods: {
        query(url, params = null) {
            // url = "/ct/ajax/system_item"
            // params = { params: { text: query } }

            axios.put(url, { 
                lot_number: "10",
                unit_cost: 99,
                freight_cost: 88,
                material_percent: 77,
            })
                .then(response => {
                    console.log("response: ", response.data);
                })
                .catch(function(error) {
                    console.log("error: ", error);
                });
        }
    }
};
</script>
