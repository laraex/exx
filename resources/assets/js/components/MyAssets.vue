<template>
<div class="">
    <div class="bgd-box-round mb-10 flex flex-m total-assets-section" style="justify-content: space-between;">
        <div>
            <h2 class="total-asset-heading">{{this.trans.total_assets}}</h2>
        </div>
        <div class="flex-1">
            <h2 class="total-asset-value">{{ this.getcurrency[this.array_count].curbalance.toFixed(2) }}
                <small> <span class="my-asset-token"></span></small></h2>
        </div>
    </div>
    <div class="bgd-box-round p-10">
        <div class="grid grid-myassets grid-head-row">
            <div>{{this.trans.coinname}}</div>
            <div style="text-align: left">{{this.trans.holding}}</div>
            <div style="text-align: right">{{this.trans.quantity}}</div>
            <!--  <div style="text-align: right">{{this.trans.option}}</div> -->
        </div>
        <ul class="my-assets-list">
            <li class="grid grid-myassets" v-for="(currency,index) in getcurrency" @click="SelectCur(currency.curname, currency.id)">
                <div class="grid-myassets-item flex">
                    <img :src=" path + currency.currimage" class="my-asset-image">
                    <div>
                        <h6 class="my-asset-heading">{{currency.displayname}}</h6>
                        <p class="no-space my-asset-token">{{currency.curname}}</p>
                    </div>
                </div>
                <div class="grid-myassets-item" style="text-align:left" >
                    <div style="display:none">{{ this.bgWidth=((currency["equ"] / (current_balance))*100)  }} </div>
                    <div v-bind:style="{ backgroundColor: bgColor, width:this.bgWidth, height: bgHeight }"> {{ this.bgWidth=((currency["equ"] / (current_balance))*100) | formatNumber2 }} %</div>
                </div>
                <div style="text-align: right" >
                    <p class="no-space">{{currency["balance"] | formatNumber8}}<span class="my-asset-token"> {{currency.curname}} </span></p>
                    <!-- <p class="no-space">{{currency["equ"] | formatNumber2}}
                        <span class="my-asset-token"> KRW </span></p> -->
                </div>
                
            </li>
        </ul>
    </div>
</div>
</template>

<script>
import { bus , router } from "../app";


export default {
  data() {
    return {
      btcbalance: "",
      getcurrency: [],
      array_count: 0,
      bal: 12,
      current_balance: 0,
      trans: [],
      selected: 1,
      path: "https://bitground.cryptoexchange4u.com/",
      errors: [],
      success: "",
      exampleContent: " ",
      bgColor: "#adc9f7",
      bgWidth: "",
      bgHeight: "30px",
      xrpbalance: 0,
      xrp_edu: 0,
      oldxrpbalance : 0,
    };
  },
  created() {
    

    axios
      .get("/trade/tradestats/1")
      .then(response => (this.btcbalance = response.data.buy_userbalance));
    axios.get("/myaccount/getcurrency").then(response => {
      this.getcurrency = response.data;
      this.array_count = this.getcurrency.length - 1;
      this.current_balance = this.getcurrency[this.array_count].curbalance;
      console.log(this.current_balance);
    });

    axios.get("/translations").then(response => (this.trans = response.data));
  },
  methods: {
    createAddress(curname_webtype) {
      axios
        .post("/myaccount/createwallet/" + curname_webtype)
        .then(response => {
          // $("#btcaddress").html(result);
          $("." + curname_webtype + "_address").css("display", "none");
          $("." + curname_webtype).css("display", "block");
        })
        .catch(error => {
          $("#" + curname_webtype + "address").html("Try After Sometime");
        });
    },

    SelectCur(name,curid) {
   router.replace(
          "/myaccount/accounts/"+name
        );
        $("#activecurrency").val(curid);

      bus.$emit("selectCurrency", curid);
    }
  }
};
</script>

<style>
ul.my-assets-list {
  padding: 0;
  margin: 0;
}

ul.my-assets-list > li {
  padding: 10px;
  border-top: 1px solid #dedede;
}

ul.my-assets-list > li:hover {
  background-color: #f2f2f2;
  cursor: pointer;
}

ul.my-assets-list > li:active {
  background-color: #f2f2f2;
}

.grid-myassets {
  grid-template-columns: 6fr 3fr 4fr;
}

.my-asset-image {
  width: 40px;
  height: 40px;
  margin-right: 10px;
}

.my-asset-heading {
  font-size: 16px;
  font-weight: 700;
  margin: 0;
  padding: 0;
}

.my-asset-token {
  margin: 0;
  font-weight: 200;
  font-size: 14px;
  color: #333;
  margin-top: -4px;
}

.btn-create-wallet {
  font-size: 11px;
  text-transform: none;
  background-color: #17a5df;
  padding: 5px 10px;
  letter-spacing: 1px;
  border: 1px solid #17a5df;
}

.total-assets-section {
  padding: 15px;
}

.total-asset-heading {
  font-size: 21px;
  font-weight: 500;
  margin: 0;
  padding: 0;
}

.total-asset-value {
  font-size: 26px;
  text-align: right;
  font-weight: 500;
  color: #d60000;
  margin: 0;
  padding: 0;
}

.grid-head-row {
  padding: 10px;
  background-color: #e3e3e3;
}
</style>
