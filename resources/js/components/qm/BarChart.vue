<script>
import Chart from "chart.js";
import { Bar, mixins } from "vue-chartjs";
import ChartDataLabels from "chartjs-plugin-datalabels";
// import chartjsPluginAnnotation from "chartjs-plugin-annotation";

// const { reactiveProp } = mixins;

export default {
  name: "BarChart",
  extends: Bar,
  // mixins: [reactiveProp],
  plugins: [ChartDataLabels],
  props: {
    chartData: { type: Object, required: true, default: () => null },
    options: { type: Object, required: false, default: () => null },
  },
  mounted() {
    // this.addPlugin([chartjsPluginAnnotation]);
    this.renderChart(this.chartData, this.options);
    console.log(Chart.defaults);
    // console.log(
    // Chart.defaults.global.plugins.datalabels.display
  },
};
</script>

<style scoped></style>