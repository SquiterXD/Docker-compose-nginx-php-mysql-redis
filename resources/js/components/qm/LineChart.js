import { Line, mixins } from "vue-chartjs";
const { reactiveProp } = mixins;
import ChartDataLabels from "chartjs-plugin-datalabels";

export default {
    extends: Line,
    mixins: [reactiveProp],
    plugins: [ChartDataLabels],
    props: ["options", "showDataLabel", "minLineColor", "maxLineColor", "minLineAt", "maxLineAt", "yAxesTickMin", "yAxesTickMax"],

    mounted() {

      let yAxesTickMinValue = this.yAxesTickMin < this.minLineAt ? this.yAxesTickMin : this.minLineAt;
      let yAxesTickMaxValue = this.yAxesTickMax > this.maxLineAt ? this.yAxesTickMax : this.maxLineAt;
      yAxesTickMinValue = parseFloat((yAxesTickMinValue * 100 / 100).toFixed(2));
      yAxesTickMaxValue = parseFloat((yAxesTickMaxValue * 100 / 100).toFixed(2));

      const maxLineColorValue = this.maxLineColor ? this.maxLineColor : "#05c46b";
      const minLineColorValue = this.minLineColor ? this.minLineColor : "#ff5e57";
      const showDataLabelValue = this.showDataLabel ? this.showDataLabel : false;
      
      this.addPlugin({
        id: "horizontalLine",
        afterDraw: function(chart) {

          if (typeof chart.config.options.maxLineAt != "undefined") {

            var maxLineAt = chart.config.options.maxLineAt;
            var ctxPlugin = chart.chart.ctx;
            var xAxe = chart.scales[chart.config.options.scales.xAxes[0].id];
            var yAxe = chart.scales[chart.config.options.scales.yAxes[0].id];

            // ctxPlugin.strokeStyle = "#05c46b";
            ctxPlugin.strokeStyle = maxLineColorValue;
            ctxPlugin.beginPath();

            const maxLineAtPx = yAxe.getPixelForValue(maxLineAt);

            ctxPlugin.moveTo(xAxe.left, maxLineAtPx);
            ctxPlugin.lineTo(xAxe.right, maxLineAtPx);
            ctxPlugin.stroke();

          }

          if (typeof chart.config.options.minLineAt != "undefined") {

            var minLineAt = chart.config.options.minLineAt;
            var ctxPlugin = chart.chart.ctx;
            var xAxe = chart.scales[chart.config.options.scales.xAxes[0].id];
            var yAxe = chart.scales[chart.config.options.scales.yAxes[0].id];

            // ctxPlugin.strokeStyle = "#ff5e57";
            ctxPlugin.strokeStyle = minLineColorValue;
            ctxPlugin.beginPath();

            const minLineAtPx = yAxe.getPixelForValue(minLineAt);

            ctxPlugin.moveTo(xAxe.left, minLineAtPx);
            ctxPlugin.lineTo(xAxe.right, minLineAtPx);
            ctxPlugin.stroke();

          }

        }

      });

      // this.chartData is created in the mixin.
      // If you want to pass options please create a local options object
      this.renderChart(this.chartData, {
        plugins: {
          datalabels: {
              color: "black",
              display: showDataLabelValue,
              formatter: (value, ctx) => {
                  return value;
              },
              font: { weight: "bold", size: "10" },
              anchor: 'end',
              align: 'end',
              labels: {
                  value: {
                      color: 'black'
                  }
              }
          }
        },
        layout: {
          padding: {
              left: 25,
              right: 25,
              top: 5,
              bottom: 5
          }
        },
        maintainAspectRatio: true,
        gridLines: {
          display: false
        },
        minLineAt: this.minLineAt,
        maxLineAt: this.maxLineAt,
        scales: {
          yAxes: [{
            gridLines: {
              color: "rgba(150, 150, 150, 0.1)",
            },
            ticks: {
              // min: 0,
              min: yAxesTickMinValue ? yAxesTickMinValue : 0,
              max: yAxesTickMaxValue ? yAxesTickMaxValue : 100,
            }
          }],
          xAxes: [{
            gridLines: {
              display: false
            }
          }]
        }
      });
    }
};
