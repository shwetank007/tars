import Vue from 'vue';
import VueRouter from 'vue-router';
import Login from './components/login.vue';
import Hero from './components/hero/hero.vue';
import AddHero from './components/hero/addHero.vue';
import EditHero from './components/hero/editHero.vue';
import Villain from './components/villain/villain.vue';
import AddVillain from './components/villain/addVillain.vue';
import Match from './components/match/match.vue';
import Fight from './components/match/fight.vue';
import VueResource from 'vue-resource';

Vue.use(VueResource);
Vue.use(VueRouter);

let routes = [
	{path:'/', name:'index', component:Login},
	{path: '/hero', name: 'hero', component: Hero},
	{path: '/addHero', name: 'addHero', component: AddHero},
	{path: '/editHero/:id', name: 'editHero', component: EditHero},
	{path: '/villain', name: 'villain', component: Villain},
	{path: '/addVillain', name: 'addVillain', component: AddVillain},
	{path: '/match', name: 'match', component: Match},
	{path: '/fight/:id', name: 'fight', component: Fight},
];

const router = new VueRouter({
	routes
});

export default router;