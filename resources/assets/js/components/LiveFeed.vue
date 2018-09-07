<template>

<div class="livefeed mt-4 mb-4">
  <div class="container">
    <h1 class="text-center"> Live Data Feed </h1>
      <div class="table-wrapper mt-4 mb-4">
       <table class="table table-striped">
            <thead>
                <th>Date</th>
                <th>Transaction Id</th>
                <th>Transaction Type</th>
                <th>Sender </th>
                <th>Receiver</th>
                <th>Amount</th>         
            </thead>
            <tbody>

          
               <tr v-for="lf in livefeeds"  >
                 <td>{{lf.date}}</td>
                 <td class="transactionnumber">{{lf.transaction_number}}</td>
                 <td>{{lf.transaction_type}}</td>
                 <td>{{lf.sendername}}</td>
                 <td>{{lf.receivername}}</td>
                 <td><img :src="lf.image" class="currency" style="width:40px; height:40px; margin-right:10px;"> {{lf.amount}} {{lf.currency_code}} </td>
               </tr>
           
            </tbody>
        </table>



    </div>
  </div>
</div>

</template>

<script>
    export default {
       
    data(){

        return {
            livefeed:[ ],
            id:'0',
            array_check:0,
            count:5,
        }
    },
    computed: {
      livefeeds: function () {
       // return _.orderBy(this.livefeed, 'id',desc)
         if(this.array_check==0)
         {
            this.array_check=1;
            return this.livefeed.reverse();
         }
         else
         {

            return this.livefeed;
         }
      
      },
     
    },
     methods:{

            getData()
            {
               //   setInterval(() => {

                      

                    axios.get('/livefeed/?id='+this.id+'&count='+this.count).then(response =>{


                    for(var i=0;i<response.data.length;i++)
                    {
                    
                      if(response.data[i]['id']>this.id)
                      {

                       if(this.array_check==1)
                        {
                          
                          this.livefeed.reverse();
                         
                          this.array_check=0;

                         }
                        
                        this.livefeed.push(response.data[i]);
                        this.id=response.data[i]['id'];
                        
                                
                      }

                    }

                    var len= this.livefeed.length;

                            
                    if(len>this.count)
                    {

                          this.livefeed.reverse();
                          this.array_check=1;
                 
                             for(var j=this.count;j<len;j++)
                                {


                                   this.livefeed.pop() ;
                                }
                      
                              
                                         
                    }

                } );

            
            //  }, 1000);
            },

              listenForLiveFeed() {
                window.Echo.channel('livefeed')
                    .listen('LivefeedEvent', (data) => {
                       
                      // console.log('fg');
                      // console.log(data);
                       if(data[0]!='')
                       {
                           if(this.array_check==1)
                            {
                              
                              
                              this.livefeed.reverse();
                             
                              this.array_check=0;

                             }
                            
                            this.livefeed.push(data[0]);
                            var len= this.livefeed.length;

                            if(len>this.count)
                            {

                                  this.livefeed.reverse();
                                  this.array_check=1;
                         
                                     for(var j=this.count;j<len;j++)
                                        {


                                           this.livefeed.pop() ;
                                        }
                              
                                      
                                                 
                            }
                          
                            
                         
                      }


                    });
            },



        },

    created() {
                this.getData();
                this.listenForLiveFeed();
            },

    
       
    }

 
</script>
<style>

  .livefeed li{

 
  list-style:none;
  float: left;
  display: block;
  width: 100px;
  height: 40px;
  
}

ul.livefeed {
    display: flex;
    justify-content: space-evenly;
}

ul.livefeed_title {
    display: flex;
    justify-content: space-evenly;
}
.currency
{

  width:20%;
}

</style>