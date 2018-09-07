<template>
<div class="bgd-box-round p-10">
  <h2 class="bgd-heading-1"> {{this.trans.wallet}} </h2>
  <div class="flex">
    <div><img :src=" path + getcurrency.image" class="my-asset-image"></div>
    <div>
      <h5 class="nospace">{{getcurrency.displayname}} </h5>
      <p>{{getcurrency.name}} </p>
    </div>
  </div>
  <div class="flex flex-c mb-10">
    
    <div v-if="getcurrency.currency_type=='fiat'">

      <div>{{this.trans.address}}: {{getcurrency.address}}</div>

        <div>{{this.trans.balance}}: {{getcurrency.balance |  formatNumber2}}</div>
         <div  v-if="getcurrency.name=='EUR'">
           <a v-b-modal.modalPrevent class="btn btn-primary btn-create-wallet">
          {{this.trans.addbankacc}}</a>  <span v-if="getpayaccount.length>0"> <b-btn size="sm" variant="primary" @click="viewaccount('EUR')"> View Account
         </b-btn></span>
          <b-modal id="modalPrevent"
             ref="range"
             title="Add Bank"
             @Add="handleOk"
             @shown="clearName">
      <form @submit.stop.prevent="handleSubmit">
         
     <b-form-input type="text"
                      :placeholder="this.trans.bankname"
                      v-model="bank_name"></b-form-input>
          <span v-if="errors.bank_name"><small class="text-danger">{{errors.bank_name}}</small></span>
        <b-form-input type="text"
                      :placeholder="this.trans.swiftcode"
                      v-model="swift_code"></b-form-input>
        <span v-if="errors.swift_code"><small class="text-danger">{{errors.swift_code}}</small></span>

         <b-form-input type="text"
                      :placeholder="this.trans.accountno"
                      v-model="account_no"></b-form-input>
        <span v-if="errors.account_no"><small class="text-danger">{{errors.account_no}}</small></span>
         
          <b-form-input type="text"
                      :placeholder="this.trans.accountname"
                      v-model="account_name"></b-form-input>
        <span v-if="errors.account_name"><small class="text-danger">{{errors.account_name}}</small></span>
      
         <b-form-input type="text"
                       :placeholder="this.trans.accountaddr"
                      v-model="account_address"></b-form-input>
        <span v-if="errors.account_address"><small class="text-danger">{{errors.account_address}}</small></span>

      </form>
       <div slot="modal-footer" class="w-100">
         <b-btn size="sm" class="float-right" variant="primary" @click="handleOk">
           {{this.trans.addbank}}
         </b-btn>
       </div>
       </b-modal>
        </div>
         <div v-if="getcurrency.name=='USD'"> 
            <!-- <a  class="btn btn-primary"  v-b-modal.modalPreventusd>
          Add Bank Account</a>-->
           <b-btn v-b-modal.modalPreventusd>{{this.trans.addbankacc}}</b-btn> 
                  <span v-if="getpayaccount.length>0"> <b-btn size="sm" variant="primary" @click="viewaccount('USD')">
          {{this.trans.viewacc}}
         </b-btn></span>
    <!-- Main UI -->
  
    <!-- Modal Component -->
 <b-modal id="modalPreventusd"
             ref="range"
             title="Add Bank"
             @Add="handleOkusd"
             @shown="clearName">
      <form @submit.stop.prevent="handleSubmit">
         
     <b-form-input type="text"
                       :placeholder="this.trans.bankname"
                      v-model="bank_name"></b-form-input>
          <span v-if="errors.bank_name"><small class="text-danger">{{errors.bank_name}}</small></span>
        <b-form-input type="text"
                     :placeholder="this.trans.swiftcode"
                      v-model="swift_code"></b-form-input>
        <span v-if="errors.swift_code"><small class="text-danger">{{errors.swift_code}}</small></span>

         <b-form-input type="text"
                      :placeholder="this.trans.accountno"
                      v-model="account_no"></b-form-input>
        <span v-if="errors.account_no"><small class="text-danger">{{errors.account_no}}</small></span>
         
          <b-form-input type="text"
                      :placeholder="this.trans.accountname"
                      v-model="account_name"></b-form-input>
        <span v-if="errors.account_name"><small class="text-danger">{{errors.account_name}}</small></span>
      
         <b-form-input type="text"
                      :placeholder="this.trans.accountaddr"
                      v-model="account_address"></b-form-input>
        <span v-if="errors.account_address"><small class="text-danger">{{errors.account_address}}</small></span>

      
      </form>
       <div slot="modal-footer" class="w-100">
         <b-btn size="sm" class="float-right" variant="primary" @click="handleOkusd">
           {{this.trans.addbank}}
         </b-btn>
       </div>
       </b-modal>
        </div>

        <div v-if="getcurrency.name=='GBP'"> 
            <!-- <a  class="btn btn-primary"  v-b-modal.modalPreventusd>
          Add Bank Account</a>-->
           <b-btn v-b-modal.modalPreventgbp>{{this.trans.addbankacc}}</b-btn> 
                  <span v-if="getpayaccount.length>0"> <b-btn size="sm" variant="primary" @click="viewaccount('GBP')">
          {{this.trans.viewacc}}
         </b-btn></span>
    <!-- Main UI -->
  
    <!-- Modal Component -->
 <b-modal id="modalPreventgbp"
             ref="range"
             title="Add Bank"
             @Add="handleOkgbp"
             @shown="clearName">
      <form @submit.stop.prevent="handleSubmit">
         
     <b-form-input type="text"
                       :placeholder="this.trans.bankname"
                      v-model="bank_name"></b-form-input>
          <span v-if="errors.bank_name"><small class="text-danger">{{errors.bank_name}}</small></span>
        <b-form-input type="text"
                     :placeholder="this.trans.swiftcode"
                      v-model="swift_code"></b-form-input>
        <span v-if="errors.swift_code"><small class="text-danger">{{errors.swift_code}}</small></span>

         <b-form-input type="text"
                      :placeholder="this.trans.accountno"
                      v-model="account_no"></b-form-input>
        <span v-if="errors.account_no"><small class="text-danger">{{errors.account_no}}</small></span>
         
          <b-form-input type="text"
                      :placeholder="this.trans.accountname"
                      v-model="account_name"></b-form-input>
        <span v-if="errors.account_name"><small class="text-danger">{{errors.account_name}}</small></span>
      
         <b-form-input type="text"
                      :placeholder="this.trans.accountaddr"
                      v-model="account_address"></b-form-input>
        <span v-if="errors.account_address"><small class="text-danger">{{errors.account_address}}</small></span>

      
      </form>
       <div slot="modal-footer" class="w-100">
         <b-btn size="sm" class="float-right" variant="primary" @click="handleOkgbp">
           {{this.trans.addbank}}
         </b-btn>
       </div>
       </b-modal>
        </div>

    </div>
    <div v-else>{{this.trans.balance}}: {{getcurrency.balance}} {{getcurrency.name}}</div>
  </div>
  <tabs>
  <tab name="Information">
  <div class="p-10">{{this.trans.withdrawinfor}}</div>
  </tab>
  <tab name="Withdraw" v-if="getpayaccount.length>0 || getcurrency.currency_type!='fiat' " >
  <div v-if="getcurrency.name=='USD'|| getcurrency.name=='KRW' " class="p-10">
    <div v-if="this.success_withdraw!=''"  class="alert alert-success" id="success-alert">{{this.success_withdraw}}</div>
    <div class="form-group flex flex-m">
      <div class="sell-amount" style="width: 200px;"> {{this.trans.amount_lbl}} ({{getcurrency.name}})</div>
      <div class="flex flex-c" >
        <input type="text" name="withdraw_amount" class="form-control text-right"  v-model="withdraw_amount" id="withdraw_amount" >
        <span v-if="errors.withdraw_amount"><small class="text-danger">{{errors.withdraw_amount}}</small> </span>
      </div>
    </div>
    <div class="form-group flex flex-m">
      <div class="sell-price" style="width: 200px;">{{this.trans.transaction_lbl}} </div>
      <div class="flex flex-c">
        <input type="password" name="trans_password" class="form-control text-right" v-model="trans_password" >
        <span v-if="errors.trans_password"><small class="text-danger">{{errors.trans_password}}</small> </span>
      </div>
    </div>
    <div class="form-group flex flex-m">
      <div class="sell-price" style="width: 200px;"> {{this.trans.select_payment}}</div>
      <div class="flex flex-c">
        <select name="userpayaccountid" id="userpayaccountid" v-model="userpayaccountid">
          <option v-for="(payaccount,index) in getpayaccount" v-bind:value="payaccount.id" >
            {{ payaccount.param1 }} - {{ payaccount.param3.replace(/\d{3}/, "XXXX") }} 
          </option>
        </select>
        <span v-if="errors.userpayaccountid"><small class="text-danger">{{errors.userpayaccountid}}</small> </span>
        
      </div>
    </div>
    <div class="flex flex-m" >
      <input v-bind:value="this.trans.reset" class="btn btn-default btn-reset" type="button"  id="resetBtn" @click.prevent="withdrawformReset()">
      <input v-bind:value="this.trans.submit" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtnwithdraw" @click.prevent="checkFormWithdraw()">
    </div>
  </div>
  <div v-else  class="p-10" >
     <div v-if="this.success_withdraw_crypto!=''"  class="alert alert-success" id="success-alert">{{this.success_withdraw_crypto}}</div>
    
    <div class="form-group flex flex-m">
      <div class="sell-amount" style="width: 200px;"> {{getcurrency.name}} {{this.trans.address}}</div>
      <div class="flex flex-c"> 
        <input type="text" :name="getcurrency.currency_lower+'_address'" class="form-control text-right"  :v-model="getcurrency.currency_lower+'_address'" :id="getcurrency.currency_lower+'_address'" >
        <span v-if="errors.address"><small class="text-danger">{{errors.address}}</small> </span>
      </div>
    </div>
    <div class="form-group flex flex-m">
      <div class="sell-price" style="width: 200px;"> {{this.trans.send_amount}} ({{getcurrency.name}}) </div>
      <div class="flex flex-c">
        <input type="number" name="send_amount" class="form-control text-right" v-model="send_amount" >
        <span v-if="errors.send_amount"><small class="text-danger">{{errors.send_amount}}</small> </span>
        
      </div>
    </div>
    <div class="form-group flex flex-m">
      <div class="sell-price" style="width: 200px;">{{this.trans.transaction_lbl}} </div>
      <div class="flex flex-c">
        <input type="password" name="transaction_password" class="form-control text-right" v-model="transaction_password" >
        <span v-if="errors.transaction_password"><small class="text-danger">{{errors.transaction_password}}</small> </span>
      </div>
    </div>
    <div class="flex flex-m" >
      <input v-bind:value="this.trans.reset" class="btn btn-default btn-reset" type="button"  id="resetBtn" @click.prevent="CryptoformReset()">
      <input v-bind:value="this.trans.send" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtncry" @click.prevent="checkSendCrypto()">
    </div>
  </div>
  </tab>
  <tab name="Deposit" v-if="getpayaccount.length>0  || getcurrency.currency_type!='fiat'">
  <div v-if="getcurrency.name=='USD' || getcurrency.name=='EUR' || getcurrency.name=='GBP'">
    <div>
      <div class="flex flex-c p-10" v-if="this.formshow===0">
        <div><h4>{{this.trans.addfund}} </h4></div>
        <div v-if="this.success!=''"  class="alert alert-success" id="success-alert">{{this.success}}</div>

        <div class="form-group flex flex-m" >
          <div class="sell-price" style="width: 200px;"> {{this.trans.amount_lbl}} ({{getcurrency.name}}) </div>
          <div class="flex flex-c">
            <input type="number" name="amount" class="form-control text-right" v-model="amount" width="150px">
            <span v-if="errors.amount"><small class="text-danger">{{errors.amount}}</small> </span>
          </div>
        </div>
         <div class="form-group flex flex-m">
      <div class="sell-price" style="width: 200px;"> {{this.trans.select_payment}} </div>
      <div class="flex flex-c">
        <select name="userpayid" id="userpayid" v-model="userpayid">
          <option v-for="(payaccount,index) in getpayaccount" v-bind:value="payaccount.id"  v-bind:selected="userpayid ==payaccount.id ? 'selected' :'' ">
            {{ payaccount.param1 }} - {{ payaccount.param3.replace(/\d{3}/, "XXXX") }}
          </option>
        </select>
        <span v-if="errors.userpayid"><small class="text-danger">{{errors.userpayid}}</small> </span>
        
      </div>
    </div>

      <div class="flex flex-m p-10" >
        <input v-bind:value="this.trans.reset" class="btn btn-default btn-reset" type="button"  id="resetBtn" @click.prevent="withdrawformReset()">
        <input v-bind:value="this.trans.deposit" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtnsell" @click.prevent="checkAddFund()">
      </div>
    </div>
      </div>
  <div class="flex flex-c p-10" v-if="this.formshow===1">
    <table class="table table-striped">
      <tbody>
        <tr>
          <td>{{ this.trans.amount_to_be_deposited }} </td>
          <td> <label for="input01">{{ funddetail.amount }} {{getcurrency.name}}</label></td>
        </tr>
        <tr>
          <td> {{ this.trans.transaction_id }} </td>
          <td><label for="input01">{{ funddetail.transaction_id }}</label>
        </td>
      </tr>
      <tr>
        <td> {{ this.trans.bank_name_lbl }} </td>
        <td> <label for="input01">{{funddetail.params.bank_name}}</label>
      </td>
    </tr>
    <tr>
      <td>{{ this.trans.address }}</td>
      <td> <label for="input01">{{funddetail.params.bank_address}}</label>
    </td>
  </tr>
  <tr>
    <td>{{ this.trans.swift_code_lbl }}</td>
    <td><label for="input01">{{funddetail.params.swift_code}}</label>
  </td>
</tr>
<tr>
  <td>{{ this.trans.account_name_lbl}}</td>
  <td> <label for="input01">{{funddetail.params.account_name}}</label>
</td>
</tr>
<tr>
<td>{{ this.trans.account_no_lbl }}</td>
<td><label for="input01">{{funddetail.params.account_no}}</label>
</td>
</tr>
<tr>
<td colspan="2">
<div class="flex flex-m mb-10">
  <input v-bind:value="this.trans.submit_complete_btn" class="btn btn-success " type="submit" id="myBtnConfirm" @click.prevent="checkAddBank()">
  <input v-bind:value="this.trans.printinvoice" class="btn btn-submit" type="submit" id="myBtnsell" @click.prevent="PrintInvoice()" style="margin-left: 10px">
</div>
</td>
</tr>
<tr>
<td colspan="2">
   <input v-bind:value="this.trans.backtomywallet" class="flex-1 btn btn-primary btn-submit" type="submit" id="myBtnsell" @click.prevent="backtomywallet()" style="margin-left: 10px"> 
</td>
</tr>
</tbody>
</table>
</div>
</div>
<div class="p-20" v-else>
  <div v-if="getcurrency.address==''">
<div v-if="getcurrency.currency_type=='crypto'">
       <div v-if="getcurrency.address==''">
        <input v-bind:value="this.trans.create+' '+getcurrency.name+' '+this.trans.wallet" class="btn btn-primary btn-block" type="button" id="createBtn" @click.prevent="createAddress(getcurrency.currency_lower)">
      
        </div>
        <!-- <div v-else>
        <div>{{this.trans.address}}: {{getcurrency.address}}</div>
        <div>{{this.trans.balance}}: {{getcurrency.balance}} {{getcurrency.name}}</div>
         </div> -->
    </div> 
    <div v-else-if="getcurrency.currency_type=='token'">
       <div v-if="getcurrency.address==''">
         <a  href="#" class="btn btn-primary btn-block"  v-on:click="createAddress('eth')">Create Eth Wallet</a>
        
        </div>
        <!-- <div v-else>
        <div>{{this.trans.address}}: {{getcurrency.address}}</div>
        <div>{{this.trans.balance}}: {{getcurrency.balance}} {{getcurrency.name}}</div>
         </div> -->
    </div>
    </div>
    <div v-else>
<h3>{{getcurrency.name}} {{this.trans.receive}}</h3>
<qr-code v-bind:text="this.qraddress" size="150"
></qr-code>
<br/>
<p>{{this.trans.address}}: {{this.qraddress}} </p>
</div>
</div>

</tab>
</tabs>
 <b-modal ref="myModalRef" hide-footer title="Create XRP Address">
      <div class="d-block text-center">
        <h3>{{this.trans.XRPminireserve}}</h3>
      </div>
      <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Cancel</b-btn>
      <b-btn class="mt-3" variant="outline-success" block @click="createXRP(getcurrency.currency_lower)">Confirm</b-btn>
    </b-modal>

     <b-modal no-close-on-esc no-close-on-backdrop hide-header-close ref="myModalRefAddr" hide-footer :title="this.trans.servererror">
      <div class="d-block text-center"> 
        <h4>{{this.trans.servererror}}. {{this.trans.tryagain}}</h4>
      </div>
      <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Close</b-btn>
      
    </b-modal>
     <b-modal no-close-on-esc no-close-on-backdrop  ref="myModalRefViewAcc" hide-footer :title="this.trans.bankdetails">
      <div class="d-block" v-for="getpay in getpayaccountlist"> 
  <dl class="bank-details"  >
  <dt>{{trans.bankname}}</dt>
  <dd>{{getpay.param1}}</dd>
  <dt>{{trans.accountno}}</dt>
  <dd>{{getpay.param3}}</dd>
  <dt>{{trans.swiftcode}}</dt>
  <dd>{{getpay.param2}}</dd>
  <dt>{{trans.accountname}}</dt>
  <dd>{{getpay.param4}}</dd>
  <dt>{{trans.accountaddr}}</dt>
  <dd>{{getpay.param5}}</dd>
  </dl>
    <p><b-btn class="mt-3" variant="outline-danger"  @click="deleteBank(getpay.id)">{{trans.delete}}</b-btn></p>                        
      </div>
    </b-modal>
<br/> 
         <div v-if="getcurrency.currency_type=='crypto'">
           <view-transaction-history></view-transaction-history>
          </div>
          <div v-if="getcurrency.currency_type=='token'">
           <token-transaction-history></token-transaction-history>
          </div>

    </div>

</div>


</template>

<script>
import VueQRCodeComponent from "vue-qrcode-component";
Vue.component("qr-code", VueQRCodeComponent);
import { bus, router } from "../app";
import Tabs from "vue-tabs-component";

const RippleAPI = require("ripple-lib").RippleAPI;

const api = new RippleAPI({ server: "wss://s.altnet.rippletest.net:51233" });

export default {
  data() {
    return {
      trans: [],
      getcurrency: [],
      funddetail: [],
      selects: $("#activecurrency").val(),
      qraddress: "",
      path: "https://bitground.cryptoexchange4u.com/",
      errors: [],
      success: "",
      amount: "",
      address: "",
      paymentid: 0,
      formshow: 0,
      formdata: {},
      getpayaccount: [],
      getpayaccountlist: [],
      //gettrans:[],
      userpayaccountid: "",
      withdraw_amount: "",
      transaction_password: "",
      success: "",
      success_withdraw: "",
      trans_password: "",
      success_withdraw_crypto: "",
      addr: "",
      coin_addr: "",
      bank_name: "",
      account_address: "",
      swift_code: "",
      account_no: "",
      account_name: "",
      modalShow: false,
      from_ripple_address: "",
      from_ripple_secret: "",
      userpayid: ""
    };
  },
  created() {
    axios.get("/translations").then(response => (this.trans = response.data));
    this.getCurrency();

    bus.$on("selectCurrency", data => {
      this.selects = data;
      if (this.selects != "") {
        this.errors = [];
        this.getCurrency();
        //this.getTranHistory();
        this.getPayAccount();
        this.withdrawformReset();
        this.CryptoformReset();
      }
    });
  },
  methods: {
    clearName() {
      this.bank_name = "";
      this.account_address = "";
      this.swift_code = "";
      this.account_no = "";
      this.account_name = "";
      this.errors = "";
    },
    // getTranHistory(){
    //    axios.get("/myaccount/transhistory/"+this.paymentid).then(response => {
    //   this.gettrans = response.data;

    // });

    // },
    getCurrency() {
      axios.get("/currencydetail/" + this.selects).then(response => {
        this.getcurrency = response.data;

        this.qraddress = this.getcurrency.address;
        this.paymentid = this.getcurrency.paymentgateway_id;

        bus.$emit("PaymentId", this.selects);

        console.log("1");
        //this.getTranHistory();
        this.getPayAccount();
        var d = this.getcurrency.currency_lower + "_address";
        d = "";
      });
    },
    checkFormWithdraw: function(e) {
      this.success_withdraw = "";
      if (
        this.withdraw_amount &&
        this.userpayaccountid &&
        this.trans_password
      ) {
        $("#myBtnwithdraw").prop("disabled", true);
        this.errors = [];
        var addr = this.getcurrency.name + "_address";

        axios
          .post("/myaccount/withdraw", {
            amount: this.withdraw_amount,
            userpayaccountid: this.userpayaccountid,
            trans_password: this.trans_password,
            paymentgateway: this.paymentid,
            currency_id: this.getcurrency.id
          })
          .then(response => {
            console.log("Withdraw For USD");
            this.success_withdraw = response.data.message;
            this.userpayaccountid = "";
            this.withdraw_amount = "";
            this.trans_password = "";
            $("#myBtnwithdraw").prop("disabled", false);
            this.getCurrency();
          })
          .catch(error => {
            // if (error.response.status === 401 || error.response.status === 500) {
            //   window.location.href = "/login";
            // }
            $("#myBtnwithdraw").prop("disabled", false);
            this.errors = error.response.data.errors;
            if (this.errors.amount != undefined) {
              console.log("withamount");
              this.errors.withdraw_amount = this.errors.amount[0];
            }
            if (this.errors.trans_password != undefined) {
              console.log("tranpass");
              this.errors.trans_password = this.errors.trans_password[0];
            }
            e.preventDefault();
          });

        return true;
      }

      this.errors = [];
      if (
        !this.withdraw_amount ||
        !this.userpayaccountid ||
        !this.trans_password
      ) {
        if (!this.withdraw_amount)
          this.errors["withdraw_amount"] = this.trans.amounterrmsg;
        if (!this.transaction_password)
          this.errors["trans_password"] = this.trans.transpasserr;
        if (!this.userpayaccountid)
          this.errors["userpayaccountid"] = this.trans.selectpayerr;
        e.preventDefault();
      }
    },
    withdrawformReset() {
      //alert("GG");
      this.errors = [];
      this.userpayaccountid = "";
      this.withdraw_amount = "";
      this.trans_password = "";
    },
    checkSendCrypto: function(e) {
      this.success_withdraw_crypto = "";

      var getaddress = $(
        "#" + this.getcurrency.currency_lower + "_address"
      ).val();

      this.coin_addr = this.getcurrency.currency_lower + "_address";
      if (getaddress && this.send_amount && this.transaction_password) {
        $("#myBtncry").prop("disabled", true);
        axios
          .post(
            "/myaccount/type/" + this.getcurrency.currency_lower + "/send",
            {
              address: getaddress,
              amount: this.send_amount,
              transaction_password: this.transaction_password
            }
          )
          .then(response => {
            this.success_withdraw_crypto = response.data.message;
            $("#" + this.getcurrency.currency_lower + "_address").val("");
            this.send_amount = "";
            this.transaction_password = "";
            (this.address = ""), $("#myBtncry").prop("disabled", false);
            this.errors = [];
            this.getCurrency();
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            $("#myBtncry").prop("disabled", false);
            this.errors = error.response.data.errors;
            console.log("trassns" + this.errors.transaction_password);
            console.log("trasamount" + this.errors.amount);

            if (this.errors.amount != undefined) {
              this.errors.send_amount = this.errors.amount[0];
            }
            if (this.errors.transaction_password != undefined) {
              this.errors.transaction_password = this.errors.transaction_password[0];
            }
            // this.errors.send_amount=this.errors.amount[0];
            e.preventDefault();
          });
        return true;
      }
      this.errors = [];

      if (!this.send_amount || !getaddress || !this.transaction_password) {
        if (!getaddress) this.errors["address"] = this.trans.addresserr;
        if (!this.send_amount)
          this.errors["send_amount"] = this.trans.amounterrmsg;
        if (!this.transaction_password)
          this.errors["transaction_password"] =
            "Transaction Password required.";
        e.preventDefault();
      }
    },
    CryptoformReset() {
      this.errors = [];
      $("#" + this.getcurrency.currency_lower + "_address").val("");
      this.send_amount = "";
      this.transaction_password = "";
    },
    checkAddFund: function(e) {
      if (this.amount && this.userpayid) {
        this.errors = [];
        axios
          .post("/myaccount/addfund", {
            amount: this.amount,
            paymentgateway: this.paymentid,
            payment: this.userpayid,
            currency_id: this.getcurrency.currency_id
          })
          .then(response => {
            this.success = response.data.message;
            this.address = "";
            this.amount = "";
            this.funddetail = response.data.funddetails;
            //console.log(this.funddetail.user_id);
            this.formshow = 1;
            //console.log("HH"+this.funddetail);
            //console.log("TT"+this.funddetail['amount']);

            //  this.errors
          })
          .catch(error => {
            if (error.response.status === 401) {
              window.location.href = "/login";
            }
            $("#myBtn").prop("disabled", false);
            this.errors = error.response.data.errors;
            this.errors["amount"] = this.errors.amount;
            this.errors.amount = this.errors.amount[0];
            e.preventDefault();
          });

        return true;
      }
      this.errors = [];
      if (!this.amount) {
        if (!this.amount) this.errors["amount"] = this.trans.amounterrmsg;
      }
      if (!this.userpayid) this.errors["userpayid"] = "Select Payment";

      e.preventDefault();
    },

    checkAddBank: function(e) {
      $("#myBtnConfirm").prop("disabled", true);

      axios
        .post("/myaccount/addfund/bankwire", {
          amount: this.funddetail.amount,
          transaction_id: this.funddetail.transaction_id,
          bank_name: this.funddetail.params.bank_name,
          bank_address: this.funddetail.params.bank_address,
          swift_code: this.funddetail.params.swift_code,
          account_name: this.funddetail.params.account_name,
          account_no: this.funddetail.params.account_no,
          user_id: this.funddetail.user_id,
          paymentgateway: this.paymentid,
          currency_id: this.getcurrency.currency_id,
          payment: this.userpayid
        })
        .then(response => {
          $("#myBtnConfirm").prop("disabled", false);
          this.success = response.data.message;
          this.address = "";
          this.amount = "";

          this.funddetail = response.data.funddetails;

          //console.log(this.funddetail.params);

          this.formshow = 0;
        })
        .catch(error => {
          if (error.response.status === 401) {
            window.location.href = "/login";
          }
          $("#myBtnConfirm").prop("disabled", false);

          this.errors = error.response.data.errors;

          this.errors["amount"] = this.errors.amount;

          this.errors.amount = this.errors.amount[0];
          e.preventDefault();
        });

      return true;
    },
    deleteBank(id) {
      // alert(id);
      this.$swal({
        title: "Are you sure ?",
        text: "You can't revert your action",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes Delete it!",
        cancelButtonText: "No, Keep it!",
        showCloseButton: true,
        showLoaderOnConfirm: true
      }).then(result => {
        axios
          .get("/myaccount/deletebank/" + id)
          .then(response => {
            // $("#myBtnConfirm").prop("disabled", false);
            this.success = response.data.message;
            this.$swal("Deleted!", response.data.message, "success");
            this.getPayAccount();
            this.$refs.myModalRefViewAcc.hide();
          })
          .catch(error => {
            this.errors = error.response.data.errors;
            // alert(this.errors);
            this.$swal("Error", this.errors, "info");
            e.preventDefault();
          });
      });
      return true;
    },
    PrintInvoice() {
      window.open(
        "/myaccount/bankwire/printinvoice",
        "_blank" // <- This is what makes it open in a new window.
      );
    },
    backtomywallet() {
      window.location.href = "/myaccount/accounts";
    },
    getPayAccount() {
      axios.get("/myaccount/getpayaccount/" + this.paymentid).then(response => {
        this.getpayaccount = response.data;
        this.userpayid = response.data[0]["id"];
        this.userpayaccountid = response.data[0]["id"];

        console.log(this.getpayaccount);
      });
    },
    getPayAccountList($val) {
      axios.get("/myaccount/getpayaccountlist/" + $val).then(response => {
        this.getpayaccountlist = response.data;

        console.log("PAY" + this.getpayaccountlist);
      });
    },
    hideModal() {
      this.$refs.myModalRef.hide();
      this.$refs.myModalRefAddr.hide();
      this.$refs.myModalRefViewAcc.hide();
    },
    sendXRP(toaddress) {
      var from_ripple_address = this.from_ripple_address;
      var from_ripple_secret = this.from_ripple_secret;
      run().catch(error => console.error(error.stack));
      var kthis = this;
      async function run() {
        await api.connect();

        // Ripple payments are represented as JavaScript objects
        const payment = {
          source: {
            address: from_ripple_address,
            maxAmount: {
              value: "30.00",
              currency: "XRP"
            }
          },
          destination: {
            address: toaddress,
            amount: {
              value: "30.00",
              currency: "XRP"
            }
          }
        };

        // Get ready to submit the payment
        const prepared = await api.preparePayment(
          from_ripple_address,
          payment,
          {
            maxLedgerVersionOffset: 5
          }
        );
        console.log("prepared");
        console.log(prepared);
        // Sign the payment using the sender's secret
        const { signedTransaction } = api.sign(
          prepared.txJSON,
          from_ripple_secret
        );
        console.log("Signed", signedTransaction);

        // Submit the payment
        const res = await api.submit(signedTransaction);

        console.log("Done", res);
        kthis.getCurrency();
        axios.post("/myaccount/withdraw/usebuyxrp").then(response => {});
      }
    },
    createXRP(curname_webtype) {
      var keys = api.generateAddress();
      axios
        .post("/myaccount/createwallet/" + curname_webtype, {
          secret: keys.secret,
          address: keys.address
        })
        .then(response => {
          this.from_ripple_address = response.data.xrp_address;
          this.from_ripple_secret = response.data.xrp_secret;
          // $("#btcaddress").html(result);
          this.sendXRP(keys.address);

          this.hideModal();

          $("." + curname_webtype + "_address").css("display", "none");
          $("." + curname_webtype).css("display", "block");
        })
        .catch(error => {
          $("#" + curname_webtype + "address").html("Try After Sometime");
        });
    },
    createAddress(curname_webtype) {
      $("#createBtn").prop("disabled", true);
      if (curname_webtype == "xrp") {
        axios.get("/checkxrp").then(response => {
          console.log(response);
          if (response.data == "success") {
            this.$refs.myModalRef.show();
          } else {
            alert(this.trans.insufficentbal);
          }
        });
      } else {
        axios
          .post("/myaccount/createwallet/" + curname_webtype)
          .then(response => {
            // $("#btcaddress").html(result);
            this.getCurrency();
            $("#createBtn").prop("disabled", false);

            $("." + curname_webtype + "_address").css("display", "none");
            $("." + curname_webtype).css("display", "block");
          })
          .catch(error => {
            if (
              error.response.status === 404 ||
              error.response.status === 500
            ) {
              //window.location.href = "/login";
              this.$refs.myModalRefAddr.show();
              console.log("500erroe");
            }
            $("#createBtn").prop("disabled", false);
            $("#" + curname_webtype + "address").html("Try After Sometime");
          });
      }
    },
    handleOk(evt) {
      // Prevent modal from closing
      evt.preventDefault();

      this.errors = [];
      if (!this.bank_name || !this.account_address) {
        if (!this.bank_name) this.errors["bank_name"] = this.trans.banknameerr;
        if (!this.account_address)
          this.errors["account_address"] = this.trans.accountaddrerr;
        if (!this.swift_code)
          this.errors["swift_code"] = this.trans.swiftcodeerr;
        if (!this.account_no)
          this.errors["account_no"] = this.trans.accountnoerr;
        if (!this.account_name)
          this.errors["account_name"] = this.trans.accountnameerr;

        // e.preventDefault();
      } else {
        axios
          .post("/myaccount/payaccounts", {
            bank_name: this.bank_name,
            account_address: this.account_address,
            swift_code: this.swift_code,
            account_no: this.account_no,
            account_name: this.account_name,
            account_address: this.account_address,
            paymentid: 4
          })
          .then(response => {
            this.success = response.data.message;
            alert(this.success);
            this.clearName();
            this.handleSubmit();
          });
        return true;
      }
    },

    handleOkusd(evt) {
      // Prevent modal from closing
      evt.preventDefault();
      this.errors = [];
      if (!this.bank_name || !this.account_address) {
        if (!this.bank_name) this.errors["bank_name"] = this.trans.banknameerr;
        if (!this.account_address)
          this.errors["account_address"] = this.trans.accountaddrerr;
        if (!this.swift_code)
          this.errors["swift_code"] = this.trans.swiftcodeerr;
        if (!this.account_no)
          this.errors["account_no"] = this.trans.accountnoerr;
        if (!this.account_name)
          this.errors["account_name"] = this.trans.accountnameerr;

        // e.preventDefault();
      } else {
        axios
          .post("/myaccount/payaccounts", {
            bank_name: this.bank_name,
            account_address: this.account_address,
            swift_code: this.swift_code,
            account_no: this.account_no,
            account_name: this.account_name,
            account_address: this.account_address,
            paymentid: 2
          })
          .then(response => {
            this.success = response.data.message;
            alert(this.success);
            this.clearName();
            this.handleSubmit();
          });
        return true;
      }
    },
    handleOkgbp(evt) {
      // Prevent modal from closing
      evt.preventDefault();
      this.errors = [];
      if (!this.bank_name || !this.account_address) {
        if (!this.bank_name) this.errors["bank_name"] = this.trans.banknameerr;
        if (!this.account_address)
          this.errors["account_address"] = this.trans.accountaddrerr;
        if (!this.swift_code)
          this.errors["swift_code"] = this.trans.swiftcodeerr;
        if (!this.account_no)
          this.errors["account_no"] = this.trans.accountnoerr;
        if (!this.account_name)
          this.errors["account_name"] = this.trans.accountnameerr;

        // e.preventDefault();
      } else {
        axios
          .post("/myaccount/payaccounts", {
            bank_name: this.bank_name,
            account_address: this.account_address,
            swift_code: this.swift_code,
            account_no: this.account_no,
            account_name: this.account_name,
            account_address: this.account_address,
            paymentid: 3
          })
          .then(response => {
            this.success = response.data.message;
            alert(this.success);
            this.clearName();
            this.handleSubmit();
          });
        return true;
      }
    },
    handleSubmit() {
      //

      this.$refs.modal.hide();

      // $('#modalPrevent').modal('hide');
      //evt.preventDefault();
    },
    viewaccount($val) {
      this.$refs.myModalRefViewAcc.show();
      this.getPayAccountList($val);

      // window.open(
      //   "/myaccount/viewpayaccounts",
      //   "_blank" // <- This is what makes it open in a new window.
      // );
    }
  }
};
</script>
<style scoped>
   ul {
    list-style: none;
    padding:0;
    margin:0;
  }
  .transaction-list ul li {
    padding:0;
    margin:0;
  }
  .transaction-list-item {
    margin-bottom: 10px;
    border-bottom: 1px dotted #ccc;
  }
  h4.transaction-amount {
    padding-top: 10px;
    font-size: 18px;
    font-weight: 600;
  }
  .trans-address {
    font-size: 14px;
  }
 dl.bank-details dd {
   width: 75%;
   text-align: left;
}

dl.bank-details dt {
   text-align: left;
   float: left;
   width: 25%;
}
</style>
