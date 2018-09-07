<template>
       <div class="flex flex-m mt-10 mb-10" style="justify-content: center; border-top:2px dotted #223322">
              <div class="no-trade-link login-section p-10"  @click.prevent="Login()" style="cursor: pointer;"> 
                Login to Trade
              </div>
          </div>
</template>
<script>
    export default { 
    	data() {
    		return {
          trans: [],
        };
    	},
      created() {
            axios.get("/translations").then(response => (this.trans = response.data));
      },
    	methods : {
    		    signUp() {
           			window.location.href="/register"; 
      			},
      			Login(){
            		window.location.href="/login"; 
      			}
    	}
    }
</script>