import Vue from 'vue';
import router from './router.js';
import Test from './test.vue';

new Vue({
  el: '#app',
  render: h => h(Test),
  router
});