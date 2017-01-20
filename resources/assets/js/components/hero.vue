<style>
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
			<button @click="seen = !seen">{{(seen)?'Cancel':'Add Hero' }}</button>
			<div v-if="errorMessage">
				<span class="text-danger bg-danger">
					<h3>Superhero already exists.</h3>
				</span>
			</div>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add a New Hero</h3>
								</div>
								<div class="panel-body">
									<div class="form-group" :class="{'has-error': errors.has('actor')}">
										<input v-model="actor" v-validate data-vv-rules="required" data-vv-name="actor" type="text"
											   class="form-control input-sm" placeholder="Superhero Name">
										<span v-show="errors.has('actor')" class="help-block">{{ errors.first('actor') }}</span>
									</div>

									<div class="form-group" :class="{'has-error': errors.has('name')}">
										<input v-model="name" v-validate data-vv-rules="required" data-vv-name="name" type="text"
											   class="form-control input-sm" placeholder="Superhero Alias">
										<span v-show="errors.has('name')" class="help-block">{{ errors.first('name') }}</span>
									</div>

									<div class="form-group" :class="{'has-error': errors.has('weakness')}">
										<input v-model="weakness" v-validate data-vv-rules="required" data-vv-name="weakness" type="text"
											   class="form-control input-sm" placeholder="Weakness">
										<span v-show="errors.has('weakness')" class="help-block">{{ errors.first('weakness') }}</span>
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
	</div>
</template>
<script>
export default {
	data: function () {
		return {
			seen: false,
			actor: '',
			name: '',
			weakness: '',
			partner: '',
			rival: '',
			heroes:[],
			errorMessage: false,
		}
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
				console.log(error);
			})
		},
		add: function () {
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
				console.log(error);
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
	},
	computed: {
		isValid: function () {
			return this.actor != '' && this.name != '' && this.partner != '' && this.rival != '' && this.weakness != ''
		}
	}
}
</script>