<template>
	<div>
		<button @click="seen = !seen">Add Hero</button>
	    <div v-if="seen">
	        <input v-model="actor" placeholder="Add New Superhero"><br>
	        <input v-model="name" placeholder="Add Name of Superhero"><br>
	        <input v-model="weakness" placeholder="Add weakness"><br>
	        <input v-model="partner" placeholder="Add partner/girlfriend/spouse"><br>
	        <input v-model="rival" placeholder="Add Arch Rival">
	        <button @click="add">Submit</button>
	    </div>
	    <ol>
	        <li v-for="(hero,index) in heroes" v-cloak>
	            {{ hero.actor }}
	            <div v-show="hero.detail">
	                Name        : {{ hero.name }}.<br>
	                Weakness    : {{ hero.weakness }}.<br>
	                Partner     : {{ hero.partner }}.<br>
	                Rival       : {{ hero.rival }}.
	            </div>
	            <button @click="hero.detail = !hero.detail">{{(hero.detail)?'Hide Detail':'Detail' }}</button>
	            <button @click="remove(index,hero.id)">Delete</button>
	        </li>
	    </ol>
	</div>
</template>
<script>
var data = { 
	seen: false,
	actor: '',
	name: '',
	weakness: '',
	partner: '',
	rival: '',
	heroes:[],
};
export default {
	data: function () {
		return data
	},
	created () {
		this.fetch();
	},
	methods: {
		fetch: function() {
			let that = this;
			this.$http.get('api/hero')
			.then((response)=> {
				that.heroes = JSON.parse(response.body);
			})
			.catch((error) => {
				console.log('fail');
			})
		},
		add: function () {
			let that = this;
			var hero = {
				actor: this.actor,
				name: this.name,
				weakness: this.weakness,
				partner: this.partner,
				rival: this.rival,
				detail: false
			};
			this.$http.post('api/hero', hero)
			.then((response) => {
				this.heroes.push(hero);
			})
			.catch((error) => {
            	console.log('error');
            });
			this.actor = this.name = this.weakness = this.partner = this.rival = '';
			this.seen = false;
		},
		remove: function (item,id) {
			this.$http.delete('api/hero/'+id)
			.then((response) => {
				this.heroes.splice(item,1);
			})
			.catch((response) => {
				console.log('not deleted');
			});
		}
	} 
}
</script>