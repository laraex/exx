<template >
<div class="grid grid-4 gc-40 p-10">
<div class="select-section this-is-test-class">
  <select name="currencypair" v-model="selected" @change="additionalData" class="pair-select" id="coin" >
      <option v-for="(marketrate, index) in marketrates.data" v-bind:data-foo="marketrate.currencypair" v-bind:value="marketrate.id">
          <font style="vertical-align: inherit;">{{ marketrate.fromcurrency.displayname }} </font>({{ marketrate.currencypair }}) 
      </option>
  </select>
        
  <div class="price-section">
        <h2 class="pair-price">{{getorder.last_order_amt | formatNumber}} </h2>  
        <div class="flex flex-m stats-row mb-10"> 
            <div class="db">{{this.trans.daybefore}}</div>
            <div v-if="getorder.updown_status===0" class="flex db-sign down">
              <div>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="26" fill="green"><path d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/></svg>
              </div>
               <div class="minus-sign"></div>
               <div> <span class="order-value down"> {{getorder.order_per | formatNumber2}} %  </span></div>
               <div> <span class="order-percentage down"> {{getorder.diff_amt | formatNumber2}}</span> </div>
           </div>
          <div v-if="getorder.updown_status===1" class="flex db-sign up">
            <div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="16" height="26" fill="red"><path d="M288.662 352H31.338c-17.818 0-26.741-21.543-14.142-34.142l128.662-128.662c7.81-7.81 20.474-7.81 28.284 0l128.662 128.662c12.6 12.599 3.676 34.142-14.142 34.142z"/></svg></div>
            <div class="plus-sign">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="18" height="16" fill="red"><path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"/></svg></div>
            <div><span class="order-value up"> {{getorder.order_per | formatNumber2}} %  </span></div>
            <div><span class="order-percentage up"> {{getorder.diff_amt | formatNumber2}}</span></div>
            
        </div>
      </div>
  </div>
  </div>

  <div class="stats-section">
          <table class="table table-pricing">
            <tr>
              <td>{{this.trans.high}}</td>
              <td style="text-align: right">
                {{ tradestats.max_order | formatNumber }} 
                <span class="pair-token">{{ marketrates.data[selected].tocurrency.name }}</span> 
              </td>
            </tr>
            <tr>
              <td>{{this.trans.low}}</td>
              <td style="text-align: right">
                {{ tradestats.min_order |formatNumber }} 
                <span class="pair-token">{{ marketrates.data[selected].tocurrency.name }}</span> 
              </td>
            </tr>
          <tr>
              <td>{{this.trans.h24_volume}}</td>
              <td style="text-align: right">{{ tradestats.hourvolume }} 
                <span class="pair-token">{{ marketrates.data[selected].fromcurrency.name }}</span>
              </td>
            </tr>
                    <tr>
              <td>{{this.trans.h24_amount}}</td>
              <td style="text-align: right">{{ tradestats.houramount | formatNumber }} 
                <span class="pair-token">{{ marketrates.data[selected].tocurrency.name }}</span> 
              </td>
            </tr>
          </table>
    </div>
        <div class="">
          <div class="table table-pricing">

              <tr v-if="getrates.bitfinex!=0">
               
              <td>Bitfinex</td>
              <td>
                {{ getrates.bitfinex | formatNumber}} <span class="pair-token"> KRW </span>  <span class="pair-token">( {{getrates.bitfinexval}} EUR ) </span>
              </td>
            </tr>
            <tr v-if="getrates.kraken!=0">
              <td>Kraken </td>
              <td>
                {{ getrates.kraken | formatNumber}} <span class="pair-token"> KRW </span> 
           <span class="pair-token">( {{getrates.krakenval}} EUR ) </span>
              </td>
            </tr>
              <tr v-if="getrates.bitflyer!=0">
              <td>Bitflyer </td>
              <td>{{ getrates.bitflyer | formatNumber}} <span class="pair-token"> KRW </span> 
           <span class="pair-token">( {{getrates.bitflyerval}} JPY ) </span>
              </td>
            </tr>
            <tr>
              <td>CoinMarketCap </td>
              <td>{{ coinmarketcap | formatNumber }} 
              <span class="pair-token">{{ marketrates.data[selected].tocurrency.name }}</span>
              </td>
            </tr>
          </div>
    </div>
</div>
</template>

<script>
import { bus, router } from "../../app";
import LoginSignupButtons from "../LoginSignupButtons.vue";
import PortalVue from "portal-vue";
import Tabs from "vue-tabs-component";

Vue.use(PortalVue);
Vue.use(Tabs);
export default {
  data() {
    return {
      trans: [],
      marketrates: {
        data: {
          1: {
            id: $("#currentpair").val(),
            fromcurrency: {
              name: $("#fromtoken").val()
            },
            tocurrency: {
              name: $("#totoken").val()
            }
          }
        }
      }, //For selected default data
      tradestats: [],
      selected: $("#currentpair").val(),
      bitfinex: [],
      kraken:[],
      coinmarketcap:[],
      bitflyer:[],
      coinmarketcap:'',
      getorder: [],
      getrates:[],

    };
  },
  created() {
    this.getOrders();
    axios
      .get("/trade/tradestats/" + this.selected)
      .then(response => (this.tradestats = response.data));

    axios
      .get("/marketrate")
      .then(response => (this.$data.marketrates = response.data));
   
       this.getExchange();
       this.getRates();
       
    axios.get("/translations").then(response => (this.trans = response.data));

    bus.$on("dataSelected", data => {
      this.selected = data;
      console.log("Listen");
      console.log(data);
      this.currencypair(data);
    });
    axios
      .get("/chart?action=ajaxSymbolAutocomplete&q=" + $("#fromtoken").val())
      .then(response => {
        this.e = response.data;
        this.showGraph(this.e[0].id, $("#totoken").val());
      });
  },
  computed: {
    additionalData: function() {
      if (
        $("#coin")
          .find(":selected")
          .data("foo") != undefined
      ) {
        router.replace(
          "/trade/" +
            $("#coin")
              .find(":selected")
              .data("foo")
        );
      }
      
      bus.$emit("dataSelect", this.selected);

      this.currencypair(this.selected);

      //console.log("Jss");
    }
  },

  methods: {
    //Get Orders

    currencypair(val) {
      console.log("Selected");
      console.log(val);
      this.getOrders();
      this.getExchange();
       this.getRates();

      axios
        .get("/trade/tradestats/" + val)
        .then(response => (this.tradestats = response.data));
    },
    getRates() {
      axios.get("/exchangerate/getrates/"+this.selected).then(response => {
        this.getrates = response.data;
      });
    },
    getOrders() {
      axios.get("/getorder/" + this.selected).then(response => {
        this.getorder = response.data;
      });
    },
    getExchange() {
       axios
      .get("/exchangerate/bitfinex/" + this.selected)
      .then(response => (this.bitfinex = response.data));
    axios
      .get("/exchangerate/kraken/" + this.selected)
      .then(response => (this.kraken = response.data));
    axios
      .get("/exchangerate/coinmarketcap/" + this.selected)
      .then(response => (this.coinmarketcap = response.data));
    axios
      .get("/exchangerate/bitflyer/" + this.selected)
      .then(response => (this.bitflyer = response.data));
    },
    showGraph: function(asset, currency) {
      var istudy = this.istudy;
      this.istudy++;
      var chartData = [];
      $.ajax({
        url: "/chart",
        method: "post",
        dataType: "json",
        data: {
          action: "ajaxGetData",
          asset: asset,
          currency: currency
        }
      }).done(function(e) {
        for (var i = 0; i < e.data.length; i++) {
          var newDate = new Date(e.data[i].time);

          chartData[i] = {
            Date: e.data[i].time,
            Open: e.data[i].open,
            Close: e.data[i].close,
            High: e.data[i].high,
            Low: e.data[i].low,
            Volume: e.data[i].volume,
            DT: "new"
          };
        }
        var stxxxm = new CIQ.ChartEngine({
          container: $$$("#minichart"),
          layout: { chartType: "baseline" }
        });
        stxxxm.controls.chartControls.style.display = "none"; // use this line to disable the controls

        stxxxm.setStyle("stx_baseline_down", "color", "blue");
        stxxxm.setStyle("stx_baseline_up", "color", "red");
        stxxxm.newChart("SPY", chartData, null, function() {});
      });
    }
  }
};
</script>
<style  scoped>
#minichart #chartSize {
  /* Chart size container */
  display: none;
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
#minichart {
  font-size: 11px;
  margin-left: 26px;
  margin-top: -38px;
}
</style>