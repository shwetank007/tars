<style>
	html,body{
		background-color: #d3d3d3;
		height:100%;
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
	<div class="page-wrap">
		<div class="center">
			<button @click="seen = !seen">{{(seen)?'Cancel':'Add Villain' }}</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add a New Villain</h3>
								</div>
								<div class="panel-body">
									<div class="form-group" :class="{'has-error': errors.has('actor')}">
										<input v-model="actor" v-validate data-vv-rules="required" data-vv-name="actor" type="text"
											   class="form-control input-sm" placeholder="Villain Name">
										<span v-show="errors.has('actor')" class="help-block">{{ errors.first('actor') }}</span>
									</div>

									<div class="form-group" :class="{'has-error': errors.has('name')}">
										<input v-model="name" v-validate data-vv-rules="required" data-vv-name="name" type="text"
											   class="form-control input-sm" placeholder="Villain Alias">
										<span v-show="errors.has('name')" class="help-block">{{ errors.first('name') }}</span>
									</div>

									<div class="form-group" :class="{'has-error': errors.has('partner')}">
										<input v-model="partner" v-validate data-vv-rules="required" data-vv-name="partner" type="text"
											   class="form-control input-sm" placeholder="Partner Name">
										<span v-show="errors.has('partner')" class="help-block">{{ errors.first('partner') }}</span>
									</div>

									<div class="form-group" :class="{'has-error': errors.has('rival')}">
										<input v-model="rival" v-validate data-vv-rules="required" data-vv-name="rival" type="text"
											   class="form-control input-sm" placeholder="Arch Rival Name">
										<span v-show="errors.has('rival')" class="help-block">{{ errors.first('rival') }}</span>
									</div>

									<button @click.prevent="add" v-bind:disabled="!isValid" class="btn btn-info btn-block">Submit</button>
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
export default {
	data: function () {
		return {
			seen: false,
			actor: '',
			name: '',
			partner: '',
			rival: '',
			antiHero: []
		}
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
	},
	computed: {
		isValid: function () {
			return this.actor != '' && this.name != '' && this.partner != '' && this.rival != ''
		}
	}
}
</script>