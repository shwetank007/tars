<style>
	body{
		background-color: #d3d3d3;
	}
	.centered-form{
		margin-top: 60px;
	}

	.centered-form .panel{
		background: rgba(255, 255, 255, 0.8);
	}
	.panel{
		margin-top: 15px;
	}
</style>
<template>
	<div>
		<div class="center">
			<button @click="seen = !seen">Add Villain</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add a New Villain</h3>
								</div>
								<div class="panel-body">
									<div class="form-group">
										<input v-model="actor" type="text" name="actor" class="form-control input-sm" placeholder="Villain Name">
									</div>

									<div class="form-group">
										<input v-model="name" type="text" name="name" class="form-control input-sm" placeholder="Villain Alias">
									</div>

									<div class="form-group">
										<input v-model="partner" type="text" name="partner" class="form-control input-sm" placeholder="Partner Name">
									</div>

									<div class="form-group">
										<input v-model="rival" type="text" name="rival" class="form-control input-sm" placeholder="Arch Rival Name">
									</div>

									<button @click.prevent="add" class="btn btn-info btn-block">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
			<ol>
				<li v-for="(villain,index) in antiHero" v-cloak>
					{{ villain.actor }}
					<div v-show="villain.detail">
						Name        : {{ villain.name }}.<br>
						Partner     : {{ villain.partner }}.<br>
						Rival       : {{ villain.rival }}.
					</div>
					<button @click="villain.detail = !villain.detail">{{(villain.detail)?'Hide Detail':'Detail' }}</button>
					<button @click="remove(index,villain.id)">Delete</button>
				</li>
			</ol>
		</div>
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