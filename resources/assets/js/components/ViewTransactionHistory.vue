 <template>
 <div>
 <h4>{{this.trans.transhis}}
                </h4>
         
          <div v-if="gettranshis.length=='0'">                <p>{{this.trans.norecords}} </p>

          </div>
          <ul class="transaction-list" v-else >
              <li class="transaction-list-item" v-for="(history,index) in gettranshis" v-if="gettranshis.length!='0'">
                          <h4 class="transaction-amount" >{{trans.amount  }} : {{ history.amount  }} {{history.curname}}</h4>
                          <p class="no-space trans-address">
                          {{trans.fromaddress}}: {{history.from_address}} </p>
                          <p class="no-space trans-address">{{trans.toaddress}}: {{history.to_address}}</p>
                          <a :href='history.txurl' class="btn btn-sm btn-success mb-10" :title="history.txid" target="_blank"> {{trans.viewtrans}} </a>
                        
              </li>
          </ul>
          <ul v-if="gettranshis.length!='0'">
          <li> <a :href="'/myaccount/transhistory/all/'+this.payment_id" class="btn btn-sm btn-success mb-10"  target="_blank"> {{trans.viewall}} </a> </li>
          </ul>

  </div>
</template>
<script>
import { bus, router } from "../app";
export default {
  //props: ['paymentid'],
  data() {
    return {
     
      gettranshis:[],
      trans:[], 
     // payment:paymentid,
      payment_id: $("#activecurrency").val(),
      selects: $("#activecurrency").val(),
   
    };
  },
  mounted: function () {
    console.log('The props are also available in JS:',+this.paymentid);
    //console.log("PaymentId"+this.payment_id);
  },
  created() {
     axios.get("/myaccount/transhistory/"+this.payment_id).then(response => {
        this.gettranshis = [];
       this.gettranshis = response.data;
      
      
       });

    axios.get("/translations").then(response => (this.trans = response.data));

      bus.$on("PaymentId", data => {
        console.log("2");
      this.payment_id = data;
      console.log("DATA"+data);
      if(this.payment_id != "") {
        
        this.getTranHistory();
      }

    });
   
    

  },
  methods: {
   
    getTranHistory(){

       bus.$on("PaymentId", data => {
      this.payment_id = data;
      if(this.payment_id != "") {
       
       // this.getTranHistory();
      }

    });


       axios.get("/myaccount/transhistory/"+this.payment_id).then(response => {
        this.gettranshis = [];
       this.gettranshis = response.data;
      
      
       });

    },
    
    }
};
</script>