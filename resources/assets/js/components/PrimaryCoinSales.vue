<script>
  export default {
    template: '<canvas ref="chart" width="520" height="260"></canvas>',
       
       props:['keys','values','label','color','type'],
        
  mounted() {
    this.$nextTick(() => {
      let myChart = new Chart(this.$refs.chart, {
        type: this.type,
        data: {
          labels: this.keys,
          datasets: [
            {
              label: this.label,
              fillColor: "rgba(220,220,220,0.2)",
              strokeColor: "rgba(220,220,220,1)",
              pointColor: "rgba(220,220,220,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              backgroundColor:this.color,
              data: this.values
            }
            
          ]
           
        },

     options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
   
      })

    })

  }
       
    }

 
</script>
