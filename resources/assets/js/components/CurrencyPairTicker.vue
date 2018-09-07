<template>
<div class="ticker-bar-components">
    <div class="walletbalancecomponent btc">
    <h2 class="ticker-currency-name">{{this.btc_from_currency_token}}</h2>
    <div class="flex-2">
      <div class="price-switcher">
        <b-dropdown variant="link" size="sm" no-caret>
          <template slot="button-content">
            <div class="currencyMenu" id="currencyMenuBTC"><i class="fas fa-chevron-down"></i></div>
          </template>
          <b-dropdown-item  v-for="lf in btc_details[0]" @click="selectcurrency=lf.to_currency_token">
            {{lf.to_currency_token}}  {{lf.amount}} 
          </b-dropdown-item>
        </b-dropdown>
      </div>
      <div class="price-info">
        <div class="" v-for="disp in btc_details[0]">
                                <span v-if="selectcurrency==disp.to_currency_token">
                                  <h4 class="price">{{disp.to_currency_token}}  {{disp.amount}} </h4>
                                 <h6 class="price-delta"> 
                                  <span class="text-green" v-if="disp.final_total_per >= 0"> {{disp.final_total_per}} % <span><i class="fas fa-caret-up green-up"></i></span></span>
                                  

                                  <span v-if="disp.final_total_per < 0" class="text-red"> {{disp.final_total_per}} % <span><i class="fas fa-caret-down red-down"></i></span></span>
                                  
                                </h6>
                                </span>
                             </div>         


     
    </div>
    </div>
    </div>

<!--LTC  Start-->
  <div class="walletbalancecomponent ltc">
  <h2 class="ticker-currency-name">{{this.ltc_from_currency_token}}</h2>

  <div class="flex-2">
    <div class="price-switcher">
      <b-dropdown variant="link" size="sm" no-caret>
        <template slot="button-content">
          <div class="currencyMenu" id="currencyMenuBTC"><i class="fas fa-chevron-down"></i></div>
        </template>
        <b-dropdown-item  v-for="lf in ltc_details[0]" @click="selectcurrency=lf.to_currency_token">
          {{lf.to_currency_token}}  {{lf.amount}} 
        </b-dropdown-item>
      </b-dropdown>
    </div>
    <div class="price-info">
      <div class="" v-for="disp in ltc_details[0]">
                              <span v-if="selectcurrency==disp.to_currency_token">
                                <h4 class="price">{{disp.to_currency_token}}  {{disp.amount}} </h4>
                               <h6 class="price-delta"> 
                                <span class="text-green" v-if="disp.final_total_per >= 0"> {{disp.final_total_per}} % <span><i class="fas fa-caret-up green-up"></i></span></span>
                                

                                <span v-if="disp.final_total_per < 0" class="text-red"> {{disp.final_total_per}} % <span><i class="fas fa-caret-down red-down"></i></span></span>
                                
                              </h6>
                              </span>
                           </div>         


   
  </div>
  </div>
  </div>
  <!--LTC  End-->

<!--DOGE  Start-->
<div class="walletbalancecomponent doge">
<h2 class="ticker-currency-name">{{this.doge_from_currency_token}}</h2>

<div class="flex-2">
  <div class="price-switcher">
    <b-dropdown variant="link" size="sm" no-caret>
      <template slot="button-content">
        <div class="currencyMenu" id="currencyMenuDOGE"><i class="fas fa-chevron-down"></i></div>
      </template>
      <b-dropdown-item  v-for="lf in doge_details[0]" @click="selectcurrency=lf.to_currency_token">
        {{lf.to_currency_token}}  {{lf.amount}} 
      </b-dropdown-item>
    </b-dropdown>
  </div>
  <div class="price-info">
    <div class="" v-for="disp in doge_details[0]">
                            <span v-if="selectcurrency==disp.to_currency_token">
                              <h4 class="price">{{disp.to_currency_token}}  {{disp.amount}} </h4>
                             <h6 class="price-delta"> 
                              <span class="text-green" v-if="disp.final_total_per >= 0"> {{disp.final_total_per}} % <span><i class="fas fa-caret-up green-up"></i></span></span>
                              

                              <span v-if="disp.final_total_per < 0" class="text-red"> {{disp.final_total_per}} % <span><i class="fas fa-caret-down red-down"></i></span></span>
                              
                            </h6>
                            </span>
                         </div>         


 
</div>
</div>
</div>
<!--DOGE  End-->
</div>

</template>

<script>
    export default {
    data(){
        return {
            alldata :[],
            btc_details:[ ],           
            btc_from_currency_token:'',
            selectcurrency:'',

            ltc_details:[ ],           
            ltc_from_currency_token:'',

             doge_details:[ ],           
             doge_from_currency_token:'',
        }
    },
     methods:{
      getAllData()
            {
                    axios.get('/marketrate').then(response =>{

                       console.log("test"+response.data);
                      
                        this.alldata=response.data;
                } );

            
          
            },


            getDataBTC()
            {
                    axios.get('/getpairdetails/BTC').then(response =>{

                       
                        this.btc_details.push(response.data);
                        this.btc_from_currency_token=response.data[0].from_currency_token;
                        this.selectcurrency=response.data[0].to_currency_token;
                } );

            
          
            },

              listenForWalletBTC() {
                window.Echo.channel('BTC')
                    .listen('ExternalTickerEvent', (data) => {                      
                        this.btc_details=data;
                      //  console.log('BTC');
                       
                     
                    });
            },

            getDataLTC()
            {
                    axios.get('/getpairdetails/LTC').then(response =>{

                       
                        this.ltc_details.push(response.data);
                        this.ltc_from_currency_token=response.data[0].from_currency_token;
                         this.selectcurrency=response.data[0].to_currency_token;

                } );

            
          
            },

              listenForWalletLTC() {
                window.Echo.channel('LTC')
                    .listen('ExternalTickerEvent', (data) => {                      
                        this.ltc_details=data;
                             //  console.log('LTC');
                       
                     
                    });
            },


            getDataDOGE()
            {
                    axios.get('/getpairdetails/DOGE').then(response =>{

                       
                        this.doge_details.push(response.data);
                        this.doge_from_currency_token=response.data[0].from_currency_token;
                         this.selectcurrency=response.data[0].to_currency_token;

                } );

            
          
            },

              listenForWalletDOGE() {
                window.Echo.channel('DOGE')
                    .listen('ExternalTickerEvent', (data) => {                      
                        this.doge_details=data;
                             //  console.log('DOGE');
                       
                     
                    });
            },




        },

    created() {
   
                this.getDataBTC();
                this.listenForWalletBTC();

                this.getDataLTC();
                this.listenForWalletLTC();

                this.getDataDOGE();
                this.listenForWalletDOGE();
            },

    
       
    }

 
</script>
<style>
.ticker-bar-components {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
}
.flex-2 {
    display: flex;
    flex-direction: row;
}
.price-switcher {
    display: block;
    margin-top: -40px;
}
.price-info {
  display: block;
  padding-left: 10px;
  color: #fff;
}
.price-delta {
  margin-top: -12px;
  margin-bottom: 0px;
}
i.fas.fa-chevron-down {
    padding-top: 7px;
}
i.fas.fa-caret-down.red-down {
    font-size: 140%;
    padding: 4px;
    color: #d80000;
}
i.fas.fa-chevron-up {
    padding-top: 7px;
}
i.fas.fa-caret-up.green-up {
    font-size: 140%;
    padding: 4px;
    color: #00ec00;
}
.text-green {
  color: #00ec00;
}
.text-red {
  color: #d80000;
}
.price-switcher.btn-sm {
    padding: 0;
    margin: 0;
    height: 0;
    margin-top:-50px;
}

.price-switcher.btn-sm .dropdown-menu.show {
    margin-top: 10px;
}
.ticker-currency-name {
  color: #fff;
  font-size: 24px;
}
.currencyMenu {
    margin-top: 36px;
    width: 25px;
    height: 25px;
    border-width: initial;
    border-style: none;
    border-color: initial;
    border-image: initial;
    background-color: rgb(245, 245, 245);
    background-repeat: no-repeat;
    border-radius: 15px;
}
.currencyMenu:hover {
    cursor: pointer;
    background-color: rgb(250, 191, 44);
}
@media only screen and (min-width: 320px) {
   .ticker-bar-components {
      flex-direction: column;
  }
}
@media only screen and (min-width: 768px) {
  .ticker-bar-components {
      flex-direction: row;
  }
}

</style>