import Vue from 'vue';
import VueRouter from 'vue-router';
import Hero from './components/hero.vue';
import Villain from './components/villain.vue';
import Match from './components/match.vue';
import Login from './components/login.vue';
import Fight from './components/fight.vue';
import VueResource from 'vue-resource';

Vue.use(VueResource);
Vue.use(VueRouter);

var routes = [
	{path:'/', name:'index', component:Login},
	{path: '/hero', name: 'hero', component: Hero},
	{path: '/villain', name: 'villain', component: Villain},
	{path: '/match', name: 'match', component: Match},
	{path: '/fight/:id', name: 'fight', component: Fight}
];

const router = new VueRouter({
	routes
});

export default router;