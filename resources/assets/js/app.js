require('./bootstrap');

/*Vue.component('livefeed', require('./components/LiveFeed.vue'));
Vue.component('wallet', require('./components/Wallet.vue'));
Vue.component('primarycoin-sales', require('./components/PrimaryCoinSales.vue'));
Vue.component('fiat-exchange', require('./components/FiatExchange.vue'));
Vue.component('currency-pair-ticker', require('./components/CurrencyPairTicker.vue'));
Vue.component('send-mail', require('./components/SendMail.vue'));*/ //Imp
//Vue.component('trade', require('./components/Trade.vue'));
Vue.component('trade-pair-market-info', require('./components/TradePairMarketInfo.vue'));

Vue.component('trade-pair-graph', require('./components/TradePairGraph.vue'));
Vue.component('trade-pair-select', require('./components/trade/TradePairSelect.vue'));

//For trade
Vue.component('currency-pair', require('./components/trade/CurrencyPair.vue'));
Vue.component('currency-pair-data', require('./components/trade/CurrencyPairData.vue'));
Vue.component('trade-orders', require('./components/trade/TradeOrders.vue'));
Vue.component('trade', require('./components/trade/Trade.vue'));
Vue.component('chartbtc-usd', require('./components/ChartBTCUSD.vue'));
Vue.component('my-assets', require('./components/MyAssets.vue'));
Vue.component('currency-wallet', require('./components/CurrencyWallet.vue'));
Vue.component('currency-infor', require('./components/CurrencyInfor.vue'));
Vue.component('mini-chart', require('./components/MiniChart.vue'));
Vue.component('login-signup-buttons', require('./components/LoginSignupButtons.vue'));
Vue.component('modal-view', require('./components/Modal.vue'));
Vue.component('message-marquee', require('./components/MessageMarquee.vue'));
Vue.component('view-transaction-history', require('./components/ViewTransactionHistory.vue'));
Vue.component('token-transaction-history', require('./components/TokenTransactionHistory.vue'));
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);
var numeral = require("numeral");

Vue.filter("formatNumber", function (value) {
    return numeral(value).format('0.0'); // displaying other groupings/separators is possible, look at the docs
});
Vue.filter("formatNumber2", function (value) {
    return numeral(value).format('0.00'); // displaying other groupings/separators is possible, look at the docs
});

Vue.filter("formatNumber4", function (value) {
    return numeral(value).format('0.0000'); // displaying other groupings/separators is possible, look at the docs
});
Vue.filter("formatNumber8", function (value) {
    return numeral(value).format('0.00000000'); // displaying other groupings/separators is possible, look at the docs
});

Vue.config.devtools = true
import {
    routes
} from './routes';
import VueRouter from 'vue-router';
Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes
});
export const bus = new Vue();
const app = new Vue({
    el: '#app',
    router
});

