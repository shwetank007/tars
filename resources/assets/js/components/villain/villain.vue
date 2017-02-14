<template>
	<div class="page-wrap">
		<div class="center">
			<router-link to="/addVillain"><button type="button" class="btn btn-success">Add Villain</button></router-link>
		</div>
		<div class="container">
			<div class="col-md-12 hv-look" v-for="(villain,index) in antiHero">
				<div class="col-md-4 center">
					<div v-bind:class="[villain.detail ? 'distance' : '']">
						<img :src="'images/'+villain.avatar" height="40px" width="40px" style="border-radius: 50%;">
						<span class="hv-style">{{ villain.actor }}</span>
						<div class="vertical-line" style="height: 45px;"></div>
					</div>
				</div>
				<div class="col-md-6 center">
					<div class="hv-down" v-show="!villain.detail">
						{{villain.actor}} Description
					</div>
					<div v-show="villain.detail">
						<img :src="'images/'+villain.avatar" height="100px" width="100px" style="border-radius: 50%;">
						<div class="design">
							<b>{{ villain.actor }}</b>
						</div>
						<div>
							<b>Name        :</b> {{ villain.name }}.<br>
							<b>Partner     :</b> {{ villain.partner }}.<br>
							<b>Rival       :</b> {{ villain.rival }}.
						</div>
					</div>
				</div>
				<div class="col-md-2 center hv-down">
					<div v-bind:class="[villain.detail ? 'distance' : '']">
						<button @click="villain.detail = !villain.detail" style="position: inherit;">{{(villain.detail)?'Hide Detail':'Detail' }}</button>
						<button @click="remove(index,villain.id)">Delete</button>
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
			seen: false,
			avatar:'',
			actor: '',
			name: '',
			partner: '',
			rival: '',
			antiHero: [],
			errorMessage: false
		}
	},

	name: 'villain',

	created () {
		this.fetch();
	},

	methods: {
		fetch () {
			let that = this;
			this.$http.get('api/villain')
			.then((response) => {
				that.antiHero = JSON.parse(response.body);
			})
			.catch((error) => {
				console.debug(error);
			});
		},
		remove (item,id) {
			this.$http.delete('api/villain/'+id)
			.then((response) => {
				this.antiHero.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		}
	}
}
</script>