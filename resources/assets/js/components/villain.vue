<template>
	<div>
		<button @click="seen = !seen">Add Villain</button>
	    <div v-if="seen">
	        <input v-model="actor" placeholder="Add New Villain"><br>
	        <input v-model="name" placeholder="Add Name of Villain"><br>
	        <input v-model="partner" placeholder="Add partner/girlfriend/spouse"><br>
	        <input v-model="rival" placeholder="Add Arch Rival">
	        <button @click="add">Submit</button>
	    </div>
	    <ol>
	        <li v-for="(villain,index) in antiHero" v-cloak>
	            {{ villain.actor }}
	            <div v-show="villain.detail">
	                Name        : {{ villain.name }}.<br>
	                Partner     : {{ villain.partner }}.<br>
	                Rival       : {{ villain.rival }}.
	            </div>
	            <button @click="villain.detail = !villain.detail">{{(villain.detail)?'Hide Detail':'Detail' }}</button>
	            <button v-on:click="remove(index,villain.id)">Delete</button>
	        </li>
	    </ol>
	</div>
</template>
<script>
var data = {
	seen: false,
	actor: '',
	name: '',
	partner: '',
	rival: '',
	antiHero: []
};
export default {
	data: function () {
		return data
	},
	created() {
		this.fetch();
	},
	methods: {
		fetch: function () {
			let that = this;
			this.$http.get('api/villain')
			.then((response) => {
				that.antiHero = JSON.parse(response.body);
			})
			.catch((response) => {
				console.log('fail');
			})
		},
		add: function () {
			var villain = {
				actor: this.actor,
				name: this.name,
				partner: this.partner,
				rival: this.rival,
				detail: false
			};
			this.$http.post('api/villain', villain)
			.then((response) => {
				this.antiHero.push(villain);
			})
			.catch((response) => {
				console.log('error');
			});
			this.actor = this.actor = this.name = this.partner = this.rival = '';
			this.seen = false;
		},
		remove: function (item,id) {
			this.$http.delete('api/villain/'+id)
			.then((response) => {
				this.antiHero.splice(item,1);
			})
			.catch((response) => {
				console.log('Not Deleted');
			});
		}
	}
}
</script>