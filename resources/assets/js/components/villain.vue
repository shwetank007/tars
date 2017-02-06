<template>
	<div class="page-wrap">
		<div class="center">
			<button @click="seen = !seen">{{(seen)?'Cancel':'Add Villain' }}</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<form enctype="multipart/form-data" method="post">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add a New Villain</h3>
								</div>
								<div class="panel-body">
									<div v-if="errorMessage" class="bg-danger text-danger">
										Villain Exists.
									</div>
									<div class="form-group center" :class="{'has-error': errors.has('avatar')}">
										<div class="fileinput fileinput-new" data-provides="fileinput">
											<div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 120px; height: 120px;border-radius: 50%;"></div>
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
							</form>
						</div>
					</div>
				</div>
			</div>
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
	data: function () {
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
	created() {
		this.fetch();
	},
	methods: {
		upload: function (e) {
			this.avatar = e.target.files[0] || e.dataTransfer.files[0];
		},
		fetch: function () {
			let that = this;
			this.$http.get('api/villain')
			.then((response) => {
				that.antiHero = JSON.parse(response.body);
			})
			.catch((error) => {
				console.debug(error);
			});
		},
		add: function () {
			var form = new FormData;
			form.append('avatar',this.avatar);
			form.append('actor',this.actor);
			form.append('name',this.name);
			form.append('partner',this.partner);
			form.append('rival',this.rival);
			form.append('detail', '0');
			this.$http.post('api/villain', form)
			.then((response) => {
				var all = JSON.parse(response.body);
				var villain = {
					avatar: all.avatar,
					actor: this.actor,
					name: this.name,
					weakness: this.weakness,
					partner: this.partner,
					rival: this.rival,
					detail: false
				};
				this.antiHero.push(villain);
				this.actor = this.actor = this.name = this.partner = this.rival = this.avatar = '';
				this.seen = false;
			})
			.catch((error) => {
				console.debug(error);
				this.errorMessage = true;
			});
		},
		remove: function (item,id) {
			this.$http.delete('api/villain/'+id)
			.then((response) => {
				this.antiHero.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		}
	},
	computed: {
		isValid: function () {
			return this.actor != '' && this.name != '' && this.partner != '' && this.rival != '' && this.avatar != ''
		}
	}
}
</script>