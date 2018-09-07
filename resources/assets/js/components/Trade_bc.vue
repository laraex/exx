<template>

<tabs>
<div class="grid mb-50">
        <tab name="Trade Buy">
              <div class="grid-box">
                            <h2 class="text-left content-title">Trade Buy{{this.selected}}</h2>
                             <div class="" style="justify-content:space-between">
                             <p>Total Volume :&nbsp;{{this.buy_total_quantity}} {{this.from_currency}}</p>
                             <p>Total Amount :&nbsp;{{this.buy_total_amount}} {{this.to_currency}} </p>
                            </div>
                               <table class="table table-striped">
                                    <thead>
                                        <th>Volume</th>
                                        <th class="text-right">Price Per </th>
                                    
                                               
                                    </thead>
                                    <tbody>
                                       <tr v-for="buy in buyorders"  >
                                         <td>{{buy.quantity}}</td>
                                         <td class="text-right">{{buy.amount}}</td>
                                        
                                       </tr>
                                   
                                    </tbody>
                                </table>
     
                </div>
                </tab>
                <tab name="Trade Sell">
               <div class="grid-box">

                      <h2 class="text-left content-title">Trade Sell</h2>
                          <div class="flex m-flex" style="justify-content:space-between">
                             <p>Total Volume :&nbsp;{{this.sell_total_quantity}}  {{this.from_currency}} </p>
                             <p>Total Amount :&nbsp;{{this.sell_total_amount}} {{this.to_currency}}</p>
                            </div>
                               <table class="table table-striped">
                                    <thead>
                                        <th>Volume</th>
                                        <th class="text-right">Price Per </th>
                                    
                                               
                                    </thead>
                                    <tbody>
                                       <tr v-for="sell in sellorders"  >
                                         <td>{{sell.quantity}}</td>
                                         <td class="text-right">{{sell.amount}}</td>
                                        
                                       </tr>
                                   
                                    </tbody>
                                </table>

               </div>
               </tab>
               <tab name="Trade Order">
                <div class="grid-box">

                      <h2 class="text-left content-title">Trade Order</h2>
                            <div class="flex m-flex" style="justify-content:space-between">
                             <p>24H Volume :</p>
                            </div>
                               <table class="table table-striped">
                                    <thead>
                                        <th>Date</th>
                                        <th>Volume</th>
                                        <th class="text-right">Price Per </th>
                                    
                                               
                                    </thead>
                                    <tbody>
                                       <tr v-for="order in orders"  >
                                         <td>{{order.created_at}}</td>
                                         <td>{{order.quantity}}</td>
                                         <td class="text-right">{{order.amount}}</td>
                                        
                                       </tr>
                                   
                                    </tbody>
                                </table>
               </div>
               </tab>


</div>

</tabs>

</template>

<script>
    export default {
        props:['selectedpair'], 
    data(){

        return {
            buyorders:[ ],
            sellorders:[ ],
            orders:[ ],
            buy_total_quantity:0,
            sell_total_quantity:0,
            buy_total_amount:0,
            sell_total_amount:0,
            currency_token:[],
            from_currency:'',
            to_currency:'',
          
           
        }
    },
  
     methods:{

            getData()
            {

                 axios.get('/trade/gettrade/1').then(response =>{
                        this.buyorders=response.data['buyorders'];
                        this.sellorders=response.data['sellorders'];
                        this.orders=response.data['orders'];
                        this.buy_total_quantity=response.data['buy_total_quantity'];
                        this.sell_total_quantity=response.data['sell_total_quantity'];
                        this.buy_total_amount=response.data['buy_total_amount'];
                        this.sell_total_amount=response.data['sell_total_amount'];
                        this.from_currency=response.data['to_currency_token'];
                        this.to_currency=response.data['from_currency_token'];
         
                });
            },

            listenForTrade() {
 
                window.Echo.channel('trade')
                    .listen('TradeEvent',(data) => {
    

                         this.getData();


                    });
              },

        },

    created() {
                this.getData();
                this.listenForTrade();
                
            },

    
       
    }

 
</script>
<style>
.grid-trade {
  grid-template-columns: auto;
}
.grid-box {
    padding: 10px;
}
.trade li{
  list-style:none;
  float: left;
  display: block;
  width: 100px;
  height: 40px;
}

ul.trade {
    display: flex;
    justify-content: space-evenly;
}

ul.trade_title {
    display: flex;
    justify-content: space-evenly;
}
.currency
{
  width:20%;
}

</style>