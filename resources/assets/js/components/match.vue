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
	.select-picker {
		height: 30px;
		width: 146px;
	}
</style>
<template>
	<div class="page-wrap">
		<div class="center">
			<button @click="seen = !seen">{{(seen)?'Cancel':'Add Match' }}</button>
			<div v-if="seen">
				<div class="container">
					<div class="row centered-form">
						<div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title">Add New Match</h3>
								</div>
								<div class="panel-body">
									<div class="row">
										<div class="col-md-5">
											<div class="form-group" :class="{'has-error': errors.has('hero')}">
												<select class="select-picker form-control" v-model="hero" v-validate data-vv-rules="required" data-vv-name="hero">
													<option value="">Select Hero</option>
													<option v-for="(superhero,index) in superheroes" v-bind:value="{id: superhero.id, name: superhero.actor}">{{superhero.actor}}</option>
												</select>
												<span v-show="errors.has('hero')" class="help-block">{{ errors.first('hero') }}</span>
											</div>
										</div>
										<div class="col-md-1">V/S</div>
										<div class="col-md-5">
											<div class="form-group" :class="{'has-error': errors.has('antiHero')}">
												<select class="select-picker form-control" v-model="antiHero" v-validate data-vv-rules="required" data-vv-name="antiHero">
													<option value="">Select Villain</option>
													<option v-for="(villain,index) in villains" v-bind:value="{id: villain.id, name: villain.actor}">{{villain.actor}}</option>
												</select>
												<span v-show="errors.has('antiHero')" class="help-block">{{ errors.first('antiHero') }}</span>
											</div>
										</div>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('cause')}">
                                        <textarea v-model="cause" v-validate data-vv-rules="required" data-vv-name="cause" class="form-control input-sm" placeholder="Cause of Match"></textarea>
										<span v-show="errors.has('cause')" class="help-block">{{ errors.first('cause') }}</span>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('place')}">
                                        <input v-model="place" type="text" v-validate data-vv-rules="required" data-vv-name="place" class="form-control input-sm" placeholder="Place of Match">
										<span v-show="errors.has('place')" class="help-block">{{ errors.first('place') }}</span>
									</div>

                                    <div class="form-group" :class="{'has-error': errors.has('date')}">
                                        <datepicker :disabled="state.disabled" placeholder="Match Date" v-model="date" v-validate data-vv-rules="required" data-vv-name="date"></datepicker>
										<span v-show="errors.has('date')" class="help-block">{{ errors.first('date') }}</span>
									</div>
                                    <button @click.prevent="add" v-bind:disabled="!isValid" class="btn btn-info btn-block">Submit</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<ol>
				<li v-for="(match,index) in matches" v-cloak>
					{{match.hero.actor}} v/s {{match.villain.actor}}
					<div v-show="match.detail">
						Cause       : {{ match.cause }}.<br>
						Place       : {{ match.place }}.<br>
						Date        : {{match.date}}.
					</div>
					<button @click="match.detail = !match.detail">{{(match.detail)?'Hide Detail':'Detail' }}</button>
					<button @click="remove(index,match.id)">Delete</button>
					<button @click="start(match.hero.actor, match.villain.actor)">Start Match</button>
				</li>
			</ol>
		</div>
		<div class="col-md-6 center" v-if="">
			<ol style="list-style-type: none">
				<li v-for="(comment,index) in commentary">
					{{comment}}
				</li>
			</ol>
		</div>
	</div>
</template>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script>
import Datepicker from 'vuejs-datepicker';
var moment = require('moment');

export default {
    components: { Datepicker },
    data: function () {
        return {
            seen: false,
            superheroes: [],
            villains: [],
            cause: '',
            place: '',
            actor: '',
            matches: [],
            hero: '',
            antiHero: '',
            date: '',
			powers: [],
			state: {
				disabled: {
					to: new Date()
				}
			},
			chance: 0,
			villainHealth: 100,
			heroHealth: 100,
			weaponDamage: '',
			weaponName: '',
			defence: 0,
			heroName: '',
			villainName: '',
			review: [],
			commentary: [],
			matchComplete: false,
        }
    },
  	created() {
		this.fetch();
	},
    methods: {
        fetch: function () {
			this.$http.get('api/match')
			.then((response) => {
			    var all = JSON.parse(response.body);
                this.matches = all.fixture;
                this.superheroes = all.heros;
                this.villains = all.aVillain;
				this.powers	= all.power;
			})
			.catch((error) => {
				console.debug(error);
			});
        },
        add : function () {
			var match = {
				hero_id: this.hero.id,
				villain_id: this.antiHero.id,
				cause: this.cause,
				place: this.place,
                date: moment(this.date).format('DD/MM/YYYY'),
				detail: false
			};
			var fight = {
				hero: {
					actor: this.hero.name
				},
				villain: {
					actor: this.antiHero.name
				},
				cause: this.cause,
				place: this.place,
				date: moment(this.date).format('DD/MM/YYYY'),
				detail: false
			};
			this.$http.post('api/match', match)
			.then((response) => {
				this.matches.push(fight);
			})
			.catch((error) => {
				console.debug(error);
			});
			this.superhero = this.villain = this.cause = this.place = this.date = '';
			this.seen = false;
		},
		remove : function (item,id) {
			this.$http.delete('api/match/'+id)
			.then((response) => {
				this.matches.splice(item,1);
			})
			.catch((error) => {
				console.debug(error);
			});
		},
		start : function (hero,villain) {
			this.heroHealth = 100;
			this.villainHealth = 100;
			this.heroName = hero;
			this.villainName = villain;
			this.clear();
			this.comment('Match Start');
			this.toss();
		},
		toss : function () {
			var tossWin = Math.floor(Math.random() * 2);
			var n = 0;
			if(tossWin == 0) {
				this.comment(this.heroName +' win the toss');
				this.comment(this.heroName +' Health '+ 100 + ', '+ this.villainName +' Health '+ 100);
				while(this.heroHealth >= 0 && this.villainHealth >= 0) {
					if(n % 2 == 0) {
						this.attack(this.chance = 0);
					} else {
						this.attack(this.chance = 1);
					}
					if(this.heroHealth <= 0) {
						this.heroHealth = 0;
						this.comment(this.heroName +' Dead');
						this.showCommentary();
						break;
					} else if(this.villainHealth <= 0) {
						this.villainHealth = 0;
						this.comment(this.villainName +' Dead');
						this.showCommentary();
						break;
					} else {
						this.comment(this.heroName +" Health " + this.heroHealth +" "+ this.villainName +" Health " + this.villainHealth);
					}
					n++;
				}
			} else {
				this.comment(this.villainName +' Win the toss');
				this.comment(this.heroName +' Health '+ 100 + ', ' +this.villainName+' Health '+ 100);
				while(this.heroHealth >= 0 && this.villainHealth >= 0) {
					if(n % 2 != 0) {
						this.attack(this.chance = 0);
					} else {
						this.attack(this.chance = 1);
					}
					if(this.heroHealth <= 0	) {
						this.heroHealth = 0;
						this.comment(this.heroName +' Dead');
						this.showCommentary();
						break;
					}else if(this.villainHealth <= 0) {
						this.villainHealth = 0;
						this.comment(this.villainName +' Dead');
						this.showCommentary();
						break;
					} else {
						this.comment(this.heroName + " Health " + this.heroHealth +", "+ this.villainName + " Health " + this.villainHealth);
					}
					n++;
				}
			}
		},
		attack : function () {
			var max = this.powers.length;//Total number of powers present
			var min = 0;
			this.defence = Math.floor(Math.random() * 2);
			var weaponChoice = Math.floor(Math.random() * (max - min) + min);
			this.weaponDamage = this.powers[weaponChoice].damage;
			this.weaponName = this.powers[weaponChoice].power_name;
			if(this.chance == 0) {
				if(this.defence == 0) {
					this.shield(this.defence=0);//Shield is on for Villain
				} else {
					this.comment(this.heroName +' hit '+ this.villainName +' with ' + this.weaponName);
					this.villainHealth = this.villainHealth - this.weaponDamage;
				}
			} else {
				if(this.defence == 0) {
					this.shield(this.defence=1);//Shield is on for Hero
				} else {
					this.comment(this.villainName + ' hit ' +this.heroName+ ' with ' + this.weaponName);
					this.heroHealth = this.heroHealth - this.weaponDamage;
				}
			}
		},
		shield : function () {
			if(this.defence==0) {
				this.villainHealth = this.villainHealth - (this.weaponDamage * 0.2);
				this.comment(this.heroName + ' hit '+ this.villainName +' with ' + this.weaponName);
				this.comment(this.villainName +' shield attack of '+this.heroName+ ' but got a knick'+ ' ' +this.villainHealth);
			} else {
				this.heroHealth = this.heroHealth - (this.weaponDamage * 0.2);
				this.comment(this.villainName+' hit '+this.heroName+ ' with ' + this.weaponName);
				this.comment(this.heroName +' shield attack of '+this.villainName +' but got a knick'+ ' ' +this.heroHealth);
			}
		},
		clear : function () {
			this.commentary = [];
			this.review = [];
			return true;
		},
		comment : function (a) {
			this.review.push(a);
			return true;
		},
		showCommentary(){
			let that =  this;
			if(this.review.length > 0) {
				var comments = this.review[0];
				this.commentary.push(comments);
				this.review.splice(0,1);
				setTimeout(function () {
					that.showCommentary();
				},1000);
			}
			return true;
		}
    },
	computed: {
		isValid: function () {
			return this.superhero != '' && this.villain != '' && this.cause != '' && this.place != '' && this.date != ''
		}
	}
}
</script>