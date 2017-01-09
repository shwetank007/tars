import Vue from 'vue';
import VueRouter from 'vue-router';
import Hero from './components/hero.vue';
import Villain from './components/villain.vue';
import Match from './components/match.vue';
import Login from './components/login.vue';
import VueResource from 'vue-resource';

Vue.use(VueResource)
Vue.use(VueRouter)

var routes = [
	{path: '/', component: Login},
	{path: '/hero', name: 'hero', component: Hero},
	{path: '/villain', name: 'villain', component: Villain},
	{path: '/match', name: 'match', component: Match}
]

const router = new VueRouter({
	routes
});

export default router;