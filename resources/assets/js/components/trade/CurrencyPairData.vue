<template>
	<div class="grid grid-currency-data ">

        
       <slot name="star"></slot>
        <div class="market-rate-info-section market-rate-info-section-2 " >
            <h6 class="nospace market-rate-info-coinname">
                <slot name="coinname" ></slot></h6> 
            <p class="nospace market-rate-info-pairname">
              <slot></slot>
            </p>
        </div>

        <div class="market-rate-info-section market-rate-info-section-3">
            <h6 class="nospace market-rate-info-rate text-right">
              <slot name="exchangerate"></slot>
            </h6>
        </div>
        <div class="market-rate-info-section market-rate-info-section-4">
            <h6 class="nospace market-rate-info-rate text-right">
              <slot name="currentprice"></slot>
            </h6>
        </div>
         <div class="market-rate-info-section market-rate-info-section-5">
            <h6 class="nospace market-rate-info-rate text-right">
              <slot name="daybefore"></slot>%
            </h6>
        </div>

 </div>
</template>

<style scoped>
    .w-20 {
      width: 20px;
    }
    .w-60 {
      width: 60px;
    }
     .w-100 {
      width: 100px;
    }
     .w-200 {
      width: 200px;
    }
   .market-rate-info-section  {
     padding:0 2px;
   }
  .trans-btn {
    background-color: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
  }
  .fa-overwrite {
    padding: 0 2px;
    background-color: #transperant;
  }
	.market-rate-info-coinname {
    font-size: 20px;
    font-weight: 600;
    color: #212121;
    margin: 0;
    padding: 0;
  }
  .market-rate-info-pairname {
    font-size: 14px;
    font-weight: 600;
    color: #c1c1c1;
    margin: 0;
    padding: 0;
  }
  .grid-currency-data {
    grid-template-columns: 1fr 5fr 3fr 2fr 2fr;
  }
</style>
