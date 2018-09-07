<template>
   <div  class="section-1-right" style="width:63%">
      <ul class="actionlist">
         <li>
            <div class="dropdown ">
               <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Time
               </a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changePeriodicity(1,1)">1 Minute</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changePeriodicity(1,5)">5 Minute</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changePeriodicity(1,30)">30 Minute</a>
                  <!-- <a class="dropdown-item" href="javascript:void(0);" v-on:click="addQuoteFeed({period:2, timeUnit:'minute',interval:30})">1 hour</a> -->
                  <a class="dropdown-item" href="javascript:void(0);" v-on:click="changePeriodicity(1,'day')">Daily</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changePeriodicity(1,'week')">Weekly</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changePeriodicity(1,'month')">Monthly</a>
                  <!-- <a class="dropdown-item" href="javascript:void(0);"v-on:click="addQuoteFeed({period:1, timeUnit:'tick'})">Ticks</a> -->
               </div>
            </div>
         </li>
         <li>
            <div class="dropdown ">
               <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Display
               </a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changeChartType('bar')">bar</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changeChartType('colored_bar')">colored bar</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changeChartType('line')">line</a>
                  <a class="dropdown-item" href="javascript:void(0);" v-on:click="changeChartType('hollow_candle')">hollow candle</a>
                  <a class="dropdown-item" href="javascript:void(0);" v-on:click="changeChartType('mountain')">mountain</a>
                  <a class="dropdown-item" href="javascript:void(0);"v-on:click="changeChartType('candle')">candle</a>
               </div>
            </div>
         </li>
         <li>
            <div class="dropdown ">
               <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               Studies
               </a>
               <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="height:200px; overflow:scroll;">
                  <a class="dropdown-item" v-for="(s, index) in studies" href="javascript:void(0);"v-on:click="addStudy(index)" >{{s.name}}</a>
               </div>
            </div>
         </li>
         <li ><button type="button" v-bind:class="{ 'active' : eventsAreDisplayed }" class="btn btn-default" v-on:click="showEvents();">Events</button></li>
         <li><button type="button" v-bind:class="{ 'active' :   toggleCrosshairs }" class="btn btn-default" v-on:click="toggleCrosshair();"><i class="fa fa-plus"></i></button></li>
          <li><button type="button"  v-bind:class="{ 'active' :   showTool }"  class="btn btn-default" v-on:click="showTools();"><i class="fa fa-pencil"></i></button></li>
      </ul>
      <select v-show="showTool" class="form-control" v-on:change="toggleDrawingTool()" v-model="tools">
        <option value=""> select tool</option>
        <option v-for="tool in drawingTools" :value="tool">{{tool}}</option>
      </select>
      <br>
      <ul class="hu">
         <li><span class="huLabel">T: </span><span id="huDate" class="huField date"></span></li>
         <li><span class="huLabel">O: </span><span id="huOpen" class="huField"></span></li>
         <li><span class="huLabel">H: </span><span id="huHigh" class="huField"></span></li>
         <li><span class="huLabel">C: </span><span id="huClose" class="huField"></span></li>
         <li><span class="huLabel">L: </span><span id="huLow" class="huField"></span></li>
         <li><span class="huLabel">V: </span><span id="huVolume" class="huField"></span></li>
      </ul>
      <div  id="chartdiv" style="width:100%;height:400px;position:relative;" >
      </div>
      <div id="stxEventPrototype" class="myEvents"></div>
   </div>
</template>
<script >
import { bus } from "../app";
var data;
var istudy =0 ;
export default {
  data() {
    return {
      trans: [],
      e: [],
      tocurrency: "",
      studies: [],
      eventsAreDisplayed: false,
      toggleCrosshairs: false,
      drawingToolsMap:[],
      drawingTools:[],
      tools :"",
      istudy:0,
      showTool : false,
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
    axios.get("/chart?action=ajaxSymbolAutocomplete&q="+$('#fromtoken').val()).then(response => {
      this.e = response.data;
      this.tocurrency = $('#totoken').val();
      this.showGraph(this.e[0].id, this.tocurrency);
    });

    bus.$on("dataSelect", data => {
      this.selected = data;
      axios.get("/trade/gettrade/" + this.selected).then(response => {
        this.tocurrency = response.data["to_currency_token"];
        axios
          .get(
            "/chart?action=ajaxSymbolAutocomplete&q=" +
              response.data["from_currency_token"]
          )
          .then(responses => {
            this.e = responses.data;
            this.showGraph(
              this.e[0].id,
              response.data["to_currency_token"],
              this.selected
            );
          });
      });
    });

    bus.$on("dataSelected", data => {
      this.selected = data;
      axios.get("/trade/gettrade/" + this.selected).then(response => {
        this.tocurrency = response.data["to_currency_token"];
        axios
          .get(
            "/chart?action=ajaxSymbolAutocomplete&q=" +
              response.data["from_currency_token"]
          )
          .then(responses => {
            this.e = responses.data;
            this.showGraph(
              this.e[0].id,
              response.data["to_currency_token"],
              this.selected
            );
          });
      });
    });
  },
  methods: {
    showGraph: function(asset, currency, ccurrnecy) {
    this.drawingToolsMap=CIQ.Drawing.getDrawingToolList({});
    for(var i in this.drawingToolsMap){
      this.drawingTools.push(this.drawingToolsMap[i]);
    }
      this.studies = CIQ.Studies.studyLibrary;
      var chartData = [];
      $.ajax({
        url: "/chart",
        method: "post",
        dataType: "json",
        data: {
          action: "ajaxGetData",
          asset: asset,
          currency: currency
        }
      }).done(function(e) {
        for (var i = 0; i < e.data.length; i++) {
          var sourceEpoch = parseInt(e.data[i].time);

          if (sourceEpoch <= 9999999999) {
            sourceEpoch *= 1000;
          }
          chartData[i] = {
            Date: new Date(sourceEpoch).toISOString(),
            Open: e.data[i].open,
            Close: e.data[i].close,
            High: e.data[i].high,
            Low: e.data[i].low,
            Volume: e.data[i].volume,
            Adj_Close: e.data[i].value,
            DT: new Date(sourceEpoch).toJSON(),
            munish: new Date(sourceEpoch).toJSON()
          };
        }

        data = chartData;
        displayChart();
        // Declare a CIQ.ChartEngine object. This is the main object for drawing charts.
        // var stxx = new CIQ.ChartEngine({
        //   container: $$$("#chartdiv")
        // });

        STXChart.prototype.prepend("headsUpHR", prependHeadsUpHR);
        function prependHeadsUpHR() {
          var tick = Math.floor(
            (STXChart.crosshairX - this.left) / this.layout.candleWidth
          );
          var prices = this.chart.xaxis[tick];

          $$("huDate").innerHTML = "";
          $$("huOpen").innerHTML = "";
          $$("huClose").innerHTML = "";
          $$("huHigh").innerHTML = "";
          $$("huLow").innerHTML = "";
          $$("huVolume").innerHTML = "";
          if (prices != null && prices.data) {
            var newDate = STX.strToDateTime(prices.data.DT);
            $$("huDate").innerHTML = STX.friendlyDate(newDate);
            $$("huOpen").innerHTML = STX.commas(prices.data.Open);
            $$("huClose").innerHTML = STX.commas(prices.data.Close);
            $$("huHigh").innerHTML = STX.commas(prices.data.High);
            $$("huLow").innerHTML = STX.commas(prices.data.Low);
            $$("huVolume").innerHTML = STX.condenseInt(prices.data.Volume);
          }
        }
      });
    },
    changePeriodicity: function(newPeriod, newInterval) {
      var intervalDisplayMap = {
        day: "1 D",
        week: "1 W",
        month: "1 Mo",
        "1": "1 Min",
        "5": "5 Min",
        "30": "30 Min"
      };
      stxx.setPeriodicityV2(newPeriod, newInterval, function(err) {});
    },
    changeChartType: function(type) {
      stxx.setChartType(type);
    },
    addStudy: function(study) {
      CIQ.Studies.addStudy(stxx, study);
    },
    showEvents: function(shape = "dividend") {
      // This is called by the menu item
      if (this.eventsAreDisplayed) {
        this.eventsAreDisplayed = false;
        STX.Marker.removeByLabel(stxx, "events");
      } else {
        this.eventsAreDisplayed = true;

        if (!stxx.masterData) return;
        var markerTypes = ["dividend", "news", "earnings"],
          newNode;
        for (var i = 0; i < stxx.masterData.length; i += 10) {
          var r = Math.floor(Math.random() * (markerTypes.length + 1));
          if (r == markerTypes.length) continue; // randomize
          newNode = $$$("#stxEventPrototype").cloneNode(true);
          newNode.id = null;
          newNode.innerHTML = markerTypes[r].capitalize().charAt(0);
          STX.appendClassName(newNode, markerTypes[r]); // make sure there is valid CSS class for markerTypes[r].
          new STX.Marker({
            stx: stxx,
            xPositioner: "date",
            x: stxx.masterData[i].DT,
            label: "events",
            node: newNode
          });
        }

        newNode = $$$("#stxEventPrototype").cloneNode(true);
        newNode.id = null;
        newNode.innerHTML = "F"; // future tick
        STX.appendClassName(newNode, shape);
        var someDate = new Date(stxx.masterData[stxx.masterData.length - 1].DT);
        console.log(someDate);
        someDate = stxx.getNextInterval(someDate, 5); // 5 bars in the future
        new STX.Marker({
          stx: stxx,
          xPositioner: "date",
          x: someDate,
          label: "events",
          node: newNode
        });

        newNode = $$$("#stxEventPrototype").cloneNode(true);
        newNode.id = null;
        newNode.innerHTML = "F"; // future tick overlaping an existing location
        STX.appendClassName(newNode, shape);
        new STX.Marker({
          stx: stxx,
          xPositioner: "date",
          x: someDate,
          label: "events",
          node: newNode
        });

        newNode = $$$("#stxEventPrototype").cloneNode(true);
        newNode.id = null;
        newNode.innerHTML = "F"; // future tick overlaping an existing location
        STX.appendClassName(newNode, shape);
        new STX.Marker({
          stx: stxx,
          xPositioner: "date",
          x: someDate,
          label: "events",
          node: newNode
        });

        newNode = $$$("#stxEventPrototype").cloneNode(true);
        newNode.id = null;
        newNode.innerHTML = "P"; // past tick
        STX.appendClassName(newNode, "circle");
        someDate = new Date(stxx.masterData[0].DT);
        someDate = stxx.getNextInterval(someDate, -5); // 5 bars in the past
        new STX.Marker({
          stx: stxx,
          xPositioner: "date",
          x: someDate,
          label: "events",
          node: newNode
        });

        stxx.draw();
        stxx.layout.events = true;
        stxx.changeOccurred("layout");
      }
    },
    toggleCrosshair: function() {
      if (this.toggleCrosshairs) {
        this.toggleCrosshairs = false;
        stxx.layout.crosshair = null;
      } else {
        this.toggleCrosshairs = true;
        stxx.layout.crosshair = true;
      }
    },
    showTools: function(){
      if(this.showTool){
          var numDrawings = stxx.drawingObjects.length; // changes as each drawing is removed
          stxx.changeVectorType('');
          for (var i = 0; i < numDrawings; i++) {
            stxx.removeDrawing(stxx.drawingObjects[0]);
          }
          this.showTool = false;
      }else{
        this.showTool = true;
        stxx.changeVectorType(this.tools);
      }
    },
    toggleDrawingTool: function() {
      stxx.changeVectorType(this.tools);
    }
  }
};

function displayChart() {
  
  stxx.setStyle("stx_candle_up", "color", "blue");
  stxx.setStyle("stx_candle_down", "color", "red");
  stxx.newChart("SPY", data);
   stxxm.newChart("SPY", data, null, function() {
          if (istudy == 0) var study = CIQ.Studies.addStudy(stxxm, "volume");
          else {
            CIQ.Studies.removeStudy(stxxm, study);
            var study = CIQ.Studies.addStudy(stxxm, "volume");
          }
        });
        istudy++;
}
</script>
<style >
#chartdiv {
  width: 100%;
  height: 339px;
  font-size: 11px;
  margin-top: 66px;
}
ul.hu {
  /* width: 405px; */
  /* float: right; */
  /* margin-right: 10px; */
  position: absolute;
  right: 0px;
  margin-top: 34px;
  text-align: left;
}
ul,
ul li {
  list-style: none;
}
ul.hu li {
  float: left;
  margin-left: 10px;
  font-size: 11px;
}
ul.actionlist li {
  /* position: absolute; */
  float: left;
  margin-left: 10px;
  font-size: 11px;
}
ul.actionlist {
  right: 0px;
  margin-top: 5px;
  text-align: left;
  float: right;
}
.Dark .huLabel {
  color: #999;
}
.huLabel {
  display: inline-block;
  margin-left: 5px;
  width: 15px;
  color: #b2b2b2;
}
.Dark .huField {
  color: #efefef;
}
.huField.date {
  width: 100px;
}
.huField {
  display: inline-block;
  width: 55px;
}
.myEvents {
  position: absolute;
  text-align: center;
  width: 20px;
  height: 20px;
  line-height: 20px;
  color: white;
}
/*style dividents to be a blue circle*/
.myEvents.dividend {
  background-color: blue;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  -ms-border-radius: 50%;
  border-radius: 50%;
}
/*style news to be a small red square*/
.myEvents.news {
  background-color: red;
  width: 15px;
  height: 15px;
  line-height: 15px;
}
.myEvents.earnings {
  background-color: purple;
  border: 5px solid yellow;
}
/*style to be a brown Rhombus*/
.myEvents.rhombus .shape {
  position: absolute;
  width: 20px;
  height: 20px;
  left: 0px;
  background-color: yellow;
  border: 2px solid black;
  color: black;
  -webkit-transform: rotate(45deg);
  /* Saf3.1+, Chrome */
  -moz-transform: rotate(45deg);
  /* FF3.5+ */
  -ms-transform: rotate(45deg);
  /* IE9 */
  -o-transform: rotate(45deg);
  /* Opera 10.5 */
  transform: rotate(45deg);
}
.myEvents.rhombus .label {
  position: absolute;
  width: 20px;
  height: 20px;
  left: 2px;
  /* offset to center the label */
}
.myEvents.hoverMarker {
  background-color: pink;
  border: 2px solid black;
}
/*  create some rudimentary styling for our tooltip class */
.tooltip {
  display: inline;
  position: relative;
}
.hoverMarker:hover .tooltip:after {
  background: #333;
  background: rgba(0, 0, 0, 0.8);
  border-radius: 5px;
  bottom: 26px;
  color: #fff;
  content: attr(title);
  left: 20%;
  padding: 5px 15px;
  position: absolute;
  z-index: 98;
  width: 30px;
  content: attr(title);
}
.hoverMarker:hover .tooltip:before {
  border: solid;
  border-color: #333 transparent;
  border-width: 11px 6px 0 6px;
  bottom: 20px;
  content: "";
  left: 50%;
  position: absolute;
  z-index: 99;
}
.btn-default {
  color: black;
  background-color: #ffffff;
  border-color: #999999;
}
button.active{
  border-bottom-color: blue;
}
</style>