<script>
  export default {
    template: `
       <div>
        <div>
          <label>Currency</label>
            <select v-model="currency_id" @change="reload" >
              <option v-for = "cur in currency" v-bind:value="cur.id">{{ cur.token }}</option>
            </select>
        </div>
          <canvas ref="chart" width="520" height="260"></canvas>
      </div>`,
      props:['keys','values','label','color','type','currency','currency_id'],
        
          data()
          {
            return 
            {
              currency:this.currency
              currency_id:this.currency_id
              values:[]
              myChart:''
              label:''
             
            }
          },

          methods:
          {
            reload()
            {
           this.label='';
              this.myChart.destroy();

              axios.get('/admin/getcurrencytoken/'+this.currency_id).then(response =>{
              this.label=response.data;
                 });

              axios.get('/admin/getcurrency/'+this.currency_id).then(response =>{
                this.render(response.data,this.label);

                //console.log(response);
               });


            },

            render(data,label)
            {
              this.$nextTick(() => {
                this.myChart = new Chart(this.$refs.chart, {
                  type: this.type,
                    data: {
                      labels: this.keys,
                        datasets: [
                        {
                          label: label,
                          fillColor: "rgba(220,220,220,0.2)",
                          strokeColor: "rgba(220,220,220,1)",
                          pointColor: "rgba(220,220,220,1)",
                          pointStrokeColor: "#fff",
                          pointHighlightFill: "#fff",
                          pointHighlightStroke: "rgba(220,220,220,1)",
                          backgroundColor:'pink',
                          data: data
                        },
                      ]
                  },
            
           options: {
              scales: {
                  yAxes: [{
                  //stacked: true,
                    //type: 'logarithmic',
                      ticks: {
                          beginAtZero:true,
                          //min: 0,
                  //stepSize: 0.1,

                      }
                    }]
                  }
                }
              })
 })
            },
          },

  mounted() {

      this.render(this.values,this.label);
           
          }
        }
</script>
