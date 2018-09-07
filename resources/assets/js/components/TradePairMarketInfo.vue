<template>
<div class="p-10">
	<div class="flex">
	<div class="fs-1"> 
		<h1>Price</h1>
		<h5>Price Variant <span id="latest_order"></span> Value:{{ value }} {{selected}}</h5> 
	</div>
	<div class="fs-2 flex-1">
		<div class="sparkline-graph"></div>
	</div>
	<div class="fs-3">
		<p>High : XXXX </p>
		<p>Low : YYYY </p>
	</div>
	<div class="fs-4">
		<p>24 H Volume BTC </p>
		<p>24 H Volume KRW </p>
	</div>
	</div>
</div>
</template>
<script >
	export default {
                
	          methods: {
          onClickChild (value) {
         console.log("KK");
          console.log(value) // someValue
           }
      },

	}
</script>