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
			<!--<button @click="seen = !seen" type="button" class="btn btn-success">{{(seen)?'Cancel':'Add Hero' }}</button>-->
			<router-link to="/addHero"><button type="button" class="btn btn-success">Add Hero</button></router-link>
		</div>
		<!--<div v-if="seen">-->
			<!--<div class="container">-->
				<!--<div class="row centered-form">-->
					<!--<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">-->
						<form enctype="multipart/form-data" method="post">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title center">Add a New Hero</h3>
							</div>
							<div class="panel-body">
								<div v-if="errorMessage" class="bg-danger text-danger">
									Superhero Exists.
								</div>
								<div class="form-group center" :class="{'has-error': errors.has('avatar')}">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 120px;border-radius: 50%;">
											<img src="default.gif">
										</div>
										<div>
											<span class="btn btn-default btn-file">
												<span class="fileinput-new">Upload Avatar</span>
												<span class="fileinput-exists">Change</span>
												<input type="file" v-on:change="upload" class="form-control input-sm"
													   v-validate data-vv-rules="required" data-vv-name="avatar">
											<span v-show="errors.has('avatar')" class="help-block">{{ errors.first('avatar') }}</span>
											</span>
											<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
										</div>
									</div>
								</div>
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

								<div class="form-group" :class="{'has-error': errors.has('powerName')}">
									<input v-model="powerName" v-validate data-vv-rules="required" data-vv-name="powerName" type="text"
										   class="form-control input-sm" placeholder="Power Name">
									<span v-show="errors.has('powerName')" class="help-block">{{ errors.first('powerName') }}</span>
								</div>

								<div class="form-group" :class="{'has-error': errors.has('powerDamage')}">
									<input v-model="powerDamage" v-validate data-vv-rules="required" data-vv-name="powerDamage" type="text"
										   class="form-control input-sm" placeholder="Power Damage">
									<span v-show="errors.has('powerDamage')" class="help-block">{{ errors.first('powerDamage') }}</span>
								</div>

								<div class="form-group center">
									<button @click="submitPower" v-bind:disabled="!checkPower" type="button" class="btn btn-success">Submit Power</button>
									<span>Power: {{counter}} </span>
								</div>

								<button @click.prevent="add" v-bind:disabled="!isValid" class="btn btn-info btn-block">Submit</button>
							</div>
						</div>
						</form>
					<!--</div>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->
		<div class="container">
			<div class="col-md-12 hv-look" v-for="(hero,index) in heroes">
				<div class="col-md-4 center">
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
							<b>Weakness    :</b> {{ hero.weakness }}.<br>
							<b>Partner     :</b> {{ hero.partner }}.<br>
							<b>Rival       :</b> {{ hero.rival }}.
						</div>
					</div>
				</div>
				<div class="col-md-2 center hv-down">
					<div v-bind:class="[hero.detail ? 'distance' : '']">
						<button @click="hero.detail = !hero.detail" style="position: inherit;">{{(hero.detail)?'Hide Detail':'Detail' }}</button>
						<button @click="remove(index,hero.id)">Delete</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	data: function () {
		return {
			seen: false,
			avatar:'',
			actor: '',
			name: '',
			weakness: '',
			partner: '',
			rival: '',
			heroes:[],
			powerName: '',
			powerDamage: '',
			weapons:[],
			counter: 0,
			errorMessage: false,
		}
	},
	name: 'hero',
	created () {
		this.fetch();
	},
	methods: {
		upload: function (e) {
			this.avatar = e.target.files[0] || e.dataTransfer.files[0];
		},
		fetch: function() {
			let that = this;
			this.$http.get('api/hero')
			.then((response)=> {
				that.heroes = JSON.parse(response.body);
			})
			.catch((error) => {
				console.debug(error);
			});
		},
		add: function () {
			let form = new FormData;
			form.append('avatar',this.avatar);
			form.append('actor',this.actor);
			form.append('name',this.name);
			form.append('weakness',this.weakness);
			form.append('partner',this.partner);
			form.append('rival',this.rival);
			form.append('detail', '0');
			this.$http.post('api/hero', form)
			.then((response) => {
//				var all = JSON.parse(response.body);
//				var hero = {
//					avatar: all.avatar,
//					actor: this.actor,
//					name: this.name,
//					weakness: this.weakness,
//					partner: this.partner,
//					rival: this.rival,
//					detail: false
//				};
//				this.heroes.push(hero);
//				this.actor = this.name = this.weakness = this.partner = this.rival = this.avatar = '';
//				this.seen = false;
			})
			.catch((error) => {
				console.debug(error);
				this.errorMessage = true;
            });
		},
		remove: function (item,id) {
			this.$http.delete('api/hero/'+id)
			.then((response) => {
				this.heroes.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		},
		submitPower : function () {
			this.weapons.push({
				name: this.powerName,
				damage: this.powerDamage
			});

			this.powerName = this.powerDamage = '';
			this.counter += 1;
		}
	},
	computed: {
		isValid: function () {
			return this.actor != '' && this.name != '' && this.partner != '' && this.rival != '' && this.weakness != '' && this.avatar != ''
		},
		checkPower : function () {
			return this.powerName != '' && this.powerDamage != ''
		}
	}
}
</script>