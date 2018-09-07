<template>

  <div class="">
    <tabs>
         <tab name="Conculsion">
            <div class="p-20">
              <table class="table table-striped">
      <thead>
        <th>{{this.trans.time}}</th>
        <th>{{this.trans.price}}({{this.from_currency}})</th>
        <th class="text-right">{{this.trans.fastening}}({{this.to_currency}})</th>
        <th class="text-right">{{this.trans.contractamount}}({{this.from_currency}})</th>
      </thead>
      <tbody>
        <tr v-for="buy in sellbuyorders">
          <td>{{buy.updated_at}}</td>
          <td >{{buy.amount}}</td>
          <td class="text-right">
                    <div style="color:red;" v-if="buy.type=='buy'" >{{buy.quantity}}</div>
                    <div style="color:blue;" v-else>{{buy.quantity}} </div>
          </td>
           <td class="text-right">{{buy.total_amount.toFixed(2)}}</td>
        </tr>
      </tbody>
    </table>
            </div>   
        </tab>
        <tab name="Glance">
           <div class="p-20">
          <table class="table table-striped">
      <thead>
        <th>{{this.trans.date}}</th>
        <th>{{this.trans.closeprice}}({{this.from_currency}})</th>
        <th class="text-right">{{this.trans.daybefore}}</th>
        <th class="text-right">{{this.trans.volume}}({{this.to_currency}})</th>
      </thead>
      <tbody>
        <tr v-for="order in glanceorders"  >
          <td>{{order.updated_at}}</td>
          <td>{{order.amount}}</td>
          <td class="text-right">{{order.diff_per.toFixed(2)}}%</td>
           <td class="text-right">{{order.quantity}}</td>
        </tr>
      </tbody>
    </table>
            </div>   
        </tab>
       <tab name="Coin Information">
             <div class="p-20" v-html="curinfor.coininfor">
               
              </div>   
        </tab>
         
    </tabs>
</div>

</template>

<script>
  import {bus} from '../app';
  import Tabs from 'vue-tabs-component';
  Vue.use(Tabs);
   export default {
    data(){
        return {
           selectval:$("#currentpair").val(),
          curinfor : [],
            buyorders:[ ],
              sellorders:[ ],
              sellbuyorders:[],
              orders:[ ],
              transorders:[ ],
              buy_total_quantity:0,
              sell_total_quantity:0,
              buy_total_amount:0,
              sell_total_amount:0,              
              from_currency:'',
              to_currency:'',
              selected:$("#currentpair").val(),
              trans:[],
              glanceorders:[],
              conculsion:'',
              glance:'',
              coininfor:'',
            
        }
    },
    computed: {
         
      },
    created() {

             this.getTrans();
              //Select Currency Dropdown
               bus.$on('dataSelect', (data) => {
                this.selected = data;
                console.log('Listen Trade Orders');
                console.log(data);
                this.getTrans();
                 this.CurInfor(this.selectval);
                this.getData();
              
                                
              });
               //Currency Pair
                  bus.$on('dataSelected', (data) => {
                this.selected = data;
                console.log('Listen Trade Orders');
                console.log(data);
                this.getTrans();
                this.getData();
              
                                
              });

                this.getData();
                this.listenForTrade();

        axios.get('/curinfor/'+this.selected) 
              .then(response =>this.curinfor = response.data);

    },
     methods:{
      getData()
            {
            axios.get('/tradedetails/'+ this.selected).then(response =>{
                       this.sellbuyorders=response.data['sellbuyorders'];
                        this.glanceorders=response.data['glanceorders'];
                       
                        this.from_currency=response.data['to_currency_token'];
                        this.to_currency=response.data['from_currency_token'];
         
                });
            },
         
             listenForTrade() {
                
                window.Echo.channel('trade')
                    .listen('TradeAddEvent',(data) => {
    

                         this.getData();


                    });
              },
      CurInfor(id)  {
         axios.get('/curinfor/'+this.selected) 
              .then(response =>this.curinfor = response.data);

      },
      getTrans(){
      axios.get('/translations')
                        .then(response =>{
                          this.trans = response.data;
                          this.conculsion=this.trans.conculsion;
                          this.glance=this.trans.glance;
                          this.coininfor=this.trans.coininfor;
                          
                        });
                      },
    }
           
    }
</script>
<style type="text/css">
  
  ul.market-rate {
      padding: 0;
      margin: 0;
  }
  ul.market-rate li {
      padding: 0;
      margin: 0;
      list-style: none;
      padding: 10px;
      border-bottom: 1px solid #e2e2e2;
  }
    ul.market-rate li:last-child {
      border-bottom: 0px;
  }
  

</style>
