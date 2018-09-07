<template>
   <div class="">
      <tabs>
      <tab  name="GBP"  >
            <ul class="market-rate" v-for="currency in pair"  v-if="currency.name == 'GBP'" >
               <li v-bind:class="{ active : selectval==marketrate.id }" v-for="marketrate in marketrates.data" v-if="marketrate.to_currency_id == currency.id" @click="passId(marketrate.id)">
                 <a v-bind:href="'/trade/'+marketrate.currencypair">
                  <div class="currency-pair-data">
                     <currency-pair-data>
                        <template slot="star">
                           <div v-if="marketrate.favourite" v-on:click="addfavour(marketrate.id)" class="market-rate-info-section market-rate-info-section-1" ><i class="far fa-star tx-warning fa-overwrite" v-on:click="addfavour(marketrate.id)"></i></div>
                           <div v-else="!marketrate.favourite"  v-on:click="addfavour(marketrate.id)" scope="row" ><i class="far fa-star fa-overwrite" ></i></div>
                        </template>
                        <template slot="coinname">
                           {{ marketrate.fromcurrency.displayname }} 
                        </template>
                        {{ marketrate.currencypair }}
                        <template slot="exchangerate">
                           {{ marketrate.exchangerate | formatNumber }}
                        </template>
                        <template slot="currentprice">
                           {{ marketrate.currentprice }}
                        </template>
                        <template slot="daybefore">
                           {{ marketrate.daybefore  | formatNumber }}
                        </template>
                        <template slot="total_transaction">
                           {{ marketrate.total_transaction |  formatNumber2 }}
                        </template>
                     </currency-pair-data>
                  </div>
                  </a>
               </li>
            </ul>
         </tab>
         
      <tab  name="EUR" >
            <ul class="market-rate" v-for="currency in pair"  v-if="currency.name == 'EUR'" >
               <li v-bind:class="{ active : selectval==marketrate.id }" v-for="marketrate in marketrates.data" v-if="marketrate.to_currency_id == currency.id" @click="passId(marketrate.id)">
                 <a v-bind:href="'/trade/'+marketrate.currencypair">
                  <div class="currency-pair-data">
                     <currency-pair-data>
                        <template slot="star">
                           <div v-if="marketrate.favourite" v-on:click="addfavour(marketrate.id)" class="market-rate-info-section market-rate-info-section-1" ><i class="far fa-star tx-warning fa-overwrite" v-on:click="addfavour(marketrate.id)"></i></div>
                           <div v-else="!marketrate.favourite"  v-on:click="addfavour(marketrate.id)" scope="row" ><i class="far fa-star fa-overwrite" ></i></div>
                        </template>
                        <template slot="coinname">
                          {{ marketrate.fromcurrency.displayname }} 
                        </template>
                        {{ marketrate.currencypair }}
                        <template slot="exchangerate">
                           {{ marketrate.exchangerate | formatNumber2 }}
                        </template>
                        <template slot="currentprice">
                           {{ marketrate.currentprice | formatNumber2 }}
                        </template>
                        <template slot="daybefore">
                           {{ marketrate.daybefore | formatNumber2 }}
                        </template>

                     </currency-pair-data>
                  </div>
                  </a>
               </li>
            </ul>
         </tab>
         <tab  name="USD"  >
            <ul class="market-rate" v-for="currency in pair"  v-if="currency.name == 'USD'" >
               <li v-bind:class="{ active : selectval==marketrate.id }" v-for="marketrate in marketrates.data" v-if="marketrate.to_currency_id == currency.id" @click="passId(marketrate.id)">
                 <a v-bind:href="'/trade/'+marketrate.currencypair">
                  <div class="currency-pair-data">
                     <currency-pair-data>
                        <template slot="star">
                           <div v-if="marketrate.favourite" v-on:click="addfavour(marketrate.id)" class="market-rate-info-section market-rate-info-section-1" ><i class="far fa-star tx-warning fa-overwrite" v-on:click="addfavour(marketrate.id)"></i></div>
                           <div v-else="!marketrate.favourite"  v-on:click="addfavour(marketrate.id)" scope="row" ><i class="far fa-star fa-overwrite" ></i></div>
                        </template>
                        <template slot="coinname">
                           {{ marketrate.fromcurrency.displayname }} 
                        </template>
                        {{ marketrate.currencypair }}
                        <template slot="exchangerate">
                           {{ marketrate.exchangerate | formatNumber }}
                        </template>
                        <template slot="currentprice">
                           {{ marketrate.currentprice }}
                        </template>
                        <template slot="daybefore">
                           {{ marketrate.daybefore | formatNumber }}
                        </template>
                        <template slot="total_transaction">
                           {{ marketrate.total_transaction |  formatNumber2 }}
                        </template>
                     </currency-pair-data>
                  </div>
                  </a>
               </li>
            </ul>
         </tab>
         
         <tab  name="BTC">
            <ul class="market-rate" v-for="currency in pair"  v-if="currency.name == 'BTC'" >
               <li v-bind:class="{ active : selectval==marketrate.id }" v-for="marketrate in marketrates.data" v-if="marketrate.to_currency_id == currency.id" >
                 <a v-bind:href="'/trade/'+marketrate.currencypair">
                  <div class="currency-pair-data">
                     <currency-pair-data>
                        <template slot="star">
                           <div v-if="marketrate.favourite" v-on:click="addfavour(marketrate.id)" class="market-rate-info-section market-rate-info-section-1" ><i class="far fa-star tx-warning fa-overwrite" v-on:click="addfavour(marketrate.id)"></i></div>
                           <div v-else="!marketrate.favourite"  v-on:click="addfavour(marketrate.id)" scope="row" ><i class="far fa-star fa-overwrite" ></i></div>
                        </template>
                        <template slot="coinname">
                           {{ marketrate.fromcurrency.displayname }} 
                        </template>
                        {{ marketrate.currencypair }}
                        <template slot="exchangerate">
                           {{ marketrate.exchangerate | formatNumber }}
                        </template>
                        <template slot="currentprice">
                           {{ marketrate.currentprice }}
                        </template>
                        <template slot="daybefore">
                           {{ marketrate.daybefore  | formatNumber }}
                        </template>
                        <template slot="total_transaction">
                           {{ marketrate.total_transaction |  formatNumber2 }}
                        </template>
                     </currency-pair-data>
                  </div>
                  </a>
               </li>
            </ul>
         </tab>
         
       
      </tabs>
      
   </div>
</template>
<script>
   import { bus } from "../../app";
   import Tabs from "vue-tabs-component";
   Vue.use(Tabs);
   export default {
     data() {
       return {
         selectval: $("#currentpair").val(),
         marketrates: {},
         pair: {},
         selectedfrom: $('#fromtoken').val()
       };
     },
     computed: {},
     created() {
       this.getPairData();
       this.listenForTrade();
   
       bus.$on("dataSelect", data => {
         this.selectval = data;
         //console.log(this.selectval);
       });
     },
     methods: {
       passId(id) {
         console.log("i am hit");
         console.log(id);
         bus.$emit("dataSelected", id);
   
         this.selectval = id;
       },
       getPairData() {
         axios.get("/pair").then(response => (this.pair = response.data));
         axios
           .get("/pairmarketrate")
           .then(response => (this.marketrates = response.data));
       },
       addfavour: function(id) {
         axios
           .post("/favourite", {
             body: {
               pair: id
             }
           })
           .then(response => {
             this.marketrates = [];
             this.getPairData();
           });
       },
       listenForTrade() {
         window.Echo.channel("trade").listen("TradeAddEvent", data => {
           this.getPairData();
         });
       }
     }
   };
</script>
<style scoped>
  a{
    text-decoration: none !important;
    color: #000;
  }
   .tx-warning {
   color: #ee8102;
   }
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
   
   ul.market-rate > li {
   cursor: pointer;
   }
   ul.market-rate > li:hover {
   background-color: #f2f2f2;
   }
   ul.market-rate > li.active {
   background-color: #f2f2f2;
   }
</style>