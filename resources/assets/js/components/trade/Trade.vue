<template>
<div class="">
  <tabs>
    <tab name="Buy">
      <div class="p-10">
        <h4 class="trade-buy-heading">{{this.trans.tradebuy}} </h4>
        <form method="post">
          <div v-if="this.success!=''" class="alert alert-success" id="success-alert">{{this.success}}</div>
          <div class="form-group flex flex-m">
            <div class="balance-text">{{this.trans.balance}}</div>

            <div class="balance-value text-right flex-1"> {{tradestats.buy_userbalance}} <span class="balance-currency">{{ marketrates.data[selected].tocurrency.name }}</span></div>
          </div>
          <div class="form-group flex flex-m">

            <div class="sell-amount" style="width: 200px;">{{this.trans.amount}} ({{ marketrates.data[selected].fromcurrency.name }}) </div>

            <div class="flex flex-c">
              <div class="input-group">
                <input type="text" name="buy_volume" class="form-control text-right" v-model="buy_volume" id="buy_volume" v-on:input="getBuyExchangeRate">
                <div class="input-group-append">
                  <select name="per" v-model="percentage" @change="ChangePercentage()" class="custom-select">
              <option value="1">{{this.trans.select}}</option>
            <option value="100">100%</option>
            <option value="50">50%</option>
            <option value="25">25%</option>
            <option value="10">10%</option>
           </select>
                </div>

                <small class="text-danger"></small>
              </div>
              <span v-if="errors.volume"><small class="text-danger">{{errors.volume}}</small> </span>

            </div>
          </div>
          <div class="form-group flex flex-m">

            <div class="sell-price" style="width: 200px;">{{this.trans.price}} ({{ marketrates.data[selected].tocurrency.name }})</div>
            <div class="flex flex-c">
              <div class="input-group">
                <input type="number" name="buy_amount" class="form-control text-right" v-model="buy_amount" id="buy_amount" v-on:input="getBuyExchangeRate">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" @click.prevent="Add(2)">+</button>
                  <button class="btn btn-outline-secondary" type="button" @click.prevent="Sub(2)">-</button>
                </div>
              </div>
              <span v-if="errors.amount"><small class="text-danger">{{errors.amount}}</small> </span>
            </div>
          </div>
          <div class="total-section flex flex-m">
            <div class="flex-1">{{this.trans.payamount}} </div>
            <div class="text-right"> {{ (this.total_amount) | formatNumber8 }} {{ marketrates.data[selected].fromcurrency.name }} </div>
          </div>
          <div class="fee-section flex flex-m">
            <div class="flex-1">{{this.trans.amount}}: {{ (this.final_amount) | formatNumber }} {{ marketrates.data[selected].tocurrency.name }}</div>
            <div class="text-right">{{this.trans.fee}} : {{ (this.fee) | formatNumber8 }} {{ marketrates.data[selected].fromcurrency.name }} </div>
          </div>
          <div class="flex flex-m" v-if="tradestats.isLogin === 1">
            <input v-bind:value="this.trans.reset" class="btn btn-default btn-reset" type="button" id="resetBtn" @click.prevent="buyformReset()">
            <input v-bind:value="this.trans.buy" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtn" @click.prevent="checkForm()">
          </div>


          <div v-else>
            <login-signup-buttons></login-signup-buttons>
          </div>
        </form>

      </div>
    </tab>
    <tab name="Sell">
      <div class="p-10">
        <h4>{{this.trans.tradesell}} </h4>
        <form method="post">
          <div v-if="this.sellsuccess!=''" class="alert alert-success" id="success-alert">{{this.sellsuccess}}</div>
          <div class="form-group flex flex-m">
            <div class="balance-text">{{this.trans.balance}}</div>
            <div class="balance-value text-right flex-1"> {{tradestats.sell_userbalance}} <span class="balance-currency">{{ marketrates.data[selected].fromcurrency.name }}</span></div>
          </div>
          <div class="form-group flex flex-m">
            <div class="sell-amount" style="width: 200px;"> {{this.trans.amount}} ({{ marketrates.data[selected].fromcurrency.name }})</div>
            <div class="flex flex-c">
              <div class="input-group">
                <input type="text" name="sell_volume" class="form-control text-right" v-model="sell_volume" id="sell_volume" v-on:input="getSellExchangeRate">
                <div class="input-group-append">
                  <select name="per" v-model="sellpercentage" @change="ChangeSellPercentage()" class="custom-select">
              <option value="1">{{this.trans.select}}</option>
            <option value="100">100%</option>
            <option value="50">50%</option>
            <option value="25">25%</option>
            <option value="10">10%</option>
           </select>
                </div>
              </div>
              <span v-if="errors.sellvolume"><small class="text-danger">{{errors.sellvolume}}</small></span>

            </div>
          </div>
          <div class="form-group flex flex-m">
            <div class="sell-price" style="width: 200px;"> {{this.trans.price}} ({{ marketrates.data[selected].tocurrency.name }}) </div>
            <div class="flex flex-c">
              <div class="input-group">
                <input type="number" name="sell_amount" class="form-control text-right" v-model="sell_amount" v-on:input="getSellExchangeRate">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" @click.prevent="Add(1)">+</button>
                  <button class="btn btn-outline-secondary" type="button" @click.prevent="Sub(1)">-</button>
                </div>
              </div>
              <span v-if="errors.sellamount"><small class="text-danger">{{errors.sellamount}} </small></span>

            </div>
          </div>
          <div class="total-section flex flex-m">
            <div class="flex-1">{{this.trans.payamount}} </div>
            <div class="text-right"> {{ (this.sell_totalamount) | formatNumber8 }} {{ marketrates.data[selected].tocurrency.name }} </div>
          </div>
          <div class="fee-section flex flex-m">
            <div class="flex-1">{{this.trans.amount}}: {{ (this.sell_final_amount) | formatNumber }} {{ marketrates.data[selected].tocurrency.name }}</div>
            <div class="text-right">{{this.trans.fee}} : {{ (this.sell_fee) | formatNumber8 }} {{ marketrates.data[selected].tocurrency.name }} </div>
          </div>

          <div class="flex flex-m" v-if="tradestats.isLogin === 1">
            <input v-bind:value="this.trans.reset" class="btn btn-default btn-reset" type="button" id="resetBtn" @click.prevent="sellformReset()">
            <input v-bind:value="this.trans.sell" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtnsell" @click.prevent="checkSell()">
          </div>
          <div v-else>
            <login-signup-buttons></login-signup-buttons>
          </div>
        </form>
      </div>
    </tab>
    <tab name="My Orders">
      <div class="flex flex-m p-10" v-if="tradestats.isLogin === 1">
        <div class="flex-1">
          <div class="flex" style="justify-content: space-around;">
            <div class="form-check">
              <input class="form-check-input" type="radio" name="myorders" id="Queued" value="1">
              <label class="form-check-label" for="Queued">In Queue</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="myorders" id="Pending" value="2">
              <label class="form-check-label" for="Pending">Pending</label>
            </div>
          </div>
          <div class="" id="queue-section">
            <div class="flex flex-1 badge badge-info p-10 mb-10">Orders in Queue are locked ane you can not cancel it.</div>
            <h6 class="">Buy Orders</h6>
            <table class="table table-striped" style="width: 100%">
              <thead>
                <th>{{this.trans.date}}</th>
                <th>{{this.trans.volume}}</th>
                <th class="text-right">{{this.trans.price_per}} </th>
                <th class="text-right">{{this.trans.action}} </th>

              </thead>
              <tbody>
                <tr v-for="buyorder in buyorders">
                 <td>{{buyorder.updated_at | date }}  </td>
                  <td>{{buyorder.quantity}} {{to_currency}}</td>
                  <td class="text-right">{{buyorder.amount}} {{from_currency}}</td>
                  <td class="text-right"><a href=" " @click.prevent="cancelOrder(buyorder.id)">Cancel</a></td>
                </tr>

              </tbody>
            </table>
            <hr>
            <h6 class="">Sell Orders</h6>
            <table class="table table-striped" style="width: 100%">
              <thead>
                <th>{{this.trans.date}}</th>
                <th>{{this.trans.volume}}</th>
                <th class="text-right">{{this.trans.price_per}} </th>
                  <th class="text-right">{{this.trans.action}} </th>

              </thead>
              <tbody>
                <tr v-for="sellorder in sellorders">
                  <td>{{sellorder.updated_at}}</td>
                  <td>{{sellorder.quantity}} {{to_currency}}</td>
                  <td class="text-right">{{sellorder.amount}} {{from_currency}}</td>
                   <td class="text-right"><a href=" " @click.prevent="cancelOrder(sellorder.id)">Cancel</a></td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="flex flex-c p-10" v-if="tradestats.isLogin === 0">
        <div class="flex-1">
          <p>You can check After Login</p>
        </div>
        <login-signup-buttons></login-signup-buttons>
      </div>
    </tab>
  </tabs>
  
  <b-modal no-close-on-esc no-close-on-backdrop hide-header-close ref="myModalRef" hide-footer title="Confirm Order">
      <div class="d-block text-center"> 
        <h4>Buy  {{buymodal.buy_volume}} {{buymodal.fromcur}} at {{buymodal.amount}} {{buymodal.tocur}}
</h4><br>
Total : {{buymodal.total_amount}} {{buymodal.tocur}}
Fee : {{buymodal.fee_total}} {{buymodal.fromcur}}
      </div>
      <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Cancel</b-btn>
      <b-btn class="mt-3" variant="outline-success" block @click="checkBuy()">Confirm</b-btn>
    </b-modal>

     <b-modal no-close-on-esc no-close-on-backdrop hide-header-close ref="myModalRef1" hide-footer title="Confirm Order">
      <div class="d-block text-center"> 
        <h4>Sell  {{sellmodal.buy_volume}} {{sellmodal.fromcur}} at {{sellmodal.amount}} {{sellmodal.tocur}}
</h4><br>
Total : {{sellmodal.total_amount}} {{sellmodal.tocur}}
Fee : {{sellmodal.fee_total}} {{sellmodal.tocur}}
      </div>
      <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Cancel</b-btn>
      <b-btn class="mt-3" variant="outline-success" block @click="checkFormSell()">Confirm</b-btn>
    </b-modal>
</div>

</template>


<script>
import {
  bus
} from "../../app";
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

      buy_volume: null,
      buy_amount: null,
      sell_volume: null,
      sell_amount: null,
      sell_fee: 0,
      sell_totalamount: 0,
      sell_final_amount: 0,
      fee: 0,
      total_amount: 0,
      final_amount: 0,
      errors: [],
      success: "",
      orders: [],
      percentage: 1,
      sellpercentage: 1,
      getorder: [],
      sellsuccess: "",
      buymodal: [],
      sellmodal: [],
      buyorders:[],
      sellorders:[],
      from_currency:'',
      to_currency:'',
    };
  },

  created() {
    //Select Currency Dropdown
    bus.$on("dataSelect", data => {
      this.selected = data;
      if (this.selected != "") {
        this.TradeData();
        this.getData();
      }
      console.log("Listen Trades ");
      console.log(data);
    });
    //Currency Pair
    bus.$on("dataSelected", data => {
      this.selected = data;

      if (this.selected != "") {
        this.TradeData();
        this.getData();
      }
      console.log("Listen Trades");
      console.log(data);
    });

    //For Orders
    this.TradeData();
   
    axios
      .get("/marketrate")
      .then(response => (this.marketrates = response.data));

    axios.get("/translations").then(response => (this.trans = response.data));

    this.getOrders();
    this.getData();
    this.listenForTrade();
  },
  computed: {},

  methods: {
    hideModal() {
      this.$refs.myModalRef.hide();
      this.$refs.myModalRef1.hide();
      $("#myBtn").prop("disabled", false);
      $("#myBtnsell").prop("disabled", false);
    },
    TradeData() {
      // alert("JJ");
      axios
        .get("/trade/tradestats/" + this.selected)
        .then(response => (this.tradestats = response.data));
    },
    //Get Orders

    //Get Orders
    checkForm: function(e) {
      this.success = "";
      if (this.buy_volume && this.buy_amount) {
        $("#myBtn").prop("disabled", true);
        this.errors = [];
        axios
          .post("/myaccount/trade/buy/check", {
            fromcur: this.marketrates.data[this.selected].fromcurrency.name,
            tocur: this.marketrates.data[this.selected].tocurrency.name,
            currency_pair: this.selected,
            buy_volume: this.buy_volume,
            buy_amount: this.buy_amount
          })
          .then(response => {
            this.buymodal = response.data.data;
             this.$refs.myModalRef.show();
            //  this.errors
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            $("#myBtn").prop("disabled", false);

            this.errors = error.response.data.errors;

            if (this.errors.buy_amount != '') {
              //console.log("Buy"+this.errors.buy_amount[0]);
              this.errors['amount'] = this.errors.buy_amount[0];
            }

            if (this.errors.buy_volume[0] != '')
              this.errors.volume = this.errors.buy_volume[0];

            e.preventDefault();
          });
        return true;
      }



      this.errors = [];
      if (!this.buy_volume || !this.buy_amount) {
        if (!this.buy_volume) this.errors["volume"] = this.trans.volumeerrmsg;
        if (!this.buy_amount) this.errors["amount"] = this.trans.amounterrmsg;
        e.preventDefault();
      }
    },
    checkBuy: function(e) {
      this.success = "";
      if (this.buy_volume && this.buy_amount) {
        $("#myBtn").prop("disabled", true);
        this.errors = [];
        axios
          .post("/myaccount/trade/buy", {
            fromcur: this.marketrates.data[this.selected].fromcurrency.name,
            tocur: this.marketrates.data[this.selected].tocurrency.name,
            currency_pair: this.selected,
            buy_volume: this.buy_volume,
            buy_amount: this.buy_amount
          })
          .then(response => {
            console.log("BUY");
            this.success = response.data.message;
            this.buy_volume = "";
            this.buy_amount = "";
            this.fee = 0;
            this.total_amount = 0;
            this.final_amount = 0;

            $("#myBtn").prop("disabled", false);
            this.hideModal();
            this.TradeData();

            //  this.errors
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            $("#myBtn").prop("disabled", false);


            e.preventDefault();
          });
        return true;
      }
    },

    getBuyExchangeRate: function(e) {
      // console.log("BBB"+this.marketrates.data[this.selected - 1].fee);

      this.success = "";
      this.errors = [];

      // axios.post('/myaccount/trade/getbuyexchange',{currency_pair:this.selected,volume:this.buy_volume, amount:this.buy_amount})
      //      .then(response =>{
      //          this.final_amount=response.data.finaltot_amount;
      //          this.fee=response.data.fee_total;
      //          this.total_amount=response.data.final_amount;

      //               console.log(response);

      //         });

      var total = this.buy_volume * this.buy_amount;
      this.final_amount = total;
      //alert(this.marketrates.data[this.selected].fee);
     // this.fee = this.marketrates.data[this.selected].fee / 100 * total;//hide
       //this.total_amount = total + this.fee;//hide
      this.fee = (this.marketrates.data[this.selected].buy_fee / 100 * this.buy_volume)+this.marketrates.data[this.selected].buy_base_fee;

      this.total_amount = this.buy_volume-this.fee;

      this.ChangePercentage();
    },
    checkSell: function(e) {
      this.success = "";
      if (this.sell_volume && this.sell_amount) {
        $("#myBtnsell").prop("disabled", true);
        this.errors = [];
        axios
          .post("/myaccount/trade/sell/check", {
            fromcur: this.marketrates.data[this.selected].fromcurrency.name,
            tocur: this.marketrates.data[this.selected].tocurrency.name,
            currency_pair: this.selected,
            sell_volume: this.sell_volume,
            sell_amount: this.sell_amount
          })
          .then(response => {
           this.sellmodal = response.data.data;
           this.$refs.myModalRef1.show();
            //  this.errors
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            console.log(error.response.data);
            this.errors = error.response.data.errors;

            $("#myBtnsell").prop("disabled", false);
            //alert(this.errors.buy_amount);

            this.errors.sellvolume = this.errors.sell_volume[0];
            //this.errors.volume = this.errors.buy_volume[0];
            this.errors.amount = this.errors.sell_amount;
            e.preventDefault();
          });

        return true;
      }

      this.errors = [];
      if (!this.sell_volume || !this.sell_amount) {
        if (!this.sell_volume)
          this.errors["sellvolume"] = this.trans.sellvolumeerrmsg;
        if (!this.sell_amount)
          this.errors["sellamount"] = this.trans.sellamounterrmsg;
        e.preventDefault();
      }
    },
    checkFormSell: function(e) {
      this.success = "";
      if (this.sell_volume && this.sell_amount) {
        $("#myBtnsell").prop("disabled", true);
        this.errors = [];
        axios
          .post("/myaccount/trade/sell", {
            fromcur: this.marketrates.data[this.selected].fromcurrency.name,
            tocur: this.marketrates.data[this.selected].tocurrency.name,
            currency_pair: this.selected,
            sell_volume: this.sell_volume,
            sell_amount: this.sell_amount
          })
          .then(response => {
            this.$refs.myModalRef1.hide();
            console.log("BUY");
            this.sellsuccess = response.data.message;
            this.sell_volume = "";
            this.sell_amount = "";
            this.sell_fee = 0;
            this.sell_totalamount = 0;
            this.sell_final_amount = 0;
            $("#myBtnsell").prop("disabled", false);
            this.TradeData();
            //  this.errors
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            console.log(error.response.data);
            this.errors = error.response.data.errors;

            $("#myBtnsell").prop("disabled", false);
            //alert(this.errors.buy_amount);

            this.errors.sellvolume = this.errors.sell_volume[0];
            //this.errors.volume = this.errors.buy_volume[0];
            this.errors.amount = this.errors.sell_amount;
            e.preventDefault();
          });

        return true;
      }

      this.errors = [];
      if (!this.sell_volume || !this.sell_amount) {
        if (!this.sell_volume)
          this.errors["sellvolume"] = this.trans.sellvolumeerrmsg;
        if (!this.sell_amount)
          this.errors["sellamount"] = this.trans.sellamounterrmsg;
        e.preventDefault();
      }
    },

    getSellExchangeRate: function(e) {
      this.success = "";
      this.errors = [];
      var total = this.sell_volume * this.sell_amount;
      this.sell_final_amount = total;

     // this.sell_fee = this.marketrates.data[this.selected].fee / 100 * total;//hide
    //  this.sell_totalamount = total - this.sell_fee;//hide

     this.sell_fee = (this.marketrates.data[this.selected].sell_fee / 100 * total)+this.marketrates.data[this.selected].sell_base_fee;
       this.sell_totalamount = total - this.sell_fee;

    },
    buyformReset: function(e) {
      this.buy_volume = "";
      this.buy_amount = "";
      this.fee = 0;
      this.total_amount = 0;
      this.final_amount = 0;
    },
    sellformReset: function(e) {
      this.sell_volume = "";
      this.sell_amount = "";
      this.sell_fee = 0;
      this.sell_totalamount = 0;
      this.sell_final_amount = 0;
    },

    Add(val) {
      //if(this.sell_amount!=''){
      if (val == 1) {
        var sellamt = parseInt(this.sell_amount) + this.sumval;
        //console.log("ddd"+sellamt);
        this.sell_amount = sellamt;
      }
      if (val == 2) {
        //if(this.buy_amount!=''){
        var buyamt = parseInt(this.buy_amount) + this.sumval;
        this.buy_amount = buyamt;
      }

      this.getBuyExchangeRate();
    },
    Sub() {
      if (this.sell_amount != "") {
        var sellamt = this.sell_amount - this.sumval;
        this.sell_amount = sellamt;
      }
      if (this.buy_amount != "") {
        var buyamt = this.buy_amount - this.sumval;
        this.buy_amount = buyamt;
      }
      this.getBuyExchangeRate();
    },
    ChangePercentage() {
      // alert("GG"+this.percentage);
      if (this.percentage != 1) {
        var per_amount =
          this.tradestats.buy_userbalance * this.percentage / 100;
        //var per_amount=500*this.percentage/100;
        //this.getorder.last_order_amt
        //alert(per_amount);
        this.buy_volume = per_amount / this.buy_amount;
        // this.buy_volume=per_amount/5000;
        this.getBuyExchangeRate();
      }
    },
    ChangeSellPercentage() {
      //alert(this.tradestats.sell_userbalance);
      var per_amount =
        this.tradestats.sell_userbalance * this.sellpercentage / 100;
      this.sell_volume = per_amount;
      this.getSellExchangeRate();
    },
    getOrders() {
      axios.get("/getorder/" + this.selected).then(response => {
        this.getorder = response.data;
        this.buy_amount = this.getorder.last_order_amt;
        //this.buy_amount=5000;
      });
    },
    getData() {
      //alert("KK");
      axios.get("/trade/gettradedata/" + this.selected).then(response => {
        this.buyorders = response.data["buyorders"];
        //console.log(this.buyorders);
        this.sellorders = response.data["sellorders"];
        this.from_currency = response.data["to_currency_token"];
        this.to_currency = response.data["from_currency_token"];
      });
     
    },
     cancelOrder(id){
     //alert(id);
     this.$swal({
          title: 'Are you sure cancel order?',
          text: 'You can\'t revert your action',
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes Cancel order it!',
          cancelButtonText: 'No, Keep it!',
          showCloseButton: true,
          showLoaderOnConfirm: true
        }).then((result) => {

        axios.get("/myaccount/cancelorders/"+id).then(response => {
         // $("#myBtnConfirm").prop("disabled", false);
          this.success = response.data.message;
          this.$swal("Deleted!",response.data.message, "success");
          this.getData();
          //this.$refs.myModalRefViewAcc.hide();

        })
        .catch(error => {
          this.errors = error.response.data.errors;
          // alert(this.errors);
           this.$swal('Error', this.errors, 'info')
          e.preventDefault();
        });

        });
      return true;
    },
    listenForTrade() {
      window.Echo.channel("trade").listen("TradeAddEvent", data => {
      setTimeout(function(){ this.TradeData(); console.log('check trade') }, 10000);
      });
    },
  }
};
</script>

<style scoped>
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