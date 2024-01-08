<template>
    <div>
        <!-- Default to 24-Hour format HH:mm -->
        <vue-timepicker
            :format="format ? format : 'HH:mm'"
            v-model="timeValue"
            @change="valueWasChanged"
            @close="inputWasClosed"
            :hide-clear-button="clearable !== false ? false : true"
            manual-input
        ></vue-timepicker>
        <input
            type="hidden"
            v-model="timeValue"
            :name="name"
            :id="id ? id : null"
        />
    </div>
</template>

<script>
import VueTimepicker from "vue2-timepicker/src/vue-timepicker.vue";
import moment from "moment";

export default {
    props: ["name", "id", "format", "value", "clearable"],

    components: {
        VueTimepicker
    },

    watch: {
        value: function (v) {
            this.timeValue = v;
        },
    },

    data() {
        return {
            timeValue: this.value ? this.value : ""
        };
    },

    methods: {
        valueWasChanged(value) {
            this.$emit("change", value.displayTime);
        },
        inputWasClosed(value) {
            this.$emit("close", value.displayTime);
        },
    }
};
</script>
