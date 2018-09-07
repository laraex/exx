<template>
   <div class="grid mb-50" style="min-width:305px;">
      <tabs>
         <tab name="Order Book">
            <div class="grid-box">
               <div class="box_orderbook" style="display: block;">
                  <ul class="orderbook_sum_wrap">

                     <li class="orderbook_txt">{{this.trans.sell}}</li>
                     <li class="orderbook_pr">{{this.trans.totalremain}} ({{this.trans.sell}}) | <span data-verification="ORDER_INFO_TXT_TOTALSELL">{{sell_total_quantity | formatNumber2}}</span></li>
                  </ul>
                  <div class="" style="position: relative; overflow: scroll; width: auto; height: 475px;">
                     <div id="scroll_wrap" style="overflow: scroll; width: auto; height: 475px;">
                        <table class="g_table_list4">
                           <colgroup>
                              <col width="140">
                              <col width="140">
                              <col width="140">
                           </colgroup>
                           <tbody>
                              <tr>
                                 <td colspan="2">
                                    <div class="orderbook_wrap" >
                                       <table class="orderbook" id="marketStatTableSell" data-verification="ORDER_INFO_TABLE_SELL">
                                          <tbody>
                                             <tr v-for="sell in sellorderreverse" class="sell" >
                                                <td class="td_bar">
                                                   <span class="per_bar" v-bind:style="{width : sell.quantity * 100 / sell_total_quantity +'%'} "></span>
                                                   <p>{{sell.quantity}}</p>
                                                </td>
                                                <td class="sell_box buying">
                                                   <p>{{sell.amount | formatNumber}}</p>
                                                   <p class="percent">{{(sell.amount - lasttrade) * 100 / lasttrade | formatNumber2}}%&nbsp;</p>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </td>
                                 <td class="btc_info">
                                    <div class="bi_list bi_lb_tit">
                                       <p class="tit">{{this.trans.volume24h}}</p>
                                    </div>
                                    <div class="bi_list bi_lb_row">
                                       <p>
                                          <span id="24HUnitsTraded">{{ tradestats.hourvolume }}</span> <span class="t_unit" data-cointx="type">{{from_currency}}</span>
                                       </p>
                                    </div>
                                    <div class="bi_list bi_lb_tit">
                                       <p class="tit">{{this.trans.amount24h}}</p>
                                    </div>
                                    <div class="bi_list bi_lb_row">
                                       <p>
                                          <span id="24HPriceTraded" class="t_sum">{{ tradestats.houramount | formatNumber }} </span>
                                       </p>
                                    </div>
                                    <div class="bi_list bi_div bi_fdiv">
                                       <div class="tit">{{this.trans.high}}</div>
                                       <div id="cont24HMax"><span class="">{{ tradestats.max_order | formatNumber }} </span></div>
                                       <!-- <div id="cont24HMaxPer"><span class="max">+1.61%</span></div> -->
                                    </div>
                                    <div class="bi_list bi_div">
                                       <div class="tit">{{this.trans.low}}</div>
                                       <div id="cont24HMin"><span class="">{{ tradestats.min_order | formatNumber }}</span></div>
                                       <!-- <div id="cont24HMinPer"><span class="min">-0.54%</span></div> -->
                                    </div>
                                   
                                 </td>
                              </tr>
                              <tr>
                                 <td class="trade_tbl">
                                    <div class="title">
                                       <p class="lastTrad">{{this.trans.lasttradeprice}}</p>
                                       <p>{{this.trans.qty}}</p>
                                    </div>
                                    <div id="contracts">
                                       <div v-for="sellbuy in sellbuyorders" class="bi_list down  " v-if="sellbuy.type=='buy'">
                                          <p class="t_num">{{sellbuy.amount | formatNumber2}}</p>
                                          <p class="t_per">{{sellbuy.quantity}}</p>
                                       </div>
                                       <div class="bi_list up" v-for="sellbuy in sellbuyorders" v-if="sellbuy.type=='sell'" ><p class="t_num">{{sellbuy.amount | formatNumber2}}</p><p class="t_per">{{sellbuy.quantity}}</p></div>
                                      
                                    </div>
                                 </td>
                                 <td colspan="2">
                                    <div class="orderbook_wrap" >
                                       <table class="orderbook" id="marketStatTableBuying" data-verification="ORDER_INFO_TABLE_BUYING">
                                          <tbody>
                                             <tr v-for="buy in buyordersreverse" class="buying" >
                                                <td class="sell_box buying" >
                                                   <p>{{buy.amount}}</p>
                                                   <p class="percent">{{(buy.amount -lasttrade  ) * 100 / lasttrade | formatNumber2 }}%&nbsp;</p>
                                                </td>
                                                <td class="td_bar" >
                                                   <span class="per_bar" v-bind:style="{width : buy.quantity * 100 / buy_total_quantity +'%'} " ></span>
                                                   <p>{{buy.quantity  }}</p>
                                                </td>
                                             </tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                    
                  </div>
                 
               </div>
               <ul class="orderbook_sum_wrap">
                  <li class="orderbook_txt">Buy</li>
                  <li class="orderbook_pr">{{this.trans.totalremain}} ({{this.trans.buy}}) | <span data-verification="ORDER_INFO_TXT_TOTALBUYING">{{buy_total_quantity | formatNumber}}</span></li>
               </ul>
               <!-- <p class="text_point">* The digits after the fourth decimal place are displayed as 0.</p> -->
            </div>
   </tab>
   <tab name="Trends">
   <div class="grid-box p-10">
   <h2 class="text-left content-title">{{this.trans.trade_sell_title}}</h2>
   <div class="flex m-flex" style="justify-content:space-between">
   <p>{{this.trans.totalvol}} :&nbsp;{{this.sell_total_quantity | formatNumber}}  {{this.to_currency}} </p>
   <p>{{this.trans.totalamt}} :&nbsp;{{this.sell_total_amount | formatNumber}} {{this.from_currency}}</p>
   </div>
   <table class="table table-striped">
   <thead>
   <th>{{this.trans.volume}}</th>
   <th class="text-right">{{this.trans.price_per}} </th>
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
   <tab name="Last 24 H">
   <div class="grid-box p-10">
   <h2 class="text-left content-title">{{this.trans.tradeorder}}</h2>
   <div class="flex m-flex" style="justify-content:space-between">
   <p>{{this.trans.h24_volume}} :</p>
   </div>
   <table class="table table-striped">
   <thead>
   <th>{{this.trans.date}}</th>
   <th>{{this.trans.volume}}</th>
   <th class="text-right">{{this.trans.price_per}} </th>
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
      buyorders: [],
      sellorders: [],
      orders: [],
      transorders: [],
      buy_total_quantity: 0,
      sell_total_quantity: 0,
      buy_total_amount: 0,
      sell_total_amount: 0,
      from_currency: "",
      to_currency: "",
      selected: $("#currentpair").val(),
      trans: [],
      sellbuyorders: [],
      lasttrade: 0,
      tradestats: [],
    };
  },

  created() {
    axios.get("/translations").then(response => (this.trans = response.data));
    //Select Currency Dropdown
    bus.$on("dataSelect", data => {
      this.selected = data;
      console.log("Listen Trade Orders");
      console.log(data);
      this.getData();
    });
    //Currency Pair
    bus.$on("dataSelected", data => {
      this.selected = data;
      console.log("Listen Trade Orders");
      console.log(data);
      this.getData();
    });

    this.getData();
    this.listenForTrade();
  },

  methods: {
    //Get Orders
    getData() {
      //alert("KK");
      axios.get("/trade/gettrade/" + this.selected).then(response => {
        this.buyorders = response.data["buyorders"];
        this.sellorders = response.data["sellorders"];
        this.orders = response.data["orders"];
        this.transorders = response.data["transorders"];
        this.buy_total_quantity = response.data["buy_total_quantity"];
        this.sell_total_quantity = response.data["sell_total_quantity"];
        this.buy_total_amount = response.data["buy_total_amount"];
        this.sell_total_amount = response.data["sell_total_amount"];
        this.from_currency = response.data["to_currency_token"];
        this.to_currency = response.data["from_currency_token"];
        this.sellbuyorders = response.data["completedorders"];
      });
      axios.get("/getorder/" + this.selected).then(response => {
        this.lasttrade = response.data["last_order_amt"];
      });
      axios
        .get("/trade/tradestats/" + this.selected)
        .then(response => (this.tradestats = response.data));
    },

    listenForTrade() {
      window.Echo.channel("trade").listen("TradeAddEvent", data => {
        this.getData();
      });
    }
  },
  computed: { 
    sellorderreverse: function() {
        return this.sellorders.reverse();
    },
    buyordersreverse: function() {
        return this.buyorders.reverse();
    }
  }

};
</script>
<style scoped>
.grid-box {
  padding: 10px;
}
.sparkline {
  border: 1px solid #ccc;
  margin-top: 8px;
  margin-left: 8px;
}
.pair-select {
  padding: 10px;
  margin: 10px;
}
.pair-price {
  margin: 0;
}
.pair-token {
  font-size: 14px;
  color: #ccc;
}
.currency-thumb-image {
  width: 50px;
  height: auto;
  margin-right: 8px;
  margin-top: 8px;
}
.table-pricing {
  margin-top: 0;
  margin-bottom: 0;
}
.table-pricing tr td {
  padding: 5px;
  margin: 0;
  border-top: 0;
  border-bottom: 1px solid #ececec;
}
.total-section {
  padding: 10px;
  background-color: #f4f6f9;
  border: 1px solid #dfe0e5;
  border-radius: 6px;
  margin-bottom: 10px;
}
.vue-portal-target .is-active {
  background-color: #ee8102;
}
.btn-reset {
  width: 100px;
  background-color: #525f6e;
  margin-right: 10px;
  color: #fff;
  font-weight: 100;
}
.btn-submit {
  color: #fff;
  background-color: #ee8102;
  border: 1px solid #ee8102;
}
.db {
  margin-right: 10px;
}
.minus-sign {
  margin-top: 5px;
  margin-right: -6px;
  margin-left: 6px;
}
.order-value {
  font-size: 18px;
  font-weight: 600;
  margin-left: 10px;
}
.order-percentage {
  font-size: 18px;
  font-weight: 600;
  margin-left: 10px;
}
.up {
  color: red;
}
.down {
  color: green;
}
.plus-sign {
  margin-top: 3px;
  margin-right: -5px;
  margin-left: 6px;
}
</style>