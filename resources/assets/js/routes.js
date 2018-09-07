import Home from './components/MiniChart.vue';
import Example from './components/TradePairGraph.vue';
export const routes = [
    { path: '/vue', component: Home, name: 'Home' },
    { path: '/vue/example', component: Example, name: 'Example' }
];