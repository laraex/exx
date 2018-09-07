<template>
<div class="walletbalancecomponent">
  <div v-for="lf in walletdetails"  class="grid-400 grid-2">
      <div class="grid-item"><img :src="lf.btc_image" class="currency" style="width:20px; height:20px; margin-right:10px;"> {{lf.balance_btc}} {{lf.btc_token}} </div>
      <div class="grid-item"><img :src="lf.ltc_image" class="currency" style="width:20px; height:20px; margin-right:10px;"> {{lf.balance_ltc}} {{lf.ltc_token}} </div>
  </div>
</div>
</template>

<script>
    export default {
    data(){
        return {
            walletdetails:[ ],
        }
    },
     methods:{

            getData()
            {
                    axios.get('/myaccount/getwallet/').then(response =>{

                        this.walletdetails=[];
                        this.walletdetails.push(response.data);
                

                } );

            
          
            },

              listenForWallet() {
                window.Echo.channel('wallet')
                    .listen('WalletEvent', (data) => {
                       
               
                      // console.log(data);
                           
                          this.getData();
                     
                    });
            },



        },

    created() {
                this.getData();
            // this.listenForWallet();
            },

    
       
    }

 
</script>
<style>
  .grid-400 {
    display: grid;
    width: 400px;
  }
  .grid-item {
    grid-template-columns: repeat(2, 1fr);
  }
  .wallet li{

 
  list-style:none;
  float: left;
  display: block;
  width: 100px;
  height: 40px;
  
}

ul.wallet {
    display: flex;
    justify-content: space-evenly;
}

ul.wallet_title {
    display: flex;
    justify-content: space-evenly;
}
.currency
{

  width:20%;
}

</style>