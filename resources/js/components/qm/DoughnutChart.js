import { Doughnut, mixins } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";

export default {
  extends: Doughnut,
  plugins: [ChartDataLabels],
  props: {
    chartData: { type: Object, required: true, default: () => null },
    options: { type: Object, required: false, default: () => null },
  },
  mounted() {
    // this.chartData is created in the mixin.
    // If you want to pass options please create a local options object
    this.renderChart(this.chartData, this.options);
  }
};
