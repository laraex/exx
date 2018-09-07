<template>
	<div class="container notification">
		<div class="flex flex-m" style="justify-content: space-around; flex-wrap: wrap; padding-top: 10px;" >
                <h6 v-for="(news,index) in notifycontents" >  <a v-bind:href="'/news/'+news.id" target="_blank" style="color: #fff"> {{news.title}}  </a><small> <span style="margin-left: 15px; color: #f3f3f3;">( {{news.updated_at }} ) </span></small></h6>
		</div>
	  </div>
</template>
<script>
    export default {
    	data() {
    		return {
    			notifycontents:[],
    		}
    	},
        created() {
            axios.get('/latestnews') 
                    .then(response =>this.notifycontents = response.data);

        },
   }
</script>