import Vue from 'vue';
import router from './router.js';
import Test from './test.vue';
import VeeValidate from 'vee-validate';

Vue.use(VeeValidate);

new Vue({
  el: '#app',
  render: h => h(Test),
  router
});