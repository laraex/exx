<template>
<div class="bgd-box-round p-10">
     <h4>Trading View Chart</h4>
     <div id="mini-chart" style="min-height:300px;position:relative;"></div>
  
     </div>
</div>
</template>

<script >
import { bus } from "../app";
export default {
  data() {
    return {
      trans: [],
      e: [],
      istudy:0,
      marketrates: {
        data: {
          1: {
            id: $('#currentpair').val(),
            fromcurrency: {
              name: $('#fromtoken').val()
            },
            tocurrency: {
              name: $('#totoken').val()
            }
          }
        }
      } //For selected default data
    };
  },

  created() {
    bus.$on("dataSelect", data => {
      this.selected = data;
      axios.get("/trade/gettrade/" + this.selected).then(response => {
      });
    });
  },
};
</script>
<style >
#mini-chart {
  width: 100%;
  height: 339px;
  font-size: 11px;
}
</style>