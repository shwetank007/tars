<style>
	.distance {
		margin-top: 75px;
	}
	.design {
		font-size: large;
		margin: 6px 0px 6px 0px;
	}
</style>
<template>
	<div class="page-wrap">
		<div class="center">
			<router-link to="/addHero"><button type="button" class="btn btn-success">Add Hero</button></router-link>
		</div>
		<div class="container">
			<div class="col-md-12 hv-look" v-for="(hero,index) in heroes">
				<div class="col-md-3 center">
					<div v-bind:class="[hero.detail ? 'distance' : '']">
						<img :src="'images/'+hero.avatar" height="50px" width="50px" style="border-radius: 50%;">
						<span class="hv-style">{{ hero.actor }}</span>
						<div class="vertical-line" style="height: 45px;"></div>
					</div>
				</div>
				<div class="col-md-6 center">
					<div class="hv-down" v-show="!hero.detail">
						{{hero.actor}} Description
					</div>
					<div v-show="hero.detail">
						<img :src="'images/'+hero.avatar" height="100px" width="100px" style="border-radius: 50%;">
						<div class="design">
							{{ hero.actor }}
						</div>
						<div>
							<b>Name        :</b> {{ hero.name }}.<br>
							<b>Partner     :</b> {{ hero.partner }}.<br>
							<b>Rival       :</b> {{ hero.rival }}.<br>
						    <b>Power 	   :</b> <span v-for="powers in hero.power">{{powers.power_name}}<br></span>
						</div>
					</div>
				</div>
				<div class="col-md-3 center hv-down">
					<div v-bind:class="[hero.detail ? 'distance' : '']">
						<button @click="hero.detail = !hero.detail" style="position: inherit;">{{(hero.detail)?'Hide Detail':'Detail' }}</button>
						<router-link :to="{ name: 'editHero', params: { id: hero.id } }"><button>Edit</button></router-link>
						<button @click="removeHero(index,hero.id)">Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {

	data () {
		return {
			heroes:[],
			powerName: '',
			powerDamage: '',
			counter: 0,
		}
	},

	name: 'hero',

	created () {
		this.fetch();
	},
	methods: {

		fetch () {
			this.$http.get('api/hero')
			.then((response)=> {
				this.heroes = JSON.parse(response.body);
			})
			.catch((error) => {
				console.debug(error);
			});
		},

		removeHero (item,id) {
			this.$http.delete('api/hero/'+id)
			.then((response) => {
				this.heroes.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		}
	}
}
</script>