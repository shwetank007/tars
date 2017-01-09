<template>
	<div>
		<button @click="seen = !seen">Add Match</button>
	    <div v-if="seen">
	        <select v-model="superhero">
	            <option>Superman</option>
	            <option>Batman</option>
	            <option>Wonder Woman</option>
	            <option>Iron Man</option>
	            <option>Hulk</option>
	            <option>Thor</option>
	            <option>Captain America</option>
	            <option>Doctor Strange</option>
	            <option>Spider-Man</option>
	            <option>Flash</option>
	        </select>
	        V/S
	        <select v-model="villain">
	            <option>Joker</option>
	            <option>Lex Luthor</option>
	            <option>Cheetah</option>
	            <option>Obadiah Stane</option>
	            <option>Abomination</option>
	            <option>Loki</option>
	            <option>Red Skull</option>
	            <option>Mordo</option>
	            <option>Vulture</option>
	            <option>Reverse Flash</option>
	        </select><br>
	        <textarea v-model="cause" placeholder="Add Cause of Match"></textarea><br>
	        <input v-model="place" placeholder="Add place of match">
	        <button @click="add">Submit</button>
	    </div>
	    <ol>
	        <li v-for="(match,index) in matches" v-cloak>
	            {{ match.actor }}
	            <div v-show="match.detail">
	                Cause       : {{ match.cause }}.<br>
	                Place       : {{ match.place }}.
	            </div>
	            <button @click="match.detail = !match.detail">{{(match.detail)?'Hide Detail':'Detail' }}</button>
	            <button @click="remove(index,match.id)">Delete</button>
	        </li>
	    </ol>
	</div>
</template>
<script>
var data = {
    seen: false,
    suprehero: '',
    villain: '',
    cause: '',
    place: '',
	actor: '',
    matches: []
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
			this.$http.get('api/match')
			.then((response) => {
			that.matches = JSON.parse(response.body);
			})
			.catch((response) => {
				console.log('fail');
			});
        },
        add : function () {
			var match = {
				actor: this.superhero + ' ' + 'v/s' + ' ' + this.villain,
				cause: this.cause,
				place: this.place,
				detail: false
			};
			this.$http.post('api/match', match)
			.then((response) => {
				this.matches.push(match);
			})
			.catch((response) => {
				console.log('error');
			});
			this.superhero = this.villain = this.cause = this.place = '';
			this.seen = false;
		},
		remove : function (item,id) {
			this.$http.delete('api/match/'+id)
			.then((response) => {
				this.matches.splice(item,1);
			})
			.catch((response) => {
				console.log('Not Deleted');
			});
		}
    }
}

</script>