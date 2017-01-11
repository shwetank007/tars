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
			<button @click="seen = !seen">Add Hero</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add a New Hero</h3>
								</div>
								<div class="panel-body">
                                    <div class="form-group">
                                        <input v-model="actor" type="text" name="actor" class="form-control input-sm" placeholder="Superhero Name">
                                    </div>

                                    <div class="form-group">
                                        <input v-model="name" type="text" name="name" class="form-control input-sm" placeholder="Superhero Alias">
                                    </div>

                                    <div class="form-group">
                                        <input v-model="weakness" type="text" name="weakness" class="form-control input-sm" placeholder="Weakness">
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
var data = { 
	seen: false,
	actor: '',
	name: '',
	weakness: '',
	partner: '',
	rival: '',
	heroes:[]
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